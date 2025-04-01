<?php

# Register ACF blocks
function jourj_acf_register_blocks()
{
    $block_json_files = glob(get_template_directory() . '/blocks/*/block.json');

    foreach ($block_json_files as $block_json_file) {
        register_block_type($block_json_file);
    };
}
add_action('init', 'jourj_acf_register_blocks');
