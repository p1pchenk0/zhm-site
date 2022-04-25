<?php
/*
Template Name: Сторінка файлів
*/
?>

<?php get_header(); ?>
  <?php get_template_part('breadcrumbs'); ?>
  <div class="row mb-3">
    <div class="col-lg-9">
      <?php echo zhm_get_title(get_the_title()); ?>
      <?php 
        global $post;
        
        $file_type = get_post_meta($post->ID, '_zhm_file_type', true);
      ?>
      <?php
        $current_page = get_query_var('paged');

        $files_query = new WP_Query(array(
          'post_type' => 'zhm_doc',
          'posts_per_page' => 20,
          'paged' => $current_page,
          'meta_key' => '_zhm_doc_type',
          'meta_value' => $file_type
        ));

        if ($files_query->have_posts()) {
          while ($files_query->have_posts()) {
            $post = get_post($files_query->the_post());

            get_template_part( 'file', 'preview', array('post' => $post) );
          } 
      ?>
      <div class="news-pagination bold primary-font text-primary mt-4">
        <?php
          echo paginate_links(array(
            'total' => $files_query->max_num_pages,
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