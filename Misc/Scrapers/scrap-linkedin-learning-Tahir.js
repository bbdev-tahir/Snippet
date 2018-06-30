
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
var waitForVideo = 30000;


function CreateForm(action, inputData){
	bb_form=document.createElement('FORM');
	bb_form.name='bbform';
	bb_form.method='POST';
	bb_form.action= action;

	bb_input=document.createElement('textarea');
	bb_input.name = 'linkedin';
	bb_input.value = inputData;
	bb_form.appendChild(bb_input);
	
	bbcn_input=document.createElement('textarea');
	bb_input.name = 'course-name';
	bb_input.value = $('.course-banner__meta-title').find('a').text();
	bb_form.appendChild(bb_input);
	

	document.body.appendChild(bb_form);
	bb_form.submit();
}

function get_video_url(){

	if(last_video_src == 'no'){
		last_video_src = 'started';
		loop_timer = setTimeout(get_video_url, waitForVideo);
		all_videos_obj[ii][2][jj].find('a.toc-item').trigger("click");
	}
	else if(last_video_src != jQuery(".video-container video").attr("src")){
		if(wait_video >= 10){
			wait_video = 0;
			all_videos_obj[ii][2][jj].find('a.toc-item').trigger("click");
		}else{
			video_src = jQuery(".video-container video").attr("src");
			last_video_src = video_src;
			all_videos_url[ii].vidoes[jj].url= video_src;
			console.log(all_videos_obj[ii][0]+" -> "+all_videos_obj[ii][1][jj] +" -> "+ video_src);
			wait_video = 0;
			if((all_videos_obj[ii][2].length)-1 == jj){
				++ii;
				jj = 0;
				if(ii < all_videos_obj.length){
					all_videos_obj[ii][2][jj].find('a.toc-item').trigger("click");
				}
				else{
					console.log(JSON.stringify(all_videos_url));
					clearTimeout(loop_timer);
					CreateForm("https://misc.bytebunch.com/", JSON.stringify(all_videos_url));
				}
			}else{
				jj++;
				all_videos_obj[ii][2][jj].find('a.toc-item').trigger("click");
			}
		}
		++wait_video;
		loop_timer = setTimeout(get_video_url, waitForVideo);
	}
}




jQuery(document).ready(function($){
	var k = 0;
	var current_obj;
	$(".course-sidebar .course-chapter").each(function(){
		all_videos_obj[k] = new Array($(this).find("span.course-chapter__title-text").text(), new Array(), new Array());
		objc = {};
		objc.MainCat = $(this).find("span.course-chapter__title-text").text();
		objc.vidoes = new Array();
		$(this).find(".course-chapter__items").css("max-height", "9999px");
		$(this).find(".course-chapter__items .video-item").each(function(){
			objc.vidoes.push({"title" : $(this).find("div.toc-item__content").children().remove().end().text()});
			all_videos_obj[k][1].push($(this).find("div.toc-item__content").children().remove().end().text());
			all_videos_obj[k][2].push($(this));
		});
		all_videos_url.push(objc);
		k++;
	});
	//console.log(all_videos_url);
	//console.log(all_videos_obj);
	get_video_url();
});




















function CreateForm(action){
	bb_form=document.createElement('FORM');
	bb_form.name='bbform';
	bb_form.method='POST';
	bb_form.action= action;

	bb_input=document.createElement('textarea');
	bb_input.name = 'linkedin';
	bb_input.value = 'testing2';
	bb_form.appendChild(bb_input);
	
	bbcn_input=document.createElement('textarea');
	bbcn_input.name = 'course-name';
	//bbcn_input.value = $('.course-banner__meta-title').find('a').text();
	bbcn_input.value = 'testing';
	bb_form.appendChild(bbcn_input);

	document.body.appendChild(bb_form);
	bb_form.submit();
}
CreateForm('https://misc.bytebunch.com/');


var dcata = '[{"MainCat":"Introduction","vidoes":[{"title":"Welcome                    \n\n                  \n                ","url":"https://files3.lynda.com/secure/courses/585275/VBR_MP4h264_main_SD/585275_00_01_WX30_welcome.mp4?RAW8l4-4npu_vteKWc4_9dHnpSH69iehMHZenkUPSE7OPDk06rYzgXwlCQ-0qe2iOxzMQ-iFx5HCrc03r_TGsraI6ohFHQ_gb70naOFJLYDZRC9Ymno-VzON-2WWK5K4n_5sfLwYGnl-2xQC-kaImXn_lxl8aWPBbC4ZN4z8KmULQ55tm4o"},{"title":"How to use the exercise files                    \n\n                  \n                ","url":"https://files3.lynda.com/secure/courses/585275/VBR_MP4h264_main_SD/585275_00_02_XR15_exfiles.mp4?BAYS6hprWGArzul8l7sKgWss5RRjo8gK1d-QwLS9NNMLaYUSh9CZvln8X4yNY0uZ6X20jQst0wI9_zsD_pnDRc98-GGAJLqD0V2Sn6vzlGhq9fE7pP6WYY9YhWTX-PbXphu3yXv0JRQ-b2wFvQIM8QYQVBwANyIelHGz18scWYTjlZygGvM"},{"title":"What you need                    \n\n                  \n                ","url":"https://files3.lynda.com/secure/courses/585275/VBR_MP4h264_main_SD/585275_00_03_XR30_prerequisites.mp4?f9lO_wm7kW_PR_mhIHsh5Y-mCqiMYnPdgJbXfWPwAvr_uzn-TYv5t_BxWehUYXN1B0hoYfKgUQ3UCb4D_t7gkfJ9lmiZDcxivttnC8iLX1KcTrKJekGEyz2y_rEaG705vEr1JrAQWOSlPLfGernVOi8hHRZjhAGGt8JEuy1Ng77hEIVyuOgDr5NjleU"}]},{"MainCat":"1. What Is Authentication?","vidoes":[{"title":"What is authentication and when do you need it?                    \n\n                  \n                ","url":"https://files3.lynda.com/secure/courses/585275/VBR_MP4h264_main_SD/585275_01_01_XR30_whatis.mp4?VQD8hkif5NHaiftxbd88Zn0uy9z9vjGQnh4LzY-q3FCW-0gI2uORXagJkTFZr8Nqao6a67Vyqv5Gh02Ne-LfzYGifGOsUIdKIc0VjzNPknMIS0RM4XJ3xDxeHJOVhpFjC50iRXozvvg2ehOjvA7CRVHfNj2eL6BEXl2624g4QDofRxU_rA"},{"title":"What type of authentication is needed?                    \n\n                  \n                ","url":"https://files3.lynda.com/secure/courses/585275/VBR_MP4h264_main_SD/585275_01_02_XR30_types.mp4?kojsBMdIVlyzNPOLvtev7NmkLm-ekfz-UycyL1T5AOekPXQDaGvg71mXCER-9JS9MhC3B3nA6V459kPmI5XCAnxShB9677iqQx4Rq-A48-Y5QCoyG7ZTNWXuayUcUNSYMK5LOnrGhuopYalIv5_-9WIynyY-T7UxXok6vuXOHCDpSZWF"},{"title":"Authentication requires encryption                    \n\n                  \n                ","url":"https://files3.lynda.com/secure/courses/585275/VBR_MP4h264_main_SD/585275_01_03_XR30_encryption.mp4?34CpJiDJ_ys-E3ZdcSox-Cl_mL2WS9bVhEEURbmyJf9PZZThO3nL9bupSvy3-y1KllxMEfovkdG2l0_NLjXwZvqCLrBxa_lL43CPVkZoISsQXh_oH6whPscDdGF-DelWQ98H9GHNYWYhz1uwXQdw39XuCjs2jSJOkgyR8BsBDZ5gPSpfQztlyOU"},{"title":"Sidebar: Basic authentication for development, and ONLY development                    \n\n                  \n                ","url":"https://files3.lynda.com/secure/courses/585275/VBR_MP4h264_main_SD/585275_01_04_XR15_basic.mp4?aNpdUnDR0YoWJ4cI4p8kUOL3TU8abYlBICLsNEFsPaWIaREbTDZzZrULzmaon-2sg-QehT9IQmEhxRsC0MxwqoQA5MOR-ICvsoZDaMb5SUOjjSu6uHclTlH7JmgGu2C3phUu8NhkbfPpYKcuCLo96H9jYkWGOGTm94ebvKLWq2Qrq22l"}]},{"MainCat":"2. Cookie Authentication","vidoes":[{"title":"What is cookie authentication?                    \n\n                  \n                ","url":"https://files3.lynda.com/secure/courses/585275/VBR_MP4h264_main_SD/585275_02_01_XR30_cookie.mp4?Kz86WXh3OjBOTi1iZLqv_OwUhqlu2LCQ8FcWy715xRjhKovwsPLDzBipkBLvdcb5N_fvCToWRA8I7U8SB8hzj2ZxcsvDVUmUOfhj1SXGyllipPt8Ev1AMbXJoh0YJCanjrP0eG2ihz76IeRCCt5lw9ILc57NEZRzoLRAY0fwm9oZFUhZjQ"},{"title":"Prevent Cross-Site Request Forgeries (CSRF) with nonces                    \n\n                  \n                ","url":"https://files3.lynda.com/secure/courses/585275/VBR_MP4h264_main_SD/585275_02_02_XR30_CSRF.mp4?hbGXgImFK-eC2Aiat442puY1HPg_bYZUSeKeQrRvkRNdUPeDV7UBwmbS7jIeSZF9039_pizE4kPuTXc_GcatcIzrQ6FSDYDPyNK5gu3YYybILb8Wr1ZKu_aFQs2NqelktETL0hg3XDGIuMV3rJN4N-XoWp-UllC8ud7nB-OpqNyoGAA"},{"title":"Preview of the REST API-enabled front-end editing plugin                    \n\n                  \n                ","url":"https://files3.lynda.com/secure/courses/585275/VBR_MP4h264_main_SD/585275_02_03_XR15_intro.mp4?6T9-iAqz-Beg5Eq3f81w4fGKZkDICT2jZ9JjjSNhMhiTzyCBfvV23VkiuJsaS1S5Nbl5d7OOMKIfByEuOBNw4FIBBzXGJZYs55vz_s4Xbm1pwsEhOdtl0mXS3uSPhyQVKqebzSuuCA0_zqYx2ND6tEIKXdHWY6hiUO4ggELOapd7xKbK"},{"title":"Create a plugin for front-end editing                    \n\n                  \n                ","url":"https://files3.lynda.com/secure/courses/585275/VBR_MP4h264_main_SD/585275_02_04_XR15_js.mp4?wbsWoxh1A0bG6iH_lKrmTcAEaHCBL-Imdk7amwfzAlnB_kLvWl60oMRHFxya9NaC0E-W-O9eqZqp_VY3atpL6LuAg7RlLeecJEuPUnAwkBxAHgQZwZfUnCXyGw7_fml0wTYEKxluK2AvNMHOHB2fsdpmF-FVfGcpbFcKFNomtMTW"},{"title":"Pass nonce and other information from WordPress to the JavaScript                    \n\n                  \n                ","url":"https://files3.lynda.com/secure/courses/585275/VBR_MP4h264_main_SD/585275_02_05_XR15_localize.mp4?rZ5jgbwzJGJwxPlDscsSvly5Mmx0EaAQlodlbeo1zWwhs_E--bbdKPUu_aLOVKxgsUa6H3TwgVidnO-blPmZPlA2X3GmbU46VHFaMQkIB85HsdAWVjvDgsApZmDEcbyROwLzzAqUlZoOmOQhV1zKxTgj9DlJuKZEK6ApBqUkim_Xux9bHt7T"},{"title":"Add the front-end editing functionality using jQuery                    \n\n                  \n                ","url":"https://files3.lynda.com/secure/courses/585275/VBR_MP4h264_main_SD/585275_02_06_XR15_editbutton.mp4?ozvVbL2yWpTlmERFHNlKFXP2D1UF81H83T_MBXSSLrAEDiTK511tIodW03X4nqyytstx0z_yK8C_osyjWRJWb_hLnJxH9IbSVZVEKfmS4d6_1rXS6Yl0rBMMhXUI0BbrusyF-YBtpzAJtVVT-qMSmEqb9VkrsdwzniL77QZk7GSVntSrHFklECg"},{"title":"Send nonce-authenticated Ajax requests to the REST API                    \n\n                  \n                ","url":"https://files3.lynda.com/secure/courses/585275/VBR_MP4h264_main_SD/585275_02_07_XR15_ajax.mp4?fDorW2poLPfzgXfENc0LzoyZ-FtVCzZ5RDrIZkmHbwtlbxBJ6_hvkf2RzIZ475UJ5D-er2kL6XxL6-OdpahQhLJY4CNF9nyjoXGMpD99rBoK0pMaaFdql5NX8oqz7vXhD2io3WpHunlPJwQ8KsRB_uzFFQ30OejP_E641eEQAEY4hPI"},{"title":"Limit front-end editing to authorized users                    \n\n                  \n                ","url":"https://files3.lynda.com/secure/courses/585275/VBR_MP4h264_main_SD/585275_02_08_XR15_restrict.mp4?WygBJvLfaGLCgfaNoNkEZSWLMmOQ7maZ_vGs_qlUp-kg4Pt6fsg-PLGQV9HdLx2irVFoKhHscbwy7FQbqMlKDCJ4hgoNEdi2YeyZ1yFV2x4LVw8Dho6-Oc3kvuzUSI9Qtrs1-dXN6iWpomfYAdnH2rFadESJyBnHm3k1BRlg_nwQBc571orm"}]},{"MainCat":"3. JWT Authentication","vidoes":[{"title":"What is JWT authentication?                    \n\n                  \n                ","url":"https://files3.lynda.com/secure/courses/585275/VBR_MP4h264_main_SD/585275_03_01_XR30_JWT.mp4?buBDr-OjcWkIkodulI8iLjFMMrBmsND6vE5bY5Q63GBtHGZBSe77bhdCK8VLfnKiIyE63d9WnJ_sBJ6pRK1WRV_5uV8DNrvAi-r77NvME32d0A-Iq0Xv90-r_Ff1bjD8Ubc3vBJ8WrVGwnxok07ByHp1oKBxsGBbSQdv-NII0XP6YA"},{"title":"Set up JWT support with a plugin                    \n\n                  \n                ","url":"https://files3.lynda.com/secure/courses/585275/VBR_MP4h264_main_SD/585275_03_02_XR15_plugin.mp4?2eUO2IfrkbrvTuG4NNskzk4UAnTXlXk7kjKblCfCxOFbEx2r6G_SSR4vC-TeOIO3kQqtT5SlVPy89QqIOlRdeJxcSWXx_0UeP1X8Pk974uGc-BXlGk9tmp6E9-uwsmTHgIBIpgvte2VFuvxWEEhQM-ge_leEhbC7w1LNEyDiV9Z-uSeUlw"},{"title":"Test the JWT authentication in Postman\n                  \n                ","url":"https://files3.lynda.com/secure/courses/585275/VBR_MP4h264_main_SD/585275_03_03_XR30_postman.mp4?moroNbtc00G0jn0SN_ZsSeKf2WQw26KQpPzD09lgRSd0zoOdaN6RHjyJaexlNPnoimS1RCsSGyXYeGwXAeiUoj2QktqfbvfrDy8kIUEZTP0f_49PeXXHTEgmuA4F5WMyl1ayUldXTAtVFK9vE0tjiEkvxIMt-VKdguz7TVVGdq62cNhrw5I"},{"title":"Preview of the stand-alone WP Edit app\n                  \n                ","url":"https://files3.lynda.com/secure/courses/585275/VBR_MP4h264_main_SD/585275_03_04_XR15_preview.mp4?bANFoKPSzGW5NyYEtQIZKt4v8mO06jPVKHWV2lM42rclVjnWTA7n9N-F7QKWt8hSr3sMh_xGSx_LBY3v5-cDNDOj2Rh-959LnWUhoEoxLa1ncVNPKysWABvvsi96mxmwMnJZFZNBfm5qnnK2gE1dJ6b8QmBF2pAzSDofz_tE9YpcxVtyUmE"},{"title":"Capture login information with JavaScript\n                  \n                ","url":"https://files3.lynda.com/secure/courses/585275/VBR_MP4h264_main_SD/585275_03_05_XR15_form.mp4?kUqJuXz4R6n3dWH_Pv7i6VpUeBpmImDHpp_DEk1HyP37Mu2v5wunvHid5wvBmtAM7qWPdG7iOBPWfIODx463eHiYzrBm3nAs_zlOQ7FqHZKMMsmV5kP4AKGWvkCkCJRU6Q82B6aSaaNmuZvHkNNgE_OG2qTcn6WgbBHqG2YxqFHNt9g"},{"title":"Get the JWT token using Ajax\n                  \n                ","url":"https://files3.lynda.com/secure/courses/585275/VBR_MP4h264_main_SD/585275_03_06_XR15_gettoken.mp4?dqSE4n4dmZuxvhZvryXXnllAgJT0DBPM7Px1GEPjxBp8f_cyi3GwDPzwwYVhhz3U5Wqbay0UemQTYWym-NT3Ww22w58g8ItA4lNfv-9Cv57X694BGgMxEoixTDDN5RveeAAb51SQQ_PDTaRA_q9M3GnPbXRTKn-Xw1FP1Yn8bX4NlkzJdHLF"},{"title":"Add editing capability using Ajax\n                  \n                ","url":"https://files3.lynda.com/secure/courses/585275/VBR_MP4h264_main_SD/585275_03_07_XR15_edittitle.mp4?hxrUYi59tD_xbO9ATco22FNhEsMz9rKa_H_lUEXO-3fH66vd8oNFiooHchKLg5e6PJj1QCcrxFd325-9UDw1EZegcG-pSA7gYIjTkC1LOwmA1NFdzJ3D0NGeEC-8sA5hWZWcJN5VnWAXnQ79t7EzGSih3RStjtexJMy8IfXBZ_P61FAaBu9RzA"},{"title":"Add conditions for different scenarios\n                  \n                ","url":"https://files3.lynda.com/secure/courses/585275/VBR_MP4h264_main_SD/585275_03_08_XR15_conditions.mp4?J00kBjTKA3Mk2ONICvkywZEw0lJzEjWS35-H2KuhcMaEXzTGMw7VQeiIRUvnED2cFtAAlnG8HRCJfGP0jVUdLL0id29wBrp7JQKiej3DKyUziQ_hxTL9FPHtp8CUe9jRoWLiq7rZQyBJzsplwdTh80Rgx3bzTcMomAc33fV7lEfAvGDO8bB4-p8"}]},{"MainCat":"4. OAuth 2 Authentication","vidoes":[{"title":"What is OAuth 2 authentication?\n                  \n                ","url":"https://files3.lynda.com/secure/courses/585275/VBR_MP4h264_main_SD/585275_04_01_XR30_oauth.mp4?T7xvFqq-PRhLCMBfxGclwUMCBUHU1OL_ktn2ajZsR2D93p34r0GhvwUyiBlFYlv6TZn73FGjyNIvwIrvb6Hmt05rHLIrmpDVaemBKXa4QUGqP76QpVYTxMRxB-GNsr9nJUpQ7JWg87hj-65mrQLWpX-bu6K062MSEKo7590YUZaN7AUN"},{"title":"Install WP OAuth Server plugin\n                  \n                ","url":"https://files3.lynda.com/secure/courses/585275/VBR_MP4h264_main_SD/585275_04_02_XR15_plugin.mp4?EJSjf4uLbx8GRuPCpFMqb02QedXHCFyHZy-07NQYbePbTPeYyFEQQYKTWxfMDill9mmT75gf9ax0ywhUcLHEvXJFDWkqaJ175o5MVvuc9f4EESNmCXU1jVIZrHL8W4ztaWTCtwyc_G_u6AGVPQ6NKv5LIWh3U1QaALDxh7aWuvoAgXI7jg"},{"title":"Registering the client application with the OAuth server\n                  \n                ","url":"https://files3.lynda.com/secure/courses/585275/VBR_MP4h264_main_SD/585275_04_03_XR15_JSO.mp4?NldHRgvVQr-IQUe1svQSkygpedUS8cjP5nIoureE2OAb-eitzBvON80gn_Wdc5qW1VKlrbFX7rCmIhCV7jfvMfSHxNOnbwiLTid6N9wwmsXexzsa9PMY7Z5Bc2ysQCUM5X7Dmp7ZLiN7-iKXfAP8aic3gFwVW2TH4RNtlGfL8D3Wkg"},{"title":"Configure JSO\n                  \n                ","url":"https://files3.lynda.com/secure/courses/585275/VBR_MP4h264_main_SD/585275_04_04_XR15_JSO_VID_PU.mp4?pTVu9ZlLQnuyXvzbprI19mhfpxUuEAfV2VBFK3rATJ86d1s7L5NjN4O4gg4hho6-9D8HDtanXgqW-ZTUfCAC50fNBIdgG_0ZuGSZGPAjng7BGI-rMd3SSWaMcYdIfk0isb4G79L5w6yzC26FoOU1q4NB9hQAbIGtu999e-JtD0V6syrFqUSpmAg"},{"title":"Get an OAuth 2 token using JSO\n                  \n                ","url":"https://files3.lynda.com/secure/courses/585275/VBR_MP4h264_main_SD/585275_04_05_XR30_JSOtoken.mp4?mB6n7MCPvRYkXXS-vqJRYU_31978OWUjQrfh5_d6BMxlkCWv9CltPoEHhL90ED4ADfvVbToRq8C2E6Gaei6getssxzmZWCJpH5m0uMXWcis4BohGp83B35xSyCsqtrxvz3fZ17Ot1SDrkqMDxdyslOBr_TiuL5gAEqYLCjtbMzdR9npEH9rB"},{"title":"Run authenticated requests to the REST API using JSO\n                  \n                ","url":"https://files3.lynda.com/secure/courses/585275/VBR_MP4h264_main_SD/585275_04_06_XR15_request.mp4?rQ5MZ7BssDhRJ5FCDBoAI4CI3ww9_muw_74xCfr9ar384qj1Wuo3v7UCamsbc1XulFQ460-HknB0eYDdw2X2SEqZL_vgQuEEH15nYLvTlVMVEr5m5f9_bsVcmxONzwgAEozBTJqOKmeOzoIah08HZJEvKxDcH6oogM9oArCQsArb5m4sgHY"},{"title":"Make login and log out states meaningful\n                  \n                ","url":"https://files3.lynda.com/secure/courses/585275/VBR_MP4h264_main_SD/585275_04_07_XR15_logic.mp4?4vPI3_ofw2JxQNaVRhEJnFZsZKvYHHzzZHZovFR1GtoapyhVUeWgV7qdeq-WTiO3OVJDvzl3WisJfZfuoQImTYINs49l6E9Yxia9dmedv8Vg4b4BUP1xjXceHDuKgpFRdp11qDuz-6slBYdHg303ssq0yJ8gkSd5KTx20iouP4TLUZIn"}]},{"MainCat":"Conclusion","vidoes":[{"title":"This is just the beginning\n                  \n                ","url":"https://files3.lynda.com/secure/courses/585275/VBR_MP4h264_main_SD/585275_05_01_XR15_thankyou.mp4?uT0JUQ8Csn63lJNVRS3b4W5Oifz3xgjelFPTOX0XP7X6u1W31p_fHPeKxZOQwEYCW05EenGJRCiduVsTc0CZ_qqYcFaUDrzktU5lMOrqX967B9tr9YdWsAM9JYTIBLecqNPcU8jM2-AJRtUxjVnrOfPzGkX88mHjBipkCegHq3p7BDqsRHSO"}]}]';
$.ajax({
    url: 'https://misc.bytebunch.com/',
    type: "POST",
    data: dcata,
    contentType: "application/json",
    complete: function(){ alert('yeah');    },
});



























/*

Step 1: Write down release date of course and start it. Press F12, and open console tab
Step 2: Replace date with correct released date in below given code i-e var course_title = jQuery('#course-title').text() + '-Feb 16';
Step 3: Select all code using Ctr+A and paste on console

*/


jQuery.noConflict();
var all_videos_obj = [];
var all_videos_url = [];
var wait_video = 1;
var last_video_src = 'no';
var last_time = 'nothing';
var loop_timer;
var main_cat = 0;
var sub_cat = 0;
var half_wait = 0;
var total_time = 1;
var last_title = '';

var course_title = jQuery('.course-banner__meta-title').find('a').text() + ' - March 2017';
console.log(course_title);

// Adjust these two variables if course is NOT Downloaded completely
// See last downloaded video, for example if last downloaded video is like 02_11_* .
// Then enter 2 for main adjust and 11 for sub_adjust
var main_adjust = 0;
var sub_adjust = 0; // if 0-5 files are downloaded than 5

// DO NOT CHANGE BELOW ===========================================
var adjust = 0; // Do not change it.. if 1 is downloaded completely then 1, if it breaks sometimes, we can use this to create correct sequence number.

if(main_adjust > 0){
    adjust = main_adjust - 1
}




//
function CreateAjax(inputData){
	
    jQuery.ajax({
        url : "https://mover.bytebunch.com/test",
        type : "post",
        data: {pluralsight: inputData}
    });
}


function randomIntFromInterval(min,max)
{
    return Math.floor(Math.random()*(max-min+1)+min);
}

function get_video(){
    console.log('in get video');
    //video_src = jQuery("#video video").attr("src");
    //last_video_src = video_src;
    //all_videos_url[main_cat].vidoes[sub_cat].url= video_src;
    //console.log(all_videos_obj[main_cat][0]+" -> "+all_videos_obj[main_cat][1][sub_cat] +" -> "+ video_src);
    //
    //var data = {course_title: course_title, main_cat: (main_cat+1+adjust) + '_' +all_videos_obj[main_cat][0], title: (main_cat+1+adjust) + '_' + (sub_cat+1) +'_'+all_videos_obj[main_cat][1][sub_cat], url: video_src };
    //CreateAjax(JSON.stringify(data));

    wait_video = 0;
    if((all_videos_obj[main_cat][2].length)-1 == sub_cat){
        // all videos in this main_cat are done then go for nex cat
        console.log('all videos in this main_cat are done then go for nex cat');
        ++main_cat;
        sub_cat = 0;
        if(main_cat < all_videos_obj.length){ // make sure its not completd i-e main_cats are remaingn
            console.log('next main cat click started');
            all_videos_obj[main_cat][2][sub_cat].find('a.toc-item').trigger("click"); // click on first video of next main cat
        }else{
            console.log(JSON.stringify(all_videos_url));
            console.log('DONE........');

            clearTimeout(half_wait);
            clearTimeout(loop_timer);
            return;
            //CreateForm("https://mover.bytebunch.com/scraper", JSON.stringify(all_videos_url));
        }

    }else{
        // go for next video in this cat
        console.log('next video cilck');
        sub_cat++;
        all_videos_obj[main_cat][2][sub_cat].find('a.toc-item').trigger("click");
    }
    ++wait_video;
    console.log('gonna call get fideo url after 10 sec');
    loop_timer = setTimeout(get_video_url, randomIntFromInterval(5000, 10000)); // wait
}

function get_video_url(){
    console.log('get vieo url called...');

    if (main_cat == 0 && sub_cat < sub_adjust){
    console.log('sub cat less then sub adjust');
        sub_cat++;
        console.log('sub cat', sub_cat);
        get_video_url();
    } else if(last_video_src == 'no'){ // just for the first time
        console.log('first time condtino');
        console.log('sub_cat', sub_cat);

        last_video_src = 'started';
        all_videos_obj[main_cat][2][sub_cat].find('a.toc-item').trigger("click");
        loop_timer = setTimeout(get_video_url, randomIntFromInterval(5000,10000));
    } else if(last_video_src != jQuery(".video-container video").attr("src") && last_time != jQuery('.ssplayer-time-display-duration').text() && last_title != jQuery('h1.course-banner__headline').children().remove().end().text()){
        console.log('video loaded successfully');

        // video loaded successfully, Download
        video_src = jQuery(".video-container video").attr("src");
        last_video_src = video_src;
        all_videos_url[main_cat].vidoes[sub_cat].url= video_src;
        console.log(all_videos_obj[main_cat][0]+" -> "+all_videos_obj[main_cat][1][sub_cat] +" -> "+ video_src);

        var seq_num = ('0' + (main_cat+1+adjust)).slice(-2); // always return 2 digits
        var sub_seq_num = ('0' + (sub_cat+1)).slice(-2); // always return 2 digits

        var main_title = sanitize(/*seq_num + '_' +*/all_videos_obj[main_cat][0]);
        var sub_title = sanitize(seq_num + '_' + sub_seq_num +'_'+all_videos_obj[main_cat][1][sub_cat]);

        var data = {course_title: sanitize(course_title), main_cat: main_title, title: sub_title, url: video_src, email: 'tahir@bytebunch.com' };
        CreateAjax(JSON.stringify(data));
		


        last_time = jQuery('.ssplayer-time-display-duration').text(); //note this is just string like '4:36'
        last_title = jQuery('h1.course-banner__headline').children().remove().end().text(); // Some videos have same time as previous, so that's why we need this


        // optional: wait for half time
        var times = jQuery('.ssplayer-time-display-duration').text().split(':'); // minutes at 0 index, sec at 1
        var mins = parseInt(times[0]);
        var secs = parseInt(times[1]);

        console.log('Time: min: ', mins);
        console.log('Time: sec: ', secs);

        total_time = ((mins*60 + secs ) * 1000);
        if (mins > 35){
            total_time = total_time/9;
        } else if (mins > 25){
            total_time = total_time/8;
        } else if (mins > 15){
            total_time = total_time/7;
        } else if (mins > 10){
            total_time = total_time/5;
        } else if (mins > 7){
            total_time = total_time/4;
        } else {
            total_time = total_time/3;
        }

        console.log('Total: mili sec: ', (total_time/1000));
        console.log('get video shoudl run after above sec');

        half_wait = setTimeout(get_video, total_time );

    } else {

        // is not loaded yet :( wait again
        console.log('is not loaded yet :( wait again');
        console.log('last_title: ', last_title);
        console.log('current_title: ', jQuery('h1.course-banner__headline').children().remove().end().text());
        console.log('last_time: ', last_time);
        console.log('current time: ', jQuery('.ssplayer-time-display-duration').text());
        console.log('last url: ', last_video_src);
        console.log('current url: ', jQuery(".video-container video").attr("src"));

        if(wait_video%5 == 0){
            all_videos_obj[main_cat][2][sub_cat].find('a.toc-item').trigger("click");
            if(wait_video >= 15){  wait_video = 0;  } else if(wait_video >=10){  last_time == jQuery('.ssplayer-time-display-duration').text() ? last_time= '' : last_title = ''}
        }
        ++wait_video;
        loop_timer = setTimeout(get_video_url, randomIntFromInterval(5000,wait_video * 10000));
    }
}

function sanitize(str){
    return str.replace(/[,'$]/g, '').replace(/\//g, ' OR ');
};



jQuery(document).ready(function(){
    var k = 0;
    var current_obj;
    jQuery(".course-sidebar .course-chapter").slice(adjust,50).each(function(){
        //jQuery("#side-menu .modules .module").each(function(){
        all_videos_obj[k] = new Array(jQuery(this).find("span.course-chapter__title-text").text(), new Array(), new Array());
        objc = {};
        objc.MainCat = jQuery(this).find("span.course-chapter__title-text").text();
        objc.vidoes = new Array();
        jQuery(this).find(".course-chapter__items").css("max-height", "9999px");
        jQuery(this).find(".course-chapter__items .video-item").each(function(){
            objc.vidoes.push({"title" : jQuery(this).find("div.toc-item__content").children().remove().end().text()});
            all_videos_obj[k][1].push(jQuery(this).find("div.toc-item__content").children().remove().end().text());
            all_videos_obj[k][2].push(jQuery(this));
        });
        all_videos_url.push(objc);
        k++;
    });
    get_video_url();
});




