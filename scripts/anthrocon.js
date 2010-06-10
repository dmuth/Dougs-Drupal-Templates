
jQuery.fn.anthrocon = {};

/**
* This function checks to see if our window is wide enought to allow the 
* right sidebar to be displayed.
*/
jQuery.fn.anthrocon.checkRightSidebar = function() {

		var width = $(window).width();
		//$("h1").append(width + " "); // Debugging

		var min_width = 1260;
		if (width < min_width) {
			$("#sidebar-right").hide();
		} else {
			$("#sidebar-right").fadeIn();
		}

} // End of checkRightSidebar()


$(document).ready(function(){

	//
	// Do the initial check for our right sidebar, and set it as a resize handler.
	//
	jQuery.fn.anthrocon.checkRightSidebar();
	$(window).resize(function() {
		jQuery.fn.anthrocon.checkRightSidebar();
	});

});

