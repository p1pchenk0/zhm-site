<?php
    function zhm_files_add_metaboxes($post) {
        $tmpl = get_post_meta($post->ID, '_wp_page_template', true);

        if (!str_contains($tmpl, 'page-files.php')) {
            return;
        }

        add_meta_box('zhm_file_type', 'Тип документів для відображення', 'zhm_file_type_html', 'page');
    }

    add_action( 'add_meta_boxes_page', 'zhm_files_add_metaboxes' );

    function zhm_file_type_html($post) {
        $value = get_post_meta( $post->ID, '_zhm_file_type', true );
    
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
        <select name="zhm_file_type" id="zhm_file_type_select">
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

    function zhm_files_save_postdata($post_id) {
        if (array_key_exists('zhm_file_type', $_POST)) {
            update_post_meta($post_id, '_zhm_file_type', $_POST['zhm_file_type']);
        }
    }

    add_action( 'save_post', 'zhm_files_save_postdata' );
?>