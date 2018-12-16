<?php

require_once 'inc/kc-maps.php';
require_once 'inc/shortcodes.php';

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

	// Resume
	remove_action( 'jobhunt_before_resume_title', 'jobhunt_template_candidate_image', 10 );
	remove_action( 'jobhunt_resume_title', 'jobhunt_template_candidate_info', 30 );
	remove_action( 'jobhunt_after_resume_title', 'jobhunt_template_candidate_view', 50 );
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

add_filter( 'jobhunt_secondary_nav_menu_titles', 'moranow_secondary_nav_menu_titles', 99, 1 );
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

/**
 * Display Search block
 */
function moranow_home_v1_search_block() {

	if ( jobhunt_is_wp_job_manager_activated() ) {

		$home_v1        = jobhunt_get_home_v1_meta();
		$hsb_options    = $home_v1['hsb'];

		$args =  apply_filters( 'jobhunt_home_v1_search_block_args', array(
			'section_class'             => isset( $hsb_options['section_class'] ) ? $hsb_options['section_class'] : '',
			'section_title'             => isset( $hsb_options['section_title'] ) ? $hsb_options['section_title'] : esc_html__( 'The Easiest Way to Get Your New Job', 'jobhunt' ),
			'sub_title'                 => isset( $hsb_options['sub_title'] ) ? $hsb_options['sub_title'] : esc_html__( 'Find Jobs, Employment & Career Opportunities', 'jobhunt' ),
			'search_placeholder_text'   => isset( $hsb_options['search_placeholder_text'] ) ? $hsb_options['search_placeholder_text'] : esc_html__( 'Job title, keywords or company name', 'jobhunt' ),
			'location_placeholder_text' => isset( $hsb_options['location_placeholder_text'] ) ? $hsb_options['location_placeholder_text'] : esc_html__( 'City, province or region', 'jobhunt' ),
			'show_category_select'      => isset( $hsb_options['show_category_select'] ) ? filter_var( $hsb_options['show_category_select'], FILTER_VALIDATE_BOOLEAN ) : false,
			'category_select_text'      => isset( $hsb_options['category_select_text'] ) ? $hsb_options['category_select_text'] : esc_html__( 'Any Category', 'jobhunt' ),
			'show_browse_button'        => isset( $hsb_options['show_browse_button'] ) ? filter_var( $hsb_options['show_browse_button'], FILTER_VALIDATE_BOOLEAN ) : false,
			'browse_button_label'       => isset( $hsb_options['browse_button_label'] ) ? $hsb_options['browse_button_label'] : esc_html__( 'Or browse job offers by', 'jobhunt' ),
			'browse_button_text'        => isset( $hsb_options['browse_button_text'] ) ? $hsb_options['browse_button_text'] : esc_html__( 'Category', 'jobhunt' ),
			'browse_button_link'        => isset( $hsb_options['browse_button_link'] ) ? $hsb_options['browse_button_link'] : '#'
		) );

		moranow_home_search_block( $args );
	}
}

/**
 * Display Search block
 */
function moranow_home_search_block( $args = array() ) {

	if ( jobhunt_is_wp_job_manager_activated() ) {
		$defaults =  apply_filters( 'jobhunt_home_search_block_args', array(
			'section_title'             => '',
			'sub_title'                 => '',
			'section_class'             => '',
			'search_type'               => '',
			'search_placeholder_text'   => esc_html__( 'Job title, keywords or company name', 'jobhunt' ),
			'location_placeholder_text' => esc_html__( 'City, province or region', 'jobhunt' ),
			'category_select_text'      => esc_html__( 'Any Category', 'jobhunt' ),
			'show_category_select'      => true,
			'show_browse_button'        => false,
			'browse_button_label'       => esc_html__( 'Or browse job offers by', 'jobhunt' ),
			'browse_button_text'        => esc_html__( 'Category', 'jobhunt' ),
			'browse_button_link'        => '#'
		) );

		$args = wp_parse_args( $args, $defaults );

		$section_class = empty( $args['section_class'] ) ? 'site-content-page-header' : 'site-content-page-header ' . $args['section_class'];

		?><header class="<?php echo esc_attr( $section_class ); ?>" <?php echo jobhunt_site_content_bg_image(); ?>>

			<div class="site-content-page-header-inner">

				<?php
					do_action( 'jobhunt_home_page_header_before' );

					if( function_exists( 'jobhunt_resume_header_search_block' ) && $args['search_type'] == 'resume' ) {
						jobhunt_resume_header_search_block( $args );
					} else {
						moranow_job_header_search_block( $args );
					}

					do_action( 'jobhunt_home_page_header_after' );
				?>

			</div>

		</header><?php
	}
}

/**
 * Display Job Header Search block
 */
function moranow_job_header_search_block( $args = array() ) {

	$defaults =  apply_filters( 'jobhunt_job_header_search_block_args', array(
		'section_title'             => esc_html__( 'Explore Thousand Of Jobs With Just Simple Search...', 'jobhunt' ),
		'sub_title'                 => '',
		'search_placeholder_text'   => esc_html__( 'Job title, keywords or company name', 'jobhunt' ),
		'location_placeholder_text' => esc_html__( 'City, province or region', 'jobhunt' ),
		'category_select_text'      => esc_html__( 'Any Category', 'jobhunt' ),
		'show_category_select'      => false,
		'show_browse_button'        => false,
		'browse_button_label'       => esc_html__( 'Or browse job offers by', 'jobhunt' ),
		'browse_button_text'        => esc_html__( 'Category', 'jobhunt' ),
		'browse_button_link'        => '#'
	) );

	$args = wp_parse_args( $args, $defaults );

	extract( $args );

	$jobs_page_id = jh_wpjm_get_page_id( 'jobs' );
	$jobs_page_url = get_permalink( $jobs_page_id );

	?><div class="job-search-block">

		<?php do_action( 'jobhunt_job_header_search_block_before' ); ?>

		<?php if ( ! empty( $section_title ) || ! empty( $sub_title ) ) : ?>
		<div class="section-header">
			<?php if ( ! empty( $section_title ) ) : ?>
				<h3 class="section-title"><?php echo esc_html( $section_title ); ?></h3>
			<?php endif; ?>
			<?php if ( ! empty( $sub_title ) ) : ?>
				<span class="section-sub-title"><?php echo esc_html( $sub_title ); ?></span>
			<?php endif; ?>
		</div>
		<?php endif; ?>
		<div class="job-search-form">
			<a href="#">Tìm cố vấn</a>
		</div>
		
		<?php do_action( 'jobhunt_job_header_search_block_after' ); ?>

	</div><?php
}

// Remove unused post type
add_action('init', 'remove_post_type');

function remove_post_type() {
    unregister_post_type( 'company' );
}

// Custom page title
add_filter( 'jobhunt_site_content_page_title', 'moranow_site_content_page_title', 99, 1 );
function moranow_site_content_page_title( $site_content_page_title ) {
	if ( is_post_type_archive( 'resume' ) )  {
		$site_content_page_title = 'Đội ngũ tư vấn';
	}

	return $site_content_page_title;
}

// Content Resume
add_filter( 'resume_manager_resume_fields', 'moranow_admin_resume_form_fields' );
function moranow_admin_resume_form_fields( $fields ) {
	
	$fields['_couselor_age'] = array(
	    'label' 		=> __( 'Age', 'moranow' ),
	    'type' 			=> 'text',
	    'description'	=> '',
	    'priority' 		=> 1
	);

	return $fields;
	
}

add_action( 'jobhunt_before_resume_title', 'moranow_template_candidate_image', 10 );
function moranow_template_candidate_image() {
	?>
	<div class="candidate-image">
		<a href="<?php the_resume_permalink(); ?>">
			<?php the_candidate_photo(); ?>
		</a>
		<h3 class="counselor-name">
			<a href="<?php the_resume_permalink(); ?>"><?php the_title(); ?></a>
		</h3>
		<?php 
			if ($age = get_post_meta( get_the_ID(), '_couselor_age', true ) ) : ?>
			<span class="counselor-age"><?php echo '(' . $age . ' tuổi)'; ?></span>
		<?php endif; ?>
	</div>
	<?php
}

add_action( 'jobhunt_resume_title', 'moranow_template_candidate_info', 30 );
function moranow_template_candidate_info() {
	$education = get_post_meta(get_the_ID(), '_candidate_education', true);

	if (is_array($education)) {
		$edu = $education[0];
	}
	?>
	<div class="counselor-title">
		<i class="la la-user"></i><?php echo 'Nghề nghiệp: ' . get_post_meta(get_the_ID(), '_candidate_title', true); ?>
	</div>
		<?php if (isset($edu)) : ?>
		<div class="counselor-degree">
			<i class="la la-bookmark"></i><?php echo 'Degree: ' . $edu['qualification']; ?>
		</div>
		<div class="counselor-school">
			<i class="la la-graduation-cap"></i><?php echo 'School: ' . $edu['location']; ?>
		</div>
	<?php endif; ?>
	<?php if( ! empty( get_the_candidate_location() ) ) :  ?>
		<div class="location">
			<i class="la la-map-marker"></i>
			<?php echo 'Location: ' . get_the_candidate_location(); ?></div>
	<?php endif;
}

add_action( 'jobhunt_after_resume_title', 'moranow_template_candidate_view', 50 );
function moranow_template_candidate_view() {
	global $post;
	$post = get_post( $post );
	?>
	<div class="view-resume-action">
		<a href="<?php the_resume_permalink(); ?>"><i class="la la-arrow-right"></i><?php echo esc_html__( 'Thông tin', 'jobhunt' ); ?></a>
	</div>
	<?php
}