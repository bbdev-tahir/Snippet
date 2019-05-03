<?php 
add_action( 'edit_user_profile', 'edit_user_profile_by_nuqta' );
add_action( 'show_user_profile', 'edit_user_profile_by_nuqta' );
add_action( 'profile_update', 'update_user_profile_by_nuqta' );

/******************************************/
/***** function to update user profile start from here **********/
/******************************************/

function update_user_profile_by_nuqta()
{
	$get_user_id = get_user_id();
	$all_fields = get_option('create_user_fields_by_nuqta');
			if(!is_array($all_fields)){ $all_fields = unserialize($all_fields); };
			if(count($all_fields) >= 1){
				foreach($all_fields as $values)
				{
					$key = $values['meta_key'];
					if(isset($_POST[$key."_delete_image"]))
					{
						delete_image($_POST[$key."_delete_image"]);
						update_user_meta($get_user_id, $key, "");
					}// delete the old image if end here
					
					if($values['field_type'] == "checkbox")
					{
						if(is_array($_POST[$key])){update_user_meta($get_user_id, $key, serialize($_POST[$key]));}
						else{update_user_meta($get_user_id, $key, serialize(array()));}
					}// if for checkbox end here
					if(isset($_POST[$key])){
						update_user_meta($get_user_id, $key, $_POST[$key]);
						if(isset($_POST[$key."_profile_hidden"]) && $_POST[$key."_profile_hidden"] == "profile_image")
						{
							$porfile_image_meta_key = $key;
							update_option("profile_image_metakey", $key);
						}
						
					}// isset($_post[KEY]) end here
					
				}// foreach loop end here
			}// count array all values in array end here
}// update_user_profile_by_nuqta



/******************************************/
/***** function to edit user profile start from here **********/
/******************************************/

function edit_user_profile_by_nuqta()
{
$get_user_id = get_user_id();
global $myplugin_urlpath;
?>
<style type="text/css">

</style>
    	
	<h3>Extra User Details</h3>
    <?php //dbp(get_option("dummy_values")); ?>
	<table class="form-table">
    	<?php 
			$all_fields = get_option('create_user_fields_by_nuqta');
			if(!is_array($all_fields)){ $all_fields = unserialize($all_fields); };
			if(count($all_fields) >= 1){
				foreach($all_fields as $values)
				{
					echo '<tr>';
					echo "<th>".$values['field_title']."</th>";
					if($values['field_type'] == "profile_image" || $values['field_type'] == "file")
					{?>
						<td>
                        <label for="<?php echo $values['meta_key']; ?>_url_input">
                        <input id="<?php echo $values['meta_key']; ?>_url_input" type="text" name="<?php echo $values['meta_key']; ?>" value="<?php echo get_user_meta($get_user_id, $values['meta_key'], true); ?>" class="upload_images_input" />
                        <input type="button" value="Upload Image" />
                        </label>
                        <input type="hidden" name="<?php echo $values['meta_key']; ?>_delete_image" id="" class="delete_image_hidden" />
                        <input type="hidden" name="<?php echo $values['meta_key']; ?>_profile_hidden" class="profile_image_hidden" value="<?php echo $values['field_type']; ?>">
                        <?php 
						$show_span = "";
						if(!get_user_meta($get_user_id, $values['meta_key'], true))
						{
							$show_span = ' style="display:none;"';
						} ?>
                        <br /><span class="image_preview_span"<?php echo $show_span; ?>><a name="#" class="delete_image_link" style="cursor:pointer;">Delete image</a><br />
                        <img style="margin-top:10px;" src="<?php echo get_user_meta($get_user_id, $values['meta_key'], true); ?>" alt="" height="100" class="image_preview" /></span>
                        </td>
					<?php 
					}// input type file end here
					elseif($values['field_type'] == "textarea")
					{
						echo '<td><textarea rows="5" cols="30" name="'.$values['meta_key'].'">'.get_user_meta($get_user_id, $values['meta_key'], true).'</textarea></td>';
					}// textarea input end here
					elseif($values['field_type'] == "checkbox")
					{
						$check_box_html = "";						
						foreach($values['field_type_values'] as $value)
						{
							$checked = " ";
							if(get_user_meta($get_user_id, $values['meta_key'], true))
							{
								$db_values = get_user_meta($get_user_id, $values['meta_key'], true);
								if(!is_array($db_values)){ $db_values = unserialize($db_values); }
								if(count($db_values) > 0){
									foreach($db_values as $db_value)
									{
										if($db_value == $value){$checked = ' checked="checked" ';}
									}
								}
								
							}
							$check_box_html .= '<input'.$checked.'type="checkbox" name="'.$values['meta_key'].'[]" value="'.$value.'" /> '.$value." &nbsp;&nbsp;";
						}
						echo '<td>'.$check_box_html.'</td>';
					}// checkbox input end here
					elseif($values['field_type'] == "select")
					{
						$check_box_html = '<select style="width:15em;" name="'.$values['meta_key'].'">';
						foreach($values['field_type_values'] as $value)
						{
							$checked = " ";
							if(get_user_meta($get_user_id, $values['meta_key'], true) == $value)
							{
								$checked = ' selected="selected" ';
							}
							$check_box_html .= '<option value="'.$value.'"'.$checked.'>'.$value."</option>";
						}
						$check_box_html .= "</select>";
						echo '<td>'.$check_box_html.'</td>';
					}// select box input end here
					elseif($values['field_type'] == "radio")
					{
						$check_box_html = "";
						foreach($values['field_type_values'] as $value)
						{
							$checked = " ";
							if(get_user_meta($get_user_id, $values['meta_key'], true) == $value)
							{
								$checked = ' checked="checked" ';
							}
							$check_box_html .= '<input'.$checked.'type="radio" name="'.$values['meta_key'].'" value="'.$value.'" /> '.$value." &nbsp;&nbsp;";
						}
						echo '<td>'.$check_box_html.'</td>';
					}// radio input end here
					else
					{	
						echo '<td><input type="'.$values['field_type'].'" name="'.$values['meta_key'].'" value="'.get_user_meta($get_user_id, $values['meta_key'], true).'" class="regular-text"></td>';
					}// else input here
					echo '</tr>';
				}
			}
		?>
	</table>
    <script type="text/javascript" src="<?php echo $myplugin_urlpath; ?>js/script.js"></script>
<?php 
}// edit_user_profile_by_nuqta functino end here