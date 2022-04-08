<div class="side-menu-wrapper col-lg-3">
  <div id="sideMenu">
    <?php echo zhm_get_title('Корисне', 'ps-3'); ?>

    <ul class="side-menu navbar-nav mt-4 pb-3">
      <?php
        wp_nav_menu(
          array(
            'container'       => '',
            'items_wrap'      => '%3$s',
            'theme_location'  => 'sidebar',
            'add_li_class'    => 'nav-item primary-font text-primary'
          )
        );
      ?>
    </ul>

    <?php echo zhm_get_title('Інші ресурси'); ?>
    <div class="mt-5">
      <?php get_template_part('side', 'links'); ?>
    </div>
  </div>
</div>
