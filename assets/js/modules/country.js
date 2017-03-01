(function (ihired){
	ihired(window.jQuery, window, document);
}(function ihired($, window, document){
	$(function (){
		/* initialization of useful variables  */ 

		// forms
		var frm_country = $("#frm_country"),
			frm_state = $("#frm_state"),
			frm_city = $("#frm_city"),
			frm_town = $("#frm_town");

		// textfields
		var country_name = frm_country.find("input[name='country_name']"),
			country_code = frm_country.find("input[name='country_code']"),
			nationality = frm_country.find("input[name='nationality']"),
			currency_name = frm_country.find("input[name='currency_name']"),
			currency_symbol = frm_country.find("input[name='currency_symbol']");

		// select boxes
		var sb_stateCountry = $("#sb_state_country"),
			sb_cityCountry = $("#sb_city_country")
			sb_cityState = $("#sb_city_state"),
			sb_townCountry = $("#sb_town_country"),
			sb_townCity = $("#sb_town_city");

		// tables
		var tbl_countries = $("#tbl_countries"),
			tbl_states = $("#tbl_states"),
			tbl_cities = $("#tbl_cities"),
			tbl_towns = $("#tbl_towns");

		// buttons
		var btn_add_country = $("#btn_add_country"),
			btn_add_state = $("#btn_add_state")
			btn_add_city = $("#btn_add_city"),
			btn_add_town = $("#btn_add_town"),

			raw_btn = $('<button type="button" class="btn btn-primary btn-xs btn-noradius" title="Delete this record.">Delete</button>'),
			btn_delete_country = raw_btn.clone().addClass('btn-delete-country');
			btn_delete_state = raw_btn.clone().addClass('btn-delete-state'),
			btn_delete_city = raw_btn.clone().addClass('btn-delete-city'),
			btn_delete_town = raw_btn.clone().addClass('btn-delete-town');

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

		/* select2 initialization and DOM events */

		// Manage State tab
		ajaxSelect2(sb_stateCountry, base_url+'common/get_countries');

		// Manage City tab
		ajaxSelect2(sb_cityCountry, base_url+'common/get_countries');

		sb_cityState.select2({
			placeholder: sb_cityState.attr("data-text"),
	        width: '100%',
	        theme: 'bootstrap'
		});

		sb_cityCountry.on("change", function (){
			var country_id = $("#sb_city_country").val();

			checkCountryHasStates(country_id, function (){
	            $('*[data-hide-when="country_has_no_states"]').fadeIn();

	            if( sb_cityState.data('select2') ){
	            	sb_cityState.select2('destroy').html("");
	            }

	            ajaxSelect2(sb_cityState, base_url+'common/get_states/'+country_id);

	        }, function (){
	            $('*[data-hide-when="country_has_no_states"]').fadeOut();
	        });
		});

		// Manage Town tab
		ajaxSelect2(sb_townCountry, base_url+"common/get_countries");

		sb_townCity.select2({
			placeholder: sb_townCity.attr("data-text"),
	        width: '100%',
	        theme: 'bootstrap'
		});

		sb_townCountry.on("change", function (){
			var country_id = $("#sb_town_country").val();

			if( sb_townCity.data('select2') ){
            	sb_townCity.select2('destroy').html("");
            }

            ajaxSelect2(sb_townCity, base_url+'common/get_cities/'+country_id);
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

		btn_add_city.on("click", function (){
			var $this = $(this),
				city_name = frm_city.find('input[name="city_name"]').val(),
				city_country = $("#city_country").val(),
				city_state = $("#city_state").val();

			$.ajax({
                url: base_url+"admin/city/create",
                type: 'post',
                dataType: 'json',
                data: {
                	city_name : city_name,
					country_id : city_country,
					state_id : city_state
                },
                beforeSend: function (){
                    $this.addClass("disabled").attr("disabled", "disabled").text("Please wait...");
                },
                success: function (data){
                    if( data.success == true ){
                    	var city = data.details.city;

                        btn_delete_city.attr("data-id", city.city_id);

                        var div = $(document.createElement('div')).append(btn_delete_city);

                        dt_tbl_cities.row.add([
                            city_name,
                            city.state_name,
                            city.country_name,
							city.date_added,
							city.full_name,
                            div.html()
                        ]).draw( false );

                        flashdata_status(data.msg, 'Saved.');
                        // clear form
                        clearFormValues(frm_city);
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

		btn_add_town.on("click", function (){
			var $this = $(this),
				town_name = frm_town.find('input[name="town_name"]').val(),
				town_country = $("#sb_town_country").val(),
				town_city = $("#sb_town_city").val();

			$.ajax({
                url: base_url+"admin/town/create",
                type: 'post',
                dataType: 'json',
                data: {
                	town_name : town_name,
					country_id : town_country,
					city_id : town_city
                },
                beforeSend: function (){
                    $this.addClass("disabled").attr("disabled", "disabled").text("Please wait...");
                },
                success: function (data){
                    if( data.success == true ){
                    	var town = data.details.town;

                        btn_delete_town.attr("data-id", town.town_id);

                        var div = $(document.createElement('div')).append(btn_delete_town);

                        dt_tbl_towns.row.add([
                            town_name,
                            town.city_name,
                            town.country_name,
							town.date_added,
							town.full_name,
                            div.html()
                        ]).draw( false );

                        flashdata_status(data.msg, 'Saved.');
                        // clear form
                        clearFormValues(frm_town);
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

		$(document).on("click", ".btn-delete-town", function (){
			addDeleteFunction($(this), base_url + 'admin/town/delete/', dt_tbl_towns);
		});

	});

	// The rest of the code goes here
}));