<?php
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

$prefix = 'otw_elementor_form_crm';
delete_option($prefix.'_options');