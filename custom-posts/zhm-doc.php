<?php

function zhm_register_doc_post() {
    register_post_type('zhm_doc', array(
      'menu_position' => 6,
      'public' => false,  // it's not public, it shouldn't have it's own permalink, and so on
      'publicly_queryable' => true,  // you should be able to query it
      'show_ui' => true,  // you should be able to edit it in wp-admin
      'exclude_from_search' => true,  // you should exclude it from search results
      'show_in_nav_menus' => false,  // you shouldn't be able to add it to menus
      'has_archive' => false,  // it shouldn't have archive page
      'rewrite' => false,  // it shouldn't have rewrite rules
      'labels' => array(
        'name' => 'Відскановані документи',
        'singular_name' => 'Відсканований документ',
        'add_new_item' => 'Додати новий',
        'add_new' => 'Додати новий'
      ),
      'menu_icon' => 'dashicons-share',
    //   'supports' => array('thumbnail', 'title')
    ));
  }

  add_action('init', 'zhm_register_doc_post');

function wporg_add_custom_box() {
    $screens = [ 'zhm_doc' ];
    foreach ( $screens as $screen ) {
        add_meta_box(
            'zhm_related_file_url',                 // Unique ID
            'Related file data',      // Box title
            'wporg_custom_box_html',  // Content callback, must be of type callable
            $screen                            // Post type
        );
    }
}

add_action( 'add_meta_boxes', 'wporg_add_custom_box' );

function wporg_custom_box_html( $post ) {
    $value = get_post_meta( $post->ID, 'zhm_related_file_url', true );
    $attachment_id = attachment_url_to_postid($value);
    $attachment_title = get_the_title($attachment_id);
    ?>
    <div>URL: <?php echo $value; ?></div>
    <div>Title: <?php echo $attachment_title; ?></div>
    <?php
}