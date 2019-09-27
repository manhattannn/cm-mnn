<?php

/**
 * Implements template_preprocess_html().
 * Adds path variables.
 */
function mnn_theme_preprocess_html(&$variables, $hook) {
  // Add variables and paths needed for HTML5 and responsive support.
  $variables['base_path'] = base_path();
  $variables['path_to_mnn_theme'] = drupal_get_path('theme', 'mnn_theme');
}

function mnn_theme_menu_tree__menu_footer_menu(&$variables){
  return '<nav class="navigation-primary"  role="navigation" itemscope="" itemtype="http://schema.org/SiteNavigationElement"><ul class="menu">'.$variables['tree']. '</ul></nav>';
}

function mnn_theme_menu_tree__menu_quick_links(&$variables){
  return '<nav class="navigation-primary"  role="navigation" itemscope="" itemtype="http://schema.org/SiteNavigationElement"><ul class="menu">'.$variables['tree']. '</ul></nav>';
}
/**
 * Implements theme_links().
 * Enables sub-menu item display for main menu.
 */
function mnn_theme_links($variables) {
  if (array_key_exists('id', $variables['attributes']) && $variables['attributes']['id'] == 'nav') {
    $pid = variable_get('menu_main_links_source', 'nav');
    $tree = menu_tree($pid);
    return drupal_render($tree);
  }
  return theme_links($variables);
}

/**
 * Implements template_preprocess_page().
 */
function mnn_theme_preprocess_page(&$vars) {
  // @todo remove this when done
  //$debug = $vars['theme_hook_suggestions'];
  //print_r($debug);
  //test

  //$vars['user_menu'] =  theme('links', array('links' => menu_navigation_links('user-menu'), 'attributes' => array('class '=> array('links', 'site-menu'))));

  $header_menu_tree = menu_tree_all_data('menu-header-menu');
  $vars['header_nav'] = menu_tree_output($header_menu_tree);

//  $footer_menu_tree = menu_tree_all_data('menu-footer-menu');
  ////  $vars['footer_nav'] = menu_tree_output($footer_menu_tree);



}

/*
 * Implements template_preprocess_region()
 * we use this to manage the visibility of a block by role
 * when we are placing the block manually
 */
function mnn_theme_preprocess_region(&$vars) {
  if (strpos($vars['region'], 'footer') === 0) {
    // Get the footer message block so we can display it where we want
    // block 10
    $vars['msgblockoutput'] = __getblock('block', '10');
  }
}

/*
 * Check if block is visible to user
 *
 */
function __checkblockvisibilitybyuser($module, $delta) {
  global $user;
  $role_access = TRUE;
  // Build an array of roles for the block.
  $block_roles = array();
  // cache result?;
  $result = db_query("SELECT rid FROM {block_role} br WHERE br.delta = :delta and br.module = :module", array(':delta' => $delta, ':module' => $module));
  foreach ($result as $record) {
    $block_roles[] = $record->rid;
  }
  $role_access = array_intersect($block_roles, array_keys($user->roles));

  return $role_access;
}
/*
 * Get the block rendered contents
 *  By default it will check the current user has no restrictions
 */
function __getblock($module, $delta, $bypass = False) {
  $showblock = __checkblockvisibilitybyuser('block', '10');
  $blockcontent = '';
  if ($showblock || $bypass) {
    $blockObject = block_load('block', '10');
    $msgblock = _block_get_renderable_array(_block_render_blocks([$blockObject]));
    $blockcontent = drupal_render($msgblock);
  }
  return $blockcontent;
}

function mnn_theme_theme(&$existing, $type, $theme, $path) {
   $hooks['user_login_block'] = array(
     'template' => 'templates/user-login-block',
     'render element' => 'form',
   );
   return $hooks;
 }
function mnn_theme_preprocess_user_login_block(&$vars) {
  $vars['name'] = render($vars['form']['name']);
  $vars['pass'] = render($vars['form']['pass']);
  $vars['submit'] = render($vars['form']['actions']['submit']);
  $vars['rendered'] = drupal_render_children($vars['form']);
}

// function mnn_theme_form_alter(&$form, &$form_state, $form_id) {
//   debug($form_id);
// }

function mnn_theme_form_user_login_block_alter(&$form, &$form_state, $form_id) {
  // debug($form_id);
  // debug($form);
  $form['name']['#required'] = FALSE;
  $form['pass']['#required'] = FALSE;
}

/**
 * Implements hook_css_alter().
 */
function mnn_theme_css_alter(&$css) {
  $path = current_path();

  $excludes = [
    'civicrm/event/register',
    'civicrm/event/info',
    'events-interim',
  ];

  // Unset CiviCRM and other theme css files that we don't need + cause conflicts
  if (in_array($path, $excludes) || arg(0) == 'event_landing_page') {
    unset($css['sites/all/modules/contrib-stable/civicrm/css/civicrm.css']);
    //unset($css[path_to_theme() . '/css/forms.css']);
    //unset($css[path_to_theme() . '/css/formalize.css']);
    //unset($css[path_to_theme() . '/css/cm.css']);
    //unset($css[path_to_theme() . '/css/pages.css']);
  }
  unset($css['sites/all/modules/contrib-dev/google_translator/theme/google_translator.css']);
}

/***********************
Let's load some CSS on specific targets - uncomment to use
************************/

// function mnn_theme_preprocess_node(&$vars) {
//   // Add JS & CSS by node type
//   if( $vars['type'] == 'page') {
//     //drupal_add_js(path_to_theme(). '/js/some_scripts.js');
//     //drupal_add_css(path_to_theme(). '/css/some_sheet.css');
//   }

//   // Add JS & CSS to the front page
//   if ($vars['is_front']) {
//     drupal_add_js(path_to_theme(). '/js/some_scripts.js');
//     //drupal_add_css(path_to_theme(). '/css/some_sheet.css');
//   }

//   // Add JS & CSS by node ID
//   if (drupal_get_path_alias("node/{$vars['#node']->nid}") == 'your-node-id') {
//     //drupal_add_js(path_to_theme(). '/js/some_scripts.js');
//     //drupal_add_css(path_to_theme(). '/css/some_sheet.css');
//   }
// }
// function mnn_theme_preprocess_page(&$vars) {
//   // Add JS & CSS by node type
//   if (isset($vars['node']) && $vars['node']->type == 'page') {
//     //drupal_add_js(path_to_theme(). '/js/some_scripts.js');
//     //drupal_add_css(path_to_theme(). '/css/some_sheet.css');
//   }
//   // Add JS & CSS by node ID
//   if (isset($vars['node']) && $vars['node']->nid == '1') {
//     //drupal_add_js(path_to_theme(). '/js/some_scripts.js');
//     //drupal_add_css(path_to_theme(). '/css/some_sheet.css');
//   }
// }

function mnn_theme_preprocess_menu_link(&$variables) {

  if ($variables["element"]["#original_link"]["menu_name"] == 'menu-header-menu') {
    $linkclass = 'link-' . str_replace(' ', '-', drupal_strtolower($variables["element"]["#title"]));
    $variables['element']['#localized_options']['attributes']['class'][] = $linkclass;
//    if ($variables["element"]["#title"] == "Live Schedule") {
//      $variables['element']['#localized_options']['attributes']['class'][] = "link-live-schedule";
//    }
  }
}

