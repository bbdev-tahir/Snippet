<?php
/*
Plugin Name: OTW Elementor Form CRM
Plugin URI: https://otw.design//
Description: Add the Zoho CRM and ActiveTrail API to elementor form.
Author: OTW Design
Version: 1.0.0
Author URI: https://otw.design/
Text Domain:       otw-elementor-form-crm-td
Domain Path:       /languages
License:           GPL v2 or later
License URI:       https://www.gnu.org/licenses/gpl-2.0.txt
*/


// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require plugin_dir_path(__FILE__).'inc/plugin-update-checker/plugin-update-checker.php';
$myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
	'https://github.com/OTWSRL/otw-elementor-form-crm',
	//'https://gloo.ooo/plugins/otw-erp-order-export/otw-erp-order-export.json',
	__FILE__, //Full path to the main plugin file or functions.php.
	'otw-elementor-form-crm'
);
$myUpdateChecker->setAuthentication('c5848a2243f4a79d6f38f7f1417d641ca57e5504');
$myUpdateChecker->setBranch('master');


define('OTW_ELEMENTOR_FORM_CRM_PLUGIN_FILE', __FILE__);

include_once plugin_dir_path(OTW_ELEMENTOR_FORM_CRM_PLUGIN_FILE).'inc/autoload.php';


otw_elementor_form_crm();