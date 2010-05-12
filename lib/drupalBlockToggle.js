/**
* Our drupalBlockToggle jQuery plugin.
* It allows the contents of menu blocks to be hidden/unhidden by clicking 
* on the title.
*
* @author Douglas Muth <http://www.dmuth.org/>
*/

jQuery.fn.drupalBlockToggle = function() { 

	//
	// Take a hint after Python here, since "this" is reserved in Javascript
	// Also keep in mind that this isn't an actual object. More like 
	// a namespace.
	//
	var self = jQuery.fn.drupalBlockToggle;

	//
	// Make all headers clickable so that they can be hidden/shown
	//

	$("#sidebar-left").find("h2.title").css("cursor", "pointer");
	$("#sidebar-left").find("h2.title").click(function() {self.toggle_menu(this)});
	$("#footer-left").find("h2.title").css("cursor", "pointer");
	$("#footer-left").find("h2.title").click(function() {self.toggle_menu(this)});
	$("#footer-middle").find("h2.title").css("cursor", "pointer");
	$("#footer-middle").find("h2.title").click(function() {self.toggle_menu(this)});
	$("#footer-right").find("h2.title").css("cursor", "pointer");
	$("#footer-right").find("h2.title").click(function() {self.toggle_menu(this)});

	self.status = self.get_status();

	//
	// Loop through each of our titles, and hide the contents
	//
	$("#sidebar-left").find("h2.title").each(function() {self.init_block(this)});
	$("#footer-left").find("h2.title").each(function() {self.init_block(this)});
	$("#footer-middle").find("h2.title").each(function() {self.init_block(this)});
	$("#footer-right").find("h2.title").each(function() {self.init_block(this)});

};


/**
*
* Retrive our status cookie, split it up, and save the 
* values as keys
*
* @return array An array of our block status where the keys
*	are the IDs of blocks that are to be hidden.
*/
jQuery.fn.drupalBlockToggle.get_status = function() {

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
* Initialize a specific block, possibly setting it to already be collapsed.
*
* @param obj e The HTML entity.  Equivilient to "this" in jQuery.
*/
jQuery.fn.drupalBlockToggle.init_block = function(e) {

	var self = jQuery.fn.drupalBlockToggle;

	var id = $(e).parent().attr("id");
	var title = $(e);

	if (self.status[id]) {
		title.siblings().hide();
	}

} // End of init_block()


/**
* This function is called whenver a menu header is clicked.
*
* @param obj e The HTML entity.  Equivilient to "this" in jQuery.
*/
jQuery.fn.drupalBlockToggle.toggle_menu = function(e) {

	var self = jQuery.fn.drupalBlockToggle;

	var id = $(e).parent().attr("id");
	var title = $(e);

	$(e).siblings().slideToggle("normal", function() {

		var display = $(this).css("display");

		if (display == "none") {
			self.status[id] = true;

		} else {
			delete (self.status[id]);
		}

		//
		// Figure out what's going on in Safari
		//
		// alert("TEST3: " + id);
		var tmp = self.serialize(self.status);
		var params = {"expires": 30, "path": "/"};
		$.cookie("block-status", tmp, params);

		});
	
}; // End of toggle_menu()


/**
* Serialize the keys in our array.
*
* @return string A comma-delimited string of keys.
*/
jQuery.fn.drupalBlockToggle.serialize = function(data) {

	var retval = "";
	for (key in data) {
		if (retval) {
			retval += ",";
		}
		retval += key;
	}

	return(retval);

}; // End of serialize()


//
// Stuff to execute when the page is done loading.
//
$(document).ready(function(){
	jQuery.fn.drupalBlockToggle();
});


