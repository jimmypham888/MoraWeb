<?php
/**
 * Benefit Block
 *
 * @author  Moranow
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

$block_class = empty( $block_class ) ? 'benefit-block' : 'benefit-block ' . $el_class;

$link_array = explode('|', $button_link);

?>
<div class="<?php echo esc_attr( $block_class ); ?>" <?php if ( !empty( $animation ) ) : ?>data-animation="<?php echo esc_attr( $animation );?>"<?php endif; ?>>
    <div class="benefit-block-inner">
        <?php if ($image) : ?>
            <div class="benefit-block-image" style="background-image:url(<?php echo esc_url(wp_get_attachment_image_src($image, 'full')[0]) ?>)">
                <img src="<?php echo esc_url(wp_get_attachment_image_src($image, 'full')[0]); ?>" alt="">
            </div>
        <?php endif; ?>
        <div class="benefit-block-text">
            <?php if ($block_title): ?>
                <h3 class="benefit-block-title"><?php echo $block_title; ?></h3>
            <?php endif; ?>
            <?php if ($content): ?>
                <div class="benefit-block-content">
                    <?php echo $content; ?>
                </div>
            <?php endif; ?>
            <?php if ($link_array[0]): ?>
                <a class="benefit-block-button" href="<?php echo esc_url($link_array[0]); ?>" target="<?php echo esc_attr($link_array[2] ? $link_array : '_self'); ?>">
                    <?php echo $link_array[1] ? $link_array[1] : $button_text; ?></a>
            <?php endif; ?>
        </div>
    </div>
</div>
