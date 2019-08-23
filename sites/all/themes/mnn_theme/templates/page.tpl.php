<div id="page">
  <div role="region" class="header-top">
    <div class="region region-header-top">
      <nav role="navigation" aria-labelledby="block-headertop-menu" id="block-headertop" class="block block-menu navigation menu--header-top">
        <h2 class="visually-hidden" id="block-headertop-menu">Header Top</h2>
        <ul class="menu">
          <li class="menu-item">
            <a href="https://cm.mnn.org/watch/tv-schedule" class="link-live-schedule" target="_blank">Live Schedule</a>
          </li>
          <li class="menu-item">
            <a href="https://cm.mnn.org/user" class="link-producer-login" target="_blank">Producer Login</a>
          </li>
          <li class="menu-item">
            <a href="https://cm.mnn.org/search" class="link-search" target="_blank">Search</a>
          </li>
        </ul>
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
  <div class="wrapper header">
    <!-- new header -->
    <header role="banner" class="header" id="header">
      <div class="region region-header">
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
      <?php if (theme_get_setting('user_menu')): ?>
        <div id="cm-user-menu">
          <?php print $user_menu;  ?>
        </div>
      <?php endif; ?>
<!--        <div id="block-mainnavigation" class="block block-superfish block-superfishmain">-->
<!--          <ul id="superfish-main" class="menu sf-menu sf-main sf-horizontal sf-style-none sf-js-enabled">-->
<!--            <li id="main-menu-link-contentfaff2e2e-03f2-46e6-8bea-8d7fe2194b6a" class="sf-depth-1 menuparent"><a href="/watch" class="primary-item-watch sf-depth-1 menuparent">Watch</a><ul class="sf-multicolumn sf-hidden" style="width: 200px;"><li class="sf-multicolumn-wrapper " style="width: 200px;"><ol style="width: 200px;"><li id="main-menu-link-content4cd8e21d-baf6-4b78-961f-e50675a00e07" class="sf-depth-2 sf-multicolumn-column menuparent" style="width: 100px;"><div class="sf-multicolumn-column" style="width: 100px;"><span class="sf-depth-2 menuparent nolink">Live Channels</span><ol style="float: none; width: 100px;"><li id="main-menu-link-content5902750e-159a-4538-8cfd-5e3c32ce3769" class="sf-depth-3 sf-no-children" style=""><a href="/watch/channels/community-channel" class="sf-depth-3" style="">Community Channel</a><article role="article" about="/watch/channels/community-channel" class="node node--type-channel node--view-mode-menu"><a href="/watch/channels/community-channel" rel="bookmark"><span class="field field--name-title field--type-string field--label-hidden">Community Channel</span><div class="field field--name-field-image field--type-entity-reference field--label-hidden field__item"><img src="/sites/default/files/styles/thumbnail/public/2019-06/MNN%20Channel_HiRes_1.png?itok=xRXeXEYZ" alt="Community Channel Logo" typeof="foaf:Image" class="image-style-thumbnail" width="100" height="100"></div></a></article></li><li id="main-menu-link-content230658fd-baa5-487f-93dc-4f5b95a5315f" class="sf-depth-3 sf-no-children" style=""><a href="/watch/channels/lifestyle-channel" class="sf-depth-3" style="">Lifestyle Channel</a><article role="article" about="/watch/channels/lifestyle-channel" class="node node--type-channel node--view-mode-menu"><a href="/watch/channels/lifestyle-channel" rel="bookmark"><span class="field field--name-title field--type-string field--label-hidden">Lifestyle Channel</span><div class="field field--name-field-image field--type-entity-reference field--label-hidden field__item"><img src="/sites/default/files/styles/thumbnail/public/2019-06/MNN%20Channel_HiRes_2.png?itok=8R1xbo1R" alt="Lifestyle Channel Logo" typeof="foaf:Image" class="image-style-thumbnail" width="100" height="100"></div></a></article></li><li id="main-menu-link-contentf26cd529-c680-47d7-a69e-c5a3c0ed6ca6" class="sf-depth-3 sf-no-children" style=""><a href="/watch/channels/spirit-channel" class="sf-depth-3" style="">Spirit Channel</a><article role="article" about="/watch/channels/spirit-channel" class="node node--type-channel node--view-mode-menu"><a href="/watch/channels/spirit-channel" rel="bookmark"><span class="field field--name-title field--type-string field--label-hidden">Spirit Channel</span><div class="field field--name-field-image field--type-entity-reference field--label-hidden field__item"><img src="/sites/default/files/styles/thumbnail/public/2019-06/MNN%20Channel_HiRes_3.png?itok=SYil9CVE" alt="Spirit Channel Logo" typeof="foaf:Image" class="image-style-thumbnail" width="100" height="100"></div></a></article></li><li id="main-menu-link-contentea968552-5f30-4f08-8dec-9cbf9b0f52a5" class="sf-depth-3 sf-no-children" style=""><a href="/watch/channels/culture-channel" class="sf-depth-3" style="">Culture Channel</a><article role="article" about="/watch/channels/culture-channel" class="node node--type-channel node--view-mode-menu"><a href="/watch/channels/culture-channel" rel="bookmark"><span class="field field--name-title field--type-string field--label-hidden">Culture Channel</span><div class="field field--name-field-image field--type-entity-reference field--label-hidden field__item"><img src="/sites/default/files/styles/thumbnail/public/2019-06/MNN%20Channel_HiRes_4.png?itok=sz-eKTzq" alt="Culture Channel Logo" typeof="foaf:Image" class="image-style-thumbnail" width="100" height="100"></div></a></article></li><li id="main-menu-link-content839815fe-96e9-4790-9335-563f47485c35" class="sf-depth-3 sf-no-children" style=""><a href="/watch/channels/hd-channel" class="sf-depth-3" style="">HD Channel</a><article role="article" about="/watch/channels/hd-channel" class="node node--type-channel node--view-mode-menu"><a href="/watch/channels/hd-channel" rel="bookmark"><span class="field field--name-title field--type-string field--label-hidden">HD Channel</span><div class="field field--name-field-image field--type-entity-reference field--label-hidden field__item"><img src="/sites/default/files/styles/thumbnail/public/2019-02/mnn_hd_logo_vector.jpg?itok=LB5CLz4t" alt="MNN HD channel logo" typeof="foaf:Image" class="image-style-thumbnail" width="100" height="100"></div></a></article></li><li id="main-menu-link-contentb179a6bd-78ac-418a-b2a5-52d38efd1dd7" class="sf-depth-3 sf-no-children" style=""><a href="/watch/channels/nyxt-channel" class="sf-depth-3" style="">NYXT Channel</a><article role="article" about="/watch/channels/nyxt-channel" class="node node--type-channel node--view-mode-menu"><a href="/watch/channels/nyxt-channel" rel="bookmark"><span class="field field--name-title field--type-string field--label-hidden">NYXT Channel</span><div class="field field--name-field-image field--type-entity-reference field--label-hidden field__item"><img src="/sites/default/files/styles/thumbnail/public/2019-02/nyxt_circle.png?itok=5wXvhU9X" alt="MNN NYXT channel logo" typeof="foaf:Image" class="image-style-thumbnail" width="100" height="100"></div></a></article></li><li id="main-menu-link-content3efda045-ab44-4f35-b2a3-204d45b8d17a" class="sf-depth-3 sf-no-children" style=""><a href="/watch/channels/free-speech" class="sf-depth-3" style="">MNN-FSTV Channel</a><article role="article" about="/watch/channels/free-speech" class="node node--type-channel node--view-mode-menu"><a href="/watch/channels/free-speech" rel="bookmark"><span class="field field--name-title field--type-string field--label-hidden">Free Speech</span><div class="field field--name-field-image field--type-entity-reference field--label-hidden field__item"><img src="/sites/default/files/styles/thumbnail/public/2019-02/mnn-fstv.jpg?itok=IOxueLHk" alt="MNN FSTV channel logo" typeof="foaf:Image" class="image-style-thumbnail" width="100" height="100"></div></a></article></li><li id="main-menu-link-content18569679-0d66-4375-9d4f-3e876cb6fb18" class="sf-depth-3 sf-no-children" style=""><a href="/watch/tv-schedule" class="button sf-depth-3" style="">TV Schedule</a></li></ol></div></li><li id="main-menu-link-contentf288d371-69a6-48a9-98fd-e4c5337a558c" class="sf-depth-2 sf-multicolumn-column menuparent" style="width: 100px;"><div class="sf-multicolumn-column" style="width: 100px;"><span class="sf-depth-2 menuparent nolink">Shows</span><ol style="width: 100px; float: none;"><li id="main-menu-link-contentdc393a8f-e8d8-42e4-b4d7-858088796243" class="sf-depth-3 sf-no-children" style=""><a href="/watch/programs" class="sf-depth-3" style="">Programs</a></li><li id="main-menu-link-content169bae14-4693-4a35-832c-efc4540f613c" class="sf-depth-3 sf-no-children" style=""><a href="/watch/programs/youth-channel" class="sf-depth-3" style="">Youth Channel</a></li><li id="main-menu-link-content8ee63d01-46b4-4e2f-a8d2-cfacf5732c9b" class="sf-depth-3 sf-no-children" style=""><a href="/watch/videos" class="sf-depth-3" style="">Video Library</a></li></ol></div></li></ol></li></ul></li><li id="main-menu-link-content22d91cf2-bcb8-494e-b0df-c04db1b3834c" class="sf-depth-1 menuparent"><a href="/create" class="sf-depth-1 menuparent">Create</a><ul class="sf-multicolumn sf-hidden" style="float: none; width: 12em;"><li class="sf-multicolumn-wrapper " style=""><ol><li id="main-menu-link-contentcaf1f1e2-0a45-43fe-a034-7a492bad8178" class="sf-depth-2 sf-no-children"><a href="/create/producer-resources/become-certified-producer" class="sf-depth-2">Make Media</a></li><li id="main-menu-link-content8deb386f-b076-4d24-ad22-0f686508cc95" class="sf-depth-2 sf-no-children"><a href="/create/producer-resources-video-tutorials" class="sf-depth-2">Producer Resources</a></li><li id="main-menu-link-contenta7987989-5a5b-4182-8498-24808280fc17" class="sf-depth-2 sf-no-children"><a href="/create/producer-resources/submit-show" class="sf-depth-2">Submit a Show</a></li></ol></li></ul></li><li id="main-menu-link-contenta022de79-51b4-45f4-8bd8-d991b828f350" class="sf-depth-1 menuparent"><a href="/learn" class="sf-depth-1 menuparent">Learn</a><ul class="sf-multicolumn sf-hidden" style="float: none; width: 12em;"><li class="sf-multicolumn-wrapper " style=""><ol><li id="main-menu-link-content054eaf28-47d8-48b8-87f0-6b850d3b2bb7" class="sf-depth-2 sf-no-children"><a href="/learn/orientation" class="sf-depth-2">Orientation</a></li><li id="main-menu-link-content7d8fe0a0-6f29-4517-bda9-4983a08e75f9" class="sf-depth-2 sf-no-children"><a href="/learn/events" class="sf-depth-2">Class Schedule</a></li><li id="main-menu-link-content4c3ead1f-f180-45eb-b2ad-f9b27a6a591c" class="sf-depth-2 sf-no-children"><a href="/learn/certification-classes" class="sf-depth-2">Certification</a></li><li id="main-menu-link-contentb0ea7362-e5a2-4dd9-bd3a-9520031a697a" class="sf-depth-2 sf-no-children"><a href="/learn/documentary-storytelling-intensive" class="sf-depth-2">Documentary Storytelling</a></li><li id="main-menu-link-contentcd3d42c5-73ce-45be-8d00-e6a6d694cf7d" class="sf-depth-2 sf-no-children"><a href="/events/mediamaker-meetup" class="sf-depth-2">MediaMaker Meetup</a></li><li id="main-menu-link-contentd733277d-2949-4935-9c0d-4cc39ce01f43" class="sf-depth-2 sf-no-children"><a href="/learn/workshops" class="sf-depth-2">Workshops</a></li><li id="main-menu-link-contentf96c646e-494f-4125-b0b0-4555ce57c2b2" class="sf-depth-2 sf-no-children"><a href="/learn/youth-education" class="sf-depth-2">Youth Education</a></li></ol></li></ul></li><li id="main-menu-link-contentcf7ff640-7dff-4229-9eb9-233b7990fa20" class="sf-depth-1 menuparent"><a href="/blog" class="sf-depth-1 menuparent">Blog</a><ul class="sf-multicolumn sf-hidden" style="float: none; width: 12em;"><li class="sf-multicolumn-wrapper " style=""><ol><li id="main-menu-link-content0734fc73-38b8-4ff8-bf8d-5d7e503b902d" class="sf-depth-2 sf-no-children"><a href="/blog?topic=4" class="sf-depth-2">Clip of the Week</a></li><li id="main-menu-link-contentbfe0162e-6e43-4058-84f9-696fd646d043" class="sf-depth-2 sf-no-children"><a href="/blog?topic=8" class="sf-depth-2">Producer Spotlight</a></li><li id="main-menu-link-content84ed539e-c2cb-490c-8da6-e129c162ec5c" class="sf-depth-2 sf-no-children"><a href="/blog?topic=14" class="sf-depth-2">Race to Represent</a></li></ol></li></ul></li><li id="main-menu-link-content319ed713-bb55-4dff-94f9-16d35e22704a" class="sf-depth-1 menuparent"><a href="/watch/programs" title="MNN's Program pages" class="sf-depth-1 menuparent">Programs</a><ul class="sf-multicolumn sf-hidden" style="float: none; width: 12em;"><li class="sf-multicolumn-wrapper " style=""><ol><li id="main-menu-link-content6473f3b0-8ef0-4b86-921a-5cada75cc744" class="sf-depth-2 sf-no-children"><a href="/watch/programs/cgp" class="sf-depth-2">Chris Gethard Presents</a></li><li id="main-menu-link-contentd8d1c80e-4291-4f79-b28a-0cba53e37252" class="sf-depth-2 sf-no-children"><a href="/watch/programs/punto-de-vista" class="sf-depth-2">Punto De Vista</a></li><li id="main-menu-link-content64150a21-cddd-46c6-8f2b-ed9947ed6a26" class="sf-depth-2 sf-no-children"><a href="/watch/programs/represent-nyc" class="sf-depth-2">Represent NYC</a></li></ol></li></ul></li><li id="main-menu-link-content3dddc865-34da-45d1-9c94-81340ebb7e1a" class="sf-depth-1 menuparent"><a href="/locations" class="sf-depth-1 menuparent">Locations</a><ul class="sf-multicolumn sf-hidden" style="float: none; width: 12em;"><li class="sf-multicolumn-wrapper " style=""><ol><li id="main-menu-link-content03a5280f-f608-4ab7-80a2-1dbb2520fd7e" class="sf-depth-2 sf-no-children"><a href="/locations/59th-street-studios" class="sf-depth-2">59th Street Studios</a></li><li id="main-menu-link-content238c674e-49ac-4cb9-b6bd-089917ad0c78" class="sf-depth-2 sf-no-children"><a href="/locations/firehouse" class="sf-depth-2">Firehouse Community Media Center</a></li><li id="main-menu-link-contentfaa7de74-d09b-4dc9-9500-acffde1da615" class="sf-depth-2 sf-no-children"><a href="/locations/youth-media-center" class="sf-depth-2">Youth Media Center</a></li></ol></li></ul></li><li id="main-menu-link-contentd5c20d7c-4b8f-4dc8-870d-70de17786109" class="sf-depth-1 menuparent"><a href="/about" class="sf-depth-1 menuparent">About</a><ul class="sf-multicolumn sf-hidden" style="float: none; width: 12em;"><li class="sf-multicolumn-wrapper " style=""><ol><li id="main-menu-link-content5b3429ae-86c2-44f3-aa2f-f0f3a5dd59cd" class="sf-depth-2 sf-no-children"><a href="/about/contact" class="sf-depth-2">Contact Us</a></li><li id="main-menu-link-content8b16bc09-ae4c-4cd0-b1e3-00d94fd81cca" class="sf-depth-2 sf-no-children"><a href="/about/faqs" class="sf-depth-2">FAQs</a></li><li id="main-menu-link-contentbecd021d-cac1-4002-bb01-87eb4b9c3221" class="sf-depth-2 sf-no-children"><a href="/about/forms" class="sf-depth-2">Forms</a></li><li id="main-menu-link-contentf7f7f3c1-f08f-4b8a-8f33-c8b757b98907" class="sf-depth-2 sf-no-children"><a href="/about/internships" class="sf-depth-2">Internships</a></li><li id="main-menu-link-contentcfac18f4-d74a-4632-92da-58ae97b18a8f" class="sf-depth-2 sf-no-children"><a href="/about/jobs" class="sf-depth-2">Jobs</a></li><li id="main-menu-link-content144fba04-2590-40d4-8806-b590337dc14c" class="sf-depth-2 sf-no-children"><a href="/about/mission-vision-and-values" class="sf-depth-2">Mission, Vision &amp; Values</a></li><li id="main-menu-link-content47b03cd5-19b5-46a6-9657-e012eb33076f" class="sf-depth-2 sf-no-children"><a href="/about/policies" class="sf-depth-2">Policies</a></li><li id="main-menu-link-content753ea7b1-8567-4428-a3cb-d05a8ad38ccf" class="sf-depth-2 sf-no-children"><a href="/about/support-mnn" class="sf-depth-2">Support MNN</a></li><li id="main-menu-link-contentb013f0b4-76ae-436f-b140-5ac768464c8d" class="sf-depth-2 sf-no-children"><a href="/about/staff" class="sf-depth-2">Staff &amp; Board</a></li></ol></li></ul></li>-->
<!--          </ul>-->
<!--        </div>-->
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
    <?php print render($page['footer']); ?>
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
    <footer role="contentinfo" class="footer">
      <div class="region region-footer">
        <nav role="navigation" aria-labelledby="block-mainnavigation-2-menu" id="block-mainnavigation-2" class="footer-navigation block block-menu navigation menu--main">
          <h2 class="visually-hidden" id="block-mainnavigation-2-menu">Main navigation</h2>
          <ul class="menu">
            <li class="menu-item menu-item--collapsed">
              <a href="/watch" class="primary-item-watch" data-drupal-link-system-path="node/46">Watch</a>
            </li>
            <li class="menu-item menu-item--collapsed">
              <a href="/create" data-drupal-link-system-path="node/47">Create</a>
            </li>
            <li class="menu-item menu-item--collapsed">
              <a href="/learn" data-drupal-link-system-path="node/1650">Learn</a>
            </li>
            <li class="menu-item menu-item--collapsed">
              <a href="/blog" data-drupal-link-system-path="node/39">Blog</a>
            </li>
            <li class="menu-item menu-item--collapsed">
              <a href="/watch/programs" title="MNN's Program pages" data-drupal-link-system-path="node/1629">Programs</a>
            </li>
            <li class="menu-item menu-item--collapsed">
              <a href="/locations" data-drupal-link-system-path="node/1628">Locations</a>
            </li>
            <li class="menu-item menu-item--collapsed">
              <a href="/about" data-drupal-link-system-path="node/1993">About</a>
            </li>
          </ul>
        </nav>
        <nav role="navigation" aria-labelledby="block-quicklinks-menu" id="block-quicklinks" class="footer-quick-links block block-menu navigation menu--quick-links">
          <h2 id="block-quicklinks-menu">Quick Links</h2>
          <ul class="menu">
            <li class="menu-item">
              <a href="/watch/tv-schedule" data-drupal-link-system-path="node/1627">TV Schedule</a>
            </li>
            <li class="menu-item">
              <a href="/learn/orientation" data-drupal-link-system-path="node/50">Orientation</a>
            </li>
            <li class="menu-item">
              <a href="/create/producer-resources-video-tutorials" data-drupal-link-system-path="node/1641">Producer Resources</a>
            </li>
          </ul>
        </nav>
        <div id="block-locations" class="footer-locations block block-block-content block-block-content1ec35d76-1015-48fe-afe5-e1231eb2ef80">
          <div class="clearfix text-formatted field field--name-body field--type-text-with-summary field--label-hidden field__item"><h2><a href="/locations">Locations</a></h2>
            <h3><a href="/59th-street-studios">59th Street Studios</a></h3>
            <p><a title="Get Directions from Google Maps" href="https://goo.gl/maps/i8hUWGyuPD72" target="_blank">537 West 59th Street<br>
                New York, NY 10019</a></p>
            <h3><a href="/mnn-el-barrio-firehouse-community-media-center-0">El Barrio Firehouse</a></h3>
            <p><a title="Get Directions from Google Maps" href="https://goo.gl/maps/ZnXtnMrkrWz" target="_blank">175 E 104th Street<br>
                New York, NY 10029</a></p>
          </div>

        </div>

      </div>

    </footer>
  </div>
</div>
