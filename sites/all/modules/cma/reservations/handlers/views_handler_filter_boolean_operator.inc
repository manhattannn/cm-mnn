<?php

/**
 * @file
 * reservations views handlers
 +---------------------------------------------------------------------------+
 | Copyright (C) 2009 Openflows, Inc. + Blue Bag. All rights reserved.       |
 |                                                                           |
 | This work is published under the GNU AGPLv3 license without any           |
 | warranty. For full license and copyright information, see                 |
 | https://www.gnu.org/licenses/agpl-3.0.html                                |
 +---------------------------------------------------------------------------+
 */

class views_handler_filter_bookings_resource_disabled extends views_handler_filter_boolean_operator {
  function construct() {
    $this->definition['label'] = 'Check to show only disabled, or leave empty to show only enabled.';
    parent::construct();
  }
}

