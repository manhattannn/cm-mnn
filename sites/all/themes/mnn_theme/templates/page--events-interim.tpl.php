<!-- Header -->
<?php include 'components/header.tpl.php';?>

page--events--interim.tpl.php

<?php
  $user_login_form = drupal_get_form('user_login');
  $user_login_form_render = drupal_render($user_login_form);
  print $user_login_form_render;
?>

<!-- Footer -->
<?php include 'components/footer.tpl.php';?>
