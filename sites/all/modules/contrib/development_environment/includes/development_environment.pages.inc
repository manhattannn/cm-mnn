<?php

/**
 * @file
 * Holds menu callbacks for pages created by the Development Environment module.
 */

/**
 * Page definition for the suppressed email reports page.
 *
 * @return array
 *   A render array representing the page.
 */
function development_environment_supressed_email_report_page() {
  global $user;

  $query = db_select('development_environment_log', 'log_data')->extend('PagerDefault');
  $query->fields('log_data', array(
    'lid',
    'email_data',
    'timestamp',
    'recipient_email',
    'subject',
  ));
  $log_items = $query->limit(20)
    ->orderBy('lid', 'DESC')
    ->execute();

  $page = array(
    'items' => array(
      '#theme' => 'table',
      '#header' => array(
        '',
        t('Time'),
        t('Recipient'),
        t('Subject'),
      ),
      '#rows' => array(),
      '#empty' => t('No emails have been logged'),
    ),
    'pager' => array(
      '#type' => 'pager',
    ),
  );

  foreach ($log_items as $item) {
    $page['items']['#rows'][] = array(
      l(t('View'), 'admin/reports/email_log/' . $item->lid),
      format_date($item->timestamp, 'short', '', $user->timezone),
      $item->recipient_email,
      $item->subject,
    );
  }

  return $page;
}

/**
 * Page definition showing the log data for a single suppressed email.
 *
 * @param StdClass $mail_log
 *   The log item containing the email data, used to build the page.
 *
 * @return array
 *   A render array representing the page.
 */
function development_environment_supressed_email_log_page(StdClass $mail_log) {
  global $user;

  $mail_info = unserialize($mail_log->email_data);

  if (is_array($mail_info['body'])) {
    $body = implode('<br/>', $mail_info['body']);
  }
  else {
    $body = $mail_info['body'];
  }

  $page = array(
    'header' => array(
      '#prefix' => '<h2>',
      '#suffix' => '</h2>',
      '#markup' => t('The following email was not sent as this is a development environment'),
    ),
    'email' => array(
      '#type' => 'fieldset',
      '#title' => t('Email data'),
      '#attributes' => array(
        'class' => array('collapsible'),
      ),
      'time' => array(
        '#prefix' => '<p>',
        '#suffix' => '</p>',
        '#markup' => t(
          'Time: %time',
          array(
            '%time' => format_date($mail_log->timestamp, 'short', '', $user->timezone),
          )
        ),
      ),
      'recipient' => array(
        '#prefix' => '<p>',
        '#suffix' => '</p>',
        '#markup' => t('Recipient: %recipient', array('%recipient' => $mail_info['to'])),
      ),
      'subject' => array(
        '#prefix' => '<p>',
        '#suffix' => '</p>',
        '#markup' => t('Subject: %subject', array('%subject' => $mail_info['subject'])),
      ),
      'body' => array(
        '#prefix' => '<div>',
        '#suffix' => '</div><br/>',
        '#markup' => t('Body: %body', array('%body' => $body)),
      ),
      'headers' => array(
        '#prefix' => '<div>',
        '#suffix' => '</div>',
        '#markup' => t('Headers:') . development_environment_var_dump($mail_info['headers'], TRUE, TRUE),
      ),
    ),
    'raw_mail_data' => array(
      '#type' => 'fieldset',
      '#title' => t('Raw email data'),
      '#attributes' => array(
        'class' => array('collapsible', 'collapsed'),
      ),
      'data' => array(
        '#markup' => development_environment_var_dump($mail_info, TRUE, TRUE),
      ),
    ),
    '#attached' => array(
      'library' => array(
        array('system', 'drupal.collapse'),
      ),
    ),
  );

  return $page;
}

/**
 * Page definition for the Development Environment admin page.
 *
 * @return array
 *   A render array representing the page.
 */
function development_environment_admin_page() {
  module_load_include('inc', 'development_environment', 'includes/development_environment.forms');

  $page = array(
    '#prefix' => '<div id="development_environment_settings_page">',
    '#suffix' => '</div>',
    'form' => drupal_get_form('development_environment_settings_form'),
  );

  return $page;
}

/**
 * Dumps the details of a variable.
 *
 * @param mixed $var
 *   The variable for which details should be dumped.
 * @param bool $return
 *   Whether or not to return the data to the calling function. If FALSE, the
 *   data is dumped to the screen.
 * @param bool $html
 *   Whether or not the outputted data should be an HTML output, or plaintext.
 * @param int $level
 *   The depth of $var that should be dumped. Set to 0 (zero) for full depth.
 *
 * @return array|null
 *   An array containing the dumped data if $return is set to TRUE, or NULL
 *   otherwise.
 */
function development_environment_var_dump($var, $return = FALSE, $html = FALSE, $level = 0) {
  $spaces = "";
  $space = $html ? "&nbsp;" : " ";
  $newline = $html ? "<br />" : "\n";
  for ($i = 1; $i <= 4; $i++) {
    $spaces .= $space;
  }

  $tabs = $spaces;
  for ($i = 1; $i <= $level; $i++) {
    $tabs .= $spaces;
  }

  if (is_array($var)) {
    $title = "Array";
  }
  elseif (is_object($var)) {
    $title = get_class($var) . " Object";
  }

  $output = $title . $newline . $newline;
  foreach ($var as $key => $value) {
    if (is_array($value) || is_object($value)) {
      $level++;
      $value = development_environment_var_dump($value, TRUE, $html, $level);
      $level--;
    }
    $output .= $tabs . "[" . $key . "] => " . $value . $newline;
  }

  if ($return) {
    return $output;
  }
  else {
    echo $output;
  }
}
