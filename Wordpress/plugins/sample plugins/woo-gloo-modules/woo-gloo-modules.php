<?php

// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Gloo_Module_Woo_Gloo_Modules' ) ) {

	/**
	 * Define Gloo_Module_Woo_Gloo_Modules class
	 */
	class Gloo_Module_Woo_Gloo_Modules extends Gloo_Module_Base {

		public $instance = null;

		/**
		 * Module ID
		 *
		 * @return string
		 */
		public function module_id() {
			return 'woo_gloo_modules';
		}

		/**
		 * Module name
		 *
		 * @return string
		 */
		public function module_name() {
			return __( 'Woo Gloo Modules', 'gloo' );
		}

		/**
		 * Module init
		 *
		 * @return void
		 */
		public function module_init() {
			add_action( 'gloo/init', array( $this, 'create_instance' ) );
		}

		/**
		 * Create module instance
		 *
		 * @return [type] [description]
		 */
		public function create_instance(  ) {
			require  gloo()->modules_path( 'woo-gloo-modules/inc/module.php' );
			$this->instance = \Gloo\Modules\WooGloo\Module::instance();
		}

	}

}






//define('OTW_WOOCOMMERCE_PRICE_WIDGET_FILE', __FILE__);


//include_once plugin_dir_path(OTW_WOOCOMMERCE_PRICE_WIDGET_FILE).'inc/autoload.php';

// add the data sanitization and validation class
//if(!class_exists('BBWPSanitization'))
//  include_once BBWP_FLUID_DYNAMICS_ABS.'inc/classes/BBWPSanitization.php';


