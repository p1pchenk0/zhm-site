<div class="post-wrapper mt-3 mt-md-5">
    <?php $post = $args['post']; ?>
    <?php $img = get_the_post_thumbnail_url($post); ?>
    <?php if (!empty($img)) { ?>
        <div class="post-image me-md-4" style="background-image: url(<?php echo $img; ?>)">
            <span class="post-image-frame"></span>
        </div>
    <?php } ?>
    <div class="post-meta">
        <h3 class="secondary-font mb-3"><?php echo $post->post_title ?></h3>
        <div class="post-date primary-font bold mb-3">
            <?php echo zhm_get_date($post->post_date); ?>
        </div>
        <?php echo zhm_get_button('Читати', get_permalink($post->ID)); ?>
    </div>
</div>