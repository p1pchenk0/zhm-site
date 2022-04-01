<div class="side-links pb-3">
  <ul class="navbar-nav mt-4 pb-3">
  <?php
    wp_nav_menu(
      array(
        'container'       => '',
        'items_wrap'      => '%3$s',
        'theme_location'  => 'links',
        'add_li_class'    => 'nav-item primary-font text-primary side-link mb-3 bold'
      )
    );
  ?>
  </ul>
</div>
