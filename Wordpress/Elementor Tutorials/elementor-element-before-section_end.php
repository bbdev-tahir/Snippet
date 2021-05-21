<?php
// This example will add a custom "select" drop down & "switcher" to the "testimonial" section
// and add custom "color" to the "testimonial style" section
add_action('elementor/element/before_section_end', 'add_control_in_existing_widget', 10, 3 );
function add_control_in_existing_widget( $section, $section_id, $args ) {
	if( $section->get_name() == 'testimonial' && $section_id == 'section_testimonial' ){
		// we are at the end of the "section_testimonial" area of the "testimonial"
		$section->add_control(
			'testimonial_name_title_pos' ,
			[
				'label'        => 'Name and title position',
				'type'         => Elementor\Controls_Manager::SELECT,
				'default'      => 'vertical',
				'options'      => array(
					'vertical' => 'Vertical',
					'horizontal' => 'Horizontal'
				),
				'prefix_class' => 'dgm-testimonial-name-title-',
				'label_block'  => true,
				'condition'  => [
					'testimonial_image_position' => 'aside',
				]
			]
		);
	}
	if( $section->get_name() == 'testimonial' && $section_id == 'section_style_testimonial_content' ){
		// we are at the end of the "section_testimonial" area of the "testimonial"
		$section->add_control(
			'testimonial_content_border_bottom' ,
			[
				'label'        => 'Border Bottom',
				'type'         => Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'your-plugin' ),
				'label_off' => __( 'Hide', 'your-plugin' ),
				'return_value' => 'border_bottom',
				'default' => 'yes',
			]
		);
		$section->add_control(
			'testimonial_content_border_color' ,
			[
				'label'        => 'Border Color',
				'type'         => Elementor\Controls_Manager::COLOR,
				'label_block'  => true,
				'default'  => '#ECF0F8',
				'selectors' => [
					// Stronger selector to avoid section style from overwriting
					'{{WRAPPER}} .elementor-testimonial-content.border_bottom' => 'border-bottom-color: {{VALUE}};',
				],
				'condition'  => [
					'testimonial_content_border_bottom' => 'border_bottom',
				]
			]
		);
	}
}

// This example will add a render 'class' attribute to the testimonial content
add_action( 'elementor/widget/before_render_content', 'custom_render_to_testimonial' );
function custom_render_to_testimonial( $testimonial ) {
	//Check if we are on a testimonial
	if( 'testimonial' === $testimonial->get_name() ) {
		// Get the settings
		$settings = $testimonial->get_settings();
		// Adding our type as a class to the testimonial
		if( $settings['testimonial_content_border_bottom'] ) {
			$testimonial->add_render_attribute( 'testimonial_content', 'class', $settings['testimonial_content_border_bottom'], true );
		}
	}
}