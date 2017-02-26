(function (ihired){
	ihired(window.jQuery, window, document);
}(function ihired($, window, document){
	$(function (){
		/* initialization of useful variables  */ 

		// forms
		var frm_country = $("#frm_country"),
			frm_state = $("#frm_state");

		// textfields
		var country_name = frm_country.find("input[name='country_name']"),
			country_code = frm_country.find("input[name='country_code']"),
			nationality = frm_country.find("input[name='nationality']"),
			currency_name = frm_country.find("input[name='currency_name']"),
			currency_symbol = frm_country.find("input[name='currency_symbol']");

		// select boxes
		var sb_stateCountry = $("#sb_state_country"),
			sb_cityCountry = $("#sb_city_country")
			sb_cityState = $("#sb_city_state");

		// tables
		var tbl_countries = $("#tbl_countries"),
			tbl_states = $("#tbl_states"),
			tbl_cities = $("#tbl_cities"),
			tbl_towns = $("#tbl_towns");

		// buttons
		var btn_add_country = $("#btn_add_country"),
			btn_add_state = $("#btn_add_state"),

			raw_btn = $('<button type="button" class="btn btn-primary btn-xs btn-noradius" title="Delete this record.">Delete</button>'),
			btn_delete_country = raw_btn.clone().addClass('btn-delete-country');
			btn_delete_state = raw_btn.clone().addClass('btn-delete-state');

		// datatables
		var dt_tbl_countries = $("#tbl_countries").DataTable({
				"iDisplayLength": 100
			}),
			dt_tbl_states = $("#tbl_states").DataTable({
				"iDisplayLength": 100
			}),
			dt_tbl_cities = $("#tbl_cities").DataTable({
				"iDisplayLength": 100
			}),
			dt_tbl_towns = $("#tbl_towns").DataTable({
				"iDisplayLength": 100
			});

		// select2 initialization and DOM events
		ajaxSelect2(sb_stateCountry, base_url+'common/get_countries');

		ajaxSelect2(sb_cityCountry, base_url+'common/get_countries');

		sb_cityCountry.on("change", function (){
			// if( sb_cityState )
		});

		/* DOM events  */

		// Add button --------------------------------------------------------------------------------------
		btn_add_country.on("click", function (){
			var $this = $(this);

            $.ajax({
                url: base_url+"admin/country/create",
                type: 'post',
                dataType: 'json',
                data: {
                	country_name: country_name.val(),
					country_code: country_code.val(),
					nationality: nationality.val(),
					currency_name: currency_name.val(),
					currency_symbol: currency_symbol.val()
                },
                beforeSend: function (){
                    $this.addClass("disabled").attr("disabled", "disabled").text("Please wait...");
                },
                success: function (data){
                    if( data.success == true ){
                    	var country = data.details.country;

                        btn_delete_country.attr("data-id", country.country_id);

                        var div = $(document.createElement('div')).append(btn_delete_country);

                        dt_tbl_countries.row.add([
                            country_name.val(),
                            country_code.val(),
							nationality.val(),
							currency_name.val(),
							currency_symbol.val(),
							country.date_added,
							country.full_name,
                            div.html()
                        ]).draw( false );

                        flashdata_status(data.msg, 'Saved.');
                        // clear form
                        clearFormValues(frm_country);
                    }else{
                        flashdata_status(data.msg);
                    }

                    $this.removeClass("disabled").removeAttr("disabled").text("Update");
                },
                error: function (data){
                    console.error(data);
                    flashdata_status("Whoops! Something went wrong. Please try again later.");
                    $this.removeClass("disabled").removeAttr("disabled").text("Update");
                }
            });
		});

		btn_add_state.on("click", function (){
			var $this = $(this),
				state_name = frm_state.find('input[name="state_name"]').val();

            $.ajax({
                url: base_url+"admin/state/create",
                type: 'post',
                dataType: 'json',
                data: {
                	state_name: state_name,
					country_id: sb_stateCountry.val()
                },
                beforeSend: function (){
                    $this.addClass("disabled").attr("disabled", "disabled").text("Please wait...");
                },
                success: function (data){
                    if( data.success == true ){
                    	var state = data.details.state;

                        btn_delete_state.attr("data-id", state.state_id);

                        var div = $(document.createElement('div')).append(btn_delete_state);

                        dt_tbl_states.row.add([
                            state.state_name,
                            state.country_name,
                            div.html()
                        ]).draw( false );

                        flashdata_status(data.msg, 'Saved.');
                        // clear form
                        clearFormValues(frm_state);
                    }else{
                        flashdata_status(data.msg);
                    }

                    $this.removeClass("disabled").removeAttr("disabled").text("Update");
                },
                error: function (data){
                    console.error(data);
                    flashdata_status("Whoops! Something went wrong. Please try again later.");
                    $this.removeClass("disabled").removeAttr("disabled").text("Update");
                }
            });
		});


		// Delete buttons ------------------------------------------------------------------------------
		$(document).on("click", ".btn-delete-country", function (){
			addDeleteFunction($(this), base_url + 'admin/country/delete/', dt_tbl_countries);

        });


		$(document).on("click", ".btn-delete-state", function (){
			addDeleteFunction($(this), base_url + 'admin/state/delete/', dt_tbl_states);
		});

		$(document).on("click", ".btn-delete-city", function (){
			addDeleteFunction($(this), base_url + 'admin/city/delete/', dt_tbl_cities);
		});

	});

	// The rest of the code goes here
}));