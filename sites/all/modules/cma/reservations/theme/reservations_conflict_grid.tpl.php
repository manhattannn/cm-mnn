<?php
/**
 * @file
 * Reservations - Managed Equipment Reservation Checkout and Inventory
 +---------------------------------------------------------------------------+
 | Copyright (C) 2009 Openflows, Inc. + Blue Bag. All rights reserved.       |
 | Additionally, Kevin Reynen + Dane Powell                                  |
 |                                                                           |
 | This work is published under the GNU AGPLv3 license without any           |
 | warranty. For full license and copyright information, see                 |
 | https://www.gnu.org/licenses/agpl-3.0.html                                |
 +---------------------------------------------------------------------------+
 */
?>

<div><?php print  t("The dates and times for %name conflict with one or more existing reservations", array('%name' => $title)); ?> </div>

<div class="reservations-availability-key">
<span class="available"></span> = available
<span class="unavailable"></span> = unavailable
</div>

<?php foreach ($reservations_by_date as $date => $items): ?>

<table class="reservations-availability-schedule">

  <thead><tr>

  <th><?php print  date('m/d/Y', strtotime($date)) ?></th>

    <?php if (isset($pretty_hours[$date])) {?>
      <?php foreach ($pretty_hours[$date] as $time): ?>
        <th colspan="4"><?php print  $time ?> </th>
      <?php endforeach; ?>
    <?php }?>


    </tr></thead>

    <tbody>

    <?php foreach ($items as $times): ?>

      <tr><th> <?php print htmlspecialchars($title); ?> </th>
        <?php foreach ($times as $time => $available): ?>

         <td class="<?php print $available['class'] . ' '; print strstr($time, ':45') ? 'hourborder' : ''; ?>">
            <?php print $available['class'] == 'available' ? 0 : l(t('X'), 'node/' . $available['data'], array('attributes' => array('class' => 'unavailable'))); ?>
        </td>

        <?php endforeach; ?>

      </tr>

      <?php endforeach; ?>

    </tbody>
</table>

<?php endforeach; ?>


