<?php

# Remove Rank Math metabox on "jourj_gift" post type
add_action('add_meta_boxes', function () {
    remove_meta_box('rank_math_metabox', 'jourj_gift', 'normal');
}, 20);
