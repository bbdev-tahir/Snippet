<?php 
if ( ! get_option( 'create_user_fields_by_nuqta' ) ) add_option( 'create_user_fields_by_nuqta', serialize(array()) );
if ( ! get_option( 'create_user_fields_by_nuqta_ID' ) ) add_option( 'create_user_fields_by_nuqta_ID', 0);

add_action( 'admin_menu', 'admin_menu_create_user_fields' );
function admin_menu_create_user_fields() {
	add_submenu_page( 'users.php', 'Create User Fields Options', 'Create User Fields', 'edit_users', 'create_user_fields_details', 'admin_menu_create_user_fields_options' );
}

/******************************************/
/***** function to create plugins options page **********/
/******************************************/

function admin_menu_create_user_fields_options()
{
global $myplugin_urlpath;
global $myplugin_abspath;

if(isset($_POST['cuf_meta_key']) || isset($_POST['cuf_field_title']))
{
	if(isset($_POST['cuf_field_title']) && isset($_POST['cuf_meta_key']))
	{
		$cuf_field_type = $_POST['cuf_field_type'];
		$cuf_meta_key = $_POST['cuf_meta_key'];
		$cuf_field_title = $_POST['cuf_field_title'];
		
		$existing_values = array();
		$ID = (int)get_option('create_user_fields_by_nuqta_ID')+1;
		$existing_values = get_user_created_fileds_array();
		$new_field_values = array();
		$new_field_values['ID'] = $ID;
		$new_field_values['meta_key'] = $cuf_meta_key;
		$new_field_values['field_title'] = $cuf_field_title;
		$new_field_values['field_type'] = $cuf_field_type;
		
		if($cuf_field_type == "checkbox" || $cuf_field_type == "select" || $cuf_field_type == "radio")
		{
			$new_field_values['field_type_values'] = array_values(array_filter(explode("\n", str_replace("\r", "", $_POST['cuf_field_type_values']))));
		}
		
		$existing_values[] = $new_field_values;
		$new_values = serialize($existing_values);
		update_option('create_user_fields_by_nuqta',$new_values);
		update_option( 'create_user_fields_by_nuqta_ID', $ID);
		$updated = "Extra Fields Options Updated.";
	}
	else
	{
		$error = "Please provide both 'metakey' and 'field title' to add new field.";
	}
}
if(isset($_GET['action']) && $_GET['action'] == "delete" && isset($_GET['id']) && is_numeric($_GET['id']))
{
	$all_fields_array = get_user_created_fileds_array();
	foreach($all_fields_array as $keys=>$fields)
	{
		if($_GET['id'] == $fields["ID"])
		{
			unset($all_fields_array[$keys]);
		}
	}
	update_option('create_user_fields_by_nuqta',$all_fields_array);
}
include_once($myplugin_abspath."includes/table_for_user_fields.php");
?>
<style type="text/css">
table.add_cuf_table td
{
	vertical-align:top;
}
table.cuf_table td
{
	padding:10px;
	border:1px solid #000;
}
table.cuf_table
{
	border-collapse:collapse;
}
table.add_cuf_table td
{
	border:none;
}
</style>
	<div class="wrap">
    	<div id="icon-users" class="icon32"><br></div>
        <h2>Create User Fields Options</h2><br /><br />


        <?php if(isset($updated)){?>
        <div class="updated"><p><strong>Extra Fields Options Updated.</strong></p></div>
        <?php } ?>
        <?php if(isset($error)){?>
        <div class="error">
			<p><strong>Please provide both "metakey" and "field title" to add new field.</strong></p>
		</div>
        <?php } ?>
        <form action="" method="post" style="min-height:85px;">
        <table class="cuf_table add_cuf_table">
        	<tr>
            	<th>Field Title</th>
            	<th>Meta Key</th>
                <th>Field Type</th>
                <th class="cuf_field_type_values" style="display:none;">Type each value per line.</th>
                <th>&nbsp;</th>
            </tr>
        	<tr>
        		<td><input type="text" name="cuf_field_title" id="" /></td>
                <td><input type="text" name="cuf_meta_key" id="" /></td>
                <td class="cuf_field_type_td">
                <select name="cuf_field_type" class="cuf_field_type">
                	<option value="text">Text</option>
                	<option value="password">Password</option>
                	<option value="file">File / Image</option>
                    <option value="profile_image">Profile Image</option>
                    <option value="textarea">Text Area</option>
                    <option value="checkbox">Check Box</option>
                    <option value="select">Select</option>
                    <option value="radio">Radio Buttons</option>
                </select>
                </td>
                <td class="cuf_field_type_values" style="display:none;"><textarea name="cuf_field_type_values" id=""></textarea></td>
                <td><input type="submit" value="Submit" class="button-primary" /></td>
            </tr>
        </table>
        <?php //db(get_option('create_user_fields_by_nuqta')); ?>
        </form>
        <h3>Existing User Fields</h3>
       <?php 
	    $bookingListTable = new Booking_List_Table();
		$bookingListTable->prepare_items(); 
		$bookingListTable->display(); 
		?>
    </div><!-- wrap div end here-->
    <script type="text/javascript" src="<?php echo $myplugin_urlpath; ?>js/script.js"></script>
<?php }