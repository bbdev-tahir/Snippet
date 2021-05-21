<?php
/******************************************/
/**********Disable Revisions **************/
/*Open wp-config.php located in your WordPress root directory and add the following code:*/
/*This code will disable all future revisions to be saved and it will also increase your autosave interval from 60 seconds to 300 seconds*/
/******************************************/
define('AUTOSAVE_INTERVAL', 300 ); //5 min
define('WP_POST_REVISIONS', false );



/******************************************/
/********** Disable wp-debug on production server **************/
/******************************************/
define('WP_DEBUG', false);
