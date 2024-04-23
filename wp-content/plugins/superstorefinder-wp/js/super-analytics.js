jQuery(document).ready(function() {

var d = new Date();
var $mobile = jQuery('#storeLocatorInfobox .store-tel a');
var $ssfemail = jQuery('#storeLocatorInfobox .store-email a');

jQuery('#storeLocatorInfobox .store-tel,#mobileStoreLocatorInfobox .store-tel').on('click', function(e) { 


	var location = jQuery('.store-locator__infobox--main .store-location').html();
	jQuery.ajax({
		type: "POST",
		url: ssf_wp_base + '/tracking.php?t='+d.getTime(),
		data: {ssf_store_name: location},
		cache: false,
		success: function (html){
		}
  });

});

jQuery('#storeLocatorInfobox .store-email, #mobileStoreLocatorInfobox .store-email').on('click', function(e) { 


	var location = jQuery('.store-locator__infobox--main .store-location').html();
	jQuery.ajax({
		type: "POST",
		url: ssf_wp_base + '/tracking.php?t='+d.getTime(),
		data: {ssf_email_name: location},
		cache: false,
		success: function (html){
		}
  });

});



var typingTimer;               
var doneTypingInterval = 3000;  
var $input = jQuery('#storeLocator__searchBar');

//on keyup, start the countdown
$input.on('keyup', function () {
  clearTimeout(typingTimer);
  typingTimer = setTimeout(doneTyping, doneTypingInterval);
});

//on keydown, clear the countdown 
$input.on('keydown', function () {
  clearTimeout(typingTimer);
});

function doneTyping () {
  var searchPlace = jQuery('#storeLocator__searchBar').val();
  if(searchPlace!=''){
	jQuery.ajax({
		type: "POST",
		url: ssf_wp_base + '/tracking.php?t='+d.getTime(),
		data: {ssf_wp_track_add: searchPlace},
		cache: false,
		success: function (html){
		}
  });
  }
}
});