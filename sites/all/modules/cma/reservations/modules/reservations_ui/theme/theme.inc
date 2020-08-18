<?php

/**
 * @file
 * Reservations - Managed Equipment Reservation Checkout and Inventory
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
 * returns the number of items currently checked out for each content type
 * TODO: change this to a views view.
 */
function theme_reservations_ui_current_inventory() {

  $exclude_inactive = variable_get('reservations_ui_inventory_active_status', 0);
  $active_status_text = $exclude_inactive ? 'not listed. ' : 'listed. ';
  $ui_options = "This is set at Config >> Reservations >> UI Options.";

  $include_type_description = variable_get('reservations_ui_inventory_description', 0);

  // admin/reservations/manage/current_inventory/inventory/$tid
  // check to see if inventory is being passed
  $inventory = (arg(4) == 'inventory') ? arg(5) : NULL;

  if ($inventory) {
    $term = taxonomy_term_load($inventory);

    drupal_set_title('Current Inventory of ' . $term->name . ' Items');
  }

  if ($include_type_description) {
    $header = array(
      t('Item'),
      t('Description'),
      t('On Hand'),
      t('Unavailable'),
      t('Checked Out'),
      t('Total'),
      t('Operations'),
    );
  }
  else {
    $header = array(
      t('Item'),
      t('On Hand'),
      t('Unavailable'),
      t('Checked Out'),
      t('Total'),
      t('Operations'),
    );
  }

  $reservable_types = reservations_content_types();

  // OPENFLOWS - LOTTIE - 5/23/18 - sort order
  // sort by label (type_name) instead of machine name (type)
  foreach ($reservable_types as $key => $row) {
    $type_name[$key] = $row['type_name'];
  }
  array_multisort($type_name, SORT_ASC, SORT_STRING | SORT_FLAG_CASE, $reservable_types);

  $rows = array();

  foreach ($reservable_types as $reservable_type) {
    $include = FALSE;  // default to skipping the type unless

    // OPENFLOWS - LOTTIE - 5/23/18 - option to exclude inactive
    // set if we are excluding inactive
    if ($exclude_inactive && $reservable_type['reservations_active_status'] == 2) {
      $include = FALSE;
    }
    else {
       if ($inventory) {
        foreach ($reservable_type['inventory_tids'] as $tid) {

          if ($tid == $inventory) {
            $include = TRUE;
          }
        }
      }
      else {
        // if there is no inventory, include everything
        $include = TRUE;
      }
    }

    if ($include) {

    $operations = l(t('Edit'), 'admin/structure/types/manage/' . $reservable_type['type'], array('query' => array('destination' => 'admin/reservations/manage/current_inventory/' . $inventory)));
    $operations .= " | ";

    $typelink = str_replace('_', '-', $reservable_type['type']);
    $operations .= l(t('Add Item'), 'node/add/' . $typelink, array('query' => array('destination' => 'admin/reservations/manage/current_inventory/' . $inventory)));

    $checked_out = reservations_get_reservation_count($reservable_type['type']);

    $available = reservations_get_count($reservable_type, RESERVATIONS_AVA_F);
    $onhand = $available - $checked_out;

    $unavailable = reservations_get_count($reservable_type, RESERVATIONS_UNA_F);
    $total = $onhand + $unavailable + $checked_out;
    $available = l($onhand, 'admin/reservations/manage/current_inventory/type/' . $reservable_type['type'] . '/Available');
    $checked_out = l($checked_out, 'admin/reservations/manage/current_inventory/type/' . $reservable_type['type'] . '/checked-out');
    $unavailable = l($unavailable, 'admin/reservations/manage/current_inventory/type/' . $reservable_type['type'] . '/Unavailable');

    $description = $reservable_type['description'] ? $reservable_type['description'] : NULL;

    $title = views_get_view('reservations_inventory_view')
        ? l($reservable_type['type_name'], 'admin/reservations/manage/inventory/type', array('html' => TRUE, 'query' => 'type[0]=' . $reservable_type['type']))
        : $reservable_type['type_name'];

    if ($include_type_description) {
      $rows[] = array(
        $title,
        $description,
        $available,
        $unavailable,
        $checked_out,
        $total,
        $operations,
      );
    }
    else {
      $rows[] = array(
        $title,
        $available,
        $unavailable,
        $checked_out,
        $total,
        $operations,
      );
    }

  }
  } //include

  $output = theme('status_messages');
  $output .= t('<p>Inactive Reservable Content Types are ' . $active_status_text . $ui_options . '</p>');
  $output .= theme('table', array('header' => $header, 'rows' => $rows));
  $output .= '&raquo; ' . l(t('Add a new content type'), 'admin/structure/types/add', array('query' => array('destination' => 'admin/reservations/manage/current_inventory')));
  return $output;
}
