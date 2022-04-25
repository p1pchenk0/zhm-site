<?php

function zhm_register_doc_post() {
    register_post_type('zhm_doc', array(
      'menu_position' => 6,
      'public' => false,  // it's not public, it shouldn't have it's own permalink, and so on
      'publicly_queryable' => true,  // you should be able to query it
      'show_ui' => true,  // you should be able to edit it in wp-admin
      'exclude_from_search' => false,  // you should exclude it from search results
      'show_in_nav_menus' => false,  // you shouldn't be able to add it to menus
      'has_archive' => false,  // it shouldn't have archive page
      'rewrite' => false,  // it shouldn't have rewrite rules
      'labels' => array(
        'name' => 'Документи',
        'singular_name' => 'Документ',
        'add_new_item' => 'Додати новий',
        'add_new' => 'Додати новий'
      ),
      'menu_icon' => 'dashicons-share',
    ));
  }

  add_action('init', 'zhm_register_doc_post');

function zhm_doc_custom_boxes() {
    add_meta_box('zhm_doc_type', 'Тип документа', 'zhm_doc_type_html', 'zhm_doc');
    add_meta_box('zhm_doc_accept_date', 'Дата прийняття', 'zhm_doc_accept_date_html', 'zhm_doc');
    add_meta_box('zhm_doc_attachment', 'Файл документа', 'zhm_doc_attachment_html', 'zhm_doc');

    wp_enqueue_media();
    wp_enqueue_script('jquery-ui-datepicker', '', array(), false, true);
    wp_register_style('jquery-ui', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css');
    wp_enqueue_style('jquery-ui');
}

add_action( 'add_meta_boxes', 'zhm_doc_custom_boxes' );

function zhm_doc_accept_date_html($post) {
    $value = get_post_meta( $post->ID, '_zhm_doc_accept_date', true );
?>
    <input
        type="text"
        class="custom_date"
        name="zhm_doc_accept_date"
        value="<?php echo $value; ?>"
    />
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            $('input[name="zhm_doc_accept_date"]').datepicker({
                dateFormat : 'yy-mm-dd'
            });
        });        
    </script>
<?php
}

function zhm_doc_type_html($post) {
    $value = get_post_meta( $post->ID, '_zhm_doc_type', true );
    $types = zhm_get_doc_types();
    ?>
    <select name="zhm_doc_type" id="zhm_doc_type_select">
        <?php foreach($types as $type) { ?>
            <option
                value="<?php echo $type['id']; ?>"
                <?php selected( $value, $type['id'] ); ?>
            >
                <?php echo $type['label']; ?>
            </option>
        <?php } ?>
    </select>
    <?php
}

    function zhm_doc_attachment_html($post){
        $url = get_post_meta($post->ID, '_zhm_doc_attachment', true);
    ?>
        <div id="zhmAttachmentPreview"><?php echo $url; ?></div>
        <br>
        <input name="zhm_doc_attachment" type="hidden" value="<?php echo $url;?>" />
        <input id="my_upl_button" type="button" value="Завантажити документ"/>

        <script>
        /**
         * Load media uploader on pages with our custom metabox
         */
        jQuery(document).ready(function($){
            'use strict';

            var metaImageFrame;

            $( '#my_upl_button' ).click(function() {
                var field = $('input[name="zhm_doc_attachment"]');

                metaImageFrame = wp.media.frames.metaImageFrame = wp.media({
                    title: 'Оберіть файл документа',
                    button: { text:  'Обрати файл' },
                });

                metaImageFrame.on('select', function() {
                    var media_attachment = metaImageFrame.state().get('selection').first().toJSON();

                    $( field ).val(media_attachment.url);
                    $('#zhmAttachmentPreview').text(media_attachment.url);
                });

                metaImageFrame.open();
            });
        });
        </script>
  <?php
    }
  

function zhm_doc_save_postdata( $post_id ) {
    if (array_key_exists('zhm_doc_type', $_POST)) {
        update_post_meta($post_id, '_zhm_doc_type', $_POST['zhm_doc_type']);
    }

    if (array_key_exists('zhm_doc_accept_date', $_POST)) {
        update_post_meta($post_id, '_zhm_doc_accept_date', $_POST['zhm_doc_accept_date']);
    }

    if (array_key_exists('zhm_doc_attachment', $_POST)) {
        update_post_meta($post_id, '_zhm_doc_attachment', $_POST['zhm_doc_attachment']);
    }
}

add_action( 'save_post', 'zhm_doc_save_postdata' );

add_filter('manage_zhm_doc_posts_columns', 'set_custom_zhm_doc_columns');

function set_custom_zhm_doc_columns($columns) {
    $columns['doc_type'] = 'Тип документа';
    $columns['accepted_at'] = 'Дата прийняття';

    return $columns;
}

add_action( 'manage_zhm_doc_posts_custom_column' , 'custom_zhm_doc_column', 10, 2 );

function custom_zhm_doc_column( $column, $post_id ) {
    switch ( $column ) {
        case 'doc_type' :
            $doc_type = get_post_meta( $post_id , '_zhm_doc_type' , true );
            
            echo zhm_get_doc_type_label($doc_type);
            
            break;
        case 'accepted_at' :
            echo get_post_meta( $post_id , '_zhm_doc_accept_date' , true ); 
            
            break;
    }
}

add_action('admin_head', 'admin_styles');

function admin_styles() {
    echo '
        <style>
            .post-type-zhm_doc .wp-list-table {
                table-layout: auto;
            }
        </style>
    ';
}

add_action( 'restrict_manage_posts', 'zhm_add_doc_type_admin_filter' );

function zhm_add_doc_type_admin_filter() {
    $type = null;
    
    if (isset($_GET['post_type'])) {
      $type = $_GET['post_type'];
    }

    if ('zhm_doc' == $type){
        $values = zhm_get_doc_types();
        ?>
        <select name="zhm_doc_type">
          <option value="">Тип документа</option>
          <?php
            $current_v = isset($_GET['zhm_doc_type']) ? $_GET['zhm_doc_type'] : '';
            
            foreach ($values as $value) {
          ?>
          <option value="<?php echo $value['id']; ?>" <?php selected( $current_v, $value['id'] ); ?>>
            <?php echo $value['label']; ?>
          </option>
          <?php } ?>
        </select>
        <?php
    }
}


add_filter( 'parse_query', 'zhm_doc_type_admin_filter' );

function zhm_doc_type_admin_filter($query) {
    global $pagenow;
    $type = null;
    if (isset($_GET['post_type'])) {
        $type = $_GET['post_type'];
    }
    if ( 'zhm_doc' == $type && is_admin() && $pagenow=='edit.php' && isset($_GET['zhm_doc_type']) && $_GET['zhm_doc_type'] != '') {
        $query->query_vars['meta_key'] = '_zhm_doc_type';
        $query->query_vars['meta_value'] = $_GET['zhm_doc_type'];
    }
}