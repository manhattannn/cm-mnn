<?php

/**
 * @file
 * cma reservations report default views
 * place export in a file in /includes/views directory
 * give file same name as view_machinename.view
 +---------------------------------------------------------------------------+
 | Copyright (C) 2009 Openflows, Inc. + Blue Bag. All rights reserved.       |
 |                                                                           |
 | This work is published under the GNU AGPLv3 license without any           |
 | warranty. For full license and copyright information, see                 |
 | https://www.gnu.org/licenses/agpl-3.0.html                                |
 +---------------------------------------------------------------------------+
 */


/**
 * Implements hook_views_default_views().
 */

function cma_reservations_reports_views_default_views() {
  $files = file_scan_directory(drupal_get_path('module', 'cma_reservations_reports'). '/includes/views', '/.*\.view$/');
  foreach ($files as $filepath => $file) {
    require $filepath;
    if (isset($view)) {
      $views[$view->name] = $view;
    }
  }
  return $views;
}
