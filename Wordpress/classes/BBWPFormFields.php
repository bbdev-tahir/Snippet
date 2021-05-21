<?php
// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class BBWPFormFields{

	public $formFields = array();
  private $prefix = "";
  public $saveType = "option";
	private $dataID = '';
	public $updateMessage = 'Your setting have been updated.';

  private $displaytype = array("wrapper_open" => '<table class="form-table">', 'wrapper_close' => '</table>', 'container_open' => '<tr>', 'container_close' => '</tr>', 'label_open' => '<th scope="row">', 'label_close' => '</th>', 'input_open' => '<td>', 'input_close' => '</td>');
	
  public function __construct($prefix = ''){    
		if(isset($prefix) && $prefix && is_string($prefix))
      $this->prefix = $prefix;
    /*$this->displaytype = array(
      "wrapper_open" => '<div class="form-wrap">',
      'wrapper_close' => '</div>',
      'container_open' => '<div class="form-field">',
      'container_close' => '</div>',
      'label_open' => '',
      'label_close' => '',
      'input_open' => '',
      'input_close' => ''
    );*/
  }// construct function end here

  /******************************************/
  /***** DisplayOptions function start from here *********/
  /******************************************/
  public function DisplayOptions(){
    $existing_values = $this->formFields;
    if(isset($existing_values) && is_array($existing_values) && count($existing_values) >= 1){
      //db($existing_values);
      echo '<input type="hidden" name="'.$this->prefix('update_options').'" value="'.$this->prefix('update_options').'" />';
      echo $this->displaytype['wrapper_open'];

      foreach($existing_values as $value){

        if($value['field_type'] != 'hidden')
        	echo $this->displaytype['container_open'];

        $field_description = '';
        if(isset($value['field_description']))
          $field_description = '<p class="description">'.$value['field_description'].'</p>';

				if($value['field_type'] != 'hidden')
        	echo $this->displaytype['label_open'].'<label for="'.$value['meta_key'].'">'.$value['field_title'].'</label>'.$field_description.$this->displaytype['label_close'].$this->displaytype['input_open'];

				$default_value = "";
				$selected_value = "";
        if(isset($value['default_value']) && $value['default_value'])
          $default_value = $value['default_value'];

        if($this->saveType === "option")
          $selected_value = get_option($value['meta_key']);
        elseif($this->saveType === "user" && is_numeric($this->dataID) && $this->dataID >= 1)
          $selected_value = get_user_meta($this->dataID, $value['meta_key'], true);
        elseif($this->saveType === "post" && is_numeric($this->dataID) && $this->dataID >= 1)
          $selected_value = get_post_meta($this->dataID, $value['meta_key'], true);
        elseif($this->saveType === "term" && is_numeric($this->dataID) && $this->dataID >= 1)
          $selected_value = get_term_meta($this->dataID, $value['meta_key'], true);
        elseif($this->saveType === "comment" && is_numeric($this->dataID) && $this->dataID >= 1)
					$selected_value = get_comment_meta($this->dataID, $value['meta_key'], true);
				elseif($this->saveType === "custom_update" && isset($value['db_value']) && $value['db_value'])
					$selected_value = $value['db_value'];

        if(!(isset($selected_value) && $selected_value))
          $selected_value = $default_value;
        if(isset($value['field_duplicate']) && $value['field_duplicate'] == 'on'){
          $selected_value = SerializeStringToArray($selected_value);
        }

        if($value['field_type'] == 'text' || $value['field_type'] == 'password' || $value['field_type'] == 'number' || $value['field_type'] == 'hidden'){
          if(isset($value['field_duplicate']) && $value['field_duplicate'] == 'on'){
            echo '<div><input type="text" class="field_duplicate regular-text bb_new_tag" data-name="'.$value['meta_key'].'" />
            <input type="button" class="button tagadd bb_tagadd" value="Add"><div class="bbtagchecklist input_bbtagchecklist">';
            if($selected_value && is_array($selected_value) && count($selected_value) >= 1){
              foreach ($selected_value as $field_type_value) {
                echo '<span><input type="text" value="'.esc_attr($field_type_value).'" name="'.$value['meta_key'].'[]" class="regular-text" /><a href="#" class="bb_delete_it bb_dismiss_icon">&nbsp;</a></span>';
              }
            }
            echo '</div></div>';
          }
          else
            echo '<input type="'.$value['field_type'].'" name="'.$value['meta_key'].'" id="'.$value['meta_key'].'" value="'.esc_attr($selected_value).'" class="regular-text" '.$this->FieldAttributes($value).'>';
        }
        elseif($value['field_type'] == 'image'){
          if(isset($value['field_duplicate']) && $value['field_duplicate'] == 'on'){
            //<p class="description">You can use Ctrl+Click to select multiple images from media library.</p>
            echo '<input type="button" id="" class="bytebunch_multiple_upload_button button" value="Select Images" data-name="'.$value['meta_key'].'">';
            echo '<div class="bb_multiple_images_preview bb_image_preview">';
            if($selected_value && is_array($selected_value) && count($selected_value) >= 1){
              foreach ($selected_value as $field_type_value) {
                echo '<span><img src="'.$field_type_value.'"><a href="#" class="bb_dismiss_icon bb_delete_it">&nbsp;</a><input type="hidden" name="'.$value['meta_key'].'[]" value="'.esc_attr($field_type_value).'" /></span>';
              }
            }
            echo '<div class="clearboth"></div></div>';
          }else{
            echo '<input type="text" name="'.$value['meta_key'].'" id="'.$value['meta_key'].'" value="'.esc_attr($selected_value).'" class="regular-text">
            <input type="button" id="" class="bytebunch_file_upload_button button" value="Select Image">';
            echo '<div class="bb_single_image_preview bb_image_preview">';
            if($selected_value){
              echo '<span><img src="'.$selected_value.'"><a href="#" class="bb_dismiss_icon">&nbsp;</a></span>';
            }
            echo '<div class="clearboth"></div></div>';
          }

        }
        elseif($value['field_type'] == 'file'){
          echo '<input type="text" name="'.$value['meta_key'].'" id="'.$value['meta_key'].'" value="'.esc_attr($selected_value).'" class="regular-text">
              <input type="button" id="" class="bytebunch_file_upload_button button" value="'.__('Upload File', 'bbwp-custom-fields').'">';
        }
        elseif($value['field_type'] == 'editor'){
          $setting = array('textarea_rows' => 10, 'textarea_name' => $value['meta_key'], 'teeny' => false, 'tinymce' => true, 'quicktags' => true);
          wp_editor($selected_value, $value['meta_key'], $setting);
        }
        elseif($value['field_type'] == 'textarea'){
          echo '<textarea name="'.$value['meta_key'].'" id="'.$value['meta_key'].'" rows="5">'.$selected_value.'</textarea>';
        }
        elseif($value['field_type'] == 'color'){
          echo '<input type="text" name="'.$value['meta_key'].'" id="'.$value['meta_key'].'" value="'.esc_attr($selected_value).'" class="bytebunch-wp-color-picker regular-text">';
        }
        elseif($value['field_type'] == 'date'){
          echo '<input type="text" name="'.$value['meta_key'].'" id="'.$value['meta_key'].'" value="'.esc_attr($selected_value).'" class="bytebunch-wp-date-picker regular-text">';
        }
        elseif($value['field_type'] == 'select'){
          echo '<select name="'.$value['meta_key'].'" id="'.$value['meta_key'].'">';
          foreach($value['field_type_values'] as $field_type_value){
            if($field_type_value == $selected_value)
              echo '<option value="'.esc_attr($field_type_value).'" selected="selected">'.esc_html($field_type_value).'</option>';
            else
              echo '<option value="'.esc_attr($field_type_value).'">'.esc_html($field_type_value).'</option>';
          }
          echo '</select>';
        }
        elseif($value['field_type'] == 'radio'){
          foreach($value['field_type_values'] as $key=>$field_type_value){
            if($field_type_value == $selected_value)
              echo ' <input type="radio" id="'.$value['meta_key'].$key.'" value="'.esc_attr($field_type_value).'" name="'.$value['meta_key'].'" checked="checked" /> <label for="'.$value['meta_key'].$key.'">'.esc_html($field_type_value).'</label> ';
            else
              echo ' <input type="radio" id="'.$value['meta_key'].$key.'" value="'.esc_attr($field_type_value).'" name="'.$value['meta_key'].'" /> <label for="'.$value['meta_key'].$key.'">'.esc_html($field_type_value).'</label> ';
            echo '&nbsp;&nbsp;';
          }
        }
        elseif($value['field_type'] == 'checkbox'){
          if($selected_value)
            echo '<input type="'.$value['field_type'].'" name="'.$value['meta_key'].'" id="'.$value['meta_key'].'" checked="checked">';
          else
            echo '<input type="'.$value['field_type'].'" name="'.$value['meta_key'].'" id="'.$value['meta_key'].'">';
        }
        elseif($value['field_type'] == 'checkbox_list'){
          $selected_value = SerializeStringToArray($selected_value);
          if(!($selected_value && is_array($selected_value)))
            $selected_value = array();
          foreach($value['field_type_values'] as $key=>$field_type_value){
            if(in_array($field_type_value, $selected_value))
              echo ' <input type="checkbox" id="'.$value['meta_key'].$key.'" value="'.esc_attr($field_type_value).'" name="'.$value['meta_key'].'[]" checked="checked" /> <label for="'.$value['meta_key'].$key.'">'.esc_html($field_type_value).'</label> ';
            else
              echo ' <input type="checkbox" id="'.$value['meta_key'].$key.'" value="'.esc_attr($field_type_value).'" name="'.$value['meta_key'].'[]" /> <label for="'.$value['meta_key'].$key.'">'.esc_html($field_type_value).'</label> ';
            echo '&nbsp;&nbsp;';
          }
        }
        if($value['field_type'] != 'hidden'){
					echo $this->displaytype['input_close'];
					echo $this->displaytype['container_close'];
				}
      }
      echo $this->displaytype['wrapper_close'];
    }
  }

	/******************************************/
  /***** SaveOptions function start from here *********/
  /******************************************/
  public function SaveOptions(){
		global $wpdb;
    $existing_values = $this->formFields;
    if(isset($existing_values) && $existing_values && count($existing_values) >= 1){
      if(isset($_POST[$this->prefix("update_options")]) && $_POST[$this->prefix("update_options")] === $this->prefix("update_options"))
      {
				foreach($existing_values as $value){

					if(isset($value['attributes']) && isset($value['attributes']['disabled']))
						continue;

          $dbvalue = "";
          if(isset($_POST[$value['meta_key']]) && $_POST[$value['meta_key']]){
            if(is_array($_POST[$value['meta_key']]) && count($_POST[$value['meta_key']]) >= 1){
              $dbvalue = array();
              foreach($_POST[$value['meta_key']] as $selected_value){
                $selected_value = BBWPSanitization::Textfield($selected_value);
                if($selected_value)
                  $dbvalue[] = $selected_value;
              }
            }
            else{
                if($value['field_type'] == 'textarea' || $value['field_type'] == 'editor'){
									if(isset($value['field_allow_all_code']) && $value['field_allow_all_code'] && $value['field_allow_all_code'] == 'on'){
										if(isset($value['field_disable_autop']) && $value['field_disable_autop'] && $value['field_disable_autop'] == 'on')
											$dbvalue = wptexturize(BBWPSanitization::Textarea($_POST[$value['meta_key']], true));
										else
											$dbvalue = wptexturize(wpautop(BBWPSanitization::Textarea($_POST[$value['meta_key']], true)));
									}else{
										if(isset($value['field_disable_autop']) && $value['field_disable_autop'] && $value['field_disable_autop'] == 'on')
											$dbvalue = wptexturize(BBWPSanitization::Textarea($_POST[$value['meta_key']]));
										else
											$dbvalue = wptexturize(wpautop(BBWPSanitization::Textarea($_POST[$value['meta_key']])));
									}

								}
								elseif($value['field_type'] === 'date'){
									$dbvalue = BBWPSanitization::Textfield($_POST[$value['meta_key']]);
									$dbvalue = date('Y-m-d', strtotime($dbvalue));
								}
                else{
									$dbvalue = BBWPSanitization::Textfield($_POST[$value['meta_key']]); 
								}
            }
          }
          else{
            if(isset($value['default_value']))
              $dbvalue = $value['default_value'];
          }

          if(is_array($dbvalue))
            $dbvalue = ArrayToSerializeString($dbvalue);

          if($this->saveType === "option"){
						update_option($value['meta_key'], $dbvalue);
						update_option("bbwp_update_message", __($this->updateMessage, 'bbwp-custom-fields'));
					}

          elseif($this->saveType === "user" && is_numeric($this->dataID) && $this->dataID >= 1)
						update_user_meta($this->dataID, $value['meta_key'], $dbvalue);
          elseif($this->saveType === "post" && is_numeric($this->dataID) && $this->dataID >= 1)
            update_post_meta($this->dataID, $value['meta_key'], $dbvalue);
          elseif($this->saveType === "term" && is_numeric($this->dataID) && $this->dataID >= 1)
						update_term_meta($this->dataID, $value['meta_key'], $dbvalue);
          elseif($this->saveType === "comment" && is_numeric($this->dataID) && $this->dataID >= 1)
						update_comment_meta($this->dataID, $value['meta_key'], $dbvalue);

					elseif(($this->saveType === "custom_new" || $this->saveType === "custom_update") && isset($value['table_column']) && isset($this->tableData)){
						$this->tableData[$value['table_column']] = array('value'=>$dbvalue, 'type'=>$value['data_type']);
					}
						
				}
				
				if(isset($this->table) && isset($this->tableData) && is_array($this->tableData) && count($this->tableData) >= 1){
					
					$args = array();
					$column_values = array();
					foreach($this->tableData as $key=>$value){
						$column_values[$key] = $value['value'];
						$args[] = $value['type'];
					}

					if($this->saveType === "custom_new"){	
						$updated = $wpdb->insert($this->table, $column_values, $args);
						$lastid = $wpdb->insert_id;
					}elseif($this->saveType === "custom_update" && isset($this->update_column) && isset($this->update_value) && isset($this->update_type)){
						$updated = $wpdb->update($this->table, $column_values, array($this->update_column => $this->update_value), $args, array($this->update_type));
						//$wpdb->update('tablename', array('foo' => $foo, 'bar' => $bar), array('foobar' => $foobar), array('%s', '%u'), array('%s'));
					}
					
					if($updated){
						update_option("bbwp_update_message", __($this->updateMessage, 'bbwp-custom-fields'));
						return $lastid;
					}else{
						
						$error_message = '';
						if($wpdb->last_error !== '')
							$error_message = $wpdb->last_error;
						else
							$error_message = 'There was some problem we could not update this record, please try again';

						update_option("bbwp_error_message", __($error_message, 'bbwp-custom-fields'));
						return false;
					}
					
				}
          
      }
    }
	}


	/******************************************/
  /***** prefix function start from here *********/
  /******************************************/
  public function prefix($string = '', $underscore = "_"){
    return $this->prefix.$underscore.$string;
	}
	
	/******************************************/
  /***** Set function start from here *********/
  /******************************************/
  public function Set($property, $value = NULL){
    if(isset($property) && $property){
      if(isset(self::$$property))
        self::$$property = $value;
      else
        $this->$property = $value;
    }
	}
	

	/******************************************/
  /***** FieldAttributes function start from here *********/
  /******************************************/
	public function FieldAttributes($value = NULL){
		
		$output = '';

		if(isset($value) && isset($value['attributes']) && is_array($value['attributes']) && count($value['attributes']) >= 1){
			foreach($value['attributes'] as $key=>$attribue){
				$output .= $key.'="'.$attribue.'" ';
			}
		}

		if(isset($value) && isset($value['style']) && is_array($value['style']) && count($value['style']) >= 1){
			foreach($value['style'] as $key=>$attribue){
				$output .= 'style="'.$key.':'.$attribue.';" ';
			}
		}

		return $output;
	}

	/******************************************/
  /***** StyleAttributes function start from here *********/
  /******************************************/
	public function StyleAttributes($value = NULL){
		if(isset($value) && isset($value['attributes']) && is_array($value['attributes']) && count($value['attributes']) >= 1){
			$output = '';
			foreach($value['attributes'] as $key=>$attribue){
				$output .= $key.'="'.$attribue.'" ';
			}
			return $output;
		}
	}

}
