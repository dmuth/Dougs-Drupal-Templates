
jQuery.fn.fcn = {};

/**
* This function checks to see if our window is wide enought to allow the 
* right sidebar to be displayed.
*/
jQuery.fn.fcn.checkRightSidebar = function() {

		var width = $(window).width();
		//$("h1").append(width + " "); // Debugging

		//
		// If we go beneath 1260 pixels wide, remove the right
		// header graphic.
		//
		var min_width = 1260;
		if (width < min_width) {
			$(".fcn_header_right").hide();
		} else {
			$(".fcn_header_right").fadeIn();
		}

		//
		// If we go beneath 850 pixels wide, remove the left header graphic.
		//
		var min_width = 850;
		if (width < min_width) {
			$(".fcn_header_left").hide();
		} else {
			$(".fcn_header_left").fadeIn();
		}


} // End of checkRightSidebar()


$(document).ready(function(){

	//
	// Do the initial check for our right sidebar, and set it as a resize handler.
	//
	jQuery.fn.fcn.checkRightSidebar();
	$(window).resize(function() {
		jQuery.fn.fcn.checkRightSidebar();
	});

});

