<?php
  function zhm_register_link_post() {
    register_post_type('zhm_link', array(
      'menu_position' => 6,
      'public' => false,  // it's not public, it shouldn't have it's own permalink, and so on
      'publicly_queryable' => true,  // you should be able to query it
      'show_ui' => true,  // you should be able to edit it in wp-admin
      'exclude_from_search' => true,  // you should exclude it from search results
      'show_in_nav_menus' => false,  // you shouldn't be able to add it to menus
      'has_archive' => false,  // it shouldn't have archive page
      'rewrite' => false,  // it shouldn't have rewrite rules
      'labels' => array(
        'name' => 'Сторонні посилання',
        'singular_name' => 'Стороннє посилання',
        'add_new_item' => 'Додати нове стороннє посилання',
        'add_new' => 'Додати нове'
      ),
      'menu_icon' => 'dashicons-share',
      'supports' => array('thumbnail', 'title')
    ));
  }

  add_action('init', 'zhm_register_link_post');

  function zhm_links_metaboxes( ) {
    global $wp_meta_boxes;
    add_meta_box('zhm_link_href', 'Посилання на ресурс (починаючи з http або https)', 'zhm_links_metaboxes_html', 'zhm_link', 'normal', 'high');
  }

  add_action( 'add_meta_boxes', 'zhm_links_metaboxes' );

  function zhm_links_metaboxes_html() {
      global $post;
      $custom = get_post_custom($post->ID);
      $zhm_link_href = isset($custom["zhm_link_href"][0])?$custom["zhm_link_href"][0]:'';
    ?>
      <input
        name="zhm_link_href"
        id="zhm_link_href_input"
        value="<?php echo $zhm_link_href; ?>"
      >
        <style media="screen">
          #zhm_link_href_input {
            width: 100%;
            padding: 3px 8px;
            margin-top: 5px;
          }
        </style>
    <?php
  }

  function zhm_links_save_post() {
    global $post;

    if(empty($_POST) || !$post) return;

    update_post_meta($post->ID, "zhm_link_href", $_POST["zhm_link_href"]);
  }

  add_action( 'save_post', 'zhm_links_save_post' );
?>
