// JavaScript Document
/******************************************/
/***** javascript for edit your profile page start from here **********/
/******************************************/

jQuery(document).ready(function($) {
    $("a.delete_image_link").click(function(e){
		$(this).parent().parent().find("input[type='text']").attr("value","");
		$(this).parent().parent().find("input.delete_image_hidden").attr("value",$(this).parent().parent().find("img").attr("src"));
		$(this).parent().parent().find("span.image_preview_span").hide();
	});
});
	
jQuery(document).ready(function($) {
    $(".upload_images_input").click(function(){
		var this_object = $(this);
				
		tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
		
		window.send_to_editor = function(html) {
		if ( $(html).is("a") ) {
			var imgurl = $('img', html).attr('src');
		}
		 else if ( $(html).is("img") ) {
			var imgurl = $(html).attr('src');
		}
		this_object.val(imgurl);
		tb_remove();
		this_object.parent().parent().find("img").attr("src",imgurl);
		this_object.parent().parent().find("span.image_preview_span").show();
	}
	});
});

/******************************************/
/***** javascript for creat user fileds page start from here **********/
/******************************************/

jQuery(document).ready(function($) {
	$("select.cuf_field_type").change(function(){
		var cuf_field_type = $(this).val();
		if(cuf_field_type == "checkbox" || cuf_field_type == "select" || cuf_field_type == "radio")
		{
			$(".cuf_field_type_values").show();
		}
		else
		{
			$(".cuf_field_type_values").hide();
		}
	});
});