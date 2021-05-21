<?php

// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'BBWP_Module_DB_Backup' ) ) {

	/**
	 * Define BBWP_Module_DB_Backup class
	 */
	class BBWP_Module_DB_Backup extends BBWP_Engine_Module_Base {

		public $instance = null;

		/**
		 * Module ID
		 *
		 * @return string
		 */
		public function module_id() {
			return 'db_backup';
		}

		/**
		 * Module name
		 *
		 * @return string
		 */
		public function module_name() {
			return __( 'DB Backup', 'bbwp_engine_td' );
		}

		/**
		 * Module init
		 *
		 * @return void
		 */
		public function module_init() {
			add_action( 'bbwp_engine/init', array( $this, 'create_instance' ) );
		}

		/**
		 * Create module instance
		 *
		 * @return [type] [description]
		 */
		public function create_instance(  ) {
			require  bbwp_engine()->modules_path( 'db-backup/inc/module.php' );
			$this->instance = \BBWP\Modules\DBBackup\Module::instance();
		}

	}

}






//define('OTW_WOOCOMMERCE_PRICE_WIDGET_FILE', __FILE__);


//include_once plugin_dir_path(OTW_WOOCOMMERCE_PRICE_WIDGET_FILE).'inc/autoload.php';

// add the data sanitization and validation class
//if(!class_exists('BBWPSanitization'))
//  include_once BBWP_FLUID_DYNAMICS_ABS.'inc/classes/BBWPSanitization.php';


