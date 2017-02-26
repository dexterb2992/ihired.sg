$(function (){
	ihired(window.jQuery, window, document);
}(function ihired($, window, document){
	$(function (){
		// $ is now locall scoped
		// initialization of useful variables 

		// forms
		var frm_state = $("#frm_state");

		// textfields
		var state_name = $("#state_name");

		// select boxes
		var sb_country = $("#sb_country");

		// buttons
		var btn_add_state = $("#btn_add_state"),
			btn_delete_state = $('<button type="button" class="btn-delete-state btn btn-primary btn-xs btn-noradius" title="Delete this record.">Delete</button>');


	});

	// The rest of the code goes here
}));