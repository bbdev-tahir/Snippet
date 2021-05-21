<?php
add_action( 'elementor/widget/before_render_content', function ( $widget ) {
	if( 'form' === $widget->get_name() ) {
      // Get the settings
      $settings = $widget->get_settings();
      // Adding our type as a class to the widget
      if( $settings['widget_content_border_bottom'] ) {
        $widget->add_render_attribute( 'widget_content', 'class', $settings['widget_content_border_bottom'], true );
      }
    }
});


add_action( 'elementor/element/form/section_form_fields/before_section_end', function( $element, $args ) {
	$element->start_injection( [
        'at' => 'before',
        'of' => 'input_size',
      ] );
      /** @var \Elementor\Element_Base $element */
      $element->add_control(
        'custom_control',
        [
          'type' => \Elementor\Controls_Manager::NUMBER,
          'label' => __( 'Custom Control', 'plugin-name' ),
        ]
      );
});