<div class="breadcrumbs mt-3 secondary-font text-primary bold">
  <a href="<?php echo esc_url(home_url('/')); ?>">Головна</a>
  <?php echo zhm_get_arrow(); ?>
  <?php if (is_search()) { ?>
    <span>
      Результати пошуку
    </span>
  <?php } ?>
  <?php if (is_single()) { ?>
    <a href="<?php echo get_permalink(zhm_get_id_by_slug('news')); ?>">Новини</a>
    <?php echo zhm_get_arrow(); ?>
  <?php } ?>
  <?php if (is_page() || is_single()) { ?>
    <span>
      <?php the_title(); ?>
    </span>
  <?php } ?>
</div>
