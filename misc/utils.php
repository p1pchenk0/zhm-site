<?php
  function zhm_get_header_socials() {
    $yt_link = get_theme_mod('youtube_link');
    $fb_link = get_theme_mod('facebook_link');

    ob_start();

    ?>
      <div class="header-socials align-items-center">
        <div class="color-blind-wrapper d-flex pointer" id="colorBlindToggle">
          <?php echo zhm_get_icon('color-blind'); ?>
          <span class="color-blind-text bold primary-font" id="colorBlindText">
            Людям із порушенням зору
          </span>
        </div>
      <?php if (!empty($yt_link)) { ?>
        <a href="<?php echo $yt_link; ?>" target="_blank">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 42 42"><path d="M31,12.58a3.19,3.19,0,0,1,2.26,2.26A31.81,31.81,0,0,1,33.83,21a33.72,33.72,0,0,1-.53,6.18A3.19,3.19,0,0,1,31,29.47C29,30,21,30,21,30s-8,0-10-.55a3.19,3.19,0,0,1-2.3-2.26A33.75,33.75,0,0,1,8.17,21a33.61,33.61,0,0,1,.53-6.17A3.24,3.24,0,0,1,11,12.56C13,12,21,12,21,12S29,12,31,12.58ZM25.12,21l-6.68,3.85V17.17Z" style="fill-rule:evenodd"/><path d="M40,2V40H2V2H40m2-2H0V42H42V0Z"/></svg>
        </a>
      <?php } ?>
      <?php if (!empty($fb_link)) { ?>
        <a href="<?php echo $fb_link; ?>" target="_blank">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 42 42"><path d="M18.56,32.67V22.75H15.17V18.81h3.39v-3.1c0-3.37,2.1-5.21,5.17-5.21a29.12,29.12,0,0,1,3.1.16v3.52H24.7c-1.67,0-2,.78-2,1.92v2.71h3.77L26,22.75H22.71v9.92"/><path d="M40,2V40H2V2H40m2-2H0V42H42V0Z"/></svg>
        </a>
      <?php } ?>
      </div>
    <?php

    return ob_get_clean();
  }

  function zhm_get_reading_time($content) {
    $words_per_minute = 150;
    $words_count = count(explode(' ', $content));
    $time = (int) ($words_count / $words_per_minute);

    return $time > 1 ? $time : 1;
  }

  function zhm_get_id_by_slug($page_slug) {
    $page = get_page_by_path($page_slug);

    return $page ? $page->ID : null;
  }

  function zhm_get_date($raw_date) {
    $months = [
      'Січня',
      'Лютого',
      'Березня',
      'Квітня',
      'Травня',
      'Червня',
      'Липня',
      'Серпня',
      'Вересня',
      'Жовтня',
      'Листопада',
      'Грудня'
    ];

    $date = new DateTime($raw_date);

    $day = $date->format('d');
    $month = $months[$date->format('m') - 1];
    $year = $date->format('Y');

    return $day . " " . $month . " " . $year;
  }

  function zhm_get_arrow() {
    return '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 70.35 18.38"><polygon points="70.35 9.19 61.15 0 61.15 6.69 0 6.69 0 11.69 61.15 11.69 61.15 18.39 70.35 9.19"/></svg>';
  }

  function zhm_get_short_arrow() {
    return '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 19 19"><polygon points="0 0 0 7 9.15 7 9.15 0.31 18.35 9.5 9.15 18.69 9.15 12 0 12 0 19 19 19 19 0 0 0" style="fill:none"/><polygon points="9.15 18.69 18.35 9.5 9.15 0.31 9.15 7 0 7 0 12 9.15 12 9.15 18.69"/></svg>';
  }

  function zhm_get_icon($icon_name) {
    if ($icon_name === 'color-blind') {
      return '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 89.65 67.08"><path d="M94.4,49.23c-1.62-2.6-3.14-5.27-4.88-7.79a47.82,47.82,0,0,0-7-8,1.57,1.57,0,0,0-.25.16q-6.77,6.77-13.51,13.53a1.38,1.38,0,0,0-.26.84A47.17,47.17,0,0,1,68.32,53,18.52,18.52,0,0,1,48.17,68.61a1.6,1.6,0,0,0-1.51.54c-2.79,2.83-5.61,5.64-8.42,8.45l-.61.64.71.21a45.39,45.39,0,0,0,16.33,1.27,46,46,0,0,0,19.16-6.5A54.52,54.52,0,0,0,92.17,54.73c.91-1.48,1.77-3,2.65-4.51v-.35C94.68,49.66,94.53,49.45,94.4,49.23Z" transform="translate(-5.18 -16.46)"/><path d="M78.18,16.46c-2.46,2.46-5,4.92-7.39,7.44a1.46,1.46,0,0,1-2,.39,44.61,44.61,0,0,0-23.56-3.92,46.26,46.26,0,0,0-21.83,8.16,56.18,56.18,0,0,0-18.13,21,1.27,1.27,0,0,0,0,1,56.84,56.84,0,0,0,14.14,17.9c1.21,1,2.46,2,3.74,3l-6.82,6.79,5.19,5.32L83.41,21.67ZM55.06,39.55a1.09,1.09,0,0,1-1,.11,11.09,11.09,0,0,0-13.27,3.82,10.69,10.69,0,0,0-1.31,10.64,1,1,0,0,1-.24,1.29C37.63,57,36,58.62,34.43,60.24c-4-5-5-14.91,1.11-22.18a18.52,18.52,0,0,1,24.61-3.54C58.43,36.23,56.77,37.92,55.06,39.55Z" transform="translate(-5.18 -16.46)"/></svg>';
    }

    if ($icon_name === 'close') {
      return '<?xml version="1.0" encoding="utf-8"?><svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 89 89" xml:space="preserve"><g><polygon points="81.98,14.8 74.2,7.02 44.5,36.72 14.8,7.02 7.02,14.8 36.72,44.5 7.02,74.2 14.8,81.98 44.5,52.28 74.2,81.98 81.98,74.2 52.28,44.5"/></g></svg>';
    }
  }

  function zhm_get_title($text, $extra_classes = '') {
    ob_start(); ?>

    <h2 class="secondary-font text-primary bold mt-3 mt-md-5 mb-0 <?php echo $extra_classes; ?>">
      <?php echo $text; ?>
    </h2>

  <?php
    return ob_get_clean();
  }

  function zhm_get_button($text, $link, $extra_classes = '') {
    $arrow = zhm_get_arrow();

    ob_start(); ?>

    <a
      href="<?php echo $link; ?>"
      class="link-button <?php echo $extra_classes; ?>"
    >
      <span><?php echo $text; ?></span>
      <span class="ms-3"><?php echo $arrow; ?></span>
    </a>

    <?php

    return ob_get_clean();
  }
