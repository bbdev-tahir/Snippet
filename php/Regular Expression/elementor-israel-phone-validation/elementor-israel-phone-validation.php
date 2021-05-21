
<?php
/**
 * Plugin Name: Israel Phone Validation For Elementor & WooCommerce
 * Description: Israel phone number validation on Elementor forms & WooCommerce.
 * Version:     1.0.0
 * Author:      OTW
 * Author URI:  http://otw.design/
 * Text Domain: otw
 */

if ( ! defined( 'ABSPATH' ) ) { 
    exit; 
}

// Elementor Form Phone Number Validition
add_action( 'elementor_pro/forms/validation/tel', function( $field, $record, $ajax_handler ) { 	
	if ( preg_match( '/^((\+|00)?972\-?|0)(([23489]|[57]\d)\-?\d{7})$/', $field['value'] ) !== 1 ) { 		
	$ajax_handler->add_error( $field['id'], 'Invalid phone number, please enter a valid phone number without spaces and special chars' ); 	
	}
}, 10, 3 );
	 
// WooCommerce Phone Number Validition
add_action('woocommerce_checkout_process', function () {
    $is_correct = preg_match('/^((\+|00)?972\-?|0)(([23489]|[57]\d)\-?\d{7})$/', $_POST['billing_phone']);
    if ( $_POST['billing_phone'] && !$is_correct) {
        wc_add_notice( __( 'Invalid phone number, please enter a valid phone number without spaces and special chars' ), 'error' );
    }
});

