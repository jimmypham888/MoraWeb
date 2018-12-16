<?php

$kc = KingComposer::globe();

$shortcode_params['moranow_how_it_works_block'] = array(
    'name' => esc_html__( 'How It Works Block (by Moranow)', 'moranow' ),
    'description' => esc_html__( 'How It Works Block', 'moranow' ),
    'category' => esc_html__( 'Moranow Elements', 'moranow' ),
    'icon' => 'jobhunt-element-icon',
    'title' => esc_html__( 'How It Works Block Settings', 'moranow' ),
    'is_container' => true,
    'params' => array(
        array(
            'name'          => 'section_title',
            'label'         => esc_html__('Section Title', 'moranow'),
            'type'          => 'text',
            'description'   => esc_html__('Enter section title.', 'moranow'),
            'admin_label'   => true
        ),
        array(
            'name'          => 'sub_title',
            'label'         => esc_html__('Enter Subtitle', 'moranow'),
            'type'          => 'textarea',
            'description'   => esc_html__('Enter subtitle', 'moranow')
        ),
        array(
            'name'          => 'type',
            'label'         => esc_html__( 'Select Version', 'moranow' ),
            'type'          => 'select',
            'options'       => array(
                'v1'         => esc_html__( 'v1','moranow'),
                'v2'         => esc_html__( 'v2','moranow'),
                'v3'         => esc_html__( 'v3','moranow'),
                'v4'         => esc_html__( 'v4','moranow'),
            )
        ),
        array(
            'name'          => 'icon_1',
            'label'         => esc_html__('Step 1 Icon', 'moranow'),
            'type'          => 'icon_picker',
            'description'   => esc_html__('Enter step 1 icon class.', 'moranow')
        ),
        array(
            'name'          => 'step_title_1',
            'label'         => esc_html__('Step 1 Title', 'moranow'),
            'type'          => 'text',
            'description'   => esc_html__('Enter step 1 title.', 'moranow')
        ),
        array(
            'name'          => 'step_desc_1',
            'label'         => esc_html__('Step 1 Description', 'moranow'),
            'type'          => 'textarea',
            'description'   => esc_html__('Enter step 1 description.', 'moranow')
        ),
        array(
            'name'          => 'icon_2',
            'label'         => esc_html__('Step 2 Icon', 'moranow'),
            'type'          => 'icon_picker',
            'description'   => esc_html__('Enter step 2 icon class.', 'moranow')
        ),
        array(
            'name'          => 'step_title_2',
            'label'         => esc_html__('Step 2 Title', 'moranow'),
            'type'          => 'text',
            'description'   => esc_html__('Enter step 2 title.', 'moranow')
        ),
        array(
            'name'          => 'step_desc_2',
            'label'         => esc_html__('Step 2 Description', 'moranow'),
            'type'          => 'textarea',
            'description'   => esc_html__('Enter step 2 description.', 'moranow'),
        ),
        array(
            'name'          => 'icon_3',
            'label'         => esc_html__('Step 3 Icon', 'moranow'),
            'type'          => 'icon_picker',
            'description'   => esc_html__('Enter step 3 icon class.', 'moranow'),
        ),
        array(
            'name'          => 'step_title_3',
            'label'         => esc_html__('Step 3 Title', 'moranow'),
            'type'          => 'text',
            'description'   => esc_html__('Enter step 3 title.', 'moranow'),
        ),
        array(
            'name'          => 'step_desc_3',
            'label'         => esc_html__('Step 3 Description', 'moranow'),
            'type'          => 'textarea',
            'description'   => esc_html__('Enter step 3 description.', 'moranow'),
        ),
        array(
            'name'          => 'icon_4',
            'label'         => esc_html__('Step 4 Icon', 'moranow'),
            'type'          => 'icon_picker',
            'description'   => esc_html__('Enter step 4 icon class.', 'moranow'),
        ),
        array(
            'name'          => 'step_title_4',
            'label'         => esc_html__('Step 4 Title', 'moranow'),
            'type'          => 'text',
            'description'   => esc_html__('Enter step 4 title.', 'moranow'),
        ),
        array(
            'name'          => 'step_desc_4',
            'label'         => esc_html__('Step 4 Description', 'moranow'),
            'type'          => 'textarea',
            'description'   => esc_html__('Enter step 4 description.', 'moranow'),
        ),
        array(
            'name'          => 'icon_5',
            'label'         => esc_html__('Step 5 Icon', 'moranow'),
            'type'          => 'icon_picker',
            'description'   => esc_html__('Enter step 5 icon class.', 'moranow')
        ),
        array(
            'name'          => 'step_title_5',
            'label'         => esc_html__('Step 5 Title', 'moranow'),
            'type'          => 'text',
            'description'   => esc_html__('Enter step 5 title.', 'moranow')
        ),
        array(
            'name'          => 'step_desc_5',
            'label'         => esc_html__('Step 5 Description', 'moranow'),
            'type'          => 'textarea',
            'description'   => esc_html__('Enter step 5 description.', 'moranow')
        ),
        array(
            'name'          => 'el_class',
            'label'         => esc_html__('Extra class name', 'moranow'),
            'type'          => 'text',
            'description'   => esc_html__('If you wish to style particular content element differently, please add a class name to this field and refer to it in your custom CSS file.', 'moranow')
        )
    ),
);

$shortcode_params['moranow_benefit_block'] = array(
    'name' => esc_html__( 'Benefit Block (by Moranow)', 'moranow' ),
    'description' => esc_html__( 'Benefit Block', 'moranow' ),
    'category' => esc_html__( 'Moranow Elements', 'moranow' ),
    'icon' => '',
    'title' => esc_html__( 'Benefit Block Settings', 'moranow' ),
    'is_container' => true,
    'params' => array(
        array(
            'name'          => 'image',
            'type'          => 'attach_image',
            'label'         => esc_html__( 'Image', 'moranow' ),
            'admin_label'   => true
        ),
        array(
            'name'          => 'block_title',
            'label'         => esc_html__('Title', 'moranow'),
            'type'          => 'text',
            'description'   => esc_html__('Enter block title.', 'moranow'),
            'admin_label'   => true
        ),
        array(
            'name'          => 'content',
            'label'         => esc_html__('Enter description', 'moranow'),
            'type'          => 'textarea_html',
            'description'   => esc_html__('Enter description', 'moranow')
        ),
        array(
            'name'          => 'button_text',
            'label'         => esc_html__('Button Text', 'moranow'),
            'type'          => 'text',
            'description'   => esc_html__('Enter button text.', 'moranow'),
        ),
        array(
            'name'          => 'button_link',
            'label'         => esc_html__('Button Link', 'moranow'),
            'type'          => 'link',
            'description'   => esc_html__('Enter button text.', 'moranow'),
        ),
        array(
            'name'          => 'el_class',
            'label'         => esc_html__('Extra class name', 'moranow'),
            'type'          => 'text',
            'description'   => esc_html__('If you wish to style particular content element differently, please add a class name to this field and refer to it in your custom CSS file.', 'moranow')
        )
    )
);

$shortcode_params['moranow_counselor_block'] = array(
    'name' => esc_html__( 'Counselor Block (by Moranow)', 'moranow' ),
    'description' => esc_html__( 'Counselor Block', 'moranow' ),
    'category' => esc_html__( 'Moranow Elements', 'moranow' ),
    'icon' => '',
    'title' => esc_html__( 'Counselor Block Settings', 'moranow' ),
    'params' => array(
        array(
            'name'          => 'perpage',
            'label'         => esc_html__('Number of counselor', 'moranow'),
            'value'         => 8,
            'type'          => 'text',
        ),
        array(
            'name'          => 'columns',
            'label'         => esc_html__('Columns', 'moranow'),
            'type'          => 'number_slider',
            'options' => array(
                'min'        => 3,
                'max'        => 5,
                'show_input' => true
            ),
            'value'         => 4,
            'description'   => esc_html__('Enter number of columns', 'moranow'),
            'admin_label'   => true
        ),
        array(
            'name'          => 'el_class',
            'label'         => esc_html__('Extra class name', 'moranow'),
            'type'          => 'text',
            'description'   => esc_html__('If you wish to style particular content element differently, please add a class name to this field and refer to it in your custom CSS file.', 'moranow')
        )
    )
);

$kc->add_map( $shortcode_params );