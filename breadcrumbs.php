<div
  class="breadcrumbs mt-3 secondary-font text-primary bold"
  itemscope
  itemtype="https://schema.org/BreadcrumbList"
>
  <span
    itemprop="itemListElement"
    itemscope
    itemtype="https://schema.org/ListItem"
  >
    <a
      itemprop="item"
      href="<?php echo esc_url(home_url('/')); ?>"
    >
      <span itemprop="name">Головна</span>
      <meta itemprop="position" content="1" />
    </a>
  </span>
  <?php echo zhm_get_arrow(); ?>
  <?php if (is_search()) { ?>
    <span>
      Результати пошуку
    </span>
  <?php } ?>
  <?php if (is_single()) { ?>
    <span
      itemprop="itemListElement"
      itemscope
      itemtype="https://schema.org/ListItem"
    >
      <a
        itemprop="item"
        href="<?php echo get_permalink(zhm_get_id_by_slug('news')); ?>"
      >
        <span itemprop="name">Новини</span>
        <meta itemprop="position" content="2" />
      </a>
    </span>
    <?php echo zhm_get_arrow(); ?>
  <?php } ?>
  <?php 
    $itemsCount = null;

    if (is_page()) {
    
    $items = zhm_get_menu_item_hierarchy(get_the_ID(), zhm_get_menu_items_by_registered_slug('primary'));
    $itemsCount = count($items);
    $i = 0;

    while ($i < $itemsCount) {
      $current_item = $items[$i];

      if ($i != $itemsCount - 1) {
        ?>
        <span
          itemprop="itemListElement"
          itemscope
          itemtype="https://schema.org/ListItem"
        >
          <a
            itemprop="item"
            href="<?php echo esc_url($current_item->url); ?>"
          >
            <span itemprop="name"><?php echo $current_item->title; ?></span>
            <meta itemprop="position" content="<?php echo $i + 2; ?>" />
          </a>
        </span>
        <?php echo zhm_get_arrow(); ?>
        <?php
      } else { ?>
        <span>
          <?php echo $current_item->title; ?>
        </span>
    <?php
      }

      $i++;
    }
  } ?>
  <?php if (is_single() || is_page('news') || (is_page() && !$itemsCount)) { ?>
    <span>
      <?php the_title(); ?>
    </span>
  <?php } ?>
</div>