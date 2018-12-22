<?php 
// Custom contact form 7 counselor select
add_action( 'wpcf7_init', 'custom_counselor_select' );
function custom_counselor_select() {
    wpcf7_add_form_tag( array('counselor_select'), 'custom_counselor_handler', array( 'name-attr' => true ) );
}

function custom_counselor_handler( $tag ) {

    wp_enqueue_style( 'sumoselect', get_stylesheet_directory_uri() . '/assets/libs/sumoselect/sumoselect.min.css' );

	wp_enqueue_script( 'sumoselect',
		get_stylesheet_directory_uri() . '/assets/libs/sumoselect/jquery.sumoselect.min.js',
			array( 'jquery' ),
			null,
			true );

    $atts = array();

    $atts['name']   = $tag->name;
    $atts['class']  = 'moranow-select' . $tag->get_class_option();
    $atts['id']     = $tag->get_id_option();
    $atts           = wpcf7_format_atts( $atts );

    $selected_counselor = isset($_POST['counselor']) ? $_POST['counselor'] : '';

    $html = '<select ' . $atts . '>';
    $html         .= '<option value="-1">---</option>';

    $args = array(
      'post_type'       => 'resume',
      'posts_per_page'  => -1,
    );

    $counselors = get_posts( $args );

    foreach ( $counselors as $counselor ):

        $counselor_id = $counselor->ID;

        $slug         = $counselor->post_name;
        $title        = get_the_title($counselor_id);

        $html         .= '<option value="' . $counselor_id . '"' . ($selected_counselor == $counselor_id ? 'selected="selected"' : '') . ' >' . $title . '</option>';
    endforeach;
    $html .= '</select>';

    return $html;
}