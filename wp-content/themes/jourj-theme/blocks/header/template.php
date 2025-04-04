<?php
$logo = get_template_directory_uri() . '/assets/img/logo-rebecca-et-aurelien.svg';

$allowed_blocks = array(
    'core/navigation',
    'core/buttons',
    'core/button',
);
?>

<div class="jo-block-header">
    <div class="jo-block-header__container">
        <a href="<?php echo esc_url(home_url('/')); ?>" class="jo-block-header__logo">
            <img src="<?php echo esc_url($logo); ?>" alt="Logo Rebecca et Aurélien" class="jo-block-header__logo-img" />
        </a>

        <InnerBlocks
            allowedBlocks="<?php echo esc_attr(wp_json_encode($allowed_blocks)); ?>"
            className="jo-block-header__innerblocks" />

        <button class="jo-block-header__burger">
            <span>Menu</span>
            <div class="jo-block-header__burger--icon">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </button>
    </div>
</div>