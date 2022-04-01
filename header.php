<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
    <meta charset="utf-8">
    <title>
      <?php is_singular() ? the_title() : bloginfo('title') ?>
    </title>
    <style media="screen">
      <?php echo zhm_get_dynamic_css_values(); ?>
    </style>
  </head>
  <body <?php body_class(); ?>>
    <header class="container-fluid">
      <div class="header-top-content container py-3 py-md-4 mb-md-4">
        <div class="header-top-content__inner row justify-content-between">
          <div class="col-6 row">
            <?php get_template_part( 'logo', 'link' ); ?>
          </div>
          <div class="col-6 socials">
            <?php echo zhm_get_header_socials(); ?>
          </div>
        </div>
      </div>
      <div class="container-fluid" id="header">
        <div class="container">
          <div class="row header-actions">
            <div class="col-md-9 menu-part">
              <div class="mobile-menu-wrapper">
                <?php get_template_part('menu', 'mobile'); ?>
              </div>
              <?php if (has_nav_menu('primary')) { ?>
                <nav class="navbar navbar-expand-lg">
                  <ul class="primary-menu navbar-nav bold">
                    <?php
                      wp_nav_menu(
                        array(
                          'container'       => '',
                          'items_wrap'      => '%3$s',
                          'theme_location'  => 'primary',
                          'add_li_class'    => 'nav-item',
                          'walker'          => new Zhm_Menu_Walker()
                        )
                      );
                    ?>
                  </ul>
                </nav>
              <?php } ?>
            </div>
            <div class="col-md-3 mt-md-2 search-part">
              <?php get_search_form(); ?>
            </div>
          </div>
        </div>
      </div>
      <div id="stickySpacer"></div>
    </header>
                      
    <main class="container">
