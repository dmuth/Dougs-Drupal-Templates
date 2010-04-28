
/**
* Our SAC class, with specific functions.
*
* @author Douglas Muth (http://www.claws-and-paws.com/)
*/
SAC = function() { }


/**
* Serialize the keys in our array.
*
* @return string A comma-delimited string of keys.
*/
SAC.prototype.serialize = function(data) {

	var retval = "";
	for (key in data) {
		if (retval) {
			retval += ",";
		}
		retval += key;
	}

	return(retval);

}; // End of serialize()


/**
*
* Retrive our status cookie, split it up, and save the 
* values as keys
*
* @return array An array of our block status where the keys
*	are the IDs of blocks that are to be hidden.
*/
SAC.prototype.get_status = function() {

	var retval = {};

	var cookie = $.cookie("block-status");
	if (cookie) {
		cookie = cookie.split(",");
		for (key in cookie) {
			retval[cookie[key]] = true;
		}
	}

	return(retval);

}; // End of get_status()


/**
* This function is called whenver a menu header is clicked.
*
* @param obj sac The SAC object.  This is passed in so that we can
*	address the status array.
*
* @param obj e The HTML entity.  Equivilient to "this" in jQuery.
*/
SAC.prototype.toggle_menu = function(sac, e) {

	var id = $(e).parent().attr("id");
	var title = $(e);

	$(e).siblings().slideToggle("normal", function() {

		var display = $(this).css("display");

		if (display == "none") {
			sac.title_collapse(title);
			sac.status[id] = true;

		} else {
			sac.title_expand(title);
			delete (sac.status[id]);
		}

		//
		// Figure out what's going on in Safari
		//
		// alert("TEST3: " + id);
		var tmp = sac.serialize(sac.status);
		var params = {"expires": 30, "path": "/"};
		$.cookie("block-status", tmp, params);

		});
	
}; // End of toggle_menu()


/**
* Set the arrow on the title to collapsed.
*
* @param object title Our title entity.
*/
SAC.prototype.title_collapse = function(title) {
	//var image = directory + "/images/menu_arrow_collapsed.gif";
	//title.css("background-image", "url(" + image + ")");
	//title.css("background-position", "5px 50%");
	//title.css("background-repeat", "no-repeat");
} // End of title_collapse()


/**
* Set the arrow on the title to expanded.
*
* @param object title Our title entity.
*/
SAC.prototype.title_expand = function(title) {
	//var image = directory + "/images/menu_arrow_expanded.gif";
	//title.css("background-image", "url(" + image + ")");
	//title.css("background-position", "5px 50%");
	//title.css("background-repeat", "no-repeat");
} // End of title_expand()


//
// Stuff to execute when the page is done loading.
//
$(document).ready(function(){

	var sac = new SAC();

	//
	// Make all headers clickable so that they can be hidden/shown
	//
	$("#sidebar-left").find("h2.title").css("cursor", "pointer");
	$("#sidebar-left").find("h2.title").click(function() {sac.toggle_menu(sac, this)});

	sac.status = sac.get_status();

	//
	// Loop through each of our titles, and hide the contents
	//
	$("#sidebar-left").find("h2.title").each(function() {
		var id = $(this).parent().attr("id");
		var title = $(this);

		if (sac.status[id]) {
			title.siblings().hide();
			sac.title_collapse(title);
		} else {
			sac.title_expand(title);
		}

		});


});



