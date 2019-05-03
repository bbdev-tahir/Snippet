function lsLocalStorageAvailbleBB(){
    var test = 'test';
    try {
        localStorage.setItem(test, test);
        localStorage.removeItem(test);
        return true;
    } catch(e) {
        return false;
    }
}
jQuery(document).ready(function($){
	if(lsLocalStorageAvailbleBB() === true){
		// viewport stuff
		var targetWidth = 1400;
		var deviceWidth = 'device-width';
		var viewport = $('meta[name="viewport"]');

		// check to see if local storage value is set on page load
		localStorage.isResponsive = (localStorage.isResponsive == undefined) ? 'true' : localStorage.isResponsive;

		var showFullSite = function(){    
			viewport.attr('content', 'width=' + targetWidth);
			localStorage.isResponsive = 'false';
		}

		var showMobileOptimized = function(){
			localStorage.isResponsive = 'true';
			viewport.attr('content', 'width=' + deviceWidth);
		}

		// if the user previously chose to view full site, change the viewport
		
		if(localStorage.isResponsive == 'false'){
            $("#view-full").removeClass("view-desktop-version").addClass("view-mobile-version").html($(this).attr("data-mobile"));
            showFullSite();
            $("#view-full").parent().show();
		}

		$("#view-full").on("click", function(e){

			if($(this).hasClass("view-desktop-version")){
                $(this).removeClass("view-desktop-version").addClass("view-mobile-version").html($(this).attr("data-mobile"));
                $(this).parent().show();
                showFullSite();
			}else if($(this).hasClass("view-mobile-version")){
                $(this).removeClass("view-mobile-version").addClass("view-desktop-version").html($(this).attr("data-desktop"));
                showMobileOptimized();
			}
			return false;
		});

		$('#view-options').on("click", function(e){
			showMobileOptimized();
			return false;
		});
	}
});
