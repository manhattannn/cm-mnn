<?php

/**
 * @file
 * Reservations - Managed Equipment Reservation Checkout and Inventory
 +---------------------------------------------------------------------------+
 | Copyright (C) 2009 Openflows, Inc. + Blue Bag. All rights reserved.       |
 | Additionally, Kevin Reynen + Dane Powell                                  |
 |                                                                           |
 | This work is published under the GNU AGPLv3 license without any           |
 | warranty. For full license and copyright information, see                 |
 | https://www.gnu.org/licenses/agpl-3.0.html                                |
 +---------------------------------------------------------------------------+
 */

function template_preprocess_reservations_conflict_grid(&$variables) {

  $type = $variables['type'];
  $title = $variables['title'];
  $start = $variables['start'];
  $end = $variables['end'];
  $nid = $variables['nid'];
  $reservation_vid = $variables['reservation_vid'];
  $inventory_tid = $variables['inventory_tid'];
  $cleaning_buffer = 0;

  $hours = array();

  $exist_inventory_hrs = FALSE;
  if (module_exists('reservations_inventory')) {

    // get hours of operation
    $hours_of_operation_inv = module_invoke(
            'reservations_inventory', 'get_hours_of_operation', $inventory_tid);

    $exist_inventory_hrs = $hours_of_operation_inv['exist_inventory_hrs'];

    // Load restrictions.
    $restrictions = module_invoke(
      'reservations_inventory', 'get_restrictions', $inventory_tid);

    // Get the cleaning buffer if set.
    if (isset($restrictions['cleaning_buffer'])) {
      $cleaning_buffer = $restrictions['cleaning_buffer'];
    }


    if ($exist_inventory_hrs
            && user_access('create reservations outside hours of operation')) {
      // Use expanded (admin) hours.
      $adminhours = $hours_of_operation_inv['admin'];
      for ($day = 0; $day < 7; $day++) {
        $hours[$day]['open'] = $adminhours['open'];
        $hours[$day]['close'] = $adminhours['close'];
      }
    }
    else {
      // Use normal hours.
      for ($day = 0; $day < 7; $day++) {
        $hours[$day]['open'] = $hours_of_operation_inv[$day]['open'];
        $hours[$day]['close'] = $hours_of_operation_inv[$day]['close'];
      }
    }
  }

  if (!$exist_inventory_hrs) {
    if (user_access('create reservations outside hours of operation')) {
      $adminhours = explode('-', variable_get('reservations_hours_admin', '07:00-23:00'));

      for ($day = 0; $day < 7; $day++) {
        $hours[$day]['open'] = $adminhours[0];
        $hours[$day]['close'] = $adminhours[1];
      }
    }
    else {
      $hours = reservations_load_hours_of_operation(NULL, TRUE);
    }
  }

  // Get local time objects
  $start_object       = reservations_create_local_date_object($start);
  $end_object         = reservations_create_local_date_object($end);

  // Get the start and end day of the booking
  $start_day = date_format($start_object, 'w');
  $end_day = date_format($end_object, 'w');

  // Do we have restricted hours?
  if (isset($restrictions['restricted_hours_of_operations'])
    && $restrictions['restricted_hours_of_operations']) {
    // Load the restricted hours.
    $restricted_hours = module_invoke(
      'reservations_inventory', 'get_restricted_hours_of_operation', $inventory_tid);

    for ($day = 0; $day < 7; $day++) {
      // Override start and end hours from the restricted hours data.
      if (isset($restricted_hours[$start_day]) && isset($restricted_hours[$start_day]['start_hours'])) {
        $hours[$day]['open'] = $restricted_hours[$day]['start_hours']['open'];
      }
      if (isset($restricted_hours[$end_day]) && isset($restricted_hours[$end_day]['end_hours'])) {
        $hours[$day]['close'] = $restricted_hours[$day]['end_hours']['close'];
      }
    }

  }

  // Expand our search to the entire day in the local timezone.
  $start_date = $dates['value']['date'] = date_format($start_object, 'Y-m-d');
  $dates['value']['time'] = $hours[$start_day]['open'];
  $end_date = $dates['value2']['date'] = date_format($end_object, 'Y-m-d');
  $dates['value2']['time'] = $hours[$end_day]['close'];

  // Convert local time (date_default_timezone) to UTC .
  $dates = reservations_convert_local_datetime_to_utc($dates, 'Y-m-d H:i');

  $start_mysql = $dates['value'];
  $end_mysql = $dates['value2'];
  $reservations = reservations_load_reservations_for_node_in_timespan($nid, $type, $start_mysql, $end_mysql, $reservation_vid, array(), $inventory_tid);

  global $cleaning_buffer_checks;
  if ($cleaning_buffer > 0) {
    // Add the cleaning buffer to the reservations.
    // Set the clean buffer in the correct format.
    $buffer_start = ' -' . $cleaning_buffer . ' hours';
    $buffer_end = ' +' . $cleaning_buffer . ' hours';
    foreach ($reservations as $reservable_id => $reservable) {
      foreach ($reservable as $reservation_id => $reservation) {
        // Add a buffer for item cleaning if not disabled.
        if ($cleaning_buffer_checks['start_buffer_validation']) {
          $start_value = $reservation->field_reservations_date_value;
          $start_value = date(DATE_FORMAT_DATETIME, strtotime($start_value . $buffer_start));
          $reservations[$reservable_id][$reservation_id]->field_reservations_date_value = $start_value;
        }
        if ($cleaning_buffer_checks['end_buffer_validation']) {
          $end_value = $reservation->field_reservations_date_value2;
          $end_value = date(DATE_FORMAT_DATETIME, strtotime($end_value . $buffer_end));
          $reservations[$reservable_id][$reservation_id]->field_reservations_date_value2 = $end_value;
        }
      }
    }
  }



  $reservations_by_date = array();

  //for each day we are looking at.
  while ($start_date <= $end_date) {

    $day = date('w', strtotime($start_date));

    // Are we open on this $day?
    if (!empty($hours[$day])) {
      // Cycle the items.
      foreach ($reservations as $item => $values) {

        $reservations_by_date[$start_date][$item] = array();

        $close = strtotime($start_date . ' ' . $hours[$day]['close']);

        // all the reservations for that item.
        foreach ($values as $reservation) {

          // We need to reset the time for each of the reservations.
          $time = strtotime($start_date . ' ' . $hours[$day]['open']);

          // Convert to site timezone.
          $tz_start_date       = reservations_create_local_date_object($reservation->field_reservations_date_value);
          $tz_end_date         = reservations_create_local_date_object($reservation->field_reservations_date_value2);

          $tz_start_date = $tz_start_date->format('U');
          $tz_start_date = $tz_start_date < $close ? $tz_start_date : $close;

          // need to account for overdue items that are unavailable
          if (isset($reservation->overdue) && $reservation->overdue) {
            $tz_end_date = $close;
            // LOTTIE OVERDUE CLEANUP
            //dpm(date("Y-m-d H:i:s", $tz_end_date), 'tz_end_date');
            //dpm(date("Y-m-d H:i:s", $close), 'close');
          }
          else {
            $tz_end_date = $tz_end_date->format('U');
            $tz_end_date   = $tz_end_date < $close ? $tz_end_date : $close;
          }

          if ($tz_end_date <= $time) {
            continue;
          }
          while ($time < $tz_start_date) {
            // Make sure to not override a slot that has been set to unavailable.
            if (!isset($reservations_by_date[$start_date][$item][date('H:i', $time)])) {
              $reservations_by_date[$start_date][$item][date('H:i', $time)] = array(
                'class' => 'available',
                'data' => '',
              );
            }
            $time += 15 * 60;
          }
          while ($time >= $tz_start_date && $time < $tz_end_date) {
            $reservations_by_date[$start_date][$item][date('H:i', $time)] = array(
              'class' => 'unavailable',
              'data' => $reservation->nid,
            );
            $time += 15 * 60;
          }
          $time = $tz_end_date;
        }
        while ($time < $close) {
          // Make sure to not override a slot that has been set to unavailable.
          if (!isset($reservations_by_date[$start_date][$item][date('H:i', $time)])) {
            $reservations_by_date[$start_date][$item][date('H:i', $time)] = array(
              'class' => 'available',
              'data' => '',
            );
          }
          $time += 15 * 60;
        }
      }
    }
    $start_date = date('Y-m-d', strtotime($start_date . ' +1 day'));
  }

  $variables['reservations_by_date'] = $reservations_by_date;

  $pretty_hours = array();

  foreach ($reservations_by_date as $date => $values) {
    $day = date('w', strtotime($date));
    $time = $hours[$day]['open'];

    while ($time < $hours[$day]['close']) {
      $pretty_hours[$date][] = date('ga', strtotime($time));
      $time = date('H:i', strtotime($time . ' +1 hour'));
      //avoids overflow to next day
      if($time < '01:00') {
        break;
       }
    }
  }

  $variables['pretty_hours'] = $pretty_hours;
}


/**
 * Theme the reservation form for choices.
 */
function theme_reservations_choices($variables) {
  $form = $variables['form'];
  // Change the button title to reflect the behavior when using JavaScript.
  //drupal_add_js('if (Drupal.jsEnabled) { $(document).ready(function() { $("#edit-reservations-more").val("'. t('Add another item') {  .'"); }); }', 'inline');}

  $output = '';
  $output .= drupal_render_children($form);
  return $output;
}
/**
 * Builds the reserved items table.
 */
function theme_reservations_build_reservation_table_display($variables) {

  $form = $variables['form'];

  $output = theme('status_messages');
  $header = $form['#header'];
  // fix to deal with missing header col
  if (!isset($header[1])) {
    $header[1] = NULL;
  }

  $node   = $form['#node'];
  $rows   = array();
  foreach (element_children($form) as $did) {
    if (strstr($did, 'form_')) {
      continue;
    }
    $values = $form[$did];
    $values['display_name']['#type'] = 'markup';
    $name = drupal_render($values['display_name']);

    if ($values['reservations_item_nid']['#type'] == 'value') {
      $item = ($values['display_item_title']['#markup']) ?
	drupal_render($values['display_item_title']) :
	t('SPECIFIC ITEM NOT SELECTED');
    }
    else {
      $item = drupal_render($values['reservations_item_nid']);
    }

    $row = array(
      $item,
      $name,
    );

    foreach ($form['#header'] as $index => $value) {
      if ($value == t('Accessories')) {
        $row[$index] = drupal_render($values['accessories']);
      }
      elseif ($value == t('Operations')) {
        $row[$index] = drupal_render($values['ops']);
      }
      elseif (strstr($value, t('Check In'))) {
        $row[$index] = drupal_render($values['reservations_checkin_checkbox']);
      }
      elseif (strstr($value, t('Remove Item'))) {
        $row[$index] = drupal_render($values['reservations_remove_item_checkbox']);
      }



      elseif (strstr($value, t('Item Condition'))) {
        $row[$index] =
	  drupal_render($values['reservations_checkin_item_condition']);
      }
      elseif (strstr($value, t('Condition Notes'))) {
        $row[$index] =
	  drupal_render($values['reservations_checkin_condition_notes']);
      }

    }

    $rows[$did] = $row;
  }

  if (!empty($rows)) {
    if (!$node->is_edit_mode) {
      $table_caption = t('Reserved Items');
    }
    else if ($node->reservations_reservation_status ==
	RESERVATIONS_STATUS_CHECKED_OUT) {
      $table_caption = t('Checked out items');
    }
    else if($node->reservations_reservation_status ==
	    RESERVATIONS_STATUS_CHECKED_IN) {
      $table_caption = t('Checked in items');
    }
    else if ($node->reservations_reservation_status >
	     RESERVATIONS_STATUS_CHECKED_IN) {
      $table_caption = t('Reserved Items');
    }
    else {
      $table_caption = t('Select items to reserve');
    }

    $output .=
      '<div class="existing-items-table-header">' . $table_caption . ':</div>';

    $height = variable_get('reservation_items_scroll_size', 500);
    $output .= '<div style="overflow-y:auto; height:'.$height.'px">';
    $output .= theme('table', array('header' => $header, 'rows' => $rows));
    $output .= "</div>";
  }
  $output .= theme('status_messages');

  return $output;
}


