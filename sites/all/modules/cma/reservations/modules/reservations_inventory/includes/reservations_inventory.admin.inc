<?php

/**
 * @file
 * Reservations Inventory
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
 * Builds the admininstration settings form.
 */
function reservations_inventory_admin_settings($form, &$form_state) {

  $vid = variable_get('reservations_inventory_vid', 0);
  $tid = variable_get('reservations_inventory_default_reservation_inventory', '');

   // weighted -9
   $grouping_array =
      reservations_taxonomy_term_select(
        t('Default Inventory'),
        NULL,
        $tid,
        $vid,
        t('If configured, when creating a reservation, whenever an inventory is not specified in the URL,  the reservable items will be filtered to this inventory by default.'),
        0,
        '<' . t('Select') . '>'
   );

  $form['reservations_inventory_default_reservation_inventory'] = $grouping_array;

  // Load Hours of Operation & Restrictions.
  $hours_of_operation = reservations_inventory_load_hours_of_operation();
  $restricted_hours_of_operation =  variable_get('reservations_inventory_restricted_hours_of_operation', '');
  $restrictions = variable_get('reservations_inventory_restrictions', '');

  $hours_description = '<div>' . t('Configure hours of operations for each specific inventory.') . '</div>';
  //$inventory_hours_description = t('Enter military time for both opening and closing time, separated by a dash, in the format') . ' <em>hh:mm-hh:mm</em><br />' . t('ex.') . ' <em>09:00-17:00</em> ' . t('would be open at 9AM, close at 5PM. Leave blank to indicate not being open.');
  $inventory_hours_description = '<div>' . t('Enter military time for both opening and closing time, separated by a dash, in the format') . ' <em>hh:mm-hh:mm</em><br /></div>';
  $inventory_hours_description .= '<div>' . t('Enter hours so that producers can pickup and dropoff anytime during your operatiing hours (such as Start 09:00-17:00 and End 09:00-17:00). ') . '</div>';
  $inventory_hours_description .= '<div>' . t('Or enter hours to allow for separate windows for dropoff and pickup (such as Start 10:00-13:00 and End 14:00-17:00).') . '</div>';


  $hours_element = array(
    '#type' => 'textfield',
    '#title' => t('Monday hours'),
    '#size' => 11,
    '#maxlength' => 11,
    '#element_validate' => array('reservations_inventory_admin_validate_hours_of_operation'),
    );

  $days_of_the_week = array(
    'sunday',
    'monday',
    'tuesday',
    'wednesday',
    'thursday',
    'friday',
    'saturday',
  );

  $form['reservations_hours_title'] = array(
    '#type' => 'item',
    '#title' => t('Hours of operation'),
    '#description' => $hours_description,
  );
      // vertical tab holder - contains all sub tabs
  $form['reservations_hours'] = array(
    '#type' => 'vertical_tabs',

  );

  $tree = taxonomy_get_tree($vid);

  // Add hours of operations and restrictions settings for each inventory.
  foreach ($tree as $term) {

    $term_tid = $term->tid;

    // Hours of operations section of the inventory settings (in a collapsible fieldset).

    $form['reservations_hours'][$term_tid] = array(
      '#type' => 'fieldset',
      '#title' => t($term->name . ' Inventory'),
      '#collapsible' => TRUE,
      '#group' => 'reservations_hours',
      '#weight' => $term->weight,
    );

    $form['reservations_hours'][$term_tid]['hours'] = array(
      '#type' => 'fieldset',
      '#title' => t($term->name . ' Inventory - Hours of operations'),
      '#description' => $inventory_hours_description,
      '#collapsible' => TRUE,
    );

    // Check if restricted hours of operations is set
    $are_restricted_hours_of_operations_enabled = isset($restrictions[$term_tid]) ? $restrictions[$term_tid]['restricted_hours_of_operations'] : FALSE;

    // Button to toggle between normal and restricted hours of operations.
    if ($are_restricted_hours_of_operations_enabled) {
      $button_value = t('Switch to normal hours of operations');
    }
    else {
      $button_value = t('Switch to restricted hours of operations');
    }
    $form['reservations_hours'][$term_tid]['hours']['toggle_hours_of_operations'] = array(
      '#type' => 'button',
      '#value' => $button_value,
      '#name' => 'tgl' . $term_tid,
      '#id' => 'tgl' . $term_tid,
      '#executes_submit_callback' => TRUE,
    );

    //  Restricted hours options.
    if ($are_restricted_hours_of_operations_enabled) {

      // Section heading.
      $form['reservations_hours'][$term_tid]['hours']['type_description'] = array(
        '#type' => 'item',
        '#title' => t('Restricted hours of operations'),
      );

      // Cycle the days of the week.
      foreach ($days_of_the_week as $num => $day) {

        // For each day, build a fieldset to group that day's options.
        $form['reservations_hours'][$term_tid]['hours']['day-' . $day] = array(
          '#type' => 'fieldset',
          '#title' => drupal_ucfirst($day),
          '#collapsible' => FALSE,
        );

        // Check-out/Start Hours
        $form['reservations_hours'][$term_tid]['hours']['day-' . $day]
        ['reservations_inventory_start_hours_' . $day . '_' . $term_tid] = array(
          '#title' => t('Check-out/Start Hours'),
          '#default_value' => isset($restricted_hours_of_operation[$term_tid][$num]['start_hours']) ?
            implode('-', $restricted_hours_of_operation[$term_tid][$num]['start_hours']) : '',
          '#type' => 'textfield',
          '#size' => 11,
          '#maxlength' => 11,
          '#element_validate' => array('reservations_inventory_admin_validate_hours_of_operation'),
        );

        // Check-in/End Hours
        $form['reservations_hours'][$term_tid]['hours']['day-' . $day]
        ['reservations_inventory_end_hours_' . $day . '_' . $term_tid] = array(
          '#title' => t('Check-in/End Hours'),
          '#default_value' => isset($restricted_hours_of_operation[$term_tid][$num]['end_hours']) ?
            implode('-', $restricted_hours_of_operation[$term_tid][$num]['end_hours']) : '',
          '#type' => 'textfield',
          '#size' => 11,
          '#maxlength' => 11,
          '#element_validate' => array('reservations_inventory_admin_validate_hours_of_operation'),
        );

        // Force Check-out at these times
        $form['reservations_hours'][$term_tid]['hours']['day-' . $day]
        ['reservations_inventory_force_hours_' . $day . '_' . $term_tid] = array(
          '#title' => t('Force Check-out at these times'),
          '#description' => t('Use a comma between the hours, use 24 hour format such as 11:00, 14:00.'),
          '#default_value' => isset($restricted_hours_of_operation[$term_tid][$num]['force_hours']) ?
            implode(',', $restricted_hours_of_operation[$term_tid][$num]['force_hours']) : '',
          '#type' => 'textfield',
          '#size' => 11,
          '#maxlength' => 48,
          '#element_validate' => array('reservations_inventory_admin_validate_force_checkout_times'),
        );
      }
    }

    // Normal hours of operations.
    else {

      // Section heading.
      $form['reservations_hours'][$term_tid]['hours']['type_description'] = array(
        '#type' => 'item',
        '#title' => t('Normal hours of operations'),
      );

      // Cycle the days.
      foreach ($days_of_the_week as $num => $day) {

        // For each day, add the hours of operations field.
        $form['reservations_hours'][$term_tid]['hours']
        ['reservations_inventory_hours_' . $day . '_' . $term_tid] = array(
          '#title' => t('@day Hours', array('@day' => drupal_ucfirst($day))),
          '#default_value' => isset($hours_of_operation[$term_tid][$num]) ?
            implode('-', $hours_of_operation[$term_tid][$num]) : '',
          '#type' => 'textfield',
          '#size' => 11,
          '#maxlength' => 11,
          '#element_validate' => array('reservations_inventory_admin_validate_hours_of_operation'),
          '#group' => 'reservations_hours',
        );
      }

    }

    // Expanded Hours field.
    $form['reservations_hours'][$term_tid]['hours']
             ['reservations_inventory_hours_admin'. '_' . $term_tid] = array(
      '#type' => 'textfield',
      '#title' => t('Expanded Hours'),
      '#default_value' => isset($hours_of_operation[$term_tid]['admin']) ?
             implode('-', $hours_of_operation[$term_tid]['admin']) : '',
      '#description' =>
        t(
          "This setting controls the hours shown on the conflict grid for " .
          "users with 'Create new content (Outside Normal Hours of " .
          "Operation)' permission.  Normally, the conflict grid is limited " .
          "to the hours of operation set above for the days of the week. " .
          "But user allowed to create reservations outside normal hours of " .
          "operation, need to see conflicts during the expanded hours as well."
        ),
      '#size' => 11,
      '#maxlength' => 11,
      '#element_validate' =>
         array(
          'reservations_inventory_admin_validate_hours_of_operation'
         ),
      '#group' => 'reservations_hours',
    );


    // Restrictions section of the inventory settings (in a collapsible fieldset).

    $form['reservations_hours'][$term_tid]['restrictions'] = array(
      '#type' => 'fieldset',
      '#title' => t($term->name . ' Inventory - Restrictions'),
      '#description' => t('Below are reservation restrictions for this inventory.'),
      '#collapsible' => TRUE,
    );

    $form['reservations_hours'][$term_tid]['restrictions']['reservations_min_hours_advance_reservation'. '_' . $term_tid] = array(
      '#type' => 'textfield',
      '#title' => t('Min Advance'),
      '#size' => 11,
      '#maxlength' => 11,
      '#element_validate' => array('element_validate_integer'),
      '#default_value' => isset($restrictions[$term_tid]) ? $restrictions[$term_tid]['reservations_min_hours_advance_reservation'] : 0,
      '#description' => t('Minimum number of hours a Reservation can be made in advance.  Set to 0 if to allow Reservations to be made an unlimited time into the future.'),
    );
    $form['reservations_hours'][$term_tid]['restrictions']['reservations_max_days_advance_reservation'. '_' . $term_tid] = array(
      '#type' => 'textfield',
      '#title' => t('Max Advance'),
      '#size' => 11,
      '#maxlength' => 11,
      '#element_validate' => array('element_validate_integer'),
      '#default_value' => isset($restrictions[$term_tid]) ? $restrictions[$term_tid]['reservations_max_days_advance_reservation'] : '',
      '#description' => t('Maximum number of days a Reservation can be made in advance. Empty to use global settings, 0 if to allow Reservations to be made an unlimited time into the future.'),
    );

    $form['reservations_hours'][$term_tid]['restrictions']['reservations_min_hrs'. '_' . $term_tid] = array(
      '#type' => 'textfield',
      '#title' => t('Min hours'),
      '#size' => 11,
      '#maxlength' => 11,
      '#element_validate' => array('element_validate_number'),
      '#default_value' => isset($restrictions[$term_tid]) ? $restrictions[$term_tid]['reservations_min_hrs'] : '',
      '#description' => t('Minimum Hours per Reservation. 0 for no limit.'),
    );
    $form['reservations_hours'][$term_tid]['restrictions']['reservations_max_hrs'. '_' . $term_tid] = array(
      '#type' => 'textfield',
      '#title' => t('Max Hours'),
      '#size' => 11,
      '#maxlength' => 11,
      '#element_validate' => array('element_validate_number'),
      '#default_value' => isset($restrictions[$term_tid]) ? $restrictions[$term_tid]['reservations_max_hrs'] : '',
      '#description' => t('Maximum Hours per Reservation. 0 for no limit.'),
    );
    $form['reservations_hours'][$term_tid]['restrictions']['cleaning_buffer'. '_' . $term_tid] = array(
      '#type' => 'textfield',
      '#title' => t('Cleaning Buffer'),
      '#size' => 11,
      '#maxlength' => 11,
      '#element_validate' => array('element_validate_integer'),
      '#default_value' => isset($restrictions[$term_tid]) ? $restrictions[$term_tid]['cleaning_buffer'] : '',
      '#description' => t('The minimum hours required between books per inventory item (this allows time for cleaning or setting in closet).'),
    );


  }

  // Don't want to save each of the form variables separately in the table
  // so we handle the system_settings_form ourselves.
  $form = reservations_inventory_system_settings_form($form);
  $form['#submit'][] = 'reservations_inventory_admin_settings_submit';

  return ($form);
}

 /**
 * Builds an array representing the hours of operation for the facility
 * for producers and users who can create reservations outside normal hours.
 *
 *   A multidimensional arry with the following key/value pairs:
 *     [term_tid] => An associative array with the following key/value pairs:
 *        [day_of_week or admin] => An associative array with the
 *          following key/values pairs:
 *             'open'  => Opening time (military).
 *             'close' => Closing time (military).
 */
function reservations_inventory_admin_settings_submit($form, &$form_state) {

  // set the default inventory value
  variable_set('reservations_inventory_default_reservation_inventory',
    $form_state['values']['reservations_inventory_default_reservation_inventory']);

  $vid = variable_get('reservations_inventory_vid', 0);
  $tree = taxonomy_get_tree($vid);

  $days_of_the_week = array(
    'sunday',
    'monday',
    'tuesday',
    'wednesday',
    'thursday',
    'friday',
    'saturday',
  );

  $hours_of_operation = reservations_inventory_load_hours_of_operation();
  $inventory_restrictions = variable_get('reservations_inventory_restrictions', array());
  $restricted_hours_of_operation =  variable_get('reservations_inventory_restricted_hours_of_operation', array());

  foreach ($tree as $term) {
    $term_tid = $term->tid;
    // Inventory restrictions - Min. advance .
    $min_days_advance_reservation = $form_state['values']['reservations_min_hours_advance_reservation'. '_' . $term_tid];
    if (empty($min_days_advance_reservation)) {
      $min_days_advance_reservation = 0;
    }
    $inventory_restrictions[$term_tid]['reservations_min_hours_advance_reservation'] = $min_days_advance_reservation;
    // Inventory restrictions - Max. advance .
    $max_days_advance_reservation = $form_state['values']['reservations_max_days_advance_reservation'. '_' . $term_tid];
    $inventory_restrictions[$term_tid]['reservations_max_days_advance_reservation'] = $max_days_advance_reservation;
    // Inventory restrictions - Min Hrs
    $reservations_min_hrs = $form_state['values']['reservations_min_hrs'. '_' . $term_tid];
    if (empty($reservations_min_hrs)) {
      $reservations_min_hrs = 0;
    }
    $inventory_restrictions[$term_tid]['reservations_min_hrs'] = $reservations_min_hrs;
    // Inventory restrictions - Max Hrs
    $reservations_max_hrs = $form_state['values']['reservations_max_hrs'. '_' . $term_tid];
    if (empty($reservations_max_hrs)) {
      $reservations_max_hrs = 0;
    }
    $inventory_restrictions[$term_tid]['reservations_max_hrs'] = $reservations_max_hrs;
    // Inventory restrictions - Cleaning buffer
    $cleaning_buffer = $form_state['values']['cleaning_buffer'. '_' . $term_tid];
    if (empty($cleaning_buffer)) {
      $cleaning_buffer = 0;
    }
    $inventory_restrictions[$term_tid]['cleaning_buffer'] = $cleaning_buffer;



    foreach ($days_of_the_week as $num => $day) {

      // Restricted Hours.
      if ($inventory_restrictions[$term_tid]['restricted_hours_of_operations']) {
        // Get the values.
        $start_hours = $form_state['values']['reservations_inventory_start_hours_' . $day . '_' . $term_tid];
        $end_hours = $form_state['values']['reservations_inventory_end_hours_' . $day . '_' . $term_tid];
        $force_hours = $form_state['values']['reservations_inventory_force_hours_' . $day . '_' . $term_tid];

        // Set Check-out/Start Hours.
        if (empty($start_hours)) {
          $restricted_hours_of_operation[$term_tid][$num]['start_hours'] = NULL;
        } else {
          list($open, $close) = explode('-', $start_hours);
          $restricted_hours_of_operation[$term_tid][$num]['start_hours']['open'] = trim($open);
          $restricted_hours_of_operation[$term_tid][$num]['start_hours']['close'] = trim($close);
        }

        // Set Check-in/End Hours.
        if (empty($end_hours)) {
          $restricted_hours_of_operation[$term_tid][$num]['end_hours'] = NULL;
        } else {
          list($open, $close) = explode('-', $end_hours);
          $restricted_hours_of_operation[$term_tid][$num]['end_hours']['open'] = trim($open);
          $restricted_hours_of_operation[$term_tid][$num]['end_hours']['close'] = trim($close);
        }

        // Force Check-out at these times.
        if (empty($force_hours)) {
          $restricted_hours_of_operation[$term_tid][$num]['force_hours'] = NULL;
        } else {
          $force_hours = explode(',', $force_hours);
          $restricted_hours_of_operation[$term_tid][$num]['force_hours'] = $force_hours;
        }

      }

      // Normal hours.
      else {
        $hours = $form_state['values']
        ['reservations_inventory_hours_' . $day . '_' . $term_tid];
        if (empty($hours)) {
          $hours_of_operation[$term_tid][$num] = NULL;
        } else {
          list ($open, $close) = explode('-', $hours);
          $hours_of_operation[$term_tid][$num]['open'] = trim($open);
          $hours_of_operation[$term_tid][$num]['close'] = trim($close);
        }
      }
    }

    $expanded_hrs = $form_state['values']
            ['reservations_inventory_hours_admin_' . $term_tid];
    if (empty($expanded_hrs)) {
      $hours_of_operation[$term_tid]['admin'] = NULL;
    }
    else {
      list ($open, $close) = explode('-', $expanded_hrs);
      $hours_of_operation[$term_tid]['admin']['open'] = trim($open);
      $hours_of_operation[$term_tid]['admin']['close'] = trim($close);
    }

    // Need to determine if the hours of operation have been
    // input for this tid
    $hours_tid = $hours_of_operation[$term_tid];
    foreach($hours_tid as $key => $value) {
      if(!is_null($hours_tid[$key]['open'])) {
        $exist_inventory_hrs = TRUE;
        break;
      }
      else {
        $exist_inventory_hrs = FALSE;
      }
    }
    $hours_of_operation[$term_tid]['exist_inventory_hrs'] = $exist_inventory_hrs;

  }
  // Set the hours of operations.
  variable_set('reservations_inventory_hours_operation', $hours_of_operation);
  variable_set('reservations_inventory_restricted_hours_of_operation', $restricted_hours_of_operation);

  // After we save all the changes to the form, we need to check if the hours
  // of operations were toggled for any of the inventories.
  $te = $form_state['triggering_element'];
  if ($te['#name'] != 'op') {
    // Get the inventory ID.
    $inventory_id = substr($te['#id'],3);
    // Get the current state.
    $are_restricted_hours_of_operations_enabled = isset($inventory_restrictions[$term_tid]) ? $inventory_restrictions[$inventory_id]['restricted_hours_of_operations'] : FALSE;
    // Toggle the state.
    $inventory_restrictions[$inventory_id]['restricted_hours_of_operations'] = !$are_restricted_hours_of_operations_enabled;
  }
  // Set inventory restrictions.
  variable_set('reservations_inventory_restrictions', $inventory_restrictions);

  drupal_set_message(t('Reservations Inventory configuration updated.'));
}

/**
 * Helper function to validate hours or operation formatting.
 */
function reservations_inventory_admin_validate_hours_of_operation($element, &$form_state) {

  if (!empty($element['#value'])) {
    $time = array();
    $i = 0;
    $values = explode('-', $element['#value']);

    foreach ($values as $value) {
      list ($hour, $min) = explode(':', $value);
      // Make sure it is a number - will protect against things like 1PM-5PM
      if (!is_numeric($hour) || !is_numeric($min)) {
        form_error($element, t('The value "@time_value" is using the wrong format.', array('@time_value' => $value)));
      }

      if ($hour > 24) {
        form_error($element, t('Hour must be less than or equal to 24.'));
      }
      if ($hour < 0) {
        form_error($element, t('Hour must be greater than or equal to 0.'));
      }
      if ($hour == 24 && $min > 0) {
        form_error($element, t(
            'If hour is equal to 24 then minutes must be equal to 0.'));
      }
      if ($min > 59) {
        form_error($element, t('Minutes must be less than or equal to 59.'));
      }
      if ($min < 0) {
        form_error($element, t('Minutes must be greater than or equal to 0.'));
      }

      $time[$i]['hour'] = $hour;
      $time[$i]['min'] = $min;
      $i++;
    }

    // we need to catch values[1] < values[0] for circumstances where user
    // does not input values[1] as military time (such as 12:00-5:00)
    if ($time[1]['hour'] < $time[0]['hour']) {
form_error($element, t('Closing time must be greater then opening time.'));
    }
    elseif ($time[1]['hour'] == $time[0]['hour'] &&
        $time[1]['min'] <= $time[0]['min']) {
form_error($element, t('Closing time must be greater then opening time.'));
    }
  }
}


/**
 * Helper function to validate the "orce Check-out at these times" option.
 */
function reservations_inventory_admin_validate_force_checkout_times($element, &$form_state) {

  if (!empty($element['#value'])) {
    $values = explode(',', $element['#value']);

    foreach ($values as $value) {

      list ($hour, $min) = explode(':', $value);

      // Make sure it is a number - will protect against things like 1PM,2PM
      if (!is_numeric($hour) || !is_numeric($min)) {
        form_error($element, t('The value "@time_value" is using the wrong format.', array('@time_value' => $value)));
      }

      if ($hour > 24) {
        form_error($element, t('Hour must be less than or equal to 24.'));
      }
      if ($hour < 0) {
        form_error($element, t('Hour must be greater than or equal to 0.'));
      }
      if ($hour == 24 && $min > 0) {
        form_error($element, t(
          'If hour is equal to 24 then minutes must be equal to 0.'));
      }
      if ($min > 59) {
        form_error($element, t('Minutes must be less than or equal to 59.'));
      }
      if ($min < 0) {
        form_error($element, t('Minutes must be greater than or equal to 0.'));
      }
    }

  }
}
