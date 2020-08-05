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
 
function inventory_item_operator_history_views_default_views() {  
// Add view to list of views to provide.
  $view = new view();
  $view->name = 'inventory_item_operator_actions';
  $view->description = '';
  $view->tag = 'default';
  $view->base_table = 'inventory_item_operator_history';
  $view->human_name = 'Inventory Item Operator Actions';
  $view->core = 7;
  $view->api_version = '3.0';
  $view->disabled = FALSE; /* Edit this to true to make a default view disabled initially */

  /* Display: Master */
  $handler = $view->new_display('default', 'Master', 'default');
  $handler->display->display_options['title'] = 'Inventory Item Operator Actions';
  $handler->display->display_options['use_more_always'] = FALSE;
  $handler->display->display_options['access']['type'] = 'none';
  $handler->display->display_options['cache']['type'] = 'none';
  $handler->display->display_options['query']['type'] = 'views_query';
  $handler->display->display_options['exposed_form']['type'] = 'basic';
  $handler->display->display_options['pager']['type'] = 'full';
  $handler->display->display_options['pager']['options']['items_per_page'] = '100';
  $handler->display->display_options['style_plugin'] = 'table';
  /* Field: Inventory Items Operator History: ID */
  $handler->display->display_options['fields']['id']['id'] = 'id';
  $handler->display->display_options['fields']['id']['table'] = 'inventory_item_operator_history';
  $handler->display->display_options['fields']['id']['field'] = 'id';
  $handler->display->display_options['fields']['id']['label'] = '';
  $handler->display->display_options['fields']['id']['exclude'] = TRUE;
  $handler->display->display_options['fields']['id']['element_label_colon'] = FALSE;
  /* Field: Inventory Items Operator History: Beginning Inventory Item Status */
  $handler->display->display_options['fields']['beginning_status']['id'] = 'beginning_status';
  $handler->display->display_options['fields']['beginning_status']['table'] = 'inventory_item_operator_history';
  $handler->display->display_options['fields']['beginning_status']['field'] = 'beginning_status';
  $handler->display->display_options['fields']['beginning_status']['label'] = '';
  $handler->display->display_options['fields']['beginning_status']['exclude'] = TRUE;
  $handler->display->display_options['fields']['beginning_status']['element_label_colon'] = FALSE;
  $handler->display->display_options['fields']['beginning_status']['separator'] = '';
  /* Field: Inventory Items Operator History: End Inventory Item Status */
  $handler->display->display_options['fields']['end_status']['id'] = 'end_status';
  $handler->display->display_options['fields']['end_status']['table'] = 'inventory_item_operator_history';
  $handler->display->display_options['fields']['end_status']['field'] = 'end_status';
  $handler->display->display_options['fields']['end_status']['label'] = '';
  $handler->display->display_options['fields']['end_status']['exclude'] = TRUE;
  $handler->display->display_options['fields']['end_status']['element_label_colon'] = FALSE;
  $handler->display->display_options['fields']['end_status']['separator'] = '';
  /* Field: Inventory Items Operator History: Inventory Item nid */
  $handler->display->display_options['fields']['inventory_item_id']['id'] = 'inventory_item_id';
  $handler->display->display_options['fields']['inventory_item_id']['table'] = 'inventory_item_operator_history';
  $handler->display->display_options['fields']['inventory_item_id']['field'] = 'inventory_item_id';
  $handler->display->display_options['fields']['inventory_item_id']['label'] = '';
  $handler->display->display_options['fields']['inventory_item_id']['exclude'] = TRUE;
  $handler->display->display_options['fields']['inventory_item_id']['element_label_colon'] = FALSE;
  /* Field: Inventory Items Operator History: Notes */
  $handler->display->display_options['fields']['notes']['id'] = 'notes';
  $handler->display->display_options['fields']['notes']['table'] = 'inventory_item_operator_history';
  $handler->display->display_options['fields']['notes']['field'] = 'notes';
  $handler->display->display_options['fields']['notes']['label'] = '';
  $handler->display->display_options['fields']['notes']['exclude'] = TRUE;
  $handler->display->display_options['fields']['notes']['element_label_colon'] = FALSE;
  /* Field: Inventory Items Operator History: UID */
  $handler->display->display_options['fields']['uid']['id'] = 'uid';
  $handler->display->display_options['fields']['uid']['table'] = 'inventory_item_operator_history';
  $handler->display->display_options['fields']['uid']['field'] = 'uid';
  $handler->display->display_options['fields']['uid']['label'] = '';
  $handler->display->display_options['fields']['uid']['exclude'] = TRUE;
  $handler->display->display_options['fields']['uid']['element_label_colon'] = FALSE;
  $handler->display->display_options['fields']['uid']['separator'] = '';
  /* Field: Global: PHP */
  $handler->display->display_options['fields']['php']['id'] = 'php';
  $handler->display->display_options['fields']['php']['table'] = 'views';
  $handler->display->display_options['fields']['php']['field'] = 'php';
  $handler->display->display_options['fields']['php']['label'] = 'Inventory Item';
  $handler->display->display_options['fields']['php']['use_php_setup'] = 0;
$handler->display->display_options['fields']['php']['php_output'] = '<?php
print inventory_item_operator_history_inventory_item_field($row);
?>';
  $handler->display->display_options['fields']['php']['use_php_click_sortable'] = '0';
  $handler->display->display_options['fields']['php']['php_click_sortable'] = '';
  /* Field: Global: PHP */
  $handler->display->display_options['fields']['php_1']['id'] = 'php_1';
  $handler->display->display_options['fields']['php_1']['table'] = 'views';
  $handler->display->display_options['fields']['php_1']['field'] = 'php';
  $handler->display->display_options['fields']['php_1']['label'] = 'Operator';
  $handler->display->display_options['fields']['php_1']['use_php_setup'] = 0;
$handler->display->display_options['fields']['php_1']['php_output'] = '<?php
print inventory_item_operator_history_operator_field($row);
?>';
  $handler->display->display_options['fields']['php_1']['use_php_click_sortable'] = '0';
  $handler->display->display_options['fields']['php_1']['php_click_sortable'] = '';
  /* Field: Global: PHP */
  $handler->display->display_options['fields']['php_2']['id'] = 'php_2';
  $handler->display->display_options['fields']['php_2']['table'] = 'views';
  $handler->display->display_options['fields']['php_2']['field'] = 'php';
  $handler->display->display_options['fields']['php_2']['label'] = 'Beginning Status';
  $handler->display->display_options['fields']['php_2']['use_php_setup'] = 0;
$handler->display->display_options['fields']['php_2']['php_output'] = '<?php
print inventory_item_operator_history_status_field($row, \'beginning\');
?>';
  $handler->display->display_options['fields']['php_2']['use_php_click_sortable'] = '0';
  $handler->display->display_options['fields']['php_2']['php_click_sortable'] = '';
  /* Field: Global: PHP */
  $handler->display->display_options['fields']['php_3']['id'] = 'php_3';
  $handler->display->display_options['fields']['php_3']['table'] = 'views';
  $handler->display->display_options['fields']['php_3']['field'] = 'php';
  $handler->display->display_options['fields']['php_3']['label'] = 'Ending Status';
  $handler->display->display_options['fields']['php_3']['use_php_setup'] = 0;
$handler->display->display_options['fields']['php_3']['php_output'] = '<?php
print inventory_item_operator_history_status_field($row, \'ending\');
?>';
  $handler->display->display_options['fields']['php_3']['use_php_click_sortable'] = '0';
  $handler->display->display_options['fields']['php_3']['php_click_sortable'] = '';
  /* Field: Inventory Items Operator History: Timestamp */
  $handler->display->display_options['fields']['timestamp']['id'] = 'timestamp';
  $handler->display->display_options['fields']['timestamp']['table'] = 'inventory_item_operator_history';
  $handler->display->display_options['fields']['timestamp']['field'] = 'timestamp';
  $handler->display->display_options['fields']['timestamp']['date_format'] = 'short';
  $handler->display->display_options['fields']['timestamp']['second_date_format'] = 'long';

  /* Display: Page */
  $handler = $view->new_display('page', 'Page', 'page');
  $handler->display->display_options['path'] = 'admin/inventory/operator-actions';

  /* Display: Block */
  $handler = $view->new_display('block', 'Block', 'block_1');
  $handler->display->display_options['defaults']['relationships'] = FALSE;
  /* Relationship: Inventory Items Operator History: Operatory History Inventory Item Relationship */
  $handler->display->display_options['relationships']['inventory_item_id']['id'] = 'inventory_item_id';
  $handler->display->display_options['relationships']['inventory_item_id']['table'] = 'inventory_item_operator_history';
  $handler->display->display_options['relationships']['inventory_item_id']['field'] = 'inventory_item_id';
  $handler->display->display_options['relationships']['inventory_item_id']['required'] = TRUE;
  $handler->display->display_options['defaults']['fields'] = FALSE;
  /* Field: Inventory Items Operator History: ID */
  $handler->display->display_options['fields']['id']['id'] = 'id';
  $handler->display->display_options['fields']['id']['table'] = 'inventory_item_operator_history';
  $handler->display->display_options['fields']['id']['field'] = 'id';
  $handler->display->display_options['fields']['id']['label'] = '';
  $handler->display->display_options['fields']['id']['exclude'] = TRUE;
  $handler->display->display_options['fields']['id']['element_label_colon'] = FALSE;
  /* Field: Inventory Items Operator History: Beginning Inventory Item Status */
  $handler->display->display_options['fields']['beginning_status']['id'] = 'beginning_status';
  $handler->display->display_options['fields']['beginning_status']['table'] = 'inventory_item_operator_history';
  $handler->display->display_options['fields']['beginning_status']['field'] = 'beginning_status';
  $handler->display->display_options['fields']['beginning_status']['label'] = '';
  $handler->display->display_options['fields']['beginning_status']['exclude'] = TRUE;
  $handler->display->display_options['fields']['beginning_status']['element_label_colon'] = FALSE;
  $handler->display->display_options['fields']['beginning_status']['separator'] = '';
  /* Field: Inventory Items Operator History: End Inventory Item Status */
  $handler->display->display_options['fields']['end_status']['id'] = 'end_status';
  $handler->display->display_options['fields']['end_status']['table'] = 'inventory_item_operator_history';
  $handler->display->display_options['fields']['end_status']['field'] = 'end_status';
  $handler->display->display_options['fields']['end_status']['label'] = '';
  $handler->display->display_options['fields']['end_status']['exclude'] = TRUE;
  $handler->display->display_options['fields']['end_status']['element_label_colon'] = FALSE;
  $handler->display->display_options['fields']['end_status']['separator'] = '';
  /* Field: Inventory Items Operator History: Inventory Item nid */
  $handler->display->display_options['fields']['inventory_item_id']['id'] = 'inventory_item_id';
  $handler->display->display_options['fields']['inventory_item_id']['table'] = 'inventory_item_operator_history';
  $handler->display->display_options['fields']['inventory_item_id']['field'] = 'inventory_item_id';
  $handler->display->display_options['fields']['inventory_item_id']['label'] = '';
  $handler->display->display_options['fields']['inventory_item_id']['exclude'] = TRUE;
  $handler->display->display_options['fields']['inventory_item_id']['element_label_colon'] = FALSE;
  /* Field: Inventory Items Operator History: Notes */
  $handler->display->display_options['fields']['notes']['id'] = 'notes';
  $handler->display->display_options['fields']['notes']['table'] = 'inventory_item_operator_history';
  $handler->display->display_options['fields']['notes']['field'] = 'notes';
  $handler->display->display_options['fields']['notes']['label'] = '';
  $handler->display->display_options['fields']['notes']['exclude'] = TRUE;
  $handler->display->display_options['fields']['notes']['element_label_colon'] = FALSE;
  /* Field: Inventory Items Operator History: UID */
  $handler->display->display_options['fields']['uid']['id'] = 'uid';
  $handler->display->display_options['fields']['uid']['table'] = 'inventory_item_operator_history';
  $handler->display->display_options['fields']['uid']['field'] = 'uid';
  $handler->display->display_options['fields']['uid']['label'] = '';
  $handler->display->display_options['fields']['uid']['exclude'] = TRUE;
  $handler->display->display_options['fields']['uid']['element_label_colon'] = FALSE;
  $handler->display->display_options['fields']['uid']['separator'] = '';
  /* Field: Global: PHP */
  $handler->display->display_options['fields']['php_1']['id'] = 'php_1';
  $handler->display->display_options['fields']['php_1']['table'] = 'views';
  $handler->display->display_options['fields']['php_1']['field'] = 'php';
  $handler->display->display_options['fields']['php_1']['label'] = 'Operator';
  $handler->display->display_options['fields']['php_1']['use_php_setup'] = 0;
$handler->display->display_options['fields']['php_1']['php_output'] = '<?php
print inventory_item_operator_history_operator_field($row);
?>';
  $handler->display->display_options['fields']['php_1']['use_php_click_sortable'] = '0';
  $handler->display->display_options['fields']['php_1']['php_click_sortable'] = '';
  /* Field: Global: PHP */
  $handler->display->display_options['fields']['php_2']['id'] = 'php_2';
  $handler->display->display_options['fields']['php_2']['table'] = 'views';
  $handler->display->display_options['fields']['php_2']['field'] = 'php';
  $handler->display->display_options['fields']['php_2']['label'] = 'Beginning Status';
  $handler->display->display_options['fields']['php_2']['use_php_setup'] = 0;
$handler->display->display_options['fields']['php_2']['php_output'] = '<?php
print inventory_item_operator_history_status_field($row, \'beginning\');
?>';
  $handler->display->display_options['fields']['php_2']['use_php_click_sortable'] = '0';
  $handler->display->display_options['fields']['php_2']['php_click_sortable'] = '';
  /* Field: Global: PHP */
  $handler->display->display_options['fields']['php_3']['id'] = 'php_3';
  $handler->display->display_options['fields']['php_3']['table'] = 'views';
  $handler->display->display_options['fields']['php_3']['field'] = 'php';
  $handler->display->display_options['fields']['php_3']['label'] = 'Ending Status';
  $handler->display->display_options['fields']['php_3']['use_php_setup'] = 0;
$handler->display->display_options['fields']['php_3']['php_output'] = '<?php
print inventory_item_operator_history_status_field($row, \'ending\');
?>';
  $handler->display->display_options['fields']['php_3']['use_php_click_sortable'] = '0';
  $handler->display->display_options['fields']['php_3']['php_click_sortable'] = '';
  /* Field: Inventory Items Operator History: Timestamp */
  $handler->display->display_options['fields']['timestamp']['id'] = 'timestamp';
  $handler->display->display_options['fields']['timestamp']['table'] = 'inventory_item_operator_history';
  $handler->display->display_options['fields']['timestamp']['field'] = 'timestamp';
  $handler->display->display_options['fields']['timestamp']['date_format'] = 'short';
  $handler->display->display_options['fields']['timestamp']['second_date_format'] = 'long';
  $handler->display->display_options['defaults']['arguments'] = FALSE;
  /* Contextual filter: Content: Nid */
  $handler->display->display_options['arguments']['nid']['id'] = 'nid';
  $handler->display->display_options['arguments']['nid']['table'] = 'node';
  $handler->display->display_options['arguments']['nid']['field'] = 'nid';
  $handler->display->display_options['arguments']['nid']['relationship'] = 'inventory_item_id';
  $handler->display->display_options['arguments']['nid']['default_action'] = 'default';
  $handler->display->display_options['arguments']['nid']['default_argument_type'] = 'node';
  $handler->display->display_options['arguments']['nid']['summary']['number_of_records'] = '0';
  $handler->display->display_options['arguments']['nid']['summary']['format'] = 'default_summary';
  $handler->display->display_options['arguments']['nid']['summary_options']['items_per_page'] = '25';

  $views[$view->name] = $view;

  // ...Repeat all of the above for each view the module should provide.

  // At the end, return array of default views.
  return $views;
  
}