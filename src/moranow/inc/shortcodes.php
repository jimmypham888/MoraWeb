<?php

add_shortcode( 'moranow_how_it_works_block' , 'moranow_how_it_works_block_element' );
if ( ! function_exists( 'moranow_how_it_works_block_element' ) ) {

    function moranow_how_it_works_block_element( $atts, $content = null ){

        extract(shortcode_atts(array(
            'section_title'     => '',
            'sub_title'         => '',
            'type'              => '',
            'icon_1'            => '',
            'step_title_1'      => '',
            'step_desc_1'       => '',
            'icon_2'            => '',
            'step_title_2'      => '',
            'step_desc_2'       => '',
            'icon_3'            => '',
            'step_title_3'      => '',
            'step_desc_3'       => '',
            'icon_4'            => '',
            'step_title_4'      => '',
            'step_desc_4'       => '',
            'icon_5'            => '',
            'step_title_5'      => '',
            'step_desc_5'       => '',
            'el_class'          => '',
        ), $atts));

        $steps_arr = array();

        $steps_arr[0] = array(
            'icon'              => $icon_1,
            'step_title'        => $step_title_1,
            'step_desc'         => $step_desc_1,
        );

        $steps_arr[1] = array(
            'icon'              => $icon_2,
            'step_title'        => $step_title_2,
            'step_desc'         => $step_desc_2,
        );

        $steps_arr[2] = array(
            'icon'              => $icon_3,
            'step_title'        => $step_title_3,
            'step_desc'         => $step_desc_3,
        );

        $steps_arr[3] = array(
            'icon'              => $icon_4,
            'step_title'        => $step_title_4,
            'step_desc'         => $step_desc_4,
        );

        $steps_arr[4] = array(
            'icon'              => $icon_5,
            'step_title'        => $step_title_5,
            'step_desc'         => $step_desc_5,
        );

        $args = array(
            'section_title'     => $section_title,
            'sub_title'         => $sub_title,
            'type'              => $type,
            'steps'             => $steps_arr,
            'section_class'     => $el_class
        );

        $html = '';
        if( function_exists( 'jobhunt_how_it_works_block' ) ) {
            ob_start();
            jobhunt_how_it_works_block( $args );
            $html = ob_get_clean();
        }

        return $html;
    }
}
