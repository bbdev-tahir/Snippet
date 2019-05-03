jQuery(document).ready(function() {
 // executes when HTML-Document is loaded and DOM is ready
	jQuery(".megamenu").on("click", function(e) {
		e.stopPropagation();
	});
});