<?php
/**

 +---------------------------------------------------------------------------+
 | Copyright (C) 2009 Openflows, Inc. + Blue Bag. All rights reserved.       |
 | Additionally, Kevin Reynen                                                |
 | This work is published under the GNU AGPLv3 license without any           |
 | warranty. For full license and copyright information, see                 |
 | https://www.gnu.org/licenses/agpl-3.0.html                                |
 +---------------------------------------------------------------------------+
 */
/*
 * Move or hide reservable types depending on the setting.
*/
function reservations_ui_node_add_page() {
  $reservable = array();
  $non_reservable = array();
  $types = node_type_get_types();
  foreach ($types AS $type => $data) {
    // Check if user can access this type.
    if (!node_hook($type, 'form') || !node_access('create', $type)) {
      continue;
    }

    $item = array('title' => $data->name, 'href' => 'node/add/' . strtr($type, '_', '-'), 'description' => $data->description, 'localized_options' => array());
    if (reservations_is_reservations_type($type)) {
      $reservable[$type] = $item;
    }
    else {
      $non_reservable[$type] = $item;
    }
  }

  $output = '<h3>Site Content Types</h3>';
  $output .= theme('node_add_list', array('content' => $non_reservable));
  $output .= '<h3>Reservable Types</h3>';
  $output .= theme('node_add_list', array('content' => $reservable));
  return $output;
}
