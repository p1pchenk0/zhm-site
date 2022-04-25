<?php
    echo $_GET['s'];

    $files_query = new WP_Query(array(
        'post_type' => 'zhm_doc',
        'posts_per_page' => 10,
        'paged' => $current_page,
    ));
?>