<?php
/*
 +---------------------------------------------------------------------------+
 | Copyright (C) 2009 Openflows, Inc. + Blue Bag. All rights reserved.       |
 |                                                                           |
 | This work is published under the GNU AGPLv3 license without any           |
 | warranty. For full license and copyright information, see                 |
 | https://www.gnu.org/licenses/agpl-3.0.html                                |
 +---------------------------------------------------------------------------+
 */
 
class reservations_views_handler_filter_reserved_item_nid extends views_handler_filter_many_to_one {
  function get_value_options() {
    $this->value_options = $this->allowed_values();
  }

  // Get allowed values from hook_allowed_values(), if any,
  // or from content_allowed_values();
  function allowed_values() {
    $options = array();
    $reservations_types = reservations_content_types();
    foreach ($reservations_types as $reservations_type => $type_setting) {
      $options += reservations_get_reservable_items($reservations_type);
    }
    return $options;
  }

}
