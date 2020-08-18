<?php
/**
 * @file
 * Printable contract template.
 +---------------------------------------------------------------------------+
 | Copyright (C) 2009 Openflows, Inc. + Blue Bag. All rights reserved.       |
 | Additionally, Kevin Reynen                                                |
 |                                                                           |
 | This work is published under the GNU AGPLv3 license without any           |
 | warranty. For full license and copyright information, see                 |
 | https://www.gnu.org/licenses/agpl-3.0.html                                |
 +---------------------------------------------------------------------------+
 */

  global $base_path;
  $logourl = theme_get_setting('logo_path', '');
  $replace_cost_cols =
      variable_get('reservations_contract_replace_cost_columns', 0);
  $user_header =
      variable_get('reservations_contract_replacement_column_header',
          'Accessories');
  $user_field =
      variable_get('reservations_contract_replacement_field',
          'field_reservable_contract_text');
?>
  <html>
    <head>
      <title>Contract</title>
      <link type="text/css" rel="stylesheet" href="<?php print $base_path ?><?php print drupal_get_path('module', 'reservations_printable_contract'); ?>/contract.css" />
    </head>
    <body>
      <div id="page">
        <div id="header">
        <?php if ($logourl) { ?>
           <img src="<?php print $base_path ?><?php print $logourl ?>">
        <?php } ?>
        <?php
        if ($should_send_email) {
          if (module_exists('token')) {
            print '<div id="emailheader">' .
      token_replace(variable_get('reservations_contract_mail_header', ''),
      array('node' => $node)) .'</div>';
          }
          else {
            print '<div id="emailheader">' .
      variable_get('reservations_contract_mail_header','') .'</div>';
          }
        }
        ?>
        <h2><?php print variable_get('site_name', ''); ?> Equipment Rental Contract</h2>
        <?php if (module_exists('token')) {
          print token_replace(variable_get('reservations_contract_header', ''), array('node' => $node));
        }
        else {
          print variable_get('reservations_contract_header','');
        }
        ?>
        Start Date: <?php print $start_date . '<br />'; ?>
        Return by: <?php print $end_date . '<br />'; ?>
        Name: <?php print $username ?><br />
        Email: <?php print $email ?><br />
        <?php print $phone ? "Phone: $phone" . '<br />' : '' ?>

        </div>
        <table id="cost">
          <thead>
            <tr>
              <th>Item</th>
              <?php
                if($replace_cost_cols) {
                  print '<th>'. $user_header . '</th>';
                }
                else {
                  print '<th>Commercial Cost</th><th>Member Cost</th>';
                }
              ?>

            </tr>
          </thead>
          <tbody>
  <?php

  if (!$replace_cost_cols) {
    $discount = variable_get('reservations_membership_discount', 1);
    $comreservationsal_cost_total = 0;
    $member_cost_total = 0;
  }

  $even_odd = 'even';

  foreach ($items as $item) {
    if (!$item['did']) {
      continue;
    }
    $specific_item_node = node_load($item['reservations_item_nid']);
    $placeholder_item_node = node_load($item['reservations_placeholder_nid']);

    $item_node = empty($specific_item_node) ?
        $placeholder_item_node: $specific_item_node;

    $ttitle = isset($item['item_title']) && $item['item_title'] ?
        htmlspecialchars($item['item_title']) :
        '<b>SPECIFIC ITEM NOT SELECTED FROM BUCKET</b>';

    if($replace_cost_cols) {
      $contract_text =
          $item_node->{$user_field}[LANGUAGE_NONE][0]['value'];
    }

   $inv_number =
      isset($item_node->field_inventory_number[LANGUAGE_NONE][0]['value']) ?
      $item_node->field_inventory_number[LANGUAGE_NONE][0]['value'] : "";

   $accessories =
      isset($item_node->field_accessories[LANGUAGE_NONE][0]['value']) ?
      $item_node->field_accessories[LANGUAGE_NONE][0]['value'] : "";

  if(!$replace_cost_cols) {
    $fee_hours = $hours - ($item_node->reservations_fee_free_hours);
    $comreservationsal_cost = $item_node->reservations_rate_per_hour * $hours;
    $member_cost = ($fee_hours > 0) ?
        ($item_node->reservations_rate_per_hour * $discount) * $fee_hours : 0;
    $day_rate = ($item_node->reservations_rate_per_hour * 24);

    $comreservationsal_cost_total += $comreservationsal_cost;
    $member_cost_total += $member_cost;
  }

  ?>
            <tr class="<?php print $even_odd; ?>">
              <td>
                <div>
                <?php
    if(!$replace_cost_cols) {
      print $ttitle . ' (' . money_format('%(#10n', $day_rate) . ' per day)';
    }
    else {
      print $ttitle;
      if($inv_number) {
        print "<br>" . $inv_number;
      }
    }
      ?>
                </div>

           <?php
    if (count($item_node->taxonomy) > 0) {

      ?>
                  <ul class="accessories">
                  <?php
      foreach ($item_node->taxonomy as $accessory) {

        ?>
                    <li><?php print $accessory->name; ?></li>
                    <?php
      }
      // foreach

      ?>
                  </ul>
                  <?php
    }
    // if

    ?>
              </td>
              <?php
      if($replace_cost_cols) {
        print '<td>' . $contract_text . '</td>';
      }
      else {
        print '<td>' . money_format('%(#10n', $comreservationsal_cost) . '</td>';
        print '<td>' . money_format('%(#10n', $member_cost) . '</td>';
      }
    ?>
            </tr>
            <?php
    $even_odd = ($even_odd == 'even') ? 'odd' : 'even';
  }
  // end foreach

  ?>
          </tbody>
          <?php
      if(!$replace_cost_cols) : ?>

          <tfoot>
            <tr class="<?php echo $even_odd; ?>">
              <th>Total</th>
              <td><?php echo money_format('%(#10n', $comreservationsal_cost_total) ?></td>
              <td><?php echo money_format('%(#10n', $member_cost_total) ?></td>
            </tr>
          <tfoot>
    <?php endif; ?>

        </table>
        <div id="boilerplate"><?php module_exists('token') ? print(token_replace(variable_get('reservations_contract_boilerplate', ''), array('node' => $node))) : print(variable_get('reservations_contract_boilerplate','')) ?></div>
        <div id="footer"><?php module_exists('token') ? print(token_replace(variable_get('reservations_contract_footer', ''), array('node' => $node))) : print(variable_get('reservations_contract_footer','')) ?>
</div>
      </div>
   <?php
    if ($should_send_email) {
      if (module_exists('token')) {
        print '<div id="emailfooter">'.
          token_replace(variable_get('reservations_contract_mail_footer', ''),
              array('node' => $node)) .'</div>';
      }
      else {
        print '<div id="emailfooter">'.
          variable_get('reservations_contract_mail_footer','') .'</div>';
      }
    }
  ?>

    </body>
