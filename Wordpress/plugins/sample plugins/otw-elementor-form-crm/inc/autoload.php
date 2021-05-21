<?php

// include the generic functions file.
include_once plugin_dir_path(OTW_ELEMENTOR_FORM_CRM_PLUGIN_FILE).'inc/functions.php';

// add the data sanitization and validation class
//if(!class_exists('BBWPSanitization'))
//  include_once plugin_dir_path(OTW_ELEMENTOR_FORM_CRM_PLUGIN_FILE).'inc/classes/BBWPSanitization.php';

spl_autoload_register( function ( $class ) {

	// project-specific namespace prefix
	$prefix = 'OTW\ElementorFormCRM';
	
	// If the specified $class does not include our namespace, duck out.
	if ( false === strpos( $class, 'OTW\ElementorFormCRM' ) ) {
		return; 
	}
	// base directory for the namespace prefix
	$base_dir = plugin_dir_path(OTW_ELEMENTOR_FORM_CRM_PLUGIN_FILE) .'inc/classes/';

	// does the class use the namespace prefix?
	$len = strlen( $prefix );

	// get the relative class name
	$relative_class = substr( $class, $len+1 );
	
	$file = $base_dir .  $relative_class  . '.php';

	// if the file exists, require it
	if ( file_exists( $file ) ) {
		include_once( $file );
	}
} );
