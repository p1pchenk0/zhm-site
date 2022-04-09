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
        'singular_name' => 'Відсканований документ',
        'add_new_item' => 'Додати новий',
        'add_new' => 'Додати новий'
      ),
      'menu_icon' => 'dashicons-share',
    //   'supports' => array('thumbnail', 'title')
    ));
  }

  add_action('init', 'zhm_register_doc_post');

function zhm_doc_custom_boxes() {
    add_meta_box('zhm_doc_type', 'Тип документа', 'zhm_doc_type_html', 'zhm_doc');
    add_meta_box('zhm_doc_publish_date', 'Дата публікації', 'zhm_doc_publish_date_html', 'zhm_doc');
    add_meta_box('zhm_doc_accept_date', 'Дата прийняття', 'zhm_doc_accept_date_html', 'zhm_doc');
    add_meta_box('zhm_doc_attachment', 'Файл документа', 'zhm_doc_attachment_html', 'zhm_doc');

    wp_enqueue_script('jquery-ui-datepicker', '', array(), false, true);
    wp_register_style('jquery-ui', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css');
    wp_enqueue_style('jquery-ui');

    ?>
        
    <?php
    // $screens = [ 'zhm_doc' ];
    // foreach ( $screens as $screen ) {
    //     add_meta_box(
    //         'zhm_related_file_url',                 // Unique ID
    //         'Related file data',      // Box title
    //         'wporg_custom_box_html',  // Content callback, must be of type callable
    //         $screen                            // Post type
    //     );
    // }
}

add_action( 'add_meta_boxes', 'zhm_doc_custom_boxes' );

function zhm_doc_publish_date_html($post) {
    $value = get_post_meta( $post->ID, '_zhm_doc_publish_date', true );

?>
    <input type="text" class="custom_date" name="zhm_doc_publish_date" value="<?php echo $value; ?>"/>
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            $('input[name="zhm_doc_publish_date"]').datepicker({
                dateFormat : 'yy-mm-dd'
            });
        });        
    </script>
<?php
}

function zhm_doc_accept_date_html($post) {
    $value = get_post_meta( $post->ID, '_zhm_doc_accept_date', true );

?>
    <input type="text" class="custom_date" name="zhm_doc_accept_date" value="<?php echo $value; ?>"/>
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

    $types = array(
        array(
            'id' => 'city_council',
            'label' => 'Рішення міської ради',
        ),
        array(
            'id' => 'exec_committee',
            'label' => 'Рішення виконавчого комітету',
        ),
        array(
            'id' => 'mayor',
            'label' => 'Розпорядження міського голови',
        ),
        array(
            'id' => 'project',
            'label' => 'Проекти рішень',
        ),
        array(
            'id' => 'other',
            'label' => 'Інші документи',
        ),
        array(
            'id' => 'acts',
            'label' => 'Діючі регуляторні акти',
        ),
    );
    ?>
    
    <select name="zhm_doc_type" id="zhm_doc_type_select">
        <?php
        foreach($types as $type) {
            ?>
            <option value="<?php echo $type['id']; ?>" <?php selected( $value, $type['id'] ); ?>>
                <?php echo $type['label']; ?>
            </option>
            <?php
        } ?>

    </select>
    <?php
}

    function zhm_doc_attachment_html($post){
        $url = get_post_meta($post->ID, '_zhm_doc_attachment', true);
    ?>
        <div id="zhmAttachmentPreview"><?php echo $url; ?></div>
        <input name="zhm_doc_attachment" type="hidden" value="<?php echo $url;?>" />
        <input id="my_upl_button" type="button" value="Завантажити документ"/>

        <script>
        /**
         * Load media uploader on pages with our custom metabox
         */
        jQuery(document).ready(function($){

        'use strict';

        // Instantiates the variable that holds the media library frame.
        var metaImageFrame;

        // Runs when the media button is clicked.
        $( '#my_upl_button' ).click(function() {

            // Get the btn
            // var btn = e.target;

            // Check if it's the upload button
            // if ( !btn || !$( btn ).attr( 'data-media-uploader-target' ) ) return;

            // Get the field target
            var field = $('input[name="zhm_doc_attachment"]');

            // Prevents the default action from occuring.
            // e.preventDefault();

            // Sets up the media library frame
            metaImageFrame = wp.media.frames.metaImageFrame = wp.media({
                // title: meta_image.title,
                title: 'Оберіть файл документа',
                button: { text:  'Обрати файл' },
            });

            // Runs when an image is selected.
            metaImageFrame.on('select', function() {

                // Grabs the attachment selection and creates a JSON representation of the model.
                var media_attachment = metaImageFrame.state().get('selection').first().toJSON();

                // Sends the attachment URL to our custom image input field.
                $( field ).val(media_attachment.url);
                $('#zhmAttachmentPreview').text(media_attachment.url);

            });

            // Opens the media library frame.
            metaImageFrame.open();

        });

        });
        </script>

        <!-- <script>
            jQuery(document).ready( function($) {
                jQuery('#my_upl_button').click(function() {
                    window.send_to_editor = function(html) {
                        imgurl = jQuery(html).attr('href');

                        jQuery('input[name="zhm_doc_attachment"]').val(imgurl);
                        jQuery('#zhmAttachmentPreview').text(imgurl);
                        tb_remove();
                    }
            
                    // formfield = jQuery('input[name="zhm_doc_attachment"]').attr('name');
                    
                    tb_show('', 'media-upload.php?TB_iframe=true' );
                    
                    return false;
                });
            });
        </script> -->
  <?php
    }
  

function zhm_doc_save_postdata( $post_id ) {
    if (array_key_exists('zhm_doc_type', $_POST)) {
        update_post_meta($post_id, '_zhm_doc_type', $_POST['zhm_doc_type']);
    }

    if (array_key_exists('zhm_doc_accept_date', $_POST)) {
        update_post_meta($post_id, '_zhm_doc_accept_date', $_POST['zhm_doc_accept_date']);
    }

    if (array_key_exists('zhm_doc_publish_date', $_POST)) {
        update_post_meta($post_id, '_zhm_doc_publish_date', $_POST['zhm_doc_publish_date']);
    }

    if (array_key_exists('zhm_doc_attachment', $_POST)) {
        // TODO: check for attachment and extract text if possible
        update_post_meta($post_id, '_zhm_doc_attachment', $_POST['zhm_doc_attachment']);
    }
}

add_action( 'save_post', 'zhm_doc_save_postdata' );