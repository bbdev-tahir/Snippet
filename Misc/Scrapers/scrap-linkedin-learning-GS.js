
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

var course_title = jQuery('.course-banner__meta-title').find('a').text() + ' - October 2016';
console.log(course_title);

// Adjust these two variables if course is NOT Downloaded completely
// See last downloaded video, for example if last downloaded video is like 02_11_* .
// Then enter 2 for main adjust and 11 for sub_adjust
var main_adjust = 3;
var sub_adjust = 1; // if 0-5 files are downloaded than 5

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
        if (mins >= 35){
            total_time = total_time/9;
        } else if (mins >= 25){
            total_time = total_time/8;
        } else if (mins >= 15){
            total_time = total_time/7;
        } else if (mins >= 10){
            total_time = total_time/5;
        } else if (mins >= 7){
            total_time = total_time/4;
		} else if (mins >= 3){
			total_time = total_time/3;
		} else if (mins >= 2){
            total_time = total_time/2;
        } else {
            total_time = total_time/2;
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

