<?php get_header(); ?>

<div class="mb-4">
  <?php get_template_part('breadcrumbs'); ?>
  <div class="row">
    <div class="mt-5 col-9">
      <div class="post-top-section d-flex">
        <div class="text-primary">
          <h1 class="primary-font bold">
            <?php the_title(); ?>
          </h1>
        </div>
      </div>
      <div class="mt-4 me-5 secondary-font text-primary post-content">
        <?php the_content(); ?>
      </div>
    </div>
    <?php get_template_part('side', 'menu'); ?>
  </div>
</div>

<?php get_footer(); ?>
