<?php
namespace OTW\ElementorFormCRM;

// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Plugin{

  private static $instance = null;

  public $message = null;
  public $messageClass = 'success';

  public $prefix = 'otw_elementor_form_crm';
  static $options = array();


  /******************************************/
	/***** Single Ton base intialization of our class **********/
	/******************************************/
  public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/******************************************/
	/***** class constructor **********/
	/******************************************/
  public function __construct(){

		// get the plugin options/settings.
    self::$options = SerializeStringToArray(get_option($this->prefix('options')));
    
    /*if(!(isset(self::$options['input_element_class']) && self::$options['input_element_class'])){
      $this->set_option('input_element_class', 'autocomplete_address');
    }*/
      
    //localization hook
    add_action( 'plugins_loaded', array($this, 'plugins_loaded') );
    
    add_action( 'init', [ $this, 'init' ] );

    if(is_admin()){

      //$PageSettings = new PageSettings();

      // add javascript and css to wp-admin dashboard.
      //add_action( 'admin_enqueue_scripts', array($this, 'wp_admin_style_scripts') );

      //add settings page link to plugin activation page.
      //add_filter( 'plugin_action_links_'.plugin_basename(OTW_ELEMENTOR_FORM_CRM_PLUGIN_FILE), array($this, 'plugin_action_links') );

      // Plugin activation hook
      //register_activation_hook(plugin_basename(OTW_ELEMENTOR_FORM_CRM_PLUGIN_FILE), array($this, 'PluginActivation'));

      // plugin deactivation hook
      //register_deactivation_hook(plugin_basename(OTW_ELEMENTOR_FORM_CRM_PLUGIN_FILE), array($this, 'PluginDeactivation'));

		}else{
      // add javascript and css to front end.
      //add_action( 'wp_enqueue_scripts', array($this, 'wp_admin_style_scripts') );
    }

  }// construct function end here


	/******************************************/
	/***** get plugin prefix with custom string **********/
	/******************************************/
  public function prefix($string = '', $underscore = "_"){

    return $this->prefix.$underscore.$string;

  }// prefix function end here.


	/******************************************/
	/***** localization function **********/
	/******************************************/
	public function plugins_loaded(){

		load_plugin_textdomain( 'otw-elementor-form-crm-td', false, plugin_dir_path(OTW_ELEMENTOR_FORM_CRM_PLUGIN_FILE) . 'languages/' );

    /*if ( $this->is_compatible() ) {
      add_action( 'elementor/init', [ $this, 'init' ] );
    }*/
    

	}// plugin_loaded


	/******************************************/
	/***** add settings page link in plugin activation screen.**********/
	/******************************************/
  public function plugin_action_links( $links ) {

     $links[] = '<a href="'. esc_url(get_admin_url(null, 'options-general.php?page='.$this->prefix)) .'">'.__('Settings', 'otw-elementor-form-crm-td').'</a>';
     return $links;

  }// localization function


	/******************************************/
  /***** Plugin activation function **********/
  /******************************************/
  public function PluginActivation() {

		global $wpdb;
		
    $ver = "1.0";
    if(!(isset(self::$options['ver']) && self::$options['ver'] == $ver))
      $this->set_option('ver', $ver);

    

  }// plugin activation


	/******************************************/
  /***** plugin deactivation function **********/
  /******************************************/
  public function PluginDeactivation(){
    
  }// plugin deactivation
  

	/******************************************/
  /***** get option function**********/
  /******************************************/
  public function get_option($key){

    if(isset(self::$options[$key]))
      return self::$options[$key];
    else
      return NULL;

  }// get_option


	/******************************************/
  /***** get option function **********/
  /******************************************/
  public function set_option($key, $value){

      self::$options[$key] = $value;
      update_option($this->prefix.'_options', ArrayToSerializeString(self::$options));

	}// set_option
  

	/******************************************/
  /***** add javascript and css to wp-admin dashboard. **********/
  /******************************************/
  public function wp_admin_style_scripts() {

    /*if(is_admin()){
      wp_enqueue_script( 'postbox' );
    }
  
    wp_register_script( $this->prefix('script'), plugin_dir_url(OTW_ELEMENTOR_FORM_CRM_PLUGIN_FILE) . 'assets/admin/js/script.js', array(), '1.0');
    wp_enqueue_script( $this->prefix('script') );
    
    $js_variables = array('input_element_class' => $this->get_option('input_element_class'));
    wp_localize_script(  $this->prefix('script'), $this->prefix, $js_variables );
*/

  }// wp_admin_style_scripts


  /******************************************/
  /***** add javascript and css to front end. **********/
  /******************************************/
  /*public function wp_style_scripts() {

    wp_register_style( $this->prefix('style'), plugin_dir_url(OTW_ELEMENTOR_FORM_CRM_PLUGIN_FILE) . 'assets/css/style.css', array(), '1.0.0' );
    wp_enqueue_style($this->prefix('style'));

    wp_register_script( $this->prefix('script'), plugin_dir_url(OTW_ELEMENTOR_FORM_CRM_PLUGIN_FILE) . 'assets/js/script.js', array(), '1.0');
    wp_enqueue_script( $this->prefix('script') );


    $js_variables = array('input_element_class' => $this->get_option('input_element_class'));
    wp_localize_script(  $this->prefix('script'), $this->prefix, $js_variables );

  }*/
  


  /******************************************/
  /***** Check if elementor is loaded. **********/
  /******************************************/
  public function is_compatible() {
    
		// Check if Elementor installed and activated
		if ( ! did_action( 'elementor/loaded' ) ) {
      $this->message = __('OTW Elementor Form CRM require Elementor Pro to be installed and active.', 'otw-elementor-form-crm-td');
      $this->messageClass = 'warning';
			add_action( 'admin_notices', [ $this, 'admin_notices' ] );
			return false;
		}
    return true;
    
  }
  


  /******************************************/
  /***** admin_notice_missing_main_plugin. **********/
  /******************************************/
  public function admin_notices() {
    //Value of $class can be error, success, warning and info
    if($this->message && $this->messageClass){ 
      printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( 'notice notice-'.$this->messageClass.' is-dismissible' ), esc_html( $this->message ) );
    }
  }
  


  /******************************************/
  /***** Intialize the elementor and other plugins extended classes and functions. **********/
  /******************************************/
  public function init() {
    
	if ( $this->is_compatible() ) {
      $PluginDefault = new PluginDefault();
    }
		// Add Plugin actions
		//add_action( 'elementor/widgets/widgets_registered', [ $this, 'init_widgets' ] );
    //add_action( 'elementor/controls/controls_registered', [ $this, 'init_controls' ] );
  
    // Add pattern attribute to form field render
		
    //add_action( 'elementor/element/form/section_form_fields/before_section_end', [ $this, 'addAutocompleteAddressFieldControl' ], 100, 2 );
    
  }
  



  
} // BBWP_CustomFields class

