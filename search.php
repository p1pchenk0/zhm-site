<?php get_header(); ?>

<div class="row mb-3">
  <?php get_template_part('breadcrumbs'); ?>
  <div class="col-9">
    <h3 class="bold primary-font text-primary mt-5 mb-3">
      <?php
        if (have_posts()) {
          printf(
            esc_html('За Вашим запитом "%s" знайдено результатів: %d'),
            get_search_query(),
            (int) $wp_query->found_posts
          );
        } else {
          echo 'Нажаль, за Вашим запитом нічого не знайдено';
        }
      ?>
    </h3>

    <?php
      if ($wp_query->have_posts()) {
        while ($wp_query->have_posts()) {
          $post = get_post($wp_query->the_post());
          
          get_template_part( 'post', 'preview', array('post' => $post) );
        }
    ?>
    <div class="news-pagination bold primary-font text-primary">
      <?php
        echo paginate_links(array(
          'total' => $wp_query->max_num_pages,
          'prev_text' => 'Попередні',
          'next_text' => 'Наступні'
        ));
      ?>
    </div>
    <?php } ?>
  </div>
  <?php get_template_part('side', 'menu'); ?>
</div>

<?php get_footer(); ?>
