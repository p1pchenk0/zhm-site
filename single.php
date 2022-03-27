<?php get_header(); ?>

<div class="mb-4">
  <?php get_template_part('breadcrumbs'); ?>
  <div class="row">
    <div class="mt-5 col-9">
      <div class="post-top-section d-flex">
        <div
          class="post-main-image me-4"
          style="background-image: url(<?php echo get_the_post_thumbnail_url(); ?>)"
        >
        </div>
        <div class="text-primary">
          <div class="post-date mb-3 secondary-font bold">
            <?php echo zhm_get_date(get_post()->post_date); ?>
          </div>
          <h1 class="primary-font bold">
            <?php the_title(); ?>
          </h1>
          <div class="post-read-time secondary-font bold mt-4">
            <span>Приблизна тривалість читання:&nbsp;<?php echo zhm_get_reading_time(get_the_content()); ?>&nbsp;хв.</span>
          </div>
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
