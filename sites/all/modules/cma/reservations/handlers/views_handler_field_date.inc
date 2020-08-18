<?php

/**
 * @file
 * reservations views_handler_field_date
 +---------------------------------------------------------------------------+
 | Copyright (C) 2009 Openflows, Inc. + Blue Bag. All rights reserved.       |
 |                                                                           |
 | This work is published under the GNU AGPLv3 license without any           |
 | warranty. For full license and copyright information, see                 |
 | https://www.gnu.org/licenses/agpl-3.0.html                                |
 +---------------------------------------------------------------------------+
 */


/**
 * Views assumes dates are always Unix timestamps, so convert our DATETIME-formatted columns.
 *
 */
class views_handler_field_datetime extends views_handler_field_date {
  function query() {
    $this->ensure_my_table();
    $this->field_alias = $this->query->add_field(NULL, 'UNIX_TIMESTAMP(' . $this->table_alias . '.' . $this->field . ')', $this->table_alias . '_' . $this->field);
  }
}

