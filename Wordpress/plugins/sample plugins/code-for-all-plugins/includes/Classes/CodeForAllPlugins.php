<?php
// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class CodeForAllPlugins{

  public $prefix = 'code-for-all-plugins';
  static $codeForAllPluginsOptions = array();
  //public $url = BBWPMETABOXES_URL;

  public function __construct(){

		// get the plugin options/settings.
		self::$codeForAllPluginsOptions = SerializeStringToArray(get_option($this->prefix.'_options'));

		// add javascript and css to wp-admin dashboard.
		//add_action( 'admin_enqueue_scripts', array($this, 'wp_admin_style_scripts') );

		//add settings page link to plugin activation page.
		add_filter( 'plugin_action_links_'.CODE_FOR_ALL_PLUGINS_FILE, array($this, 'plugin_action_links') );

		// Plugin activation hook
		register_activation_hook(CODE_FOR_ALL_PLUGINS_FILE, array($this, 'PluginActivation'));

		// plugin deactivation hook
		register_deactivation_hook(CODE_FOR_ALL_PLUGINS_FILE, array($this, 'PluginDeactivation'));

		//localization hook
		add_action( 'plugins_loaded', array($this, 'plugins_loaded') );

  }// construct function end here

	/******************************************/
	/***** get plugin prefix function **********/
	/******************************************/
  public function prefix($string = '', $underscore = "_"){
    return $this->prefix.$underscore.$string;
  }

	/******************************************/
	/***** localization function **********/
	/******************************************/
	public function plugins_loaded(){
		load_plugin_textdomain( 'code-for-all-plugins', false, CODE_FOR_ALL_PLUGINS_ABS . 'languages/' );
	}

	/******************************************/
  /***** add settings page link in plugin activation screen.**********/
  /******************************************/
  public function plugin_action_links( $links ) {
     $links[] = '<a href="'. esc_url(get_admin_url(null, 'options-general.php?page='.$this->prefix)) .'">Settings</a>';
     return $links;
  }

	/******************************************/
  /***** Plugin activation function **********/
  /******************************************/
  public function PluginActivation() {
    $ver = "1.0";
    if(!(isset(self::$codeForAllPluginsOptions['ver']) && self::$codeForAllPluginsOptions['ver'] == $ver))
      $this->set_codeForAllPlugins_Option('ver', $ver);
  }

	/******************************************/
  /***** plugin deactivation function **********/
  /******************************************/
  public function PluginDeactivation(){
		// add code here.
  }

	/******************************************/
  /***** get option function**********/
  /******************************************/
  public function get_codeForAllPlugins_Option($key){
    if(isset(self::$codeForAllPluginsOptions[$key]))
      return self::$codeForAllPluginsOptions[$key];
    else
      return NULL;
  }

	/******************************************/
  /***** Debug functions start from here **********/
  /******************************************/
  public function set_codeForAllPlugins_Option($key, $value){
      self::$codeForAllPluginsOptions[$key] = $value;
      update_option($this->prefix.'_options', ArrayToSerializeString(self::$codeForAllPluginsOptions));
  }

	/******************************************/
  /***** add javascript and css to wp-admin dashboard. **********/
  /******************************************/
  public function wp_admin_style_scripts() {

    //if(isset($_GET['page']) && $_GET['page'] == $this->prefix){

      /*wp_register_script( $this->prefix.'_wp_admin_script', BBWP_CF_URL . '/js/script.js', array('jquery', 'jquery-ui-sortable' ,'jquery-ui-datepicker', 'wp-color-picker'), '1.0.0' );
      wp_enqueue_script( $this->prefix.'_wp_admin_script' );*/

      //$js_variables = array('prefix' => $this->prefix."_");
      //wp_localize_script( $this->prefix.'_wp_admin_script', $this->prefix, $js_variables );

    //}
  }

}
