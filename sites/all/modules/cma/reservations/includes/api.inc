<?php

/**
 * @file
 * Reservations API
 +---------------------------------------------------------------------------+
 | Copyright (C) 2009 Openflows, Inc. + Blue Bag. All rights reserved.       |
 | Additionally, Kevin Reynen                                                |
 |                                                                           |
 | This work is published under the GNU AGPLv3 license without any           |
 | warranty. For full license and copyright information, see                 |
 | https://www.gnu.org/licenses/agpl-3.0.html                                |
 +---------------------------------------------------------------------------+
 */


/**
 * Validates the reservablility of a items selected
 *
 * @param $node
 *   The item node.
 */
function reservations_validate_reservations_selected_items($form, &$form_state) {
//dsm('reservations_validate_reservations_selected_items');

  $messages = array();
  $node = (object) $form_state['values'];

  $langcode = $node->language;
  // ****
  // Build date objects we'll need for our different validations.
  // ****
  $start = $node->field_reservations_date[$langcode][0]['value'];
  $end = $node->field_reservations_date[$langcode][0]['value2'];

  // IS THIS RIGHT?  OR DOUBLE CONVERTING
  // IT'S USING THE FIELD VALUE
  $backtoback = variable_get('reservations_back_to_back_allowed', 0);
  if ($backtoback) {
    $end = date('Y-m-d H:i:s', strtotime($end) - 1);
    $start = date('Y-m-d H:i:s', strtotime($start) + 1);
  }


  //OPENFLOWS - LOTTIE - 4/10/18
  // load the items based on content type into this-res-items
  $content_type_items = reservations_content_type_items($node);

  //OPENFLOWS - LOTTIE - 4/11/18
  // is this an existing reservation?
  $vid = isset($node->vid) ? $node->vid : NULL;
  $inventory_tid = $node->field_reservations_inventory[LANGUAGE_NONE][0]['tid'];


  // Cycle all the reservation items.
  foreach ($node->reservations_reservation_items as $did => $item) {
      // Bucket choice?
    if (!is_numeric($item['reservations_item_nid'])) {
      $item['type'] = $item['reservations_item_nid'];
      $item['reservations_item_nid'] = 0;
    }
//    // If the item his beying checked in - may be useful at a later stage.
//    if (isset($item['reservations_checkin_checkbox']) && $item['reservations_checkin_checkbox']) {
//      // Skip its validation.
//      continue;
//    }

    // Get the title of the item.
    // Also get the content type for new resource items.
    if (!isset($item['item_title']) or !isset($item['type'])) {
      $new_item = node_load($item['reservations_item_nid']);

      if ($new_item) {
        $item['item_title'] = $new_item->title;
        $item['type'] = $new_item->type;
        $item['inventory_tid'] = $inventory_tid;
      }
      else {
        $content_settings = reservations_load_item_settings($item['type']);
        $item['item_title'] = $content_settings->type_name;
      }
    }

    $messages[$did] = '';

    // skip over the empty selections
    // checking for type ensures we catch clones as well
    if (empty($item['type'])) {
      continue;
    }

    if (isset($item['type'])) {
      $type = $item['type'];
      $item_nid = $item['reservations_item_nid'];
      $title = $item['item_title'];

      // Is this content type active?
      $content_settings = reservations_load_item_settings($type);
      if ($content_settings->reservations_active_status != RESERVATIONS_STATUS_ACTIVE) {
        $messages[$did] = '<div> ' . t("%name is not active.", array('%name' => $title)) . '</div>';
        form_set_error("reservations_reservation_items][$did][reservations_item_nid", $messages[$did]);
        continue;
      }

      // Does the user have access to manage reservations or this content type?
      if (!user_access('manage reservations') && !reservations_check_content_type_user_permissions($type)) {
        $messages[$did] = '<div> ' . t("You do not have permission to reserve %name.", array('%name' => $title)) . '</div>';
        form_set_error("reservations_reservation_items][$did][reservations_item_nid", $messages[$did]);
        continue;
      }

      // Did the user select too many of the same bucket item?
      if (reservations_type_setting($type) == 'bucket') {
        $selected_count[$type] = isset($selected_count[$type]) ? $selected_count[$type] + 1 : 1;
        if (!isset($inventory_count[$type])) {
          $inventory_count[$type] = reservations_get_available_bucket_count($type);
        }

        if ($selected_count[$type] > $inventory_count[$type]) {
          $msg = '<div> ' . t("You've selected too many %name's.  We only have %amount in the current inventory.", array(
              '%name' => $title,
              '%amount' => $inventory_count[$type]
            )) . '</div>';
          if (!in_array($msg, $messages)) {
            $messages[$did] = $msg;
            form_set_error("reservations_reservation_items][$did][reservations_item_nid", $messages[$did]);
          }
          else {
            // Highlight the element without displaying a duplicate message.
            $messages[$did] = $msg;
            form_set_error("reservations_reservation_items][$did][reservations_item_nid", '');
          }
          continue;
        }
      }

      // Guy: I do not see how this will ever get called. as nothing setting
      // $selected_count[$item_nid]).
      // Did the user select too many of the same item?
      if ($item_nid) {
        if (isset($selected_count[$item_nid])) {
          $inventory_count = 1;
          $msg = '<div> ' . t("You've selected too many %name's.  We only have %amount in the current inventory.", array(
              '%name' => $title,
              '%amount' => $inventory_count
            )) . '</div>';
          if (!in_array($msg, $messages)) {
            $messages[$did] = $msg;
            form_set_error("reservations_reservation_items][$did][reservations_item_nid", $messages[$did]);
          }
          else {
            // Highlight the element without displaying a duplicate message.
            $messages[$did] = $msg;
            form_set_error("reservations_reservation_items][$did][reservations_item_nid", '');
          }
          continue;
        }
        else {
          $selected_count[$item_nid] = 1;
        }
      }

      //IS THE ITEM AVAILABLE?

      // Overdue items validation: Is it overdue?
      $overdue_items_array = reservations_overdue_items($type, $start, $node->nid);

      if (reservations_type_setting($type) == 'bucket') {
        $items_overdue_currently = count($overdue_items_array);
        $available_bucket_items_count = $inventory_count[$type] - $items_overdue_currently;

        if ($available_bucket_items_count < 1) {
            $messages[$did] = '<div> ' . t("%name is not available because all items are currently overdue", array('%name' => $title)) . '</div>';
            // get the reservation information for each overdue reservation
            foreach ($overdue_items_array as $reservations) {
                foreach (array_keys($reservations) as $nid) {
                    $overdue = node_load($nid);
                    // compare w/ overdue window
                    $messages[$did] .= '<div> ' . l($overdue->title, 'node/' . $overdue->nid) . '</div>';
                }
            }
            if (!in_array($msg, $messages)) {
                form_set_error("reservations_reservation_items][$did][reservations_item_nid", $messages[$did]);
            }
            else {
                // Highlight the element without displaying a duplicate message.
                form_set_error("reservations_reservation_items][$did][reservations_item_nid");
            }
        }
      }
      else {  // resource
        if (!empty($overdue_items_array)) {
          $has_overlap = FALSE;
          $msg_detail = '';
          foreach ($overdue_items_array as
                   $reserved_item_nid => $reservations) {
            if ($reserved_item_nid == $item_nid) {
              $has_overlap = TRUE;
              foreach (array_keys($reservations) as $nid) {
                $overdue = node_load($nid);
                $msg_detail .= '<div> ' .
                  l($overdue->title, 'node/' . $overdue->nid) . '</div>';
              }
            }
          }
          if ($has_overlap) {
            $msg = '<div> ' .
              t("%name is not available because it is still checked out by:",
                array('%name' => $title)) . '</div>' . $msg_detail;


            if (!in_array($msg, $messages)) {
              $messages[$did] = $msg;
              form_set_error("reservations_reservation_items][$did]" .
                "[reservations_item_nid", $messages[$did]);
            }
            else {
              // Highlight the element without displaying a duplicate message.
              $messages[$did] = $msg;
              form_set_error("reservations_reservation_items][$did]" .
                "[reservations_item_nid", '');
            }


            continue;
          }
        }
      }

      // Check item restrictions.  max hours, etc.
      $restrictions = reservations_check_content_type_restrictions($type, $start, $end);

      if (!empty($restrictions)) {
        foreach ($restrictions as $restriction) {
          $messages[$did] .= '<div>' . t($restriction, array('%name' => $title)) . '</div>';
        }
        form_set_error("reservations_reservation_items][$did][reservations_item_nid", $messages[$did]);
        continue;
      }

      // Are we checking an existing item?
      //OPENFLOWS - LOTTIE - 4/12/18
      // moved up - if it exists, regardless of whether I'm adding new items
      // I will use the vid exclude this res items
      //$vid = isset($item['did']) ? $node->vid : NULL;

      // is it available?
      $count =
        reservations_is_item_reservable($content_type_items[$type], $type, $start, $end, $item_nid, $vid, $inventory_tid);
      if (!$count) {
        // get the reservation information for each overdue reservation
        $msg = '';
        foreach ($overdue_items_array as $reservations) {
          foreach (array_keys($reservations) as $nid) {
            $overdue = node_load($nid);
            // compare w/ overdue window
            $msg .= '<div> ' . t("%name is not available because it is still checked out by:", array('%name' => $title)) . '</div>';
            $msg .= '<div> ' . l($overdue->title, 'node/' . $overdue->nid) . '</div></br>';
          }
        }
        $msg .= reservations_theme_conflict_grid(
          $type, $title, $start, $end, $item_nid, $vid, $inventory_tid);

        if (!in_array($msg, $messages)) {
          $messages[$did] = $msg;
          form_set_error("reservations_reservation_items][$did][reservations_item_nid", $messages[$did]);
        }
        else {
          $messages[$did] = $msg;
          form_set_error("reservations_reservation_items][$did][reservations_item_nid", '');
        }
        continue;
      }

    }
  }
  return $messages;
}

/**
 * Validates the dates against hours of operation, max advance, closed dates
 *
 * $override_end_date
 *   Allows to overide the date to use as instead of the end date.
 *
 * $override_end_date_form_element
 *  The form element to use in case $override_end_date fails.
 *
 * @param $node
 *   The item node.
 */
function reservations_validate_reservations_reservation_date($form, &$form_state, $validation_override, $override_end_date = NULL, $override_end_date_form_element = NULL) {

  // We skip all checks if user chose to override validation.
  if ($validation_override) {
    $s = t('All reservation date checks have been disabled resulting from the the use of "Override Validation".');
    reservations_verbose_logging($s);
    drupal_set_message($s, 'warning');
    return;
  }


  if (isset($override_end_date_form_element)) {
    $end_fld = $override_end_date_form_element . '[date';
    $end_fld_time = $override_end_date_form_element . '[time';
  }
  else {
    $end_fld = 'field_reservations_date][und][0][value2][date';
    $end_fld_time = 'field_reservations_date][und][0][value2][time';
  }

  $node = (object) $form_state['values'];
  // The state the reservation is in / (original state).
  $reservation_state = $node->reservations_original_reservation_status;
  $reservation_checked_out = ($reservation_state == RESERVATIONS_STATUS_CHECKED_OUT);
  $new_status = $node->reservations_reservation_status;

  $reservations_manager = user_access('manage reservations');

  $langcode = $form_state['node']->language;
  $backtoback = variable_get('reservations_back_to_back_allowed', 0);
  // Build date objects we'll need for our different validations.
  $start = $node->field_reservations_date[$langcode][0]['value'];
  if (isset($override_end_date)) {
    $end = $override_end_date;
  }
  else {
    $end = $node->field_reservations_date[$langcode][0]['value2'];
  }
  $start_object = reservations_create_local_date_object($start, 'start', $backtoback);
  $end_object = reservations_create_local_date_object($end, 'end', $backtoback);
  $start_day_of_week = (int) date_format($start_object, 'w');
  $end_day_of_week = (int) date_format($end_object, 'w');
  $start_month_day = date_format($start_object, 'm-d');
  $end_month_day = date_format($end_object, 'm-d');


  // Hours of operation restrictions, max days, and closed dates checks
  //closed days are only avaialable from global hours so we have to retrieve
  //both hours even if inventory exists;
  $hours_of_operation_global = reservations_load_hours_of_operation();

  if (empty($hours_of_operation_global)) {
    form_set_error('Reservations', "You cannot make a Reservation until " .
      "the Hours of Operation have been configured in the Reservation admin " .
      "settings.");
    return;
  }

  $exist_inventory_hrs = FALSE;
  $restrictions = array();

  if (module_exists('reservations_inventory')) {

    // Get the inventory tid.
    $inventory_tid =
      $node->field_reservations_inventory[LANGUAGE_NONE][0]['tid'];

    // Load hours of operation.
    $hours_of_operation_inv = module_invoke(
      'reservations_inventory', 'get_hours_of_operation', $inventory_tid);
    if (isset($hours_of_operation_inv['exist_inventory_hrs'])) {
      $exist_inventory_hrs = $hours_of_operation_inv['exist_inventory_hrs'];
    }
    else {
      $exist_inventory_hrs = FALSE;
    }

    // Load restrictions.
    $restrictions = module_invoke(
      'reservations_inventory', 'get_restrictions', $inventory_tid);
  }

  // Get the next end day as it may be needed later.
  $nextday_end_number = ($end_day_of_week + 1 == 8) ? 0 : ($end_day_of_week + 1);


  // if no inventory hours, use global hours
  $hours_of_operation =
    $exist_inventory_hrs ? $hours_of_operation_inv : $hours_of_operation_global;

  // Get the opening hours for the day the reservation starts.
  $start_hours = $hours_of_operation[$start_day_of_week];
  // Get the opening hours for the day the reservation ends.
  $end_hours = $hours_of_operation[$end_day_of_week];
  // Get the opening hours for the day after the reservation ends.
  $nextday_end_hours = $hours_of_operation[$nextday_end_number];

  // Do we have restricted hours?
  if (isset($restrictions['restricted_hours_of_operations'])
    && $restrictions['restricted_hours_of_operations'])
  {
    // Load the restricted hours.
    $restricted_hours = module_invoke(
      'reservations_inventory', 'get_restricted_hours_of_operation', $inventory_tid);

    // Get the opening hours for the day the reservation starts.
    if (isset($restricted_hours[$start_day_of_week])) {
      $start_hours = $restricted_hours[$start_day_of_week]['start_hours'];
      $force_hours = $restricted_hours[$start_day_of_week]['force_hours'];
    }
    else {
      $start_hours = NULL;
      $force_hours = NULL;
    }

    // Get the opening hours for the day the reservation ends.
    if (isset($restricted_hours[$end_day_of_week])) {
      $end_hours = $restricted_hours[$end_day_of_week]['end_hours'];
    }
    else {
      $end_hours = NULL;
    }

    // Get the opening hours for the day after the reservation ends.
    $nextday_end_hours = $restricted_hours[$nextday_end_number]['end_hours'];


  }


  // Global Max days.
  $max_days = variable_get("reservations_max_days_advance_reservation", '0');
  // If we have an inventory level max days restriction use that instead of global.
  if (isset($restrictions['reservations_max_days_advance_reservation'])
  && is_numeric($restrictions['reservations_max_days_advance_reservation'])) {
    $max_days = $restrictions['reservations_max_days_advance_reservation'];
  }
  // If we have an inventory level advance min hours restriction use it.
  if (isset($restrictions['reservations_min_hours_advance_reservation'])) {
    $min_hours = $restrictions['reservations_min_hours_advance_reservation'];
  }
  else {
    // No advance min restriction.
    $min_hours = 0;
  }
  // If we have an inventory level min booking time.
  if (isset($restrictions['reservations_min_hrs'])) {
    $min_booking_time = $restrictions['reservations_min_hrs'];
  }
  else {
    $min_booking_time = 0;
  }
  // If we have an inventory level max booking time.
  if (isset($restrictions['reservations_min_hrs'])) {
    $max_booking_time = $restrictions['reservations_max_hrs'];
  }
  else {
    $max_booking_time = 0;
  }

  // Users in role with Administer Reservations permssion or outside hours of
  $skip_hours_of_op = user_access('create reservations outside hours of operation');
  if ($skip_hours_of_op) {
    //
    // Operation skip these some checks.
    reservations_verbose_logging('SKIP Hours of Operation Check because user has create reservations outside hours of operation permission');

    // Check to see if warning should be displayed
    if (!empty($start) && !empty($end)) {
      if (
        strtotime(date('G:i', strtotime($start . ' UTC'))) < strtotime($start_hours['open'])
        || strtotime($start_hours['close']) < strtotime(date('G:i', strtotime($end . ' UTC')))
      ) {
        drupal_set_message(t('You are making a Reservation outside the normal hours of operation. This may impact access to the items you are reserving.'), 'warning');
      }
    }
  }
  if (!$reservation_checked_out) {
    // Reservation start date cannot exceed the max advance
    reservations_verbose_logging('CHECKING Max Days');
    if ($max_days) {
      $max_date = new DateTime("+$max_days day");
      //$max_date = date('m-d-Y', mktime(0, 0, 0, date("m"), date("d")+$max_days, date("Y")));
      if ($start_object > $max_date) {
        form_set_error('field_reservations_date][und][0][value][date', t('You cannot make a Reservation more than %days days in advance. Start the Reservation before %date.', array(
          '%days' => $max_days,
          '%date' => date_format($max_date, 'm-d-Y')
        )));
      }
    }
  }
  // Check for advance min hours restriction if set.
  if ($min_hours && !$reservations_manager && (in_array($new_status, [RESERVATIONS_STATUS_UNCONFIRMED, RESERVATIONS_STATUS_PENDING]))) {
    reservations_verbose_logging('CHECKING Min Hours');
    $min_date = new DateTime("+$min_hours hour");
    if ($start_object < $min_date) {
      form_set_error('field_reservations_date][und][0][value][date', t('You must make a Reservation at list %hours hours before the reservation start %date.', array(
        '%hours' => $min_hours,
        '%date' => date_format($min_date, 'm-d-Y H:i')
      )));
    }
  }


  // Check for min booking time (in hour).
  if ($min_booking_time) {
    reservations_verbose_logging('CHECKING Min booking time');
    // Convert decimal hours hours and minutes.
    $hrs = (int)$min_booking_time;
    $min = (int)(($min_booking_time-$hrs)*60);
    // Calculate the minimum end time.
    $min_end_time = clone $start_object;
    $min_end_time->add(new DateInterval("PT{$hrs}H{$min}M"));
    // Remove 2 seconds.
    $min_end_time->sub(new DateInterval("PT2S"));
    // Check.
    if ($min_end_time > $end_object) {
      form_set_error( $end_fld_time, t('The minimum time for this reservation is %hours hours.', array(
        '%hours' => $min_booking_time)
      ));
    }
  }
  // Check for max booking time (in hour).
  if ($max_booking_time) {
    reservations_verbose_logging('CHECKING Max booking time');
    // Convert decimal hours hours and minutes.
    $hrs = (int)$max_booking_time;
    $min = (int)(($max_booking_time-$hrs)*60);
    // Calculate the minimum end time.
    $max_end_time = clone $start_object;
    $max_end_time->add(new DateInterval("PT{$hrs}H{$min}M"));
    // Add 2 seconds.
    $max_end_time->add(new DateInterval("PT2S"));
    // Check.
    if ($max_end_time < $end_object) {
      form_set_error($end_fld_time, t('The maximum time for this reservation is %hours hours.', array(
          '%hours' => $max_booking_time)
      ));
    }
  }

  // Can't start or end a reservation on days that are
  // closed dates.
  reservations_verbose_logging('CHECKING Closed Dates');
  if (in_array($start_month_day, $hours_of_operation_global['closed_days'])) {
    $name = date_format($start_object, 'F jS');
    form_set_error('field_reservations_date][und][0][value][date', t('Sorry, but we are closed on %day for a holiday or special event.', array('%day' => $name)));
  }
  if (in_array($end_month_day, $hours_of_operation_global['closed_days'])) {
    $name = date_format($end_object, 'F jS');
    form_set_error($end_fld, t('Sorry, but we are closed on %day for a holiday or special event.', array('%day' => $name)));
  }


  // Can't start or end a reservation on a day the facility
  // has no hours of operation, or outside hours of operation.
  if (!$reservation_checked_out) {
    reservations_verbose_logging('CHECKING Hours of Operation');
    $start_name = date_format($start_object, 'l');
    if (!$start_hours) {
      form_set_error('field_reservations_date][und][0][value][date', t('Reservations cannot start on a %day.', array('%day' => $start_name)));
    } else {
      $start_time = date_format($start_object, 'H:i');
      // Is checkout/start time before opening hours.
      if ($start_time < $start_hours['open']) {
        if (!$skip_hours_of_op) {
          form_set_error('field_reservations_date][und][0][value][time', t('Reservations cannot start at a time before %start.',
            array('%start' => reservations_format_time($start_hours['open']))));
        }
      } // Is checkout/start time, is restricted to specific hours?
      elseif (isset($force_hours)) {
        reservations_verbose_logging('CHECKING restricted start time');
        if (!in_array($start_time, $force_hours)) {
          form_set_error('field_reservations_date][und][0][value][time', t('Reservations can only start at the following times %start_times.',
            array('%start_times' => implode(',', $force_hours))));
        }
      } // Is checkout/start time after close time for that day.
      elseif ($start_time > $start_hours['close']) {
        if (!$skip_hours_of_op) {
          reservations_verbose_logging('CHECKING start time is not after close time');
          form_set_error('field_reservations_date][und][0][value][time', t('Reservations cannot start at a time after %end.',
            array('%end' => reservations_format_time($start_hours['close']))));
        }
      }
    }
  }

  //TODO: OPENFLOWS - THIS NEEDS TO BE REVIEWS
  $end_name = date_format($end_object, 'l');
  if (!$end_hours) {
    //check for push on end day
    if (user_access('push forward over closed days') && variable_get('reservations_' . strtolower($end_name) . '_push', 0)) {
      //check all equipment?


      //check the next 2 days
      $nextday = $end_object->add(new DateInterval('P1D'));
      $nextday_name = date_format($nextday, 'l');

      if ($nextday_end_hours) {

        $openinghour = $nextday_end_hours['open'];
        $pushedduehour = strtotime($openinghour . ' + ' . variable_get('reservations_push_hours', '1') . ' hours');

        $openinghour_formatted = reservations_format_time($openinghour);
        $pushedduehour_formatted = reservations_format_time(date("H:i", $pushedduehour));

        form_set_error($end_fld, t('Reservations cannot end on %day.  The items you are reserving allow extending the normal maximum reservation hours by pushing the due date forward to %nextday and ending between %openhour and %pushedhour.', array(
          '%day' => $end_name,
          '%nextday' => $nextday_name,
          '%openhour' => $openinghour_formatted,
          '%pushedhour' => $pushedduehour_formatted
        )));
      }
      else {
        form_set_error($end_fld, t('Reservations cannot end on a %day.', array('%day' => $end_name)));
      }

    }
    else {
      form_set_error($end_fld, t('Reservations cannot end on a %day.', array('%day' => $end_name)));
    }
  }
  else {
    $end_time = date_format($end_object, 'H:i');
    if ($end_time < $end_hours['open']) {
      if (!$skip_hours_of_op) {
        form_set_error($end_fld_time, t('Reservations cannot end at a time before %start.',
          array('%start' => reservations_format_time($end_hours['open']))));
      }
    }
    elseif ($end_time > $end_hours['close']) {
      if (!$skip_hours_of_op) {
        form_set_error($end_fld_time, t('Reservations cannot end at a time after %end.',
          array('%end' => reservations_format_time($end_hours['close']))));
      }
    }
  }


}

function reservations_get_user_account($username) {
  // Function that returns the uid based on the username given
  $result = db_query("SELECT uid FROM {users} WHERE name = :username",
    array(":username" => $username));

  foreach ($result as $user) {
    $uid = $user->uid;
  }
  $account = user_load($uid);

  return $account;
}

//if beginning status was checked out, if we have check box values coming in
//or end status is checked in, and all our check boxes are empty we will
//throw validation errors
function  reservations_validate_checked_in_reservation_items($form, $form_state) {
  $node = (object) $form_state['values'];
  $orig_status = $node->reservations_original_reservation_status;
  $new_status = $node->reservations_reservation_status;

  $checked_items = $changed_status_items = $condition_notes_items = array();

  foreach ($node->reservations_reservation_items as $did => $item) {


    if ($item['reservations_checkin_checkbox']) {
      $checked_items[] = $item['reservations_checkin_checkbox'];
    }
    else {
      if ($item['reservations_item_nid']) {
        $item_node = node_load($item['reservations_item_nid']);
        $tid = reservations_get_single_field_value($item_node,
          'field_equipment_item_status',
          'tid');

        if ($tid && $tid != $item['reservations_checkin_item_condition']) {
          $changed_status_items[] = $item;
        }
        else {
          if ($item['reservations_checkin_condition_notes']) {
            $condition_notes_items[] = $item;
          }
        }
      }
    }
  }
  if ($orig_status == RESERVATIONS_STATUS_CHECKED_OUT &&
    $new_status == RESERVATIONS_STATUS_CHECKED_IN &&
    !$checked_items) {
  }
  else {
    if ($orig_status == RESERVATIONS_STATUS_CHECKED_OUT &&
      $new_status == RESERVATIONS_STATUS_CHECKED_OUT &&
      $checked_items) {
      $field = '';

      $error =
        t('You checked one of the checkboxes in the "Checked Out items"' .
          ' table below. If you are meaning to check in items, you must ' .
          'change the "Status" field to "Checked in", even if you are not ' .
          'returning all of the items.');
    }
    else {
      if ($orig_status == RESERVATIONS_STATUS_CHECKED_OUT &&
        $new_status == RESERVATIONS_STATUS_CHECKED_OUT &&
        ($condition_notes_items || $changed_status_items)) {
        $field = '';

        $error =
          t('You either changed the "Condition" of an inventory item or updated ' .
            'the "Condition Notes" but did not change the status to "Checked In".' .
            ' "Condition" changes can only be made when checking in.');
      }
    }
  }

  if ($error) {
    form_set_error($field, $error);
  }
}


function reservations_validate_status(&$form, &$form_state) {
  $node = (object) $form_state['values'];
  $langcode = $form_state['node']->language;
  // Reservations with a checked out status.
  if ($node->reservations_reservation_status == RESERVATIONS_STATUS_CHECKED_OUT) {
    // Make sure all existing bucket reservations have an item assigned.
    if (empty($node->reservations_reservation_items)) {
      form_set_error('reservations_reservation_status', t('You can not finalize a reservation that has no reserved items.'));
    }
    else {
      foreach ($node->reservations_reservation_items as $did => $item) {
        // if there is a placeholder, but an real reservabled node hasn't been selected
        if (isset($item['reservations_placeholder_nid']) && $item['reservations_item_nid'] == "0") {
          // OPENFLOWS - Lottie - this had been removed but is needed - putting back
          form_set_error("reservations_reservation_items][$did][reservations_item_nid", t("The reservation for %title must have an item associated with it for finalized reservations.", array('%title' => $item['name']))); // LOTTIE
        }
        // Can't add a bucket item and finalize at the same time.
        if (!is_numeric($item['reservations_item_nid']) and drupal_strlen($item['reservations_item_nid'])) {
          form_set_error("reservations_reservation_items][$did][reservations_item_nid", t("You cannot finalize a reservation while adding a bucket item."));
        }
      }
    }
  }
  // Prevent status changes on reservations that have past.
  $current_status = $node->reservations_original_reservation_status;
  if ($current_status &&
    $current_status != $node->reservations_reservation_status &&
    time() > strtotime($node->field_reservations_date[$langcode][0]['value2'])
    && !in_array((int) $node->reservations_reservation_status,
      array(
        RESERVATIONS_STATUS_CANCELLED,
        RESERVATIONS_STATUS_CHECKED_IN,
        RESERVATIONS_STATUS_DENIED
      ))) {
    $statuses = reservations_record_status();
    form_set_error('reservations_reservation_status', t('You cannot change the status to %status for a reservation that has past.', array('%status' => $statuses[$node->reservations_reservation_status])));
  }
}

/**
 * Validates the state change of a reservable item.
 *
 * @param $node
 *   The item node.
 */
function reservations_validate_default_availability($element, &$form_state) {

  // Only perform the check if the item is set to an unavailable state.
  if (in_array((int) $element['#value'], array(
    RESERVATIONS_UNA_F,
    RESERVATIONS_UNA_S
  ))) {

    $bad_reservations = reservations_incomplete_reservations_for_item_nid($form_state['values']['nid']);
    if (!empty($bad_reservations)) {
      $output = '<ul>';
      foreach ($bad_reservations as $node) {
        $output .= '<li>' . $node . '</li>';
      }
      $output .= '</ul>';
      form_set_error('reservations_default_availability', t('%title can not be set to an unavailable status until it is removed from the following reservations:', array('%title' => $form_state['values']['title'])) . $output);

    }
  }
}


/**
 * Validation for numeric textfields.
 */
function reservations_is_numeric_validate($form) {
  if ($form['#value'] && !is_numeric($form['#value'])) {
    form_set_error($form['#name'], t('%title must be a number.', array('%title' => $form['#title'])));
  }
}


/**
 * Custom validation function to protect reservations nodes from mass deletion.
 */
function reservations_node_admin_delete_validate($form, &$form_state) {

  // Look only for delete op.
  $operation = $form_state['values']['operation'];
  if ($operation != 'delete') {
    return;
  }
  // Get the checked nodes.
  $nids = array_filter($form_state['values']['nodes']);

  // Perform the check for each submitted node.
  foreach ($nids as $nid) {
    $node = node_load($nid);

    // Check to see if any of the nodes should not be deleted.
    if (!reservations_delete_item_validate($node)) {
      // If so, then unset the checked node so it will not be processed, and display a warning.
      // Note that the array element has to be completely removed here in order to prevent the
      // node from being deleted, due to the nature of the mass deletion callback.
      unset($form_state['values']['nodes'][$nid]);
      unset($nids[$nid]);
    }
  }

  // If we've unset all of the nodes that were checked, then don't continue with the form processing.
  if (!count($nids)) {
    drupal_set_message(t('No nodes selected.'), 'error');
    drupal_goto('admin/content/node');
  }
}


function reservations_validate_empty_reservation_items($form, &$form_state) {

  $node = (object) $form_state['values'];
  $choices = $node->reservations_reservation_items;
  $unselected = 0;

  foreach ($choices as $did => $item) {
    if (is_array($item)) {
      $value = $item['reservations_item_nid'];
    }
    else {
      $value = $item;
    }

    if (is_numeric($did) and !$value) {
      $value = $item['type'];
    }

    if (!$value) {
      $unselected++;
    }
  }

  if ($unselected == count($choices)) {
    $first = array_shift(array_keys($choices));
    if (isset($form_state['clicked_button']) && $form_state['clicked_button']['#value'] != 'Preview') {
      form_set_error("reservations_reservation_items][$first][reservations_item_nid",
        t("You cannot create a reservation without any items selected."));
    }
  }
}

/**
 * Submit handler for saving Reservations node type data.
 */
function reservations_node_type_save_submit($form, &$form_state) {
  if ($form_state['clicked_button']['#value'] == t('Save content type')) {
    $settings = $form_state['values'];
    //$existing = db_result(db_query("SELECT type FROM {reservations_node_type} WHERE type = '%s'", $settings['type']));
    $existing = reservations_node_type_existing($settings['type']);
    if (!$existing) {
      $return = drupal_write_record('reservations_node_type', $settings);
    }
    else {
      $return = drupal_write_record('reservations_node_type', $settings, 'type');
    }
    cache_clear_all('reservations_' . $settings['type'] . '_data', 'cache');
    cache_clear_all('reservations_content_type_info', 'cache');
    // This hack is necessary because the node type form submit
    // automatically saves all remaining form items to {variable}
    // We're doing custom storage, so remove these.
    // Don't delete reservations_type_setting_

    $variables = array(
      'reservations_max_hours_per_reservation_',
      'reservations_allow_overnight_',
      'reservations_push_',
      'reservations_late_fee_per_hour_',
      'reservations_rate_per_hour_',
      'reservations_fee_free_hours_',
      'reservations_status_',
      'reservations_spare_items_',
      'reservations_min_cancel_hours_',
      'reservations_autocheckout_',
      'reservations_autocheckin_',
      'reservations_selfcheckout_',
    );
    foreach ($variables as $variable) {
      variable_del($variable . $settings['type']);
    }
  }
}


/**
 * Submit handler to add more choices to a reservation form. This handler is used when
 * javascript is not available. It makes changes to the form state and the
 * entire form is rebuilt during the page reload.
 */
function reservations_more_choices_submit($form, &$form_state) {
  // Set the form to rebuild and run submit handlers.
  node_form_submit_build_node($form, $form_state);

}

/**
 * Submit handler to date filter items on a reservation form.
 * It makes changes to the form state and the entire form is
 * rebuilt during the page reload.
 */
function reservations_date_filter($form, &$form_state) {
  // Set the form to rebuild and run submit handlers.
  node_form_submit_build_node($form, $form_state);
}

/**
 * writes additional info to log to aid in troubleshoot configuration
 */
function reservations_verbose_logging($string) {

  if (variable_get('reservations_verbose_logging', 0)) {
    watchdog('reservations', $string);
  }
}




/**
 * Checks for reservation restrictions for a content type.
 *
 * These include maximum hours per reservation, and if the bucket/resource
 * is reservable overnight and/or is configured to push forward.
 *
 * @param $content_type
 *   The content type to be checked.
 * @param $start
 *   The start date of the reservation in DATETIME format and UTC timezone.
 * @param $end
 *   The end date of the reservation in DATETIME format and UTC timezone.
 *
 * @return
 *   An array of warning messages for any restrictions found.
 */
function reservations_check_content_type_restrictions($content_type, $start, $end) {
  if (!user_access('manage reservations')) {

    $type_settings = reservations_load_item_settings($content_type);
    $return = array();

    $backtoback = variable_get('reservations_back_to_back_allowed', 0);
    // Convert start/end dates to local time.
    $start_object = reservations_create_local_date_object($start, 'start', $backtoback);
    $end_object = reservations_create_local_date_object($end, 'end', $backtoback);

    // We want these timestamps generated in UTC.
    $old_timezone = date_default_timezone_get();
    date_default_timezone_set('UTC');
    $start_timestamp = strtotime($start);
    $end_timestamp = strtotime($end);
    date_default_timezone_set($old_timezone);

    $reserved_hours = ($end_timestamp - $start_timestamp) / (60 * 60);
    $start_day_of_week = date_format($start_object, 'w');
    $end_day_of_week = date_format($end_object, 'w');

    // Make sure max hours aren't exceeded.
    if ($type_settings->reservations_max_hours_per_reservation &&
      $reserved_hours > $type_settings->reservations_max_hours_per_reservation) {

      // Override max_hours_per_reservation if we can pash this past the closed days

      // Validate allow_push on the types
      if (user_access('push forward over closed days') || $type_settings->reservations_push) {
        $closed_days = array();
        // Do we allow pushing this reservation forward?
        if ($type_settings->reservations_push) {
          $i = 0;
          foreach (array(
                     'sunday',
                     'monday',
                     'tuesday',
                     'wednesday',
                     'thursday',
                     'friday',
                     'saturday'
                   ) as $day) {
            if (variable_get('reservations_' . $day . '_push', 0)) {
              $closed_days[$i] = TRUE;
            }
            $i++;
          }
        }
        // Do we allow extending a reservtion over days we are closed?
        if (user_access('push forward over closed days')) {
          //FIXME: this sends a parameter $content_type but the load does nothing with it
          $hours_of_operation = reservations_load_hours_of_operation($content_type);
          for ($i = 1; $i <= 6; $i++) {
            if (empty($hours_of_operation[$i])) {
              $closed_days[$i] = TRUE;
            }
          }
        }

        // Only extend if the following day is closed/weekend.
        // TODO check that the end time is not the same day and within the hours of being open.
        if (!$closed_days[date('w', $start_timestamp + 86400)]) {
          $return[] = t('%name cannot be reserved for more than %hours hours.',
            array('%hours' => $type_settings->reservations_max_hours_per_reservation));
        }

        // Only extend the max time if the default max time falls on a weekend.
        if ($closed_days[date('w', $start_timestamp + $type_settings->reservations_max_hours_per_reservation * 60 * 60)]) {
          //Find the next day we are open.
          for ($i = 1; $i <= 6; $i++) {
            if (!$closed_days[date('w', $start_timestamp + $i * 86400)]) {

              // Does the end_day fall here?
              // TODO force time to be exactly when open.
              if ($end_day_of_week != date('w', $start_timestamp + $i * 86400)) {
                $return[] = t('%name cannot be reserved more then one day after a weekend.', array('%hours' => $type_settings->reservations_max_hours_per_reservation));
              }
              break;
            }
          }
        }
      }
      else {
        $return[] = t('%name cannot be reserved for more than %hours hours.', array('%hours' => $type_settings->reservations_max_hours_per_reservation));
      }
    }

    // Validate allow_overnight.
    if (!$type_settings->reservations_allow_overnight) {
      // Need the 48 hour check in case somebody starts and ends their
      // reservation on the same day.
      if ($start_day_of_week != $end_day_of_week || $reserved_hours > 48) {
        $return[] = t('%name cannot be reserved overnight.');
      }
    }
  }
  return (isset($return)) ? $return : NULL;
}



/**
 * Ensures the user has 'edit own [type] content' and 'delete own [type] content'
 * permissions, otherwise they are not allowed to reserve the content type.
 *
 * @return TRUE if the user has access to reserve the content type, FALSE
 *   otherwise.
 */
function reservations_check_content_type_user_permissions($type) {
  return user_access("edit own $type content") && user_access("delete own $type content");
}


function reservations_is_reservations_type($type) {
  return reservations_type_setting($type) != 'disabled';
}

function reservations_type_setting($type) {
  $return = variable_get('reservations_type_setting_' . $type, 'disabled');

  //double check this
  //if ($return == 'disabled') {
  //$return = db_query("SELECT reservations_type_setting FROM {reservations_node_type} WHERE type = :type", array(':type' =>$type))->fetchField();
  //}

  return $return;
}

/**
 * Return a list of all reservations content types.
 *
 * @param $content_type_name
 *   If set, return information on just this type.
 *
 * Do some type checking and set up empty arrays for missing
 * info to avoid foreach errors elsewhere in the code.
 */
function reservations_content_types($type_name = NULL) {
  // handle type name with either an underscore or a dash
  $type_name = !empty($type_name) ? str_replace('-', '_', $type_name) : NULL;

  $info = _reservations_content_type_info();
  if (!isset($type_name)) {
    return $info;
  }
  else {
    return isset($info[$type_name]) ? $info[$type_name] : array();
  }
}

/**
 * Return the name of a type code.
 *
 * @param string|int $code
 *  if int, will return translated name of the code.
 *  if NULL, returns array of codes as keys, and translated strings as value
 *
 * @return string|int
 */
function reservations_item_status($code = NULL) {
  $statuses = array(
    RESERVATIONS_AVA_F => t('Available'),
    RESERVATIONS_UNA_F => t('Unavailable'),
    RESERVATIONS_AVA_T => t('Template Only'),
    RESERVATIONS_UNA_S => t('No Longer in Inventory'),
  );
  if (isset($code)) {
    return $statuses[$code];
  }
  else {
    return $statuses;
  }
}


function reservations_item_reservation_status($code = NULL) {
  // Item status for reservations.
  $statuses = array(
    RESERVATIONS_ITEM_STATUS_AVAILABLE => t('Available'),
    RESERVATIONS_ITEM_STATUS_CHECKED_OUT => t('Checked Out'),
  );
  if (isset($code)) {
    return $statuses[$code];
  }
  else {
    return $statuses;
  }
}

/**
 * Return the name of a status code.
 *
 * @param string|int $code
 *  if int, will return translated name of the code.
 *  if NULL, returns array of codes as keys, and translated strings as value
 *
 * @return string|int
 */
function reservations_record_status($code = NULL) {
  $types = array(
    RESERVATIONS_STATUS_UNCONFIRMED => t('Unconfirmed'),
    RESERVATIONS_STATUS_PENDING => t('Confirmed'),
    RESERVATIONS_STATUS_CHECKED_OUT => t('Checked out'),
    RESERVATIONS_STATUS_CHECKED_IN => t('Checked in'),
    RESERVATIONS_STATUS_NO_SHOW => t('No Show'),
    RESERVATIONS_STATUS_DENIED => t('Denied'),
    RESERVATIONS_STATUS_CANCELLED => t('Cancelled'),
  );

  // allow UI reservation status to be altered with hook
  drupal_alter('reservation_record_status', $types);

  if (isset($code)) {
    return $types[$code];
  }
  else {
    return $types;
  }
}


/**
 * Pulls items available to assign to a bucket for a reservation.
 *
 * @param $node
 *   The reservation node.
 * @param $bucket_type
 *   The bucket type.
 *
 * @return
 *   An array of available items, in select options format.
 */
function reservations_get_available_bucket_items($node, $bucket_type) {

  $langcode = $node->language;
  $date_info = $node->field_reservations_date[$langcode][0];
  $start = $date_info['value'];
  $end = $date_info['value2'];

  $options = reservations_get_reservable_items($bucket_type, $start, $end, $node->nid);

  return $options;
}

function reservations_get_suggested_bucket_item($content_type, $start, $end, $items = array()) {
  $total_items_array = reservations_reserved_bucket_items($content_type, $start, $end);

  foreach ($total_items_array as $item_nid => $node) {
    if (empty($total_items_array[$item_nid]) && !in_array($item_nid, $items)) {
      return $item_nid;
    }

  }
  return 0;
}

/**
 * Builds an array representing the hours of operation for the facility.
 *
 * @param
 *  $content_type
 *  $display - if displaying, we must have some hours; if no API hours have
 *     been set, then use default admin hours
 *
 * @return
 *   An associative array with the following key/value pairs:
 *     [php_day_of_week_number_as_in_date_function] => An associative
 *       array with the following key/values pairs:
 *         'open'  => Opening time (military).
 *         'close' => Closing time (military).
 *     'closed_days' => An array of closed dates in mm-dd format.
 */
function reservations_load_hours_of_operation(
                                  $content_type = '', $display = NULL) {

  // FIXME: a content type can be passed as a parameter but this function
  // does nothing with it
  $hours = variable_get('reservations_hours_operation', '');

  $adminhours = explode('-', variable_get('reservations_hours_admin', '07:00-22:00'));

  if ($display) {

    foreach ($hours as $key => $value) {
      if (!isset($hours[$key]['open'])) {
        $hours[$key]['open'] = $adminhours[0];
      }
      if (!isset($hours[$key]['close'])) {
        $hours[$key]['close'] = $adminhours[1];
      }
    }
  }
  return $hours;
}

function reservations_hours_str_to_array($str) {

  if (drupal_strlen($str) == 11) {
    $parts = explode('-', ($str));
    if (count($parts) == 2) {
      return array(
        'open' => $parts[0],
        'close' => $parts[1],
      );
    }
  }

  return FALSE;
}
// reservations_hours_str_to_array

/**
 * Creates a date object based on the site's local timezone.
 *
 * @param $datetime
 *   A date in DATETIME format, UTC timezone.
 *
 * @return
 *   A php date object in the site's timezone.
 */
function reservations_create_local_date_object($datetime, $time = NULL, $backtoback = NULL) {
  //dsm($time);

  if ($backtoback && $time == 'start') {
    $datetime = date('Y-m-d H:i:s', strtotime($datetime) + 1);
    //dsm('adujsting start');
  }

  if ($backtoback && $time == 'end') {
    $datetime = date('Y-m-d H:i:s', strtotime($datetime) - 1);
    //dsm('adjusting end');
  }

  $date_object = date_create($datetime, timezone_open('UTC'));
  $timezone = variable_get('date_default_timezone', 'UTC');
  date_timezone_set($date_object, timezone_open($timezone));

  return $date_object;
}

/**
 * Creates a UTC date object based on site's local timezone.
 * Only DateTime objects with type 3 timezones attached will allow for
 * DST correctly.
 *
 * @param $datetime
 *   A date in DATETIME format, site's local timezone.
 *
 * @return
 *   A php date object in the UTC timezone.
 */
function reservations_create_utc_date_object($datetime, $time = NULL, $backtoback = NULL) {
  //dsm($time);

  if ($backtoback && $time == 'start') {
    $datetime = date('Y-m-d H:i:s', strtotime($datetime) + 1);
    //dsm('adujsting start');
  }

  if ($backtoback && $time == 'end') {
    $datetime = date('Y-m-d H:i:s', strtotime($datetime) - 1);
    //dsm('adjusting end');
  }

  $timezone = variable_get('date_default_timezone', 'UTC');
  $date_object = new DateTime($datetime, new DateTimeZone($timezone));
  $date_object->setTimezone(new DateTimeZone('UTC'));

  return $date_object;
}


/**
 * Calculates the short hour/minute time format based on the site settings.
 */
function reservations_time_format() {
  static $time_only_format = NULL;
  if (empty($time_only_format)) {
    $short_date_format = variable_get('date_format_short', 'm/d/Y - H:i');
    $time_only_format = date_limit_format($short_date_format, array('hour', 'minute'));
  }
  return $time_only_format;
}

/**
 * Formats a time value into the site's preferred format.
 *
 * @param object $hours_minutes
 *   A string of the form 'H:MM' or 'HH:MM'
 *
 * @return
 *   A string in 12- or 24-hour format with no leading zero.
 */
function reservations_format_time($hours_minutes) {
  $return = date(reservations_time_format(), strtotime($hours_minutes));
  if ($return[0] == '0') {
    return drupal_substr($return, 1);
  }
  return $return;
}



/**
 * Callback function for updating Reservation status from VBO.
 */
function reservations_operations_update($nodes) {
  foreach ($nodes as $nid) {
    reservations_confirm_reservation($nid);
  }
}

/**
 * Callback function for updating Reservation status.
 */
function reservations_confirm_reservation($nid) {
  $node = node_load($nid);

  //only update if Reservations Status is Unconfirmed
  if ($node->reservations_reservation_status == RESERVATIONS_STATUS_UNCONFIRMED) {
    $node->reservations_reseravation_status = RESERVATIONS_STATUS_PENDING;
    node_save($node);
    return TRUE;
  }
}


// Loads the current settings for reservable item nodes.
/* If you just want the content type settings just pass only node->type.
 */
function reservations_load_item_settings($object) {

  // Allow either a node object or type name to be passed in.
  if (is_string($object)) {
    $type = $object;
  }
  else {
    $node = (array) $object;
    $type = $node['type'];
  }

  // Initialize here in case there is no nid.
  $item_settings = array();

  // Settings from the content type edit page.
  $content_settings = reservations_content_types($type);

  if (isset($node['nid'])) {
    // Settings common to all reservations item nodes.
    // resource or bucket.
    $reservations_type = isset($content_settings['reservations_type_setting']) ? $content_settings['reservations_type_setting'] : '';

    $vid = $node['vid'];

    $item_settings = reservations_reservation_item_node_settings($vid);
    switch ($reservations_type) {
      case 'bucket':
        if ($item_settings['reservations_sub_type'] == RESERVATIONS_SUB_TYPE_RESERVATION) {
          unset($item_settings['reservations_default_availability']);
          unset($item_settings['reservations_item_status']);
          $item_settings += reservations_bucket_node_settings($vid);
        }
        break;

      case 'resource':
        if ($item_settings) {
          $item_settings += reservations_resource_node_settings($vid);
        }
        else {
          $item_settings = reservations_resource_node_settings($vid);
        }
        break;
    }
  }
  if ($item_settings && $content_settings) {
    return (object) ($item_settings + $content_settings);
  }
  else {
    if ($content_settings) {
      return (object) ($content_settings);
    }
    else {
      return (object) ($item_settings);
    }
  }
}


/**
 * Adds items to reservation on creation/update.
 *
 * @param $node
 *   The reservation node.
 */
function reservations_add_reservation_items($node) {
  $member_total = 0;
  $comreservationsal_total = 0;

  $langcode = $node->language;
  $hours = round(strtotime($node->field_reservations_date[$langcode][0]['value2']) - strtotime($node->field_reservations_date[$langcode][0]['value'])) / 3600;

  $exempt_items = array();
  // Update existing items or add new ones.
  if (isset($node->reservations_reservation_items)) {
    foreach ($node->reservations_reservation_items as $did => $item) {

      if (empty($item['reservations_item_nid']) and !isset($item['type'])) {
        continue;
      }


      // If we are copying a reservation.  I.e. via node_repeat
      // Also copy over the placeholder nodes.
      if (isset($item['reservations_placeholder_nid']) and $node->is_new) {
        $placeholder_node = node_load($item['reservations_placeholder_nid']);
        if ($placeholder_node) {
          $item['did'] = NULL;
          $placeholder_node->nid = NULL;
          $placeholder_node->vid = NULL;
          $placeholder_node = node_submit($placeholder_node);
          node_save($placeholder_node);
          $item['reservations_placeholder_nid'] = $placeholder_node->nid;
        }
      }
      // Create a placeholder node if we don't have one yet.
      if (!isset($item['reservations_placeholder_nid']) or empty($item['reservations_placeholder_nid'])) {
        // Resource.
        if (is_numeric($item['reservations_item_nid'])) {
          $item_node = node_load($item['reservations_item_nid']);
          $item['type'] = $item_node->type;
          $item['item_title'] = $item_node->title;
          $item['reservable_type'] = $item_node->reservations_type_setting; // needed for resource chart
          $settings = $item_node;
        }
        // Bucket.
        elseif ($item['reservations_item_nid']) {
          $item['reservable_type'] = 'bucket'; // needed for resource chart
          $item['type'] = $item['reservations_item_nid'];
          $settings = reservations_load_item_settings($item['type']);
          $item['name'] = $settings->type_name;
          if ($settings->reservations_auto_assign_bucket_item) {
            $date_info = $node->field_reservations_date[$langcode][0];
            $start = $date_info['value'];
            $end = $date_info['value2'];

            $item['reservations_item_nid'] = reservations_get_suggested_bucket_item($item['type'], $start, $end, $exempt_items);
            $exempt_items[] = $item['reservations_item_nid'];
            $item_node = node_load($item['reservations_item_nid']);
            $item['item_title'] = $item_node->title;
            $settings = $item_node;
          }
        }
        else {
          break;
        }
        $title = isset($item['item_title']) ? $item['item_title'] : $item['name'];

        // Build the item's placeholder node.
        $reservation = new stdClass();
        $reservation->type = $item['type'];
        $reservation->name = $node->name;
        $reservation->uid = $node->uid;
        $reservation->title = "$title " . t('(Reservation)');
        $reservation->body = '';
        $reservation->status = 0;
        $reservation->promote = 0;
        $reservation->sticky = 0;

        // Reservations specific data.
        $reservation->reservations_default_availability = RESERVATIONS_AVA_F;
        $reservation->reservations_sub_type = RESERVATIONS_SUB_TYPE_RESERVATION;

        // Use the item specific accounting data if an item is assigned,
        // otherwise fall back to the content type defaults.
        // TODO move to nodeapi insert and update ops.

        $rate = (isset($settings->reservations_rate_per_hour)) ? $settings->reservations_rate_per_hour : 0;
        $comreservationsal_total = $comreservationsal_total + ($hours * $rate);
        $reservation->reservations_late_fee_per_hour = (isset($settings->reservations_late_fee_per_hour)) ? $settings->reservations_late_fee_per_hour : 0;
        $reservation->reservations_rate_per_hour = (isset($settings->rate_per_hour)) ? $settings->rate_per_hour : 0;
        $reservation->reservations_fee_free_hours = (isset($settings->fee_free_hours)) ? $settings->fee_free_hours : 0;
        $reservation->reservations_rate_per_hour = (isset($settings->reservations_rate_per_hour)) ? $settings->reservations_rate_per_hour : 0;
        $reservation->reservations_autocheckin = (isset($settings->reservations_autocheckin)) ? $settings->reservations_autocheckin : 0;
        $reservation->reservations_autocheckout = (isset($settings->reservations_autocheckout)) ? $settings->reservations_autocheckout : 0;
        $reservation = node_submit($reservation);
        node_save($reservation);
        $item['reservations_placeholder_nid'] = $reservation->nid;

        //HACK PUT HERE BY MARK LIBKUMAN OPENFLOWS FOR OPEN SIGNAL
        //STORING NEW ITEMS HERE SO I CAN SET A TEXT FIELD OF RESOURCE TITLES
        global $pcm_reservation_new_items;
        $pcm_reservation_new_items = isset($pcm_reservation_new_items) ?
          $pcm_reservation_new_items : array();
        $pcm_reservation_new_items[] = $item;
        //END HACK BY MARK LIBKUMAN OPENFLOWS FOR OPEN SIGNAL
      }

      // Update the state of all items with associations.
      switch ((int) $node->reservations_reservation_status) {
        case RESERVATIONS_STATUS_UNCONFIRMED:
        case RESERVATIONS_STATUS_PENDING:
          $item_status = RESERVATIONS_ITEM_STATUS_RESERVED;
          break;

        case RESERVATIONS_STATUS_CHECKED_OUT:
          $item_status = RESERVATIONS_ITEM_STATUS_CHECKED_OUT;
          break;

        case RESERVATIONS_STATUS_CHECKED_IN:
          $item_status = RESERVATIONS_ITEM_STATUS_CHECKED_IN;
          break;

        case RESERVATIONS_STATUS_CANCELLED:
          $item_status = RESERVATIONS_ITEM_STATUS_CANCELED;
          break;
        // HACK - OPENFLOWS - CHARLOTTA BEAVERS FOR OPEN SIGNAL
        // SET THE ITEM STATUS FOR A NO SHOW RESERVATION
        case RESERVATIONS_STATUS_NO_SHOW:
          $item_status = RESERVATIONS_ITEM_STATUS_CANCELED;
          break;
        case RESERVATIONS_STATUS_DENIED:
          $item_status = RESERVATIONS_ITEM_STATUS_AVAILABLE;
          break;
      }

      // If we have an item assigned.  Set status to reserved.
      $item['reservations_item_status'] = $item_status;

      if ($node->revision or is_string($did) or $node->is_new) {
        unset($item['did']);  //striped so revisions get new did
        $item['nid'] = $node->nid;
        $item['vid'] = $node->vid;

        //FIXME, FIGURE OUT WHY reservations_item_nid is set here to
        //the content type. I am changing it because if the cotent
        //type starts with a number it will write the value to the field,
        //and exampls is if we have a content type called
        //59th_headphones, it will write 59 to the reservations_item_nid
        //field
        if (!is_numeric($item['reservations_item_nid']) OR
          $item['reservations_item_nid'] <= 0) {
          $tmp_item_nid = $item['reservations_item_nid'];
          unset($item['reservations_item_nid']);
          drupal_write_record('reservations_reservation_detail', $item);
          $item['reservations_item_nid'] = $tmp_item_nid;
        }
        else {
          drupal_write_record('reservations_reservation_detail', $item);
        }
        //drupal_write_record('reservations_reservation_detail', $item);
        //END PATCH
      }

      else {
        $item['did'] = $did;
        drupal_write_record('reservations_reservation_detail', $item, 'did');
      }

      $item_status = $item_status == RESERVATIONS_ITEM_STATUS_CHECKED_OUT ? RESERVATIONS_ITEM_STATUS_CHECKED_OUT : RESERVATIONS_ITEM_STATUS_AVAILABLE;
      if (is_numeric($item['reservations_item_nid']) and $item['reservations_item_nid'] > 0) {
        $update = array();
        $update['nid'] = $item['reservations_item_nid'];
        $update['reservations_item_status'] = $item_status;
        drupal_write_record('reservations_reservation_item_node', $update, 'nid');
      }
    }

    //if status == checked in
    if ($node->reservations_reservation_status ==
      RESERVATIONS_STATUS_CHECKED_IN &&
      $node->reservations_original_reservation_status ==
      RESERVATIONS_STATUS_CHECKED_OUT) {
      $new_reservation = clone $node;
      $checked_items = $unchecked_items = $items_to_save = array();

      foreach ($node->reservations_reservation_items as $did => $item) {

        if ($item['reservations_checkin_checkbox']) {
          $checked_items[] = $item['reservations_item_nid'];
          unset($new_reservation->reservations_reservation_items[$did]);
        }
        else {
          $unchecked_items[] = $item['reservations_item_nid'];
        }

        if ($item['reservations_item_nid']) {
          $item_node = node_load($item['reservations_item_nid']);
          $tid =
            reservations_get_single_field_value($item_node,
              'field_equipment_item_status',
              'tid');
          $reservation_link =
            l(t("Updated via Reservation"), "node/" . $node->nid);

          if ($item['reservations_checkin_item_condition'] &&
            $tid != $item['reservations_checkin_item_condition']) {
            $item['node'] = $item_node;
            $item['reservations_checkin_condition_notes'] =
              $item['reservations_checkin_condition_notes'] . " " .
              $reservation_link;
            $items_to_save[] = $item;

          }
          else {
            if ($item['reservations_checkin_condition_notes']) {
              $item['node'] = $item_node;
              $item['reservations_checkin_condition_notes'] =
                $item['reservations_checkin_condition_notes'] . " " .
                $reservation_link;
              $items_to_save[] = $item;
            }
          }
        }
      }

      if ($items_to_save) {
        foreach ($items_to_save as $item) {
          $item_node = $item['node'];
          $item_node->field_equipment_item_status[LANGUAGE_NONE][0]['tid'] =
            $item['reservations_checkin_item_condition'];
          $item_node->field_reservable_condition_notes[LANGUAGE_NONE]
          [0]['value'] = $item['reservations_checkin_condition_notes'];
          node_save($item_node);
        }
      }

      // Partial return.
      if ($unchecked_items) {
        global $user;
        unset($new_reservation->nid);
        unset($new_reservation->vid);
        unset($new_reservation->created);
        unset($new_reservation->changed);

        $new_reservation->is_new = TRUE;

        // Initialize the extended date to empty as it will only be set if the reservation wad extended.
        $extended_date = NULL;
        // If extended date is set.
        global $reservation_ext_date;
        if (isset($reservation_ext_date) && !empty($reservation_ext_date['end_date'])) {
          // Make sure the node IDs match.
          if ($node->nid == $reservation_ext_date['nid']) {
            // Update the end date of the new extended reservation.
            $extended_date = $reservation_ext_date['end_date'];
          }
        }
        // Clear the session variable once it is used.
        $reservation_ext_date = NULL;


        // Set the start and end date of both original and cloned reservations.
        $date_field =
          $new_reservation->field_reservations_date[LANGUAGE_NONE][0];


        $timezone = new DateTimeZone($date_field['timezone']);
        $timezone_db = new DateTimeZone($date_field['timezone_db']);

        // Replaced $timezone_db with $timezone. @todo - needs more testing.
        $current = new DateTime('now', $timezone_db);
        //$current = new DateTime('now', $timezone);

        $orig_start = new DateTime($date_field['value'], $timezone);
        $orig_end = new DateTime($date_field['value2'], $timezone);

        $new_start = new DateTime($date_field['value'], $timezone);
        $new_end = new DateTime($date_field['value2'], $timezone);

        // $extended_date should be set at this point.
        // This is last resort validation to make sure new reservation is operational.
        if (isset($extended_date)) {
          $extended = new DateTime($extended_date, $timezone);
        }
        else {
          // Should never get called - extended date must be set.
          $extended = new $current;
        }

        // Early partial checkin before reservation start.
        if ($current->getTimestamp() <= $orig_start->getTimestamp()) {
          $new_start = clone $current;
          $new_end = clone $extended;
          $orig_start = clone $current;
          $orig_end = clone $current;
        }
        // Early/ontime partial checkin after reservation start.
        elseif ($current->getTimestamp() <= $orig_end->getTimestamp()) {
          $new_start = clone $current;
          $new_end = clone $extended;
          $orig_start = clone $orig_start;
          $orig_end = clone $current;

        }
        // Late partial checkin after reservation end.
        elseif ($current->getTimestamp() > $orig_end->getTimestamp()) {
          // Now supports entering an early checkout time.
          $new_start  = $orig_end;
          $new_end = clone $extended;
          $orig_start = clone $orig_start;
          $orig_end = clone $orig_end;
        }



        if (strtotime($new_end->format('Y-m-d H:i:s')) <
          strtotime($new_start->format('Y-m-d H:i:s'))) {
          $new_end = clone $new_start;
        }
        $node->field_reservations_date[LANGUAGE_NONE][0]['value'] =
          $orig_start->format('Y-m-d H:i:s');
        $node->field_reservations_date[LANGUAGE_NONE][0]['value2'] =
          $orig_end->format('Y-m-d H:i:s');
        $new_reservation->field_reservations_date[LANGUAGE_NONE][0]['value'] =
          $new_start->format('Y-m-d H:i:s');
        $new_reservation->field_reservations_date[LANGUAGE_NONE][0]['value2'] =
          $new_end->format('Y-m-d H:i:s');





        $new_reservation->reservations_reservation_status =
          RESERVATIONS_STATUS_CHECKED_OUT;
        unset($new_reservation->reservations_original_reservation_status);
        node_save($new_reservation);

        //SETTTING IN SESSION SO WE CAN FORWARD TO THE NEW RESERVATION
        $_SESSION['reservations_new_partial_return'] = clone $new_reservation;

        if (module_exists('reservations_operator_history')) {
          $sql =
            "INSERT INTO reservations_operator_history(uid, reservation_id,
             beginning_status, end_status, timestamp, notes)
             VALUES (:uid, :reservation_id, :beginning_status, :end_status,
             :timestamp, :notes)";

          $url = l(t('See New Reservation'), "node/" . $new_reservation->nid);
          $notes = t("Partial Check In !url", array('!url' => $url));

          $args = array(
            ':uid' => $user->uid,
            ':reservation_id' => $node->nid,
            ':beginning_status' => RESERVATIONS_STATUS_CHECKED_OUT,
            ':end_status' => RESERVATIONS_STATUS_CHECKED_IN,
            ':timestamp' => strtotime('now'),
            ':notes' => $notes
          );
          db_query($sql, $args);

          $url = l(t('See Original Reservation'), "node/" . $node->nid);
          $notes = t("Reservation Created via Partial Checkin: !url",
            array('!url' => $url));

          $args = array(
            ':uid' => $user->uid,
            ':reservation_id' => $new_reservation->nid,
            ':beginning_status' => RESERVATIONS_STATUS_CHECKED_OUT,
            ':end_status' => RESERVATIONS_STATUS_CHECKED_OUT,
            ':timestamp' => strtotime('now'),
            ':notes' => $notes
          );
          db_query($sql, $args);
        }
      }
      else {
        // All items are checked in.

        // Get the end and current date using timezone details from the fate field.
        $date_field = $node->field_reservations_date[LANGUAGE_NONE][0];
        $timezone = new DateTimeZone($date_field['timezone']);
        $timezone_db = new DateTimeZone($date_field['timezone_db']);
        $end = new DateTime($date_field['value2'], $timezone);
        // Replaced $timezone_db with $timezone. @todo - needs more testing.
        $current = new DateTime('now', $timezone_db);

        // Early checkin.
        if ($current->getTimestamp() <= $end->getTimestamp()) {
          $node->field_reservations_date[LANGUAGE_NONE][0]['value2'] =
            $current->format('Y-m-d H:i:s');
        }

      }
    }
  }
}


/**
 * Returns TRUE if the reservation is an extended one.
 */
function reservations_is_extend_checkin($node, $form_state) {
    $is_extended = FALSE;
  //if status == checked in
  if ($node->reservations_reservation_status ==
    RESERVATIONS_STATUS_CHECKED_IN &&
    $node->reservations_original_reservation_status ==
    RESERVATIONS_STATUS_CHECKED_OUT) {

    // Option 2 is the extended option.
    $is_extended = (($form_state['values']['checkout_options'] == 2));
  }

  return $is_extended;
}


/**
 * Returns TRUE if the $node saved is a partial return.
 */
function reservations_is_partial_return($node) {
  //if status == checked in
  if ($node->reservations_reservation_status ==
    RESERVATIONS_STATUS_CHECKED_IN &&
    $node->reservations_original_reservation_status ==
    RESERVATIONS_STATUS_CHECKED_OUT) {

    $checked_items = array();
    $unchecked_items = array();


    foreach ($node->reservations_reservation_items as $did => $item) {
      if ($item['reservations_checkin_checkbox']) {
        $checked_items[] = $item['reservations_item_nid'];
      }
      else {
        $unchecked_items[] = $item['reservations_item_nid'];
      }
    }
    // Partial return = must have unchecked items.
    return  (count($unchecked_items) > 0 );
  }
  else {
    return FALSE;
  }
}
