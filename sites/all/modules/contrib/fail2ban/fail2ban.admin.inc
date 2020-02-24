<?php
/**
 * @file
 */

/**
 * Return the settings form.
 */
function fail2ban_admin_settings() {
  $form = array();

  $form['fail2ban_logstring'] = array(
    '#title' => 'Log String',
    '#type' => 'textfield',
    '#default_value' => variable_get('fail2ban_logstring', 'Submitting address [!address] to the firewall'),
    '#description' => t('Enter the log message that the fail2ban module should write when a comment is deleted or unpublished. Your fail2ban utility should be configured to look and act upon a message in this format. The originating IP address is inserted via the !address placeholder.'),
  );

  return system_settings_form($form);
}
