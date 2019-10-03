<!-- Header -->
<?php include 'components/header.tpl.php';?>

<h1><?php print $event_title; ?></h1>

<p>
  You need to login to register for this class. If you haven't yet attended Orientation, you must do so before taking a class. You can see upcoming Orientations <a href="https://www.mnn.org/get-know-mnn-orientations" target="_blank">here.</a>
</p>
<p>
If you have attended orientation and don't yet have a user account, please <a href="https://www.mnn.org/contact" target="_blank">contact us.</a>
</p>

<?php
  $user_login_form = drupal_get_form('user_login');
  $user_login_form_render = drupal_render($user_login_form);
  print $user_login_form_render;
?>

<!-- Footer -->
<?php include 'components/footer.tpl.php';?>
