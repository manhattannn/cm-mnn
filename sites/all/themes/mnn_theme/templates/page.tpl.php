<div id="page">
  <div role="region" class="header-top">
    <div class="region region-header-top">
      <nav role="navigation" aria-labelledby="block-headertop-menu" id="block-headertop" class="block block-menu navigation menu--header-top">
        <?php print render($header_nav); ?>
      </nav>
      <div id="block-googletranslate" class="block block-mnn-block block-mnn-block-translate">
        <?php
        $blockObject = block_load('google_translator', 'active_languages');
        $block = _block_get_renderable_array(_block_render_blocks(array($blockObject)));
        $output = drupal_render($block);
        print $output;
        ?>
      </div>
    </div>
  </div>
  <div class="wrapper">
    <!-- new header -->
    <header role="banner" class="header" id="header">
      <div class="header__region region region-header">
      <div id="block-mnn-branding" class="block block-system block-system-branding-block">
        <?php if ($logo): ?>
          <a id="logo" href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>" rel="home" class="site-logo">
            <img src="<?php print $logo; ?>" alt="<?php print t('Home'); ?>" />
          </a>
        <?php endif; ?>
        <?php if ($site_name || $site_slogan): ?>
          <hgroup id="name-and-slogan">
            <?php if ($site_name): ?>
              <h1 id="site-name">
                <a href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>" rel="home"><span><?php print $site_name; ?></span></a>
              </h1>
            <?php endif; ?>

            <?php if ($site_slogan): ?>
              <h2 id="site-slogan"><?php print $site_slogan; ?></h2>
            <?php endif; ?>
          </hgroup><!-- /#name-and-slogan -->
        <?php endif; ?>
      </div>
        <?php print render($page['header']); ?>
      </div>
    </header>
    <!-- end new header -->
  </div>
  <div class="wrapper navigation">
    <div id="navigation" tabindex="-1">
      <?php print render($page['navigation']); ?>
    </div><!-- /#navigation -->
  </div>
  <div class="wrapper main">
    <div id="main">
      <div id="content" class="column" role="main">
        <?php print render($page['highlighted']); ?>
        <a id="main-content"></a>
        <?php print render($title_prefix); ?>
        <?php if ($title): ?>
          <h1 class="title" id="page-title"><?php print $title; ?></h1>
        <?php endif; ?>
        <?php print render($title_suffix); ?>
        <?php print $messages; ?>
        <?php print render($tabs); ?>
        <?php print render($page['help']); ?>
        <?php if ($action_links): ?>
          <ul class="action-links"><?php print render($action_links); ?></ul>
        <?php endif; ?>
        <?php print render($page['content']); ?>
        <?php print $feed_icons; ?>
      </div><!-- /#content -->

      <?php
        // Render the sidebars to see if there's anything in them.
        $sidebar_first  = render($page['sidebar_first']);
        $sidebar_second = render($page['sidebar_second']);
      ?>

      <?php if ($sidebar_first || $sidebar_second): ?>
        <aside class="sidebars">
          <?php print $sidebar_first; ?>
          <?php print $sidebar_second; ?>
        </aside><!-- /.sidebars -->
      <?php endif; ?>
    </div><!-- /#main -->
  </div>
  <div id="layout-footer"></div>
</div><!-- /#page -->
<div class="wrapper footer">
  <div class="inside">
    <!-- footer top -->
    <div role="region" class="footer-top">
      <div class="region region-footer-top">
        <nav role="navigation" aria-labelledby="block-sociallinks-menu" id="block-sociallinks" class="block block-menu navigation menu--social-links">
          <h2 class="visually-hidden" id="block-sociallinks-menu">Social Links</h2>
          <ul class="menu">
            <li class="menu-item">
              <a href="https://www.youtube.com/user/MNN537" class="social-youtube" target="_blank">Youtube</a>
            </li>
            <li class="menu-item">
              <a href="https://www.linkedin.com/company/manhattan-neighborhood-network" class="social-linkedin" target="_blank">LinkedIn</a>
            </li>
            <li class="menu-item">
              <a href="https://twitter.com/MNN59" class="social-twitter" target="_blank">Twitter</a>
            </li>
            <li class="menu-item">
              <a href="https://www.instagram.com/mnnnyc" class="social-instagram" target="_blank">Instagram</a>
            </li>
            <li class="menu-item">
              <a href="https://www.facebook.com/pages/MNN/326158948121" class="social-facebook" target="_blank">Facebook</a>
            </li>
          </ul>
        </nav>
        <div id="block-footersubscribe" class="footer-subscribe block block-block-content block-block-contentba9739ca-70e3-4d73-a10a-3cec80bf2a15">
          <div class="clearfix text-formatted field field--name-body field--type-text-with-summary field--label-hidden field__item"><p>Subscribe to regular email updates from MNN:</p>
            <form action="https://mnn.us4.list-manage.com/subscribe/post?u=4d045a12d9e5a154cb25b604e&amp;id=86afd4aaca" class="validate" id="mc-embedded-subscribe-form" method="post" name="mc-embedded-subscribe-form" target="_blank" _lpchecked="1">
              <div class="mc-field-group"><label class="visually-hidden" for="mce-EMAIL">Email Address</label><br><input class="required email" id="mce-EMAIL" name="EMAIL" placeholder="Email Address" type="text" value=""></div>
              <input id="mce-group[2181]-2181-0" name="group[2181][1]" type="hidden" value="1"><input id="mce-EMAILTYPE-0" name="EMAILTYPE" type="hidden" value="html"><input class="button" id="mc-embedded-subscribe" name="subscribe" type="submit" value="Sign Up">&nbsp;</form>
          </div>

        </div>

      </div>

    </div>
    <!-- end footer top -->
<!--    <footer role="contentinfo" class="footer">-->
<!--      <div class="region region-footer">-->
    <?php print render($page['footer']); ?>
<!--      </div>-->
<!---->
<!--    </footer>-->
  </div>
</div>
