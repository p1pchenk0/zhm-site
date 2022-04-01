<?php get_header(); ?>

<div class="mb-lg-4">
  <?php get_template_part('breadcrumbs'); ?>
  <div class="row">
    <div class="mt-3 mt-lg-5 col-lg-9 col-sm-12">
      <div class="post-top-section d-flex">
        <div
          class="post-main-image me-lg-4"
          style="background-image: url(<?php echo get_the_post_thumbnail_url(); ?>)"
        >
        </div>
        <div class="text-primary">
          <div class="post-date mt-2 mt-lg-0 mb-3 secondary-font bold">
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
      <div class="mt-4 me-lg-5 secondary-font text-primary post-content">
        <?php the_content(); ?>
      </div>
      <?php
    $prev_post = get_previous_post();
    $next_post = get_next_post();

    if ($prev_post || $next_post) {
  ?>
    <?php echo zhm_get_title('Інші новини'); ?>
  <?php } ?>
  <div class="row mt-3 me-lg-5 other-posts primary-font bold justify-content-between">
    <?php if ($prev_post) { ?>
      <a
        href="<?php echo get_permalink($prev_post->ID) ?>"
        class="prev-post d-flex"
        style="background-image: url(<?php echo get_the_post_thumbnail_url($prev_post->ID); ?>);"
      >
        <span class="post-frame d-flex full-height">
          <?php echo zhm_get_arrow(); ?>
          <span class="d-flex align-self-center other-post-title">
            <?php echo $prev_post->post_title; ?>
          </span>
        </span>
        <span class="fx"></span>
      </a>
    <?php } ?>
    <?php if ($next_post) { ?>
      <a
        href="<?php echo get_permalink($next_post->ID) ?>"
        class="next-post d-flex"
        style="background-image: url(<?php echo get_the_post_thumbnail_url($next_post->ID); ?>);"
      >
        <span class="post-frame d-flex full-height">
          <span class="d-flex align-self-center other-post-title">
            <?php echo $next_post->post_title; ?>
          </span>
          <?php echo zhm_get_arrow(); ?>
        </span>
        <span class="fx"></span>
      </a>
    <?php } ?>
  </div>
    </div>
    <?php get_template_part('side', 'menu'); ?>
  </div>
</div>

<?php get_footer(); ?>
