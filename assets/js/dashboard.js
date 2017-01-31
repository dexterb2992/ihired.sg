// IIFE - Immediately Invoked Function Expression
(function (ihired){
	// The global jQuery object is passed as a parameter
	ihired(window.jQuery, window, document)
}(function ($, window, document){
	// The $ is now locally scoped

	// Listen for the jQuery ready event on the document
	$(function (){
		var passchangeemail = $("#passchangeemail"),
			modal_changepassword = $("#change_password"),
			passchange = $("#passchange"),
			hidereqnote = $("#hidereqnote"),
			u_req = $("#u_req"),
			btn_changePass = $("#btn_changePass"),
			frm_changePass = $("#frm_changePass"),
			div_validation_errors = $(".custom-validation-errors");

		if( forcePasswordChange && forcePasswordChange == "Y"){
			modal_changepassword.modal('show');
		}

		hidereqnote.on('click', function() {
			passchangeemail.addClass('hide');
			passchange.removeClass('hide');
		});

		if( u_req.val() == 'Y' ) {
			modal_changepassword.modal('show');
			passchangeemail.removeClass('hide');
			passchange.addClass('hide');
		}

		btn_changePass.on('click', function() {
			var frm = frm_changePass.serialize();
			$.ajax({
				url: base_url+'user/password_change_by_user',
				type: 'post',
				dataType: 'json',
				data: frm,
				success: function(data) {
					console.log(data);
					if(data.success == true) {
						passchange.addClass('hide');
						div_validation_errors.removeClass("alert-danger").addClass("alert-success");
						show_validation_errors(data.msg, div_validation_errors, function (){
							div_validation_errors.removeClass("alert-success").addClass("alert-danger");
							setTimeout(function() {
								modal_changepassword.modal('hide');
								passchange.removeClass('hide');
							}, 2000);
						});
					}else{
						passchange.addClass('hide');
						show_validation_errors(data.msg, div_validation_errors, function (){
							passchange.removeClass('hide');
						});
					}
				}
			});
		});
	});
}));