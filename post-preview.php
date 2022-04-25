<div class="post-wrapper mt-3 mt-md-5 align-items-center">
    <?php $post = $args['post']; ?>
    <?php $img = get_the_post_thumbnail_url($post); ?>
    <?php if (!empty($img)) { ?>
        <div class="mx-auto me-md-3 relative post-image-wrapper">
            <img class="post-image" src="<?php echo $img; ?>"/>
            <span class="post-view-count text-primary secondary-font">
                <?php echo zhm_get_icon('eye'); ?>
                <span>
                    <?php
                        $count = zhm_get_post_view();
                        echo zhm_nice_number($count ?: 0);
                    ?>
                </span>
            </span>
        </div>
        <!-- <div class="post-image me-md-4" style="background-image: url(<?php echo $img; ?>)">
            <span class="post-image-frame"></span>
        </div> -->
    <?php } ?>
    <div class="post-meta">
        <h3 class="primary-font bold mb-3"><?php echo $post->post_title ?></h3>
        <div class="post-date secondary-font mb-3">
            <?php echo zhm_get_date($post->post_date); ?>
        </div>
        <?php echo zhm_get_button('Читати', get_permalink($post->ID)); ?>
    </div>
</div>