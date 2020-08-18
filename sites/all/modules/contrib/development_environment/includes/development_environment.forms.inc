<?php

/**
 * @file
 * Form definitions for forms defined in the Development Environment module.
 */

/**
 * Form definition for the Development Environment Settings Form.
 */
function development_environment_settings_form(array $form, array $form_state) {
  $form['log_emails'] = [
    '#title' => t('Suppress emails'),
    '#type' => 'checkbox',
    '#default_value' => variable_get('development_environment.log_emails', FALSE),
    '#description' => t('If this box is checked, emails will not be sent from the system, and will instead be written to the log.'),
  ];

  $form['log_emails_display'] = [
    '#prefix' => '<p>',
    '#suffix' => '</p>',
  ];

  $form['log_emails_gui_description'] = [
    '#prefix' => '<p>',
    '#suffix' => '</p>',
    '#markup' => t("To prevent this setting from being managed through the admin UI, add a line containing <code>&#36;conf['development_environment.log_emails'] = TRUE;</code> (or FALSE) to settings.php."),
  ];

  $form['submit'] = [
    '#type' => 'submit',
    '#value' => t('Submit'),
  ];

  return $form;
}

/**
 * Submission handler for the Development Environment Settings Form.
 */
function development_environment_settings_form_submit(array $form, array $form_state) {
  variable_set('development_environment.log_emails', $form_state['values']['log_emails']);
  drupal_set_message('The settings have been updated');
}
