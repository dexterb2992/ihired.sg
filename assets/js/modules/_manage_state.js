$(function (){
	ihired(window.jQuery, window, document);
}(function ihired($, window, document){
	$(function (){
		/* initialization of useful variables  */ 

		// forms
		var frm_state = $("#frm_state");

		// textfields
		var state_name = $("#state_name");

		// select boxes
		var sb_country = $("#sb_country");

		// tables
		var tbl_states = $("#tbl_states");

		// buttons
		var btn_add_state = $("#btn_add_state"),
			btn_delete_state = $('<button type="button" class="btn-delete-state btn btn-primary btn-xs btn-noradius" title="Delete this record.">Delete</button>');

		// datatables
		var dt_tbl_states = $("#tbl_states").DataTable({
			"iDisplayLength": 100
		});

		// select2 initialization
		sb_country.select2({
			placeholder: sb_country_.attr("data-text"),
            width: '100%',
            theme: 'bootstrap',
            allowClear: true,
            ajax: {
                url: base_url+'common/get_countries',
                dataType: 'json',
                data: function(params) {
                    return {
                        term: params.term || '',
                        page: params.page || 1
                    }
                },
                cache: true
            }
		});


		/* DOM events  */

		// Add button
		btn_add_state.on("click", function (){
			
		});

	});

	/* The rest of the code goes here */
}));