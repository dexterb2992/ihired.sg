$(document).ready(function(){
		addRemarks = function () {		
		$('#EditView .error_message').html('');
		$('#EditView form').remove();
		$('.EditView').colorbox({inline:false, width:'30%'});
		
		$('.EditView').attr('title','Add New');
		$('.EditView').colorbox({inline:true, width:'30%'});
		$('.EditView').trigger('click');
	}
	
	
	
	save = function(formN,kindof,numero, other, otherno) {	
	
		var module = $('#EditView form input[type=hidden][name=module]').val();

	}

});