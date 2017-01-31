$(function() {

	$('#modal_sendEmail').modal({
	    show: false,
	    keyboard: false,
	    backdrop: 'static'
	});

	$("#clear-login-form").on('click', function() {
		$(".login-element").val('');
		$("#ck_remember").attr('checked', false);
	});

	$("#forgot_login").on('click', function() {

		var inputEmail = $("#inputEmail").val();
		if( inputEmail !== '') {
			$("#modalEmail1").val(inputEmail);
		}

		$("#modal_container").html($("#content1").html());
	});

	$("#modal_sendEmail").on('hidden.bs.modal', function() {
	  	$("#modalEmail").val('');
	  	$("#modal_flash").addClass('hide');
	});
});

function send_email() {

	var frm = $("#frm_sendEmail").serialize();
	$.ajax({
		url  : base_url + 'home/ck_ifEmail',
		data : frm,
		type : 'POST',
		dataType: 'JSON',
		success : function(data) {
			if(data.typ == 'success') {
				$("#modal_foget_password, #modal_sendEmail").modal('hide');
				flashdata_status(data.msg, 'Saved.');
			}
			else {
				$('#forgot_password_error').html(data.msg).show();
			}
		}
	});
}
function openCont1() {
	$("#content2").addClass('hide');
	$("#modal_container").html($("#content1").html());
	$("#content1").removeClass('hide');
}
