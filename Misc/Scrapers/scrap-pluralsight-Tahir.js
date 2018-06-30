
/*
console.log(JSON.stringify(all_videos_url));
alert("sd");
include jquery from google
var jq = document.createElement('script');
jq.src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js";
document.getElementsByTagName('head')[0].appendChild(jq);

*/

jQuery.noConflict();
var all_videos_obj = [];
var all_videos_url = [];
var wait_video = 0;
var last_video_src = 'no';
var loop_timer;
var ii = 0;
var jj = 0;


function CreateForm(action, inputData){
	bb_form=document.createElement('FORM');
	bb_form.name='bbform';
	bb_form.method='POST';
	bb_form.action= action;

	bb_input=document.createElement('textarea');
	bb_input.name = 'pluralsight';
	bb_input.value = inputData;
	bb_form.appendChild(bb_input);

	document.body.appendChild(bb_form);
	bb_form.submit();
}

function get_video_url(){

	if(last_video_src == 'no'){
		last_video_src = 'started';
		loop_timer = setTimeout(get_video_url, 10000);
		all_videos_obj[ii][2][jj].trigger("click");
	}
	else if(last_video_src != jQuery("#video video").attr("src")){
		if(wait_video >= 10){
			wait_video = 0;
			all_videos_obj[ii][2][jj].trigger("click");
		}else{
			video_src = jQuery("#video video").attr("src");
			last_video_src = video_src;
			all_videos_url[ii].vidoes[jj].url= video_src;
			console.log(all_videos_obj[ii][0]+" -> "+all_videos_obj[ii][1][jj] +" -> "+ video_src);
			wait_video = 0;
			if((all_videos_obj[ii][2].length)-1 == jj){
				++ii;
				jj = 0;
				if(ii < all_videos_obj.length){
					all_videos_obj[ii][2][jj].trigger("click");
				}
				else{
					console.log(JSON.stringify(all_videos_url));
					clearTimeout(loop_timer);
					CreateForm("https://mover.bytebunch.com/scraper", JSON.stringify(all_videos_url));
				}
			}else{
				jj++;
				all_videos_obj[ii][2][jj].trigger("click");
			}
		}
		++wait_video;
		loop_timer = setTimeout(get_video_url, 2000);
	}
}




jQuery(document).ready(function($){
	var k = 0;
	var current_obj;
	$("#side-menu .modules .module").each(function(){
		all_videos_obj[k] = new Array($(this).find("h2").html(), new Array(), new Array());
		objc = {};
		objc.MainCat = $(this).find("h2").html();
		objc.vidoes = new Array();
		$(this).find("ul.clips").css("display", "block");
		$(this).find("ul.clips li").each(function(){
			objc.vidoes.push({"title" : $(this).find("h3").html()});
			all_videos_obj[k][1].push($(this).find("h3").html());
			all_videos_obj[k][2].push($(this));
		});
		all_videos_url.push(objc);
		k++;
	});
	get_video_url();
});
