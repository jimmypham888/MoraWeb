<?php

// Enqueue styles
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

// Customize hooks
add_action( 'after_setup_theme', 'moranow_update_hooks' );
function moranow_update_hooks() {
	remove_action( 'jobhunt_top_bar', 'jobhunt_top_bar', 10 );

	// Header
	remove_action( 'jobhunt_header_v2', 'jobhunt_post_a_job', 30 );
	remove_action( 'jobhunt_header_v2', 'jobhunt_secondary_nav', 40 );

	add_action( 'jobhunt_header_v2', 'jobhunt_secondary_nav', 30 );

	// Homepage
	remove_action( 'jobhunt_before_homepage_v1', 'jobhunt_home_v1_hook_control', 	  10 );
	remove_action( 'jobhunt_homepage_v1', 'jobhunt_home_v1_job_categories_block',     20 );
	remove_action( 'jobhunt_homepage_v1', 'jobhunt_home_v1_banner_v1',                30 );
	remove_action( 'jobhunt_homepage_v1', 'jobhunt_home_v1_job_list_block',           40 );
	remove_action( 'jobhunt_homepage_v1', 'jobhunt_home_v1_testimonial_block',        50 );
	remove_action( 'jobhunt_homepage_v1', 'jobhunt_home_v1_company_info_carousel',    60 );
	remove_action( 'jobhunt_homepage_v1', 'jobhunt_home_v1_recent_posts',             70 );
	remove_action( 'jobhunt_homepage_v1', 'jobhunt_home_v1_banner_v2',                80 );
	
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

// Top bar
add_filter( 'jobhunt_register_nav_menus', 'moranow_register_nav_menus');
function moranow_register_nav_menus() {
	return array(
		'primary-nav'		    => esc_html__( 'Primary Menu', 'jobhunt' ),
		'handheld'				=> esc_html__( 'Handheld Menu', 'jobhunt' ),
	);
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

// Header
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

add_filter( 'jobhunt_secondary_nav_menu_titles', 'moranow_secondary_nav_menu_titles', 10, 1 );
function moranow_secondary_nav_menu_titles( $menu_titles ) {
	$menu_titles['user_page_text'] = wp_get_current_user()->display_name;
	return $menu_titles;
}

// Home page
add_filter( 'jobhunt_home_v1_data_tabs', 'moranow_home_v1_data_tabs', 10, 1 );
function moranow_home_v1_data_tabs( $tabs ) {
	unset( $tabs['job_categories_block'] );
	unset( $tabs['banner_v1'] );
	unset( $tabs['job_list_block'] );
	unset( $tabs['testimonial_block'] );
	unset( $tabs['company_info_carousel'] );
	unset( $tabs['recent_posts'] );
	unset( $tabs['banner_v2'] );
	return $tabs;
}

add_action( 'jobhunt_before_homepage_v1', 'moranow_home_v1_hook_control', 10 );
function moranow_home_v1_hook_control() {
	if( is_page_template( array( 'template-homepage-v1.php' ) ) ) {
		remove_all_actions( 'jobhunt_homepage_v1' );

		$home_v1 = jobhunt_get_home_v1_meta();

		add_action( 'jobhunt_homepage_v1',  'jobhunt_homepage_content', isset( $home_v1['hpc']['priority'] ) ? intval( $home_v1['hpc']['priority'] ) : 10 );
	}
}