<div class="file-wrapper mt-5">
    <?php
        $post = $args['post'];
        $search_term = isset($args['search_term']) ? $args['search_term'] : null;
        $is_extended = isset($args['extended']) ? $args['extended'] : false;
        $meta = get_post_meta($post->ID);

        $doc_link = $meta['_zhm_doc_attachment'][0];
        $doc_type = $meta['_zhm_doc_type'][0];
        $doc_accept_date = $meta['_zhm_doc_accept_date'][0];
        $doc_link_parts = explode('.', $doc_link);
        $extension = end($doc_link_parts);
        
        $doc_type_label = zhm_get_doc_type_label($doc_type);
    ?>
    <div class="file-meta">
        <div class="d-flex">
            <div class="extension-icon pe-3">
                <?php echo zhm_get_icon($extension); ?>
            </div>
            <div>
                <h3 class="primary-font text-primary bold mb-2"><?php echo $post->post_title ?></h3>
                    <div class="secondary-font text-primary bold <?php echo $is_extended ? 'mb-2' : 'mb-4'; ?>">
                        <?php if ($is_extended) { echo $doc_type_label; } ?>
                    </div>
                <div class="file-dates bold secondary-font">
                    <?php
                        if ($doc_accept_date) {
                    ?>
                    <div class="text-primary">
                        Дата прийняття: <?php echo zhm_get_date($doc_accept_date); ?>
                    </div>
                    <?php } ?>
                    <div class="text-primary">
                       Дата публікації: <?php echo zhm_get_date(get_the_date('Y-m-d', $post)); ?>
                    </div>
                </div>
            </div>
        </div>

        <?php
            $content = get_the_content(null, false, $post->ID);

            if ($content) {
        ?>
        <div class="file-description secondary-font text-primary mt-3">
            <?php
                $content = get_the_content(null, false, $post->ID);
                $reg = preg_quote($search_term, '/');
                $reg = "/$reg/i";
                $content = $search_term ? preg_replace($reg, '<span class="highlighted">$0</span>', $content) : $content;

                echo $content;
            ?>
        </div>
        <?php
            }
        ?>
        
        <?php echo zhm_get_button('Завантажити', $doc_link, 'mt-3'); ?>
    </div>
</div>