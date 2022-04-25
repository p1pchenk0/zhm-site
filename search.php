<?php
  get_header();
  
  $post_type = isset($_GET['type']) ? $_GET['type'] : 'post';
  $file_type = isset($_GET['file_type']) ? $_GET['file_type'] : null;
  $doc_accept_date_from = isset($_GET['doc_accept_date_from']) ? $_GET['doc_accept_date_from'] : null;
  $doc_accept_date_to = isset($_GET['doc_accept_date_to']) ? $_GET['doc_accept_date_to'] : null;
  $doc_publish_date_from = isset($_GET['doc_publish_date_from']) ? $_GET['doc_publish_date_from'] : null;
  $doc_publish_date_to = isset($_GET['doc_publish_date_to']) ? $_GET['doc_publish_date_to'] : null;
  $doc_page = isset($_GET['doc_page']) ? intval($_GET['doc_page']) : 1;
  $search = isset($_GET['s']) ? $_GET['s'] : '';

  if ($post_type === 'document') {
    $post_type = 'zhm_doc';
  }

  $is_doc = $post_type == 'zhm_doc';

  $file_meta_query = array();
  $date_query = array();

  if ($file_type && $file_type !== 'all') {
    $file_meta_query[] = array(
      'key' => '_zhm_doc_type',
      'value' => $file_type
    );
  }

  if ($doc_accept_date_from) {
    $file_meta_query[] = array(
      'key' => '_zhm_doc_accept_date',
      'value' => date($doc_accept_date_from),
      'compare' => '>=',
      'type' => 'DATE'
    );
  }

  if ($doc_accept_date_to) {
    $file_meta_query[] = array(
      'key' => '_zhm_doc_accept_date',
      'value' => date($doc_accept_date_to),
      'compare' => '<=',
      'type' => 'DATE'
    );
  }

  if ($doc_publish_date_from || $doc_publish_date_to) {
    $date_query[] = array();

    if ($doc_publish_date_from) {
      $date_query[0]['after'] = $doc_publish_date_from;
    }

    if ($doc_publish_date_to) {
      $date_query[0]['before'] = $doc_publish_date_to;
    }
  }

  $file_query_params = array(
    's' => $search,
    'post_type' => 'zhm_doc',
    'posts_per_page' => 10,
    'paged' => $doc_page,
    'meta_query' => $file_meta_query,
    'date_query' => $date_query
  );

  $search_query = $is_doc ? new WP_Query($file_query_params) : $wp_query;
?>

<div class="row mb-3">
  <?php get_template_part('breadcrumbs'); ?>
  <div class="col-12 col-lg-9">
    <h3 class="bold primary-font text-primary mt-5 mb-3">
      <?php get_template_part('search', 'results', array('is_doc' => $is_doc, 'query' => $search_query)); ?>
    </h3>
    <?php get_template_part('searchform', 'docs'); ?>
    <?php
      if ($search_query->have_posts()) {
        while ($search_query->have_posts()) {
          $post = get_post($search_query->the_post());
          
          get_template_part(
            $is_doc ? 'file' : 'post',
            'preview',
            array(
              'post' => $post,
              'extended' => $is_doc,
              'search_term' => $search
            )
          );
        }
    ?>
    <div class="news-pagination bold primary-font text-primary mt-4">
      <?php
        $pagination_params = array(
          'total' => $search_query->max_num_pages,
          'format' => '?doc_page=%#%',
          'current' => $doc_page,
          'prev_text' => 'Попередні',
          'next_text' => 'Наступні'
        );

        if ($is_doc) {
          $pagination_params['format'] = '?doc_page=%#%';
          $pagination_params['current'] = $doc_page;
        }

        echo paginate_links($pagination_params);
      ?>
    </div>
    <?php } ?>
  </div>
  <?php get_template_part('side', 'menu'); ?>
</div>
<?php get_footer(); ?>
