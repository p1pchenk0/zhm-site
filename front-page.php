<?php get_header(); ?>
<div class="row">
  <section class="news-section mb-5 col-md-9">
    <?php
      echo zhm_get_title('Останні новини');
      
      $query_args = array(
        'posts_per_page' => 5,
        'post_type' => 'post'
      );

      $posts = get_posts($query_args);

      foreach($posts as $key => $post) {
        get_template_part( 'post', 'preview', array('post' => $post) );
      }

      $total_posts = wp_count_posts('post')->publish;

      if ((int) $total_posts > 0) { echo zhm_get_button('Всі новини', get_permalink(zhm_get_id_by_slug('news')), 'mt-4 mt-md-5'); }
    ?>
  </section>
  <?php get_template_part('side', 'menu'); ?>
</div>
<?php get_footer(); ?>
