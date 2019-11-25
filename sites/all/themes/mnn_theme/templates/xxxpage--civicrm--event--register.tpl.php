<!-- Header -->
<?php include 'components/header.tpl.php';?>

<!-- Banner -->
<?php include 'components/banner.tpl.php';?>

<div class="region region-content">
  <div id="block-system-main" class="block block-system">
    <?php print render($page['content']); ?>
  </div>
</div>

<!-- footer -->
<?php include 'components/footer.tpl.php';?>
