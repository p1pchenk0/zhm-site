<?php
@ini_set( 'upload_max_size' , '120M' );
@ini_set( 'post_max_size', '120M');
@ini_set( 'max_execution_time', '300' );

  $default_primary_color = '#0713a5';
  $default_header_color = '#6dd8fd';

  // Handle Customizer settings.
  require get_template_directory() . '/classes/customizer.php';

  Zhm_Customize::set_defaults(array(
    'primary_color' => $default_primary_color,
    'header_color' => $default_header_color
  ));

  add_theme_support('post-thumbnails');
  set_post_thumbnail_size( 1568, 9999 );

  add_action( 'customize_register', array( 'Zhm_Customize', 'register' ) );

  require get_template_directory() . '/custom-posts/zhm-link.php';

  require get_template_directory() . '/misc/dynamic-css.php';
  require get_template_directory() . '/misc/utils.php';
  require get_template_directory() . '/misc/footer-info.widget.php';

  require get_template_directory() . '/classes/walker.php';


  function zhm_register_styles() {

    $version = wp_get_theme()->get('Version');

    wp_enqueue_style(
      'zhm-bootstrap',
      'https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css',
      array(),
      '5.1.3',
      'all'
    );

    wp_enqueue_style(
      'zhm-styles',
      get_template_directory_uri().'/style.css',
      array('zhm-bootstrap'),
      $version,
      'all'
    );
  }

  add_action('wp_enqueue_scripts', 'zhm_register_styles');

  function zhm_register_scripts() {

    $version = wp_get_theme()->get('Version');

    wp_enqueue_script(
      'zhm-bootstrap',
      'https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js',
      array(),
      '5.1.3',
      true
    );

    wp_enqueue_script(
      'zhm-sidebar',
      get_template_directory_uri().'/assets/js/sticky.sidebar.js',
      array('zhm-bootstrap'),
      $version,
      true
    );

    wp_enqueue_script(
      'zhm-script',
      get_template_directory_uri().'/assets/js/main.js',
      array('zhm-bootstrap', 'zhm-sidebar'),
      '3.3.4',
      true
    );
  }

  add_action('wp_enqueue_scripts', 'zhm_register_scripts');

  function zhm_register_menus() {

    $locations = array(
  		'primary'  => "Головне меню",
  		'footer'   => "Меню футера",
      'sidebar'  => "Бокове меню"
  	);

	  register_nav_menus( $locations );
  }

  add_action( 'init', 'zhm_register_menus' );

  function search_filter($query) {
    if ( !is_admin() && $query->is_main_query() ) {
      if ($query->is_search) {
        $query->set('paged', ( get_query_var('paged') ) ? get_query_var('paged') : 1 );
        $query->set('posts_per_page', 5);
        $query->set('post_type', 'post');
      }
    }
  }

  add_action('pre_get_posts', 'search_filter');

  function zhm_register_sidebar() {
    register_sidebar(array(
      'name' => 'Сайдбар',
      'id' => 'main_sidebar'
    ));
  }

  add_action( 'init', 'zhm_register_sidebar' );

  function zhm_add_additional_class($classes, $item, $args){
    if(isset($args->add_li_class)){
        $classes[] = $args->add_li_class;
    }

    return $classes;
  }

  add_filter('nav_menu_css_class', 'zhm_add_additional_class', 1, 3);

  function zhm_add_menu_link_class($attrs, $item, $args) {
    // check if the item is in the primary menu
    if( $args->theme_location == 'primary' ) {
      // add the desired attributes:
      $attrs['class'] = 'nav-link';
    }
    return $attrs;
  }

  add_filter( 'nav_menu_link_attributes', 'zhm_add_menu_link_class', 10, 3 );

  add_action('admin_head', 'my_column_width');

  function my_column_width() {
    echo '<style type="text/css">';
    echo '#dashboard-widgets .postbox-container { width: 100%; }';
    echo '</style>';
  }
?>
