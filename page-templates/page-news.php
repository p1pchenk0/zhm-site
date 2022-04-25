<?php
/*
Template Name: Сторінка новин
*/
?>

<?php get_header(); ?>
  <?php get_template_part('breadcrumbs'); ?>
  <div class="row mb-3">
    <div class="col-lg-9">
      <?php echo zhm_get_title('Новини'); ?>
      <?php
        $current_page = get_query_var('paged');

        $news_query = new WP_Query(array(
          'post_type' => 'post',
          'posts_per_page' => 10,
          'paged' => $current_page
        ));

        if ($news_query->have_posts()) {
          while ($news_query->have_posts()) {
            $post = get_post($news_query->the_post());

            get_template_part( 'post', 'preview', array('post' => $post) );
          } 
      ?>
      <div class="news-pagination bold primary-font text-primary">
        <?php
          echo paginate_links(array(
            'total' => $news_query->max_num_pages,
            'prev_text' => 'Попередні',
            'next_text' => 'Наступні'
          ));
        ?>
      </div>
      <?php
        } else {
      ?>
        <h3 class="primary-font text-primary mt-3">
          Новин поки що немає. Будь ласка, зайдіть пізніше.
        </h3>
      <?php
        }
      ?>
    </div>
    <?php get_template_part('side', 'menu'); ?>
  </div>
<?php get_footer(); ?>
