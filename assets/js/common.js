$(function(){

	/***************
	* jQuery Chosen 
	* Universal init
	*/
	// $(".chosen").chosen();
	$(".chosen").chosen({search_contains:true});
	// $(".chosen_strict").chosen();

	/***************
	* Tooltip init
	*/
	$('[data-toggle="tooltip"]').tooltip({'placement': 'right'});

}); //end onload

/**	allow only number and decimal point
 * **/
function isNumberKey(evt) {
	
   var charCode = (evt.which) ? evt.which : evt.keyCode
   if (charCode > 31 && (charCode < 48 || charCode > 57))
	   return false;
   return true;
}

function ucwords (str) {

  return (str + '').replace(/^([a-z])|\s+([a-z])/g, function ($1) {
      return $1.toUpperCase();
  });
}

function flashdata_status(data, type) {
	var color = 'alert-danger';
	
	if (type != undefined || (data == 'Saved.')) {
		color = 'alert-success';
	}
	
	var wrap = '<div class="alert alert-block '+color+'">'
		wrap += '<button type="button" class="close" data-dismiss="alert">×</button>';
      	wrap += '<div class="container">';
		wrap += data;
		wrap += '</div>';
		wrap += '</div>';

	$('#f_msg').html(wrap).fadeIn("slow", function() { $(this).delay(5000).fadeOut("slow"); });
}