<?php 
/*
Plugin Name: Create User Fields
Plugin URI: http://nuqtadesigns.com
Description: Allows you to add additional fields to the user profile like Facebook, Twitter etc.
Author: NUQTA Developers
Version: 0.0.1
Author URI: http://nuqtadesigns.com
*/
add_action('init', 'cuf_custom_js_script');
function cuf_custom_js_script()
{
	if(is_admin())
	{
		wp_enqueue_script('jquery');
		wp_enqueue_script('media-upload');
		wp_enqueue_script('thickbox');
		wp_enqueue_style('thickbox');
	}
}


//Administration
function dbp($array1)
{
	echo "<pre>";
	var_dump($array1);
	echo "<pre>";
}
function alertp($alertText)
{
	echo '<script type="text/javascript">';
	echo "alert(\"$alertText\");";
	echo "</script>";
}

/******************************************/
/***** change_image_uploader_text start from here **********/
/******************************************/
function get_user_created_fileds_array()
{
	$all_fields_data = get_option('create_user_fields_by_nuqta');
	if(!is_array($all_fields_data))
	{
		$all_fields_data = unserialize($all_fields_data); 
	}
	return $all_fields_data;
}


/******************************************/
/***** change_image_uploader_text start from here **********/
/******************************************/
//add_filter("attribute_escape", "change_image_uploader_text", 10, 2);
function change_image_uploader_text($safe_text, $text) {
    return str_replace("Insert into Post", "Insert profile image", $text);
}
/******************************************/
/***** function to get the current user id start from here **********/
/******************************************/

function get_user_id() {
	$get_user_id = empty( $_GET['user_id'] ) ? null : $_GET['user_id'];
	
	if ( ! isset( $get_user_id ) ) {
		$get_user_id = empty( $_POST['user_id'] ) ? null : $_POST['user_id'];
	}
	
	if ( ! isset( $get_user_id ) ) {
		global $current_user;
		get_currentuserinfo();
		$get_user_id = $current_user->ID;
	}

	return $get_user_id;
}// functino get_user_id function end here

/******************************************/
/***** Delete image **********/
/******************************************/

function delete_image( $image_url ) {  
    global $wpdb;  
  
    // We need to get the image's meta ID.  
    $query = "SELECT ID FROM wp_posts where guid = '" . esc_url($image_url) . "' AND post_type = 'attachment'";  
    $results = $wpdb->get_results($query);  
  
    // And delete it  
    foreach ( $results as $row ) {  
        wp_delete_attachment( $row->ID );  
    }  
}


global $myplugin_urlpath;
global $myplugin_abspath;
$plugins_folder_url = plugins_url();
$myplugin_abspath = plugin_dir_path( __FILE__ );
$myplugin_urlpath = plugin_dir_url(__FILE__);

// include create user fields page in plugin
include_once($myplugin_abspath."includes/create_user_fields_page.php");
include_once($myplugin_abspath."includes/profile_page.php");

$all_fields = get_option('create_user_fields_by_nuqta');
if(!is_array($all_fields)){ $all_fields = unserialize($all_fields); };
if(count($all_fields) >= 1)
{
	foreach($all_fields as $values)
	{
		if(in_array("profile_image", $values))
		{
			add_filter( 'get_avatar', 'avatar_override_by_nuqta', 10, 5 );
		}
	}// foreach loop end here
}

function avatar_override_by_nuqta( $avatar, $id_or_email, $size, $default, $alt ) {
		//Get user data
		if ( is_numeric( $id_or_email ) ) {
			$user = get_user_by( 'id', ( int )$id_or_email );
		} elseif( is_object( $id_or_email ) )  {
			$comment = $id_or_email;
			if ( empty( $comment->user_id ) ) {
				$user = get_user_by( 'id', $comment->user_id );
			} else {
				$user = get_user_by( 'email', $comment->comment_author_email );
			}
			if ( !$user ) return $avatar;
		} elseif( is_string( $id_or_email ) ) {
			$user = get_user_by( 'email', $id_or_email );
		} else {
			return $avatar;
		}
		if ( !$user ) return $avatar;
		$user_id = $user->ID;
		
		if(get_option("profile_image_metakey") && get_option("profile_image_metakey") != "")
		{
			$porfile_image_meta_key = get_option("profile_image_metakey");
			if(get_user_meta($user_id, $porfile_image_meta_key, true) && get_user_meta($user_id, $porfile_image_meta_key, true) != "")
			{
				$custom_avatar = "<img alt='".get_user_meta($user_id, "first_name", true)."' src='".get_user_meta($user_id, $porfile_image_meta_key, true)."' class='avatar avatar-$size photo' height='$size' width='$size' />";
			}
		}
		
		if ( !isset($custom_avatar) ) return $avatar; 
		return $custom_avatar;	
} //end avatar_override


?>