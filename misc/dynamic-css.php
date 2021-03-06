<?php
  function zhm_get_dynamic_css_values() {
    global $default_primary_color;
    global $default_header_color;

    $primary_color = !empty(get_theme_mod('primary_color')) ? get_theme_mod('primary_color') : $default_primary_color;
    $header_color = !empty(get_theme_mod('header_color')) ? get_theme_mod('header_color') : $default_header_color;

    ob_start();
    ?>

    .post-meta {
      color: <?php echo $primary_color; ?>;
    }

    .text-primary {
      color: <?php echo $primary_color; ?> !important;
    }

    .link-button, .text-primary a {
      color: <?php echo $primary_color; ?>;
    }

    .link-button svg, .extension-icon svg, .post-view-count svg, .breadcrumbs svg {
      fill: <?php echo $primary_color; ?>;
    }

    .link-button:hover {
      background-color: <?php echo $primary_color; ?>;
    }

    header, #header.sticky, .menu-item a:hover, .breadcrumbs a:hover, footer, .mobile-menu__inner {
      background-color: <?php echo $header_color; ?>;
    }

    .search-button, .other-posts a {
      color: <?php echo $header_color; ?>;
    }

    .dropdown-menu {
      border-color: <?php echo $header_color; ?> !important;
    }

    .other-posts svg {
      fill: <?php echo $header_color; ?>;
    }

    .news-pagination a.page-numbers:hover {
      background-color: <?php echo $primary_color; ?>;
      border-color: <?php echo $primary_color; ?>;
    }
    
    .ui-datepicker,
    .ui-datepicker a,
    .file-search input::placeholder,
    #topBtn,
    .side-link a
     {
      color: <?php echo $primary_color; ?>;
    }

    #topBtn:hover {
      background-color: <?php echo $primary_color; ?>;
    }

    .side-link a:hover {
      border-color: <?php echo $header_color; ?>;
      background-color: <?php echo $header_color; ?>;
      color: white;
    }

    .ui-datepicker-calendar td {
      border-color: <?php echo $primary_color; ?>;
    }

    .ui-datepicker a:hover, a.ui-state-active, .file-search input[type="submit"]:hover {
      background-color: <?php echo $primary_color; ?>;
      color: white !important;
    }

    <?php

    return ob_get_clean();
  }
?>
