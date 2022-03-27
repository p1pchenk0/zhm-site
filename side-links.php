<div class="side-links pb-3">
  <?php
    $side_links_query = new WP_Query(array(
      'post_type' => 'zhm_link',
      'posts_per_page' => 10
    ));

    if ($side_links_query->have_posts()) {
      while ($side_links_query->have_posts()) {
        $side_links_query->the_post();
        $id = get_the_id();
  ?>
    <div class="side-link bold primary-font">
      <a
        href="<?php echo get_post_meta($id, 'zhm_link_href', true); ?>"
        target="_blank"
        class="mb-3"
      >
        <?php the_title(); ?>
      </a>
    </div>
  <?php
      }
    }
  ?>
</div>
