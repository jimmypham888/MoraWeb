<?php
    
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

add_action( 'single_resume_head', 'moranow_booking', 130 );
function moranow_booking() { ?>
	<?php if (get_queried_object_id() != get_option( 'resume_manager_submit_resume_form_page_id' )) : ?>
    <div class="booking-button">
        <a href="#"><?php esc_html_e( 'Đặt lịch hẹn', 'moranow' ); ?><i class="la la-calendar"></i></a>
	</div>
<?php 
	endif;
}