<?php

add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {
	wp_enqueue_style( 'mora-style', get_stylesheet_directory_uri() . '/style.css', array( 'avada-stylesheet' ) );

	wp_enqueue_script( 'mora-script',
		get_stylesheet_directory_uri() . '/assets/js/script.js',
			array( 'jquery' ),
			null,
			true );

	$whitelist = array(
		'127.0.0.1',
		'::1'
	);
	
	if ( in_array($_SERVER['REMOTE_ADDR'], $whitelist) ) {
		// Enqueue BS Script for Dev.
		$url = sprintf( 'http://%s:3000/browser-sync/browser-sync-client.js', $_SERVER['SERVER_NAME'] );
		$ch  = curl_init();
		curl_setopt( $ch, CURLOPT_URL, $url );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
		$header = curl_exec( $ch );
		curl_close( $ch );
		if ( $header && strpos( $header[0], '400' ) === false ) {
			wp_enqueue_script( '__bs_script__', $url, array(), null, true );
		}
	}
}

add_action( 'after_setup_theme', 'moranow_setup' );
function moranow_setup() {

	// Topbar
	add_filter( 'jobhunt_register_nav_menus', function() {
		return array(
			'primary-nav'		    => esc_html__( 'Primary Menu', 'jobhunt' ),
			'handheld'				=> esc_html__( 'Handheld Menu', 'jobhunt' ),
		);
	});
	remove_action( 'jobhunt_top_bar', 'jobhunt_top_bar', 10 );

	// Header
	remove_action( 'jobhunt_header_v2', 'jobhunt_post_a_job', 30 );
	remove_action( 'jobhunt_header_v2', 'jobhunt_secondary_nav', 40 );

	add_action( 'jobhunt_header_v2', 'jobhunt_secondary_nav', 30 );

	add_filter( 'jobhunt_secondary_nav_menu_titles', function( $menu_titles ) {
		$menu_titles['user_page_text'] = wp_get_current_user()->display_name;
		return $menu_titles;
	});
}

add_action( 'widgets_init', 'moranow_widgets_init' );
function moranow_widgets_init() {
	register_sidebar ( array (
		'name'          => __( 'Top bar Widget Area', 'moranow' ),
		'id'            => 'sidebar-topbar',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<span class="gamma widget-title">',
		'after_title'   => '</span>',
	) );
}

add_action( 'jobhunt_top_bar', 'moranow_top_bar', 10 );
function moranow_top_bar() {
	if ( apply_filters( 'jobhunt_enable_top_bar', true ) ) : ?>
	<div class="top-bar">
		<div class="container">
			<div class="top-bar-inner"><?php
				dynamic_sidebar( 'sidebar-topbar' );
			?></div><!-- /.top-bar-inner -->
		</div>
	</div><!-- /.top-bar1 --><?php endif;
}

add_action( 'jobhunt_header_v2', 'moranow_submit_resume', 40 );
function moranow_submit_resume() {
	if ( apply_filters( 'jobhunt_header_post_a_job_button', true ) && jobhunt_is_wp_job_manager_activated() ) :
		$post_a_job_url = apply_filters( 'jobhunt_header_post_a_job_button_url', get_permalink( get_option( 'job_manager_submit_job_form_page_id' ) ) );
		$post_a_job_icon = apply_filters( 'jobhunt_header_post_a_job_button_icon', 'la la-plus' );
		$post_a_job_text = apply_filters( 'jobhunt_header_post_a_job_button_text', esc_html__( 'Post A Job', 'jobhunt' ) );
		?>
		<div class="submit-resume">
			<a href="<?php echo esc_url( $post_a_job_url ); ?>">
				<?php echo esc_html( $post_a_job_text ); ?>
			</a>
		</div><?php
	endif;
}