function show_global_message(msg) { 
	var w = (document.body.offsetWidth / 2 ) - 150;
	var globalErrorMsg = $("#globalErrorMsg");
	globalErrorMsg.html(msg).css('left',w);
	globalErrorMsg.slideDown(1).delay(3000).slideUp('fast');
}

function show_validation_errors(msg, targetElement, callback, delayTimeOut){
	if( delayTimeOut == undefined ) delayTimeOut = 5000;

	targetElement.removeClass("hide")
		.append(msg)
		.slideDown(1).delay(delayTimeOut).slideUp('fast', function (){
			targetElement.html("");
			if( callback ) callback();
		});
}