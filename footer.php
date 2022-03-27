</main>

<span id="topBtn">
  <?php 
    $arrow = zhm_get_arrow();

    echo $arrow;
  ?>
</span>

<footer class="container-fluid py-3 py-lg-5 mt-3 mt-lg-5">
  <?php  if (has_nav_menu('primary')) { ?>
    <nav class="container">
      <ul class="footer-menu row bold secondary-font">
        <?php
          wp_nav_menu(
            array(
              'container'       => '',
              'items_wrap'      => '%3$s',
              'theme_location'  => 'primary',
              'add_li_class'    => 'nav-item col-lg col-sm-12'
            )
          );
        ?>
      </ul>
    </nav>
  <?php } ?>
  <div class="container">
    <div class="row pt-5 mt-5 footer-info primary-font">
      <div class="col-lg col-sm-12 footer-info__home-link">
        <?php get_template_part( 'logo', 'link' ); ?>
      </div>
      <div class="col-lg col-sm-12 footer-contacts">
        <?php echo get_option('zhm_contacts'); ?>
      </div>
    </div> 
  </div>
</footer>

<?php wp_footer(); ?>

</body>
</html>
