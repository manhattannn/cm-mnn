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
 * @todo Please document this function.
 * @see http://drupal.org/node/1354
 */
function reservations_reservation_item_node_settings($vid) {
  if (!$vid) {
    return;
  }
  return db_query("SELECT reservations_default_availability, reservations_sub_type, reservations_item_status FROM {reservations_reservation_item_node} WHERE vid = :vid", array(':vid' => $vid))->fetch(PDO::FETCH_ASSOC);
}

/**
 * @todo Please document this function.
 * @see http://drupal.org/node/1354
 */
function reservations_bucket_node_settings($vid) {
  if (!$vid) {
    return;
  }
  return db_query("SELECT reservations_late_fee_per_hour, reservations_rate_per_hour, reservations_fee_free_hours FROM {reservations_bucket_node} WHERE vid = :vid", array(':vid' => $vid))->fetch(PDO::FETCH_ASSOC);
}

/**
 * @todo Please document this function.
 * @see http://drupal.org/node/1354
 */
function reservations_resource_node_settings($vid) {
  if (!$vid) {
    return;
  }
  return db_query("SELECT reservations_late_fee_per_hour, reservations_rate_per_hour, reservations_fee_free_hours, reservations_min_cancel_hours, reservations_autocheckout, reservations_autocheckin, reservations_selfcheckout FROM {reservations_resource_node} WHERE vid = :vid", array(':vid' => $vid))->fetch(PDO::FETCH_ASSOC);
}

/**
 * @todo Please document this function.
 * @see http://drupal.org/node/1354
 */
function reservations_taxonomy_node_delete_vocabulary($node, $vid) {

  if (empty($vid) or empty($node->vid)) {
    return;
  }
  // TODO Please review the conversion of this statement to the D7 database API syntax.
  /* db_query("DELETE FROM {taxonomy_term_node} WHERE vid = %d and tid IN (SELECT tid FROM {taxonomy_term_data} td WHERE td.vid = %d)", $node->vid, $vid) */
  db_delete('taxonomy_term_node')
    ->where('vid = %d and tid IN (SELECT tid FROM {taxonomy_term_data} td WHERE td.vid = %d)', $node->vid, $vid)
    ->execute();
}

/**
 * @todo Please document this function.
 * @see http://drupal.org/node/1354
 */
function reservations_taxonomy_node_save_terms($node, $tids) {

  if (empty($tids) or empty($node->vid)) {
    return;
  }

  foreach ($tids as $tid) {
    if ($tid) {
      $object = array('nid' => $node->nid, 'vid' => $node->vid, 'tid' => $tid);
      drupal_write_record('taxonomy_term_node', $object);
    }
  }
}

/**
 * @todo Please document this function.
 * @see http://drupal.org/node/1354
 */
function reservations_nodes_for_type_count($type) {
  return db_query("SELECT COUNT(nid) FROM {node} WHERE type = :type", array(':type' => $type))->fetchField();
}

function reservations_node_type_update_variables($info, $existing) {
  //dsm('reservations_node_type_update_variables');
  // This hack is necessary because the node type form submit
  // automatically saves all remaining form items to {variable}
  // We're doing custom storage, so remove these.
  // Don't delete reservations_type_setting_

  $variables = array(
    'reservations_max_hours_per_reservation',
    'reservations_allow_overnight',
    'reservations_allow_weekends',
    'reservations_late_fee_per_hour',
    'reservations_rate_per_hour',
    'reservations_fee_free_hours',
    'reservations_status',
    'reservations_spare_items',
    'reservations_min_cancel_hours',
    'reservations_autocheckout',
    'reservations_autocheckin',
    'reservations_selfcheckout',
    'reservations_grouping',
    'reservations_active_status',
    'reservations_auto_assign_bucket_item',
  );

  $settings = array(
    'reservations_type_setting' => reservations_type_setting($info->type),
    'type' => $info->type,
  );
  foreach ($variables as $variable) {
    $settings[$variable] = variable_get($variable . '_' . $info->type, 0);
    variable_del($variable . '_' . $info->type);
  }

  if (!$existing) {
    $return = drupal_write_record('reservations_node_type', $settings);
  }
  else {
    $return = drupal_write_record('reservations_node_type', $settings, 'type');
  }

  cache_clear_all('reservations_' . $settings['type'] . '_data', 'cache');
  cache_clear_all('reservations_content_type_info', 'cache');
}


/**
 * @todo Please document this function.
 * @see http://drupal.org/node/1354
 */
function reservations_node_type_existing($type) {
  return db_query("SELECT type FROM {reservations_node_type} WHERE type = :type", array(':type' => $type))->fetchField();
}

/**
 * @todo Please document this function.
 * @see http://drupal.org/node/1354
 */
function reservations_node_type_delete($info) {
  // TODO Please review the conversion of this statement to the D7 database API syntax.
  /* db_query("DELETE FROM {reservations_node_type} WHERE type = '%s'", $info->type) */
  db_delete('reservations_node_type')
    ->condition('type', $info->type)
    ->execute();
  variable_del('reservations_type_setting_' . $info->type);
  cache_clear_all('reservations_' . $info->type . '_data', 'cache');
  cache_clear_all('reservations_content_type_info', 'cache');
}

/**
 * @todo Please document this function.
 * @see http://drupal.org/node/1354
 */
function reservations_reservation_status($node) {
  return db_query("SELECT reservations_reservation_status FROM {reservations_reservation} WHERE vid = :vid", array(':vid' => $node->vid))->fetchField();
}

/**
 * @todo Please document this function.
 * @see http://drupal.org/node/1354
 */
function reservations_reservation_items($node) {
  //dsm('reservations_reservation_items');
  $items = db_query("SELECT m.did, m.reservations_item_status, reservations_placeholder_nid, pn.title AS placeholder_title, reservations_item_nid, tn.title AS item_title, nt.type, nt.name FROM {reservations_reservation_detail} m INNER JOIN {node} pn ON m.reservations_placeholder_nid = pn.nid INNER JOIN {node_type} nt ON pn.type = nt.type LEFT JOIN {node} tn ON m.reservations_item_nid = tn.nid WHERE m.vid = :vid", array(':vid' => $node->vid));

  $reservation_items = array();

  foreach ($items as $item) {
    $item = (array) $item;
    $reservation_items[$item['did']] = $item;
  }
  //dsm($reservation_items);
  return $reservation_items;
}


/**
 * @todo Please document this function.
 * @see http://drupal.org/node/1354
 */
function reservations_delete_record($table, &$object, $key) {
  return db_delete($table)
    ->condition($key, $object->{$key})
    ->execute();
}

/**
 * Returns totals for reporting.
 *
 * @param $type
 *   The bucket or resrouce node type.
 * @param $startdate
 *   TRUE to restrict to published items, FALSE otherwise.
 *
 * @return
 *   Total reservation number for that type betweent the start and end dates
 TODO NOT USER.
 */
function reservations_reservation_totals($type, $startdate, $enddate) {
  return db_query("SELECT COUNT(nid) as total  FROM {node} WHERE type LIKE :type and status = :status AND created > :created AND created < :created2", array(
    ':status' => 0,
    ':type' => $type,
    ':created' => $startdate,
    ':created2' => $enddate
  ))->fetchField();
}

/**
 * @todo Please document this function.
 * @see http://drupal.org/node/1354
 */
function reservations_has_accessories($content_type) {
  if (empty($content_type)) {
    return;
  }
  return db_query("SELECT * FROM {taxonomy_vocabulary_node_type} WHERE type = :type", array(':type' => $content_type))->fetchObject();
}

/**
 * Pass type as user/project and uid/nid
 * returns total hours
 */
function reservations_total_usage($id, $type = 'user', $date = NULL) {

  // Determine CCK table and columns the date data is stored in.
  $field = field_info_field('field_reservations_date');
  $table = key($field['storage']['details']['sql']['FIELD_LOAD_CURRENT']);
  $column_start_date = $field['storage']['details']['sql']['FIELD_LOAD_CURRENT'][$table]['value'];
  $column_end_date = $field['storage']['details']['sql']['FIELD_LOAD_CURRENT'][$table]['value2'];

  $query = db_select('reservations_reservation', 'mr');
  $query->join('node', 'n', 'n.vid = mr.vid');
  $query->join($table, 'ct', 'n.vid = ct.revisionid');
  $query->addField('ct', $column_start_date, 'field_reservations_date_value');
  $query->addField('ct', $column_end_date, 'field_reservations_date_value2');
  if ($type == 'project') {
    $query->join('og_ancestry', 'og', 'og.nid = n.nid');
    $query->condition('group_nid', $id);
  }
  else {
    if ($date) {
      $query->condition('uid', $id);
      $query->condition($column_start_date, $date, '>');
    }
    else {
      $query->condition('uid', $id);
    }
  }
  $result = $query->execute();

  //add the reservation total minutes for each item in the reservation
  foreach ($result as $reservationnode) {

    $minutes = $minutes + ((strtotime($reservationnode->field_reservations_date_value2) - strtotime($reservationnode->field_reservations_date_value)));
  }

  return $minutes;
}

/**
 * @todo Please document this function.
 * @see http://drupal.org/node/1354
 */
function reservations_incomplete_reservations_for_item_nid($nid) {
  // Determine CCK table and columns the date data is stored in.
  $field = field_info_field('field_reservations_date');
  $table = key($field['storage']['details']['sql']['FIELD_LOAD_CURRENT']);
  $column_start_date = $field['storage']['details']['sql']['FIELD_LOAD_CURRENT'][$table]['value'];
  $column_end_date = $field['storage']['details']['sql']['FIELD_LOAD_CURRENT'][$table]['value2'];


  $time = gmdate('Y-m-d H:i:s');

  // Pull any incomplete reservations that use the item in question
  // TODO Please convert this statement to the D7 database API syntax.
  $reservations = db_query("SELECT n.nid, n.title FROM {node} n INNER JOIN {" . $table . "} ct ON ct.revision_id = n.vid INNER JOIN {reservations_reservation_detail} md ON ct.revision_id = md.vid WHERE md.reservations_item_nid = :reservations_item_nid AND " . $column_end_date . " >= :end AND NOT (md.reservations_item_status <= :reservations_item_status)", array(
    ':reservations_item_nid' => $nid,
    ':end' => $time,
    ':reservations_item_status' => RESERVATIONS_ITEM_STATUS_AVAILABLE
  ));

  $bad_reservations = array();
  foreach ($reservations as $reservation) {
    $bad_reservations[] = l($reservation->title, "node/$reservation->nid/edit", array('query' => drupal_get_destination()));
  }

  return $bad_reservations;
}

/**
 * @todo Please document this function.
 * @see http://drupal.org/node/1354
 */
function reservations_db_reservations_by_status_in_timespan($statuses = array(), $start = NULL, $end = NULL) {

  // Determine CCK table and columns the date data is stored in.
  $field = field_info_field('field_reservations_date');
  $table = key($field['storage']['details']['sql']['FIELD_LOAD_CURRENT']);
  $column_start_date = $field['storage']['details']['sql']['FIELD_LOAD_CURRENT'][$table]['value'];
  $column_end_date = $field['storage']['details']['sql']['FIELD_LOAD_CURRENT'][$table]['value2'];

  $where = array();
  $args = array();

  if (!empty($statuses)) {
    $status_where = array();
    foreach ($statuses as $i => $status) {
      $key = ':reservations_reservation_status' . $i;
      $status_where[] = 'mr.reservations_reservation_status = ' . $key;
      $args[$key] = $status;
    }
    $where[] = '(' . implode(' OR ', $status_where) . ')';
  }

  if ($start) {
    $args[':start'] = $start;
    $where[] = "$column_start_date <= :start";
  }
  if ($end) {
    $args[':end'] = $end;
    $where[] = "$column_end_date > :end";
  }

  $where = count($where) ? 'WHERE ' . implode(' AND ', $where) : '';
  // Select reservation nodes where all reserved items and resources are autocheckout.
  // TODO Please convert this statement to the D7 database API syntax.
  $reservations = db_query("SELECT n.nid FROM {node} AS n
        INNER JOIN {" . $table . "} ct ON ct.revision_id = n.vid
        INNER JOIN {reservations_reservation} AS mr ON n.vid = mr.vid
          $where", $args);

  $nodes = array();
  while ($reservation_nid = $reservations->fetchField()) {

    $nodes[$reservation_nid] = $reservation_nid;

  }
  return $nodes;
}

/**
 * Pulls an array of items that are reservable for the content type and date range.
 *
 * @param $content_type
 *   The content type name of the bucket/resource.
 * @param $start
 *   Start time in DATETIME format UTC timezone.
 * @param $end
 *   End time in DATETIME format UTC timezone.
 * @param $reservation_nid
 *   (Optional) A reservation nid to exclude from the reserved items.
 *
 * @return
 *   An array of reservable items, in select option format.
 */
function reservations_get_reservable_items($content_type, $start = NULL, $end = NULL, $reservation_nid = NULL, $overdue = TRUE) {

  //dsm('reservations_get_reservable_items');

  $reservations_type = reservations_type_setting($content_type);
  // Pull reservable items.  This query takes the following into consideration:
  //   1. Pulls all all item nodes of the content type that are in an available or checked in state,
  //   2. Excludes all item nodes that have associated reservations in the date range
  //      of the this reservation where the item is in an already reserved or checked out state.
  //   3. Allows a reservation to be excluded from the exclusions if necessary (this
  //      is usually used to allow an already assigned item to not conflict with itself.
  //   4. Exclude items from past reservations where the item is in a checked out state.

  //dsm($content_type);
  //dsm($reservations_type);

  $query = "SELECT n.nid, n.title FROM {node} n
    INNER JOIN {reservations_reservation_item_node} m ON n.vid = m.vid
      WHERE m.reservations_default_availability IN (:avail, :avail2)
        AND n.type = :type
        AND m.reservations_sub_type = :reservations_sub_type
        ";

  $args = array(
    ':avail' => RESERVATIONS_AVA_F,
    ':avail2' => RESERVATIONS_AVA_T,
    ':type' => $content_type,
    ':reservations_sub_type' => RESERVATIONS_SUB_TYPE_ITEM
  );


  if ($start) {

    $args += array(
      ':start1' => $start,
      ':start2' => $end,
      ':start3' => $start,
      ':start4' => $end,
      ':start5' => $start,
      ':start6' => $end,
      ':reservations_item_status' => RESERVATIONS_ITEM_STATUS_AVAILABLE
    );

    // If there's an already selected bucket item, then we need to make sure we
    // include it in the list of available items.
    $query .= "
      AND n.nid NOT IN
      (SELECT md2.reservations_item_nid FROM {field_data_field_reservations_date} ct
      INNER JOIN {reservations_reservation_detail} md2 ON ct.revision_id = md2.vid
      INNER JOIN {reservations_reservation_item_node} m2 ON md2.reservations_item_nid = m2.nid
      INNER JOIN {node} ctn ON ctn.vid = ct.revision_id
      INNER JOIN {node} m2n ON m2.vid = m2n.vid
      WHERE (
        (
          ((field_reservations_date_value >= :start1 AND field_reservations_date_value <= :start2)
          OR (field_reservations_date_value2 >= :start3 AND field_reservations_date_value2 <= :start4)
          OR (field_reservations_date_value <= :start5 AND field_reservations_date_value2 >= :start6))
          AND NOT md2.reservations_item_status <= :reservations_item_status
        ) ";

    if ($reservation_nid) {
      $where = ' AND md2.nid <> :reservation_nid';
      $args[':reservation_nid'] = $reservation_nid;
    }

    $query .= "
      )
      " . (isset($where) ? $where : "") . "
    )
    ";

  }
  $query .= " ORDER BY n.title";


  $items = db_query($query, $args);
  $options = array();

  foreach ($items as $item) {
    //MNN Customization... needs to be tested
    if ($prefix_table = variable_get('reservations_inventory_prefix', NULL)) {
      $inventory_id = db_query("SELECT field_inventory_number_value AS id FROM {" . $prefix_table . "} WHERE entity_id = :id", array(':id' => $item->nid))->fetchField();
    }
    $value = isset($inventory_id) ? $inventory_id . ' - ' . $item->title : $item->title;
    $options[$item->nid] = $value;
  }

  if ($overdue) {
    $overdue_items_array = reservations_overdue_items($content_type, $start, $reservation_nid);
    if (!empty($overdue_items_array)) {
      foreach ($options as $item_nid => $title) {
        if (array_key_exists($item_nid, $overdue_items_array)) {
          unset($options[$item_nid]);
        }
      }
    }
  }
  return $options;
}

/**
 * @param $content_type
 * @param $start     - !!!!!! not used !!!!! - the query currently uses the current time.
 * @param null $reservation_nid
 * @return array|null
 */
function reservations_overdue_items($content_type, $start, $reservation_nid = NULL) {

  $total_items_array = array();

  // Determine CCK table and columns the date data is stored in.
  $field = field_info_field('field_reservations_date');
  $table = key($field['storage']['details']['sql']['FIELD_LOAD_CURRENT']);
  $column_start_date = $field['storage']['details']['sql']['FIELD_LOAD_CURRENT'][$table]['value'];
  $column_end_date = $field['storage']['details']['sql']['FIELD_LOAD_CURRENT'][$table]['value2'];
  $where = '';

  // @todo - Needs cleaning up: The below commented out code did not work.
    // The check for $utc_order_start_time coused checked out items to falsely be
    // identified as overdue.
    // The function to return UTC time, did not work on the server.
// Pull reservations in the past which are still checked out.
//  $utc_order_start_time = date_create($start, timezone_open("UTC"));
//  $utc_now = date_create("now", timezone_open("UTC") );
//  // The below condition is probably incorrect. @todo - review
//  if ($utc_order_start_time < $utc_now) {
//    $start =  $utc_now->date;
//  }
//  // We always want to use the current UTC time to find out if this is an overdue item.
//  $start =  $utc_now->date;


  // Pull reservations in the past which are still checked out.
  $start = gmdate("Y-m-d H:i:s");

  $args = array(
    ':end' => $start,
    ':type' => $content_type,
    ':reservations_item_status' => RESERVATIONS_ITEM_STATUS_CHECKED_OUT
  );

  $reservations_type = reservations_type_setting($content_type);

  if ($reservations_type == 'disabled') {
    return NULL;
  }

  // If we're checking an existing reservation, exclude it from the
  // reserved items.
  if (isset($reservation_nid)) {
    $where = ' AND ct.entity_id <> :reservation_nid';
    $args[':reservation_nid'] = $reservation_nid;
  }

  // TODO Please convert this statement to the D7 database API syntax.
  $reserved_nodes = db_query("
    SELECT ct.entity_id as nid, $column_start_date AS field_reservations_date_value, $column_end_date AS field_reservations_date_value2 , md.reservations_item_nid FROM {" . $table . "} ct
    INNER JOIN {reservations_reservation_detail} md on ct.revision_id = md.vid
    INNER JOIN {reservations_{$reservations_type}_node} m on md.reservations_placeholder_nid = m.nid
    INNER JOIN {node} ctn on ct.revision_id = ctn.vid
    INNER JOIN {node} mn on m.vid = mn.vid
    WHERE ($column_end_date < :end)
    AND mn.type = :type
    AND md.reservations_item_nid !=0
    AND md.reservations_item_status = :reservations_item_status
    $where",
    $args
  );

  // Use up items for assigned nodes.
  foreach ($reserved_nodes as $node) {
    $node = (array) $node;

    $total_items_array[$node['reservations_item_nid']][$node['nid']] = $node;
    // LOTTIE - 2018-10-03 no need to write overdue to watchdog
    //if (variable_get('reservations_verbose_logging', 0)) {
    //  watchdog('reservations', "Found overdue node " . $node['nid'] . ' when creating new reservation');
    //}
  }

  return (isset($total_items_array)) ? $total_items_array : NULL;
}



/**
 * Calculates the total number of available bucket items for a reservation.
 *
 * @param $content_type
 *   The bucket content type.
 * @param $start
 *   Start time in DATETIME format UTC timezone.
 * @param $end
 *   End time in DATETIME format UTC timezone.
 * @param $reservation
 *   (Optional) A reservation nid to exclude from the reserved items.
 * @param $inventory_id
 *  The ID of the inventory.
 *
 * @return
 *   The number of available bucket items.
 */
function reservations_get_available_bucket_count($content_type, $start = NULL, $end = NULL, $reservation = NULL, $inventory_id = NULL) {
  //if there are no dates, return the active total
  $reserved_items = 0;
  if (!$start) {

    //if user is admin/manager and reservations template is installed

    $count = db_query("SELECT COUNT(n.nid) as total FROM {node} n
      LEFT JOIN {reservations_bucket_node} mbn ON n.vid = mbn.vid
      WHERE n.type = :type AND n.status = :status
      AND mbn.reservations_default_availability = :reservations_default_availability",
      array(
        ':type' => $content_type,
        ':status' => 1,
        ':reservations_default_availability' => 1
      )
    )->fetchField();
    return $count;
  }

  $total_items_array = reservations_reserved_bucket_items($content_type, $start, $end, $reservation, array(), TRUE, $inventory_id);

  foreach ($total_items_array as $item_nid => $reservations) {
    if (!empty($reservations)) {
      $reserved_items++;
    }
  }

  return sizeof($total_items_array) - $reserved_items;
}


/**
 * reservations_get_reservation_count($content_type[string])
 * returns total number of checked out items for content type.
 * @ $content_type resource to be counted
 */
function reservations_get_reservation_count($content_type) {
  return db_query("SELECT COUNT(n.nid) as total FROM {node} n
    JOIN {reservations_reservation_detail} mrin ON mrin.vid = n.vid
    JOIN {node} ctn ON mrin.reservations_item_nid = ctn.nid
    WHERE ctn.type = :type and mrin.reservations_item_status = :reservations_item_status",
    array(
      ':type' => $content_type,
      ':reservations_item_status' => RESERVATIONS_ITEM_STATUS_CHECKED_OUT
    ))->fetchField();
}

/**
 * reservations_get_count ($content_type, $default_availability)
 * returns total number of items available for check out.
 * @ $content_type resource to be counted
 * @ $default_availability
 *
 * @todo Please document this function.
 * @see http://drupal.org/node/1354
 */
function reservations_get_count($type, $default_availability = RESERVATIONS_AVA_F) {
  // TODO Please convert this statement to the D7 database API syntax.
  return db_query("SELECT COUNT(n.nid) as total FROM {node} n
      LEFT JOIN {reservations_" . $type['reservations_type_setting'] . "_node} mbn ON n.vid = mbn.vid
      WHERE n.type = :type
      AND mbn.reservations_default_availability = :reservations_default_availability
      AND mbn.reservations_sub_type = :reservations_sub_type",
    array(
      ':type' => $type['type'],
      ':reservations_default_availability' => $default_availability,
      ':reservations_sub_type' => RESERVATIONS_SUB_TYPE_ITEM
    )
  )->fetchField();
}

/**
 * Get an array of content type items used by a given reservation.
 *
 * @param $node
 * @return array
 */
function reservations_content_type_items($node) {
  $content_type_items = array();
  $langcode = $node->language;

  foreach ($node->reservations_reservation_items as $did => $item) {

    //IT'S NOT INCLUDING BOTH ITEMS ALREADY ON THE RES AND ITEMS JUST ADDED
    if ($item['reservations_item_nid'] == '') {
      continue;
    }

    //dpm($item, 'item_ct');
    if (!is_numeric($item['reservations_item_nid'])) {
      $type = $item['reservations_item_nid'];
      $item_nid = 0;
      $nid = 0;
    }
    else {
      $type = $item['type'];
      $item_nid = $item['reservations_item_nid'];
      $nid = $node->nid;
    }


    $content_type_items[$type][] =
      array(
        'nid' => $nid,
        'reservations_reservation_status' =>
          $node->reservations_reservation_status,
        'field_reservations_date_value' =>
          $node->field_reservations_date[$langcode][0]['value'],
        'field_reservations_date_value2' =>
          $node->field_reservations_date[$langcode][0]['value2'],
        'reservations_item_nid' => $item_nid,
      );
  }

  return $content_type_items;
}


/**
 * Is this item reservable? Return TRUE or FALSE.
 *
 * @param $this_res_items
 * @param $type
 * @param $start
 * @param $end
 * @param $item_nid
 * @param null $exclude_vid
 * @return bool
 */
function reservations_is_item_reservable($this_res_items, $type,
       $start, $end, $item_nid, $exclude_vid = NULL, $inventory_id = NULL) {

  // exclude this->item from the array of res_items for this reservation
  if ($item_nid) {
    foreach ($this_res_items as $key => $item_reservation) {
      if ($item_nid == $item_reservation['reservations_item_nid']) {
        unset($this_res_items[$key]);
        break;
      }
    }
  }
  else {
    // didn't find the item_res using $item_nid so all the item_nids must be
    // zero, so just get rid of the first element
    unset($this_res_items[0]);
  }

  $items = reservations_load_reservations_for_node_in_timespan($item_nid, $type, $start, $end, $exclude_vid, $this_res_items, $inventory_id);
// LOTTIE REVISED DATABASE FILE
//if($type == 'flolight_with_battery_plate_ms') {
//dpm($items, 'timespan items_new');
//dpm($item_nid, 'item_nid');
//}
  // If we are checking an item?
  if ($item_nid) {
    if (isset($items[$item_nid]) and count($items[$item_nid])) {
      return FALSE;
    }
    return TRUE;
  }

  // If we are checking a bucket
  $count = 0;
  foreach ($items as $item_nid => $reservations) {
    if (empty($reservations)) {
      $count++;
    }
  }
  $content_settings = reservations_load_item_settings($type);
  return $count - $content_settings->reservations_spare_items > 0 ? TRUE : FALSE;
}


/**
 * Builds an array representing reservations for a Resource within a given timespan
 *
 * @param $item_nid
 *  The nid of the item being reserved.
 * @param $type
 * @param $start_date
 * @param $end_date
 * @param null $reservation_vid
 * @param array $this_res_items
 *  The reservation object or an empty array
 * @return array
 *   An associative array with keys as times (in MySQL datetime format) and values as number of reservations.
 */
function reservations_load_reservations_for_node_in_timespan($item_nid, $type,
        $start_date, $end_date, $reservation_vid = NULL,
        $this_res_items = array(), $inventory_id = NULL)
{
  $type_settings = reservations_type_setting($type);
  if ($type_settings == 'bucket' and empty($item_nid)) {
    return reservations_reserved_bucket_items($type, $start_date, $end_date, $reservation_vid, $this_res_items, TRUE, $inventory_id);
  }
  else {
    // Resource.
    if (variable_get('reservations_ignore_unconfirmed_reservations', 0)) {
      // IGNORE UNCONFIRMED
      $statuses = '2, 3';
    }
    else {
      $statuses = '1, 2, 3';
    }
    $cleaning_buffer = 0;
    if (isset($inventory_id)) {
      $restrictions = variable_get('reservations_inventory_restrictions', '');
      if (isset($restrictions[$inventory_id]['cleaning_buffer'])) {
        $cleaning_buffer = $restrictions[$inventory_id]['cleaning_buffer'];
        // Add Checked in status.
        $statuses .= ',4';
      }
    }

    // Check start and end buffers need disabling.
    global $cleaning_buffer_checks;
    if ($cleaning_buffer_checks['start_buffer_validation']) {
      $cleaning_buffer_start = $cleaning_buffer;
    }
    else {
      $cleaning_buffer_start = 0;
    }
    if ($cleaning_buffer_checks['end_buffer_validation']) {
      $cleaning_buffer_end = $cleaning_buffer;
    }
    else {
      $cleaning_buffer_end = 0;
    }

    // Add a buffer for item cleaning.
    $buffer_start = ' -' . $cleaning_buffer_start . ' hours';
    $buffer_end = ' +' . $cleaning_buffer_end . ' hours';
    $start_date = date(DATE_FORMAT_DATETIME, strtotime($start_date. $buffer_start));
    $end_date = date(DATE_FORMAT_DATETIME, strtotime($end_date. $buffer_end));

    // Determine CCK table and columns the date data is stored in.
    $field = field_info_field('field_reservations_date');
    $table = key($field['storage']['details']['sql']['FIELD_LOAD_CURRENT']);
    $column_start_date = $field['storage']['details']['sql']['FIELD_LOAD_CURRENT'][$table]['value'];
    $column_end_date = $field['storage']['details']['sql']['FIELD_LOAD_CURRENT'][$table]['value2'];

    // FROM {reservations_reservation_detail} d
    // WHERE d.nid = :item_nid

    $sql = "SELECT r.entity_id AS nid, $column_start_date AS field_reservations_date_value, $column_end_date AS field_reservations_date_value2, reservations_item_nid
      FROM {node} n
      JOIN {reservations_reservation_detail} d ON n.nid = d.reservations_item_nid
      JOIN {" . $table . "} r ON d.vid = r.revision_id
      JOIN {reservations_reservation} mr ON r.revision_id = mr.vid
      WHERE n.nid = :item_nid
        AND
            mr.reservations_reservation_status IN (" . $statuses . ")
        AND
                    (($column_start_date >= :start1 AND $column_start_date <= :start2)
                    OR ($column_end_date >= :start3 AND $column_end_date <= :start4)
                    OR ($column_start_date <= :start5 AND $column_end_date >= :start6))
      ";
  }

  $args = array(
    ':item_nid' => $item_nid,
    ':start1' => $start_date,
    ':start2' => $end_date,
    ':start3' => $start_date,
    ':start4' => $end_date,
    ':start5' => $start_date,
    ':start6' => $end_date
  );


  // TODO: do not exclude the entire reservation - just this->item
  // If we're checking an existing reservation, exclude it from the
  // reserved items.
  if ($reservation_vid) {
    $sql .= " AND d.vid <> :reservation_vid";
    $args[':reservation_vid'] = $reservation_vid;
  }
  $sql .= " ORDER BY $column_start_date ";

  // TODO Please convert this statement to the D7 database API syntax.
  $reservations = db_query($sql, $args);

  foreach ($reservations as $reservation) {
    $return[$item_nid][$reservation->nid] = $reservation;
  }

  return isset($return) ? $return : array();
}

/**
 * @param $content_type
 * @param null $start
 *  Start data and time.
 * @param null $end
 *  End data and time.
 * @param null $reservation_vid
 * @param array $this_res_items
 *    Set if a bucket item and more then one of.
 * its type in the order?
 * @param bool $overdue
 * @return array
 *  Key reservable items.
 *  value: If an item is used by another order then this will hold the order.
 */
function reservations_reserved_bucket_items($content_type, $start = NULL, $end = NULL, $reservation_vid = NULL, $this_res_items = array(), $overdue = TRUE, $inventory_id = NULL) {

  // LOTTIE - nothing is getting done with this currently
  //end date need to be converted again
  $backtoback = variable_get('reservations_back_to_back_allowed', 0);

  // Determine CCK table and columns the date data is stored in.
  $field = field_info_field('field_reservations_date');
  $table = key($field['storage']['details']['sql']['FIELD_LOAD_CURRENT']);
  $column_start_date = $field['storage']['details']['sql']['FIELD_LOAD_CURRENT'][$table]['value'];
  $column_end_date = $field['storage']['details']['sql']['FIELD_LOAD_CURRENT'][$table]['value2'];

  // Get all assignable nodes for this bucket item.
  $total_items_nodes = db_query("SELECT n.nid FROM {node} n INNER JOIN {reservations_reservation_item_node} m ON n.vid = m.vid WHERE n.type = :type AND m.reservations_sub_type = :reservations_sub_type AND m.reservations_default_availability IN (:avail1, :avail2)",
    array(
      ':type' => $content_type,
      ':reservations_sub_type' => RESERVATIONS_SUB_TYPE_ITEM,
      ':avail1' => RESERVATIONS_AVA_F,
      ':avail2' => RESERVATIONS_AVA_T
    )
  );
  $total_items_array = array();
  foreach ($total_items_nodes as $ctnodes) {
    $total_items_array[$ctnodes->nid] = array();
  }

  // Work out the cleaning buffer.
  $cleaning_buffer = 0;
  if (isset($inventory_id)) {
    $restrictions = variable_get('reservations_inventory_restrictions', '');
    if (isset($restrictions[$inventory_id]['cleaning_buffer'])) {
      $cleaning_buffer = $restrictions[$inventory_id]['cleaning_buffer'];
    }
  }

  // Check start and end buffers need disabling.
  global $cleaning_buffer_checks;
  if ($cleaning_buffer_checks['start_buffer_validation']) {
    $cleaning_buffer_start = $cleaning_buffer;
  }
  else {
    $cleaning_buffer_start = 0;
  }
  if ($cleaning_buffer_checks['end_buffer_validation']) {
    $cleaning_buffer_end = $cleaning_buffer;
  }
  else {
    $cleaning_buffer_end = 0;
  }

  // Add a buffer for item cleaning.
  $buffer_start = ' -' . $cleaning_buffer_start . ' hours';
  $buffer_end = ' +' . $cleaning_buffer_end . ' hours';
  $start = date(DATE_FORMAT_DATETIME, strtotime($start. $buffer_start));
  $end = date(DATE_FORMAT_DATETIME, strtotime($end. $buffer_end));

  // Query arguments.
  $args = array(
    ':start1' => $start,
    ':start2' => $end,
    ':start3' => $start,
    ':start4' => $end,
    ':start5' => $start,
    ':start6' => $end,
    ':type' => $content_type,
  );

  // If we're checking an existing reservation, exclude it from the
  // reserved items.
  if (isset($reservation_vid)) {
    $where = ' AND ct.revision_id <> :reservation_vid';
    $args[':reservation_vid'] = $reservation_vid;
  }
  else {
    $where = '';
  }

  // Pull reservations with assigned nodes.
  if ($cleaning_buffer) {
    // Where status is reserved, checked out or checked in.
    $in_list = '(' . RESERVATIONS_ITEM_STATUS_CHECKED_OUT .',' . RESERVATIONS_ITEM_STATUS_RESERVED .',' . RESERVATIONS_ITEM_STATUS_CHECKED_IN . ')';
  }
  else {
    // Where status is reserved or checked out (We don't care about checked-in if we don't have a cleaning buffer).
    $in_list = '(' . RESERVATIONS_ITEM_STATUS_CHECKED_OUT .',' . RESERVATIONS_ITEM_STATUS_RESERVED . ')';
  }
  // TODO Please convert this statement to the D7 database API syntax.
  $assigned_nodes = db_query("
    SELECT ct.entity_id as nid, $column_start_date AS field_reservations_date_value, $column_end_date AS field_reservations_date_value2 , md.reservations_item_nid FROM {" . $table . "} ct
      INNER JOIN {reservations_reservation_detail} md on ct.revision_id = md.vid
      INNER JOIN {reservations_bucket_node} m on md.reservations_placeholder_nid = m.nid
      INNER JOIN {node} ctn on ct.revision_id = ctn.vid
      INNER JOIN {node} mn on m.vid = mn.vid
        WHERE (
                ($column_start_date >= :start1 and $column_start_date <= :start2)
            OR  ($column_end_date >= :start3 and $column_end_date <= :start4)
            OR  ($column_start_date <= :start5 and $column_end_date >= :start6)
          )
          AND mn.type = :type
          AND md.reservations_item_nid !=0
          AND md.reservations_item_status IN " . $in_list . "
          $where",
    $args
  );

  // Use up items for assigned nodes.
  foreach ($assigned_nodes as $node) {
    // If item is assigned then item is in use by this node.
    $total_items_array[$node->reservations_item_nid][$node->nid] = $node;
  }

  //ADD OVERDUE WINDOW LOGIC (note $start is not used)
  if ($overdue) {  // function parameter
    $overdue_items_array = reservations_overdue_items($content_type, $start, $reservation_vid);
    if (!empty($overdue_items_array)) {
      foreach ($overdue_items_array as $reservations_item_nid => $nodes) {
        foreach ($nodes as $nid => $node) {
          $node['overdue'] = TRUE;
          $object = (object) $node;
          $total_items_array[$node['reservations_item_nid']][$node['nid']] = $object;
        }
      }
    }
  }

  //  Pull reservations without assigned nodes (no reservations_item_nid)
  // and not status smaller then RESERVATIONS_ITEM_STATUS_AVAILABLE.
  // (The status condition looks redundant/wrong but it works so let's not change.)
  $unassigned_nodes = db_query("
    SELECT ct.entity_id AS nid, $column_start_date AS field_reservations_date_value, $column_end_date AS field_reservations_date_value2 , md.reservations_item_nid FROM {" . $table . "} ct
        INNER JOIN {reservations_reservation_detail} md ON ct.revision_id = md.vid
        INNER JOIN {reservations_bucket_node} m ON md.reservations_placeholder_nid = m.nid
        INNER JOIN {node} ctn on ct.revision_id = ctn.vid
        INNER JOIN {node} mn ON m.vid = mn.vid
          WHERE (
                  ($column_start_date >= :start1 AND $column_start_date <= :start2)
              OR  ($column_end_date >= :start3 AND $column_end_date <= :start4)
              OR  ($column_start_date <= :start5 AND $column_end_date >= :start6)
            )
            AND mn.type = :type
            AND md.reservations_item_nid = 0
            AND NOT md.reservations_item_status < " . RESERVATIONS_ITEM_STATUS_AVAILABLE . "
            $where",
    $args
  );

  $generic_nodes = array();

  foreach ($unassigned_nodes as $node) {
    $generic_nodes[] = $node;
  }

  //OPENFLOWS - LOTTIE  - 4/11/18
  // add items from this reservation to $generic_nodes
  // this->item has been excluded
  foreach ($this_res_items as $item_res) {
    if ($item_res['reservations_item_nid'] == 0 &&
      $item_res['reservations_reservation_status'] <= 3) { // includes checked out
      $item_res_obj = (object) $item_res;
      $generic_nodes[] = $item_res_obj;
    }
  }
  uasort($total_items_array, '_reservations_sort_array');


  // Temporarily assign an item for these nodes. Add a test to continue if the
  // generic array is null
  foreach ((array) $generic_nodes as $node) {

    // Eat up a bucket item for this node.
    // If item is not assigned then temporarily add one.
    foreach ($total_items_array as $item_nid => $reservations) {
      $willitfit = TRUE;
      foreach ($reservations as $oldnode) {
        // Does the start date overlap this reservation.
        $oldnode = (array) $oldnode;

        // Convert start/end dates to local time.
        // TODO clean this up.
        // WHY DO THESE DATES NEED TO BE CONVERTED? BOTH OLDNODE AND NODE ARE
        // ARE USING UTC TIME
        // Guy: Looks like this conversion is not needed but as both are
        // converted for comparison only then will work ok.
        $node_start_object = reservations_create_local_date_object($node->field_reservations_date_value);
        $node_end_object = reservations_create_local_date_object($node->field_reservations_date_value2);

        $oldnode_start_object = reservations_create_local_date_object($oldnode['field_reservations_date_value']);
        $oldnode_end_object = reservations_create_local_date_object($oldnode['field_reservations_date_value2']);


        if (($node_start_object > $oldnode_start_object) &&
          ($node_start_object < $oldnode_end_object)) {
          $willitfit = FALSE;
          break;
        }
        if (($node_end_object > $oldnode_start_object) &&
          ($node_end_object < $oldnode_end_object)) {
          $willitfit = FALSE;
          break;
        }
        if (($node_start_object <= $oldnode_start_object) &&
          ($node_end_object >= $oldnode_end_object)) {
          $willitfit = FALSE;
          break;
        }

        // check for overdue
        if (isset($oldnode['overdue']) &&
          $oldnode['overdue'] == TRUE) {
          $willitfit = FALSE;
          break;
        }

      }

      if ($willitfit) {
        $total_items_array[$item_nid][$node->nid] = $node;
        break;
      }
    }
  }
  return $total_items_array;
}
