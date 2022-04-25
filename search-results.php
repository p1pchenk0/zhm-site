<?php
    $is_doc = $args['is_doc'];
    $query = $args['query'];

    $found_message = $is_doc ? 'За Вашим запитом знайдено документів: %d' : 'За Вашим запитом знайдено результатів: %d';

    if ($query->have_posts()) {
        printf(esc_html($found_message), (int) $query->found_posts);
    } else {
        echo 'Нажаль, за Вашим запитом нічого не знайдено';
    }
?>