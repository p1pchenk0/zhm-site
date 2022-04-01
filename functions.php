<?php
@ini_set( 'upload_max_size' , '120M' );
@ini_set( 'post_max_size', '120M');
@ini_set( 'max_execution_time', '300' );

/**
 * Plugins to install:
 * - Classic Editor
 * - CyrToLat
 */

// remove_filter('the_content', 'wpautop');

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

  // require get_template_directory() . '/custom-posts/zhm-link.php';

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
      'sidebar'  => "Бокове меню",
      'links'    => "Корисні посилання"
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


  function get_menu_parent( $menu, $post_id = null ) {

    $post_id        = $post_id ? : get_the_ID();

    // var_dump(get_the_ID());

    $menu_items     = get_menu_items_by_registered_slug( $menu );

    // var_dump($menu_items);

    $parent_item_id = wp_filter_object_list( $menu_items, array( 'object_id' => $post_id ), 'and', 'menu_item_parent' );

    var_dump($parent_item_id);

    if ( ! empty( $parent_item_id ) ) {
        $parent_item_id = array_shift( $parent_item_id );
        $parent_post_id = wp_filter_object_list( $menu_items, array( 'ID' => $parent_item_id ), 'and', 'object_id' );

        if ( ! empty( $parent_post_id ) ) {
            $parent_post_id = array_shift( $parent_post_id );

            return get_post( $parent_post_id )->post_title;
        }
    }

    return false;
  }

  function zhm_get_menu_items_by_registered_slug($menu_slug) {
    $menu_items = array();
  
    if ( ($locations = get_nav_menu_locations()) && isset($locations[$menu_slug]) && $locations[$menu_slug] != 0 ) {
      $menu = get_term( $locations[ $menu_slug ] );
      $menu_items = wp_get_nav_menu_items($menu->term_id);
    }
  
    return $menu_items;
  }

  function zhm_get_menu_item_hierarchy($id, $menu_items, $result = array()) {
    $i = array_search((string) $id, array_column($menu_items, 'object_id'));

    if ($i == false) {
      $i = array_search((string) $id, array_column($menu_items, 'ID'));
    }

    $element = ($i !== false ? $menu_items[$i] : null);

    $parent_id = $element->menu_item_parent; // object_id

    if ($parent_id !== null) {
      array_unshift($result, $element);

      return zhm_get_menu_item_hierarchy($parent_id, $menu_items, $result);
    } else {
      return $result;
    }
  }

  function zhm_get_menu_item_children($id) {
    $menu_items = zhm_get_menu_items_by_registered_slug('primary');

    // var_dump($id);
    // var_dump($menu_items);

    $i = array_search((string) $id, array_column($menu_items, 'object_id'));

    // var_dump($i);

    if ($i == false && $i != 0) {
      $i = array_search((string) $id, array_column($menu_items, 'ID'));
    }

    $element = ($i !== false ? $menu_items[$i] : null);

    // var_dump($element);

    if (!$element) {
      return null;
    }

    $el_id = $element->ID;
    
    // var_dump($el_id);


    return array_filter($menu_items, function($item) use($el_id) {
      // var_dump($item->menu_item_parent);
      // var_dump((string) $el_id);
      return $item->menu_item_parent == (string) $el_id && $item->url !== '#';
    });
  }
?>
