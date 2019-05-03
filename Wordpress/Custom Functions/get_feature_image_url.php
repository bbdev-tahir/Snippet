<?php
/******************************************/
/***** get featured image url **********/
/******************************************/
if(!function_exists("get_feature_image_url")){
  function get_feature_image_url($post_id, $size = 'full', $default = false)
  {
  	if(has_post_thumbnail($post_id))
  	{
  		$image5 = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), $size );
  		return $image5[0];
  	}
  	else
  	{
  		return $default;
  	}
  }
}
