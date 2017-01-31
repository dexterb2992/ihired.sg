/* Common JS Utilities  */
	
validate_email_address = function(email) {
	if (!(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email)) || $.trim(email)=='') {  
		return false;
	} else {
		return true;
	}
}

show_global_message = function (msg) { 
	var w = (document.body.offsetWidth / 2 ) - 150;
	$('#globalErrorMsg').html(msg).css('left',w);
	$('#globalErrorMsg').slideDown(1).delay(3000).slideUp('fast');
}

reset_form = function(frm) {
    frm.find('input:text, input:password, input:file, select, textarea').val('');
    frm.find('input:radio, input:checkbox').removeAttr('checked').removeAttr('selected');
}

is_min_length = function (str, len) {
	return (str.length >= len) ? true : false;
}

is_empty_string = function (str) {
	str = $.trim(str);
	return (str.length == 0) ? true : false;
}

IsNumeric = function (num) {
     return (num >=0 || num < 0);
}
