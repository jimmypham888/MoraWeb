<?php
/**
 * Counselor Block
 *
 * @author  Moranow
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

$block_class = empty( $block_class ) ? 'counselor-block' : 'counselor-block ' . $el_class;

$block_class .= ' columns-' . $columns;

$args = array(
    'post_type'       => 'resume',
    'posts_per_page'  => $perpage,
    'post_status'     => 'publish'
);

$counselors = new WP_Query($args);

?>
<div class="<?php echo esc_attr( $block_class ); ?>" <?php if ( !empty( $animation ) ) : ?>data-animation="<?php echo esc_attr( $animation );?>"<?php endif; ?>>
    <?php if ( $counselors->have_posts() ) : ?>
        <?php while ( $counselors->have_posts() ) : ?>
            <?php $counselors->the_post(); ?>
            <div class="counselor-wrapper">
                <div class="counselor-inner">
                    <a href="<?php echo esc_url(get_permalink( get_the_ID() )); ?>">
                    <img src="<?php echo esc_url(get_post_meta( get_the_ID(), '_candidate_photo', true )); ?>" alt="" class="counselor-image" />
                    </a>
                    <div class="counselor-info">
                        <h4 class="counselor-name">
                            <a href="<?php echo esc_url(get_permalink( get_the_ID() )); ?>"><?php the_title(); ?></a>
                        </h4>
                        <p class="counselor-title"><?php echo get_post_meta( get_the_ID(), '_candidate_title', true );?></p>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    <?php endif; ?>
</div>
