<?php
/*
Template Name: Головна сторінка файлів
*/
?>

<?php get_header(); ?>

<div class="mb-4">
  <?php get_template_part('breadcrumbs'); ?>
  <div class="row">
    <div class="mt-5 col-12 col-lg-9">
      <div class="post-top-section d-flex mb-2">
        <div class="text-primary">
          <h1 class="primary-font bold">
            <?php the_title(); ?>
          </h1>
        </div>
      </div>
      <?php get_template_part('searchform', 'docs'); ?>
      <div class="mt-4 me-lg-5 secondary-font text-primary post-content">
        <?php
          $children = zhm_get_menu_item_children(get_the_ID());

          if ($children) {
        ?>
            <div class="child-pages bold">
              <?php foreach ($children as $key => $child) { ?>
                  <div class="mb-4 child-pages__item">
                    <a href="<?php echo $child->url; ?>">
                      <?php echo $child->title; ?>
                    </a>
                  </div>
              <?php } ?>
            </div>
          <?php } ?>
        <?php the_content(); ?>
      </div>
    </div>
    <?php get_template_part('side', 'menu'); ?>
  </div>
</div>

<?php get_footer(); ?>