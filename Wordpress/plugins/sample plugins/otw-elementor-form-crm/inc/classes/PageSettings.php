<?php
namespace OTW\ElementorFormCRM;


// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class PageSettings extends Plugin{

  public $pageFields = array();
  public $pageFieldsSkipSaving = array();
  
  public function __construct(){

    $this->pageFields = array(
      //'host' => array('type' => 'select', 'label' => __('Web Host', 'otw-elementor-form-crm-td')),
      'ftp_host' => array('type' => 'text', 'label' => __('FTP Host.', 'otw-elementor-form-crm-td')),
      'ftp_username' => array('type' => 'text', 'label' => __('FTP Username.', 'otw-elementor-form-crm-td')),
      'ftp_password' => array('type' => 'text', 'label' => __('FTP Password.', 'otw-elementor-form-crm-td')),
      'ftp_path' => array('type' => 'text', 'label' => __('FTP Folder Path.', 'otw-elementor-form-crm-td')),
      'cron_time' => array('type' => 'text', 'label' => __('Cron Time.', 'otw-elementor-form-crm-td'), 'placeholder' => __('i.e 16:20:00', 'otw-elementor-form-crm-td')),
      'email_recipient' => array('type' => 'text', 'label' => __('Recipient(s)', 'otw-elementor-form-crm-td').'<br />
        <small>
          '.__('Seperated by ,', 'otw-elementor-form-crm-td').'<br />
          
        </small>'),
      'email_subject' => array('type' => 'text', 'label' => __('Email Subject', 'otw-elementor-form-crm-td')),   
    );
    $this->pageFieldsSkipSaving = array('cron_time');

    add_action('init', array($this, 'input_handle'));
    add_action( 'admin_menu', array($this,'admin_menu'));

  }// construct function end here

  /******************************************/
  /***** page_bboptions_admin_menu function start from here *********/
  /******************************************/
  public function admin_menu(){
    
    /* add sub menu in our wordpress dashboard main menu */
    //add_menu_page(__('OTW Elementor Form CRM', 'otw-elementor-form-crm-td'), __('OTW Elementor Form CRM', 'otw-elementor-form-crm-td'), 'manage_options', $this->prefix, array($this,'add_submenu_page') );
    add_submenu_page('options-general.php', __('OTW Elementor Form CRM', 'otw-elementor-form-crm-td'), __('OTW Elementor Form CRM', 'otw-elementor-form-crm-td'), 'manage_options', $this->prefix, array($this,'add_submenu_page') );
    
  }

  /******************************************/
  /***** add_submenu_page_bboptions function start from here *********/
  /******************************************/
  public function add_submenu_page(){ ?>
    <div class="wrap bytebunch_admin_page_container">
      <div id="icon-tools" class="icon32"></div>
      <div id="poststuff">
          <div id="postbox-container" class="postbox-container">
            <form action="" method="post">
            <?php wp_nonce_field(); ?>
              <div class="meta-box-sortables ui-sortable">
                <div class="postbox">
                  <div class="postbox-header">                    
                    <h3 class="hndle ui-sortable-handle"><span><?php _e('OTW Elementor Form CRM Settings', 'otw-elementor-form-crm-td'); ?></span></h3>
                    <div class="handle-actions hide-if-no-js">
                      <button type="button" class="handlediv" aria-expanded="true"><span class="screen-reader-text">Toggle panel: Author</span><span class="toggle-indicator" aria-hidden="true"></span></button>                    
                    </div>
                  </div><!-- postbox-header-->
                  <div class="inside">
                    <input type="hidden" name="<?php echo $this->prefix('page_update_setting'); ?>" value="<?php echo $this->prefix('page_update_setting'); ?>">
                    <table class="form-table">
                    <tbody>
                        

                        <?php
						  echo $this->displayFlipSwitch('enable_sms', __('Enable SMS system', 'otw-elementor-form-crm-td'));
                          echo $this->displayField('ftp_host');
                          echo $this->displayField('ftp_username');
                          echo $this->displayField('ftp_password');
                          echo $this->displayField('ftp_path');
                          echo $this->displayField('cron_time');
                          echo $this->displayField('outofstock_min_value');
                          echo $this->displayField('email_recipient');
                          echo $this->displayField('email_subject');
                          
                          
                        ?>
                        <tr>
                          <th scope="row">
                          <label for="<?php echo $this->prefix("email_message"); ?>"><?php _e('Email Message', 'otw-elementor-form-crm-td'); ?><br />
                          <small>
                            <?php _e('Placeholders:', 'otw-elementor-form-crm-td'); ?><br />
                            {order_number}<br />
                            {time}<br />
                            {cron_message}<br />
                            {site_name}
                          </small>
                          </label></th>
                          <td><textarea name="<?php echo $this->prefix("email_message"); ?>" id="<?php echo $this->prefix("email_message"); ?>" cols="30" rows="20" style="width:600px; max-width:100%;"><?php echo get_option($this->prefix("email_message")); ?></textarea></td>
                        </tr>
                        
                      </tbody>
                    </table>
                  </div><!-- inside-->
                </div><!-- postbox-->
              </div><!-- meta-box-sortables-->
              <?php submit_button('Save Changes'); ?>
            </form>
          </div><!-- postbox-container-->
      </div><!-- poststuff-->
    </div><!-- wrap-->
    <?php 
	//$this->bbwp_flipswitch_css();
  }


  /******************************************/
  /***** input_handle function start from here *********/
  /******************************************/
  public function input_handle(){
    
    if(isset($_GET['page']) && $_GET['page'] === $this->prefix){

      if(isset($_POST['_wpnonce']) && wp_verify_nonce($_POST['_wpnonce']) && isset($_POST[$this->prefix('page_update_setting')])){

        foreach($this->pageFields as $key=>$inputField){
          if(in_array($key, $this->pageFieldsSkipSaving))
            continue;
          if(isset($_POST[$this->prefix($key)])){
            $value = \BBWPSanitization::Textfield($_POST[$this->prefix($key)]);
            if($value)
              $this->set_option($key, $value);
            else
              $this->set_option($key, '');
          }
        }

        if(isset($_POST[$this->prefix('cron_time')])){
          $value = \BBWPSanitization::Textfield($_POST[$this->prefix('cron_time')]);
          if($value){
            $this->set_option('cron_time', $value);
            $this->setupDailyCron($value);
          }
          else
            $this->set_option('cron_time', "");
        }

        if(isset($_POST[$this->prefix('email_message')])){
          $value = wptexturize(\BBWPSanitization::Textarea($_POST[$this->prefix('email_message')], true));
          if($value)
            update_option($this->prefix('email_message'), $value);
          else
            update_option($this->prefix('email_message'), "");
        }

		//$this->save_empty('enable_sms');
        add_action( 'admin_notices', [ $this, 'admin_notices' ] );

      }
      

    } // if isset page end here

  } // input handle function end here


  /******************************************/
  /***** displayField function start from here *********/
  /******************************************/
  public function displayField($field_key){
    $output = ''; 
    if(isset($this->pageFields[$field_key])){
      $placeholder = '';
      if($this->pageFields[$field_key]['placeholder'])
        $placeholder = ' placeholder="'.$this->pageFields[$field_key]['placeholder'].'"';
        $output = '<tr>
        <th scope="row"><label for="'. $this->prefix($field_key).'">'. $this->pageFields[$field_key]['label'].'</label></th>
        <td><input type="text" name="'.$this->prefix($field_key).'" id="'.$this->prefix($field_key).'" value="'.$this->get_option($field_key).'" class="regular-text" style="width:600px; max-width:100%;"'.$placeholder.'></td>
        </tr>';
    }
    return $output;
  }


  public function pageURL($param = array()){
    return add_query_arg($param, get_admin_url(null, 'admin.php?page='.$this->prefix));
  }


  public function save_empty($meta_key){

    $update_value = '';
    if(isset($_POST[$this->prefix($meta_key)])){
      $value = \BBWPSanitization::Textfield($_POST[$this->prefix($meta_key)], true);
      if($value){           
        $update_value = $value;
      }
    }

    $this->set_option($meta_key, $update_value);
  }



  /******************************************/
  /***** displayFlipSwitch function start from here *********/
  /******************************************/
  public function displayFlipSwitch($field_key, $label = ''){
    $output = ''; 
    $checked = '';
    if($this->get_option($field_key)) 
      $checked = ' checked="checked"';
    $output .= '<tr>
      <th scope="row">
      <label for="'. $this->prefix($field_key).'">'.$label.'<br />
      </label></th>
      <td> 
        <input type="checkbox" class="bbwp_flipswitch" value="1" name="'.$this->prefix($field_key).'" '.$checked.'>
      </td>
    </tr>';
    return $output;
  }
  
  
  /******************************************/
  /***** bbwp_flipswitch_css function start from here *********/
  /******************************************/
  public function bbwp_flipswitch_css(){
	  ?>
	  <style type="text/css">
    .inside .bbwp_flipswitch {
      position: relative;
      background: #CECECE;
      width: 40px;
      height: 18px;
      -webkit-appearance: initial;
      border-radius: 15px;
      -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
      outline: none;
      font-size: 14px;
      font-family: Trebuchet, Arial, sans-serif;
      font-weight: bold;
      cursor: pointer;
      border: none;
      outline: none;
    }
    .inside .bbwp_flipswitch:after {
      position: absolute;
      top: 5%;
      display: block;
      line-height: 32px;
      width: 41%;
      height: 87%;
      background: #fff;
      box-sizing: border-box;
      text-align: center;
      transition: all 0.3s ease-in 0s;
      color: black;
      border: #888 1px solid;
      border-radius: 50%;
    }
    .inside .bbwp_flipswitch:after {
      left: 2%;
      content: "";
      background-color: #fff;
    }
    .inside .bbwp_flipswitch:checked:after {
      left: 53%;
      content: "";
      background-color: #fff;
    }
    .inside .bbwp_flipswitch:checked:before {
      display: none;
    }
    .inside .bbwp_flipswitch:checked {
      background: #2296F4;
    }
    /*.inside .bbwp_flipswitch:checked + .module-setting {
      display: block;
    }*/

    </style>
	  <?php 
  }
}// class end here
