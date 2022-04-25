<?php
@ini_set( 'upload_max_size' , '120M' );
@ini_set( 'post_max_size', '120M');
@ini_set( 'max_execution_time', '300' );

function my_post_count_queries( $query ) {
  if (!is_admin() && $query->is_main_query()){
    if(is_home()){
       $query->set('posts_per_page', 1);
    }
  }
}
add_action( 'pre_get_posts', 'my_post_count_queries' );

/**
 * Plugins to install:
 * - Classic Editor
 * - CyrToLat
 */

  $default_primary_color = '#0713a5';
  $default_header_color = '#6dd8fd';

  // Handle Customizer settings.
  require get_template_directory() . '/classes/customizer.php';

  Zhm_Customize::set_defaults(array(
    'primary_color' => $default_primary_color,
    'header_color'  => $default_header_color
  ));

  add_theme_support('post-thumbnails');
  set_post_thumbnail_size( 1568, 9999 );

  add_action( 'customize_register', array( 'Zhm_Customize', 'register' ) );

  require get_template_directory() . '/misc/utils.php';
  require get_template_directory() . '/custom-posts/zhm-doc.php';
  require get_template_directory() . '/misc/dynamic-css.php';
  require get_template_directory() . '/misc/files.php';
  require get_template_directory() . '/misc/footer-info.widget.php';

  require get_template_directory() . '/classes/walker.php';

  add_action( 'admin_init', 'zhm_hide_editor' );
 
  function zhm_hide_editor() {
      $post_id = isset($_GET['post']) ? $_GET['post'] : (isset($_POST['post_ID']) ? $_POST['post_ID'] : null);
      if( !isset( $post_id ) ) return;
  
      $template_file = get_post_meta($post_id, '_wp_page_template', true);
      
      if(str_contains($template_file, 'page-files.php')){ // edit the template name
          remove_post_type_support('page', 'editor');
      }
  }


  function zhm_register_styles() {
    $version = wp_get_theme()->get('Version');
    wp_enqueue_style('jquery-ui');
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
    wp_enqueue_media();
    wp_enqueue_script('jquery-ui-datepicker', '', array(), false, true);
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
    echo '
      <style type="text/css">
        #dashboard-widgets .postbox-container {
          width: 100%;
        }
      </style>
    ';
  }

  function get_menu_parent( $menu, $post_id = null ) {
    $post_id        = $post_id ? : get_the_ID();
    $menu_items     = get_menu_items_by_registered_slug( $menu );
    $parent_item_id = wp_filter_object_list( $menu_items, array( 'object_id' => $post_id ), 'and', 'menu_item_parent' );

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
      $menu       = get_term( $locations[ $menu_slug ] );
      $menu_items = wp_get_nav_menu_items($menu->term_id);
    }
  
    return $menu_items;
  }

  function zhm_get_menu_item_hierarchy($id, $menu_items, $result = array()) {
    $i = array_search((string) $id, array_column($menu_items, 'object_id'));

    if ($i == false) {
      $i = array_search((string) $id, array_column($menu_items, 'ID'));
    }

    $element    = ($i !== false ? $menu_items[$i] : null);
    $parent_id  = $element ? $element->menu_item_parent : null; // object_id

    if ($parent_id !== null) {
      array_unshift($result, $element);

      return zhm_get_menu_item_hierarchy($parent_id, $menu_items, $result);
    } else {
      return $result;
    }
  }

  function zhm_get_menu_item_children($id) {
    $menu_items = zhm_get_menu_items_by_registered_slug('primary');
    $i          = array_search((string) $id, array_column($menu_items, 'object_id'));

    if ($i == false && $i != 0) {
      $i = array_search((string) $id, array_column($menu_items, 'ID'));
    }

    $element = ($i !== false ? $menu_items[$i] : null);

    if (!$element) {
      return null;
    }

    $el_id = $element->ID;

    return array_filter($menu_items, function($item) use($el_id) {
      return $item->menu_item_parent == (string) $el_id && $item->url !== '#';
    });
  }



function zhm_get_post_view() {
    $count = get_post_meta( get_the_ID(), 'post_views_count', true );

    return $count;
}
function zhm_set_post_view() {
    $key = 'post_views_count';
    $post_id = get_the_ID();
    $count = (int) get_post_meta( $post_id, $key, true );

    $count++;

    update_post_meta( $post_id, $key, $count );
}
function zhm_posts_column_views( $columns ) {
    $type = 'post';
    
    if (isset($_GET['post_type'])) {
      $type = $_GET['post_type'];
    }
    
    if ('post' == $type) {
      $columns['post_views'] = 'Переглядів';
    }

    return $columns;
}
function zhm_posts_custom_column_views( $column ) {
    if ( $column === 'post_views') {
        echo zhm_get_post_view();
    }
}
add_filter( 'manage_posts_columns', 'zhm_posts_column_views' );
add_action( 'manage_posts_custom_column', 'zhm_posts_custom_column_views' );
add_action('admin_head', 'post_views_admin_styles');

function post_views_admin_styles() {
    echo '
        <style>
            .post-type-post .wp-list-table {
                table-layout: auto;
            }
        </style>
    ';
}
?>
