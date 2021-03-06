(function (ihired){
	ihired(window.jQuery, window, document);
	
}(function($, window, document){

	$(function (){
		// $ is now locally scoped

        /* tables */
        var tbl_skills = $("#tbl_skills");

        /* form text inputs */
		var university_name = $("#university_name"),
			txt_university_name = $("#txt_university_name");

        /* text inputs autocomplete */
        initAutoComplete(txt_university_name, $("#txt_university_name"), universities, university_name);
        
        /* form select boxes */
        var sb_country = $("#sb_country"),
            sb_city = $("#sb_city");

        /* form buttons */
        var btn_delete_university = $(".btn-delete-university").first(),
            btn_add_university = $("#btn_add_university");

        /** = = = = = = dropdown boxes = = = = = = =  */
        ajaxSelect2(sb_country, base_url+'common/get_countries');

        sb_city.select2({
            placeholder: sb_city.attr("data-text"),
            width: '100%',
            theme: 'bootstrap',
            allowClear: true,
        });

        sb_country.on("change", function (){
            var country_id = $(this).val();
            if( sb_city.data('select2') ){
                sb_city.select2('destroy').html("");
            }

            ajaxSelect2(sb_city, base_url+'common/get_cities/'+country_id);
        });

        /** = = = = = = dataTables = = = = = = = = = = = = */
        var dtTable_universities = $("#tbl_universities").DataTable({
            	"iDisplayLength": 100,
            });


        /* = = = = = = dataTables' search field = = = = = */
        txt_university_name.bind("change keyup", function(){
            dtTable_universities
                .column(0)
                .search(this.value)
                .draw();
        });


        /* = = = = = = = update buttons = = = = = = = = = */
        btn_add_university.on("click", function (){
        	var $this = $(this);

        	$.ajax({
        		url: base_url+"admin/university/create",
        		type: 'post',
        		dataType: 'json',
        		data: {
        			university_name: txt_university_name.val(),
					country_id: sb_country.val(),
					city_id: sb_city.val()
        		},
        		beforeSend: function (){
        			$this.addClass("disabled").attr("disabled", "disabled").text("Please wait...");
        		},
        		success: function (data){
                    if( data.success == true ){
                        universities.push({
                            label: data.details.university.university_name,
                            value: data.details.university.university_id
                        });

                        var btn_delete = btn_delete_university.clone();

                        btn_delete.attr("data-id", data.details.university.university_id);

                        // I used document.createElement because it's the fastest way to create a dom element
                        // Run some tests here http://jsperf.com/jquery-vs-createelement

                        var div = $(document.createElement('div')).append(btn_delete);

                        dtTable_universities.row.add([
                            txt_university_name.val(),
                            sb_country.select2('data')[0].text,
                            sb_city.select2('data')[0].text,
                            div.html()
                        ]).draw( false );

                        flashdata_status(data.msg, 'Saved.');
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


        /* = = = = = = = delete buttons = = = = = = = = = */
        $(document).on("click", ".btn-delete-university", function (){
        	var id = $(this).attr('data-id');

            addDeleteFunction($(this), base_url+'admin/university/delete/', dtTable_universities, function (){
                //remove from source
                universities = universities.filter(function(university) {
                    return university.value != id;
                });
                // refresh autocomplete
                initAutoComplete(txt_university_name, $("#txt_university_name"), universities, university_name);               
            });
        });

	});

	// The rest of the code goes here
    
}));