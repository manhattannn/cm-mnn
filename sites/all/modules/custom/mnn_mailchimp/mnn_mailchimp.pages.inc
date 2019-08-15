<?php

/**
 * @file
 * Page callbacks for the mnn_mailchimp module.
 */

/**
 * Menu callback; Rss feed for events
 *
 * @param $term
 *   The taxonomy term.
 * @return
 *   The page content.
 */
function mnn_mailchimp_rss($term) {
  // Get base url
  global $base_url;

  $base_feed_url = $base_url . '/taxonomy/term/' . $term->tid;

  // Query the nodes
  $query = new EntityFieldQuery();
  $query->entityCondition('entity_type', 'node')
    ->entityCondition('bundle', 'civicrm_multiday_event')
    ->propertyCondition('status', 1)
    ->fieldCondition('field_civicrm_multidayevent_type', 'tid', $term->tid, '=');

  $result = $query->execute();

  if (isset($result['node'])) {
    $nids = array_keys($result['node']);
    $nodes = entity_load('node', $nids);

    foreach($nodes as $node) {
      // Pubdate
      if (isset($node->field_civicrm_multiday_session[LANGUAGE_NONE] )) {
        foreach ($node->field_civicrm_multiday_session[LANGUAGE_NONE] as $key => $value) {
          $field_collection = entity_load('field_collection_item', array($value['value']));
          $idx = $value['value'];
          $field_session_date = $field_collection[$idx]->field_session_date[LANGUAGE_NONE][0]['value'];
          $pub_date = date('D, d M Y H:i:s T', strtotime($field_session_date));
        }
      }

      // Media content
      $image = FALSE;
      if (isset($node->field_generic_event_photo[LANGUAGE_NONE][0]['uri'])) {
        $image_uri = $node->field_generic_event_photo[LANGUAGE_NONE][0]['uri'];
        $image = image_style_url('large', $image_uri);
      }

      $data[] = [
        'nid' => $node->nid,
        'link' => $base_url . '/civicrm/event/register?id=' . $node->field_civievent_id[LANGUAGE_NONE][0]['value'],
        'title' => $node->title,
        'description' => strip_tags($node->body[LANGUAGE_NONE][0]['summary']),
        'pub_date' => $pub_date,
        'media_content' => $image,
      ];
    }
  }

  $variables = array(
    'data' => $data,
    'base_feed_url' => $base_feed_url,
    'term_name' => $term->name,
  );

  $xml = theme('mnn_mailchimp_rss', $variables);

  drupal_add_http_header('Content-Type', 'application/rss+xml; charset=utf-8');
  print $xml;
}
