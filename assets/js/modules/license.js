(function (ihired){
	ihired(window.jQuery, window, document);
	
}(function($, window, document){

	$(function (){
		// $ is now locally scoped

        /* tables */
        var tbl_skills = $("#tbl_skills");

        /* form text inputs */
		var license_name = $("#license_name"),
			txt_license_name = $("#txt_license_name"),
			is_specialised = $("#is_specialised");

        /* text inputs autocomplete */
        txt_license_name.autocomplete({
            source: licenses,
            minLength:0,
            select: function (event, ui) {
                console.log(ui.item);
                $("#txt_license_name").val(ui.item.label); // display the selected text
                license_name.val(ui.item.value); // save selected id to hidden input
                return false;
            },
            response: function(event, ui) {
                // ui.content is the array that's about to be sent to the response callback.
                if (ui.content.length === 0) {
                    license_name.val("");
                }
            } 
        }).on('focus', function() { 
            $(this).keydown(); 
        });

        /* form select boxes */
        var sb_country = $("#sb_country"),
            sb_city = $("#sb_city");

        /* form buttons */
        var btn_delete_license = $(".btn-delete-license").first(),
            btn_add_license = $("#btn_add_license");

        /** = = = = = = dropdown boxes = = = = = = =  */
        sb_country.select2({
            placeholder: sb_country.attr("data-text"),
            width: '100%',
            theme: 'bootstrap',
            allowClear: true,
            ajax: {
                url: base_url+'admin/license/get_countries',
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

        sb_city.select2({
            placeholder: sb_city.attr("data-text"),
            width: '100%',
            theme: 'bootstrap',
            allowClear: true,
        });

        sb_country.on("change", function (){
            var country_id = $(this).val();
            sb_city.select2('destroy').html("");

            $.ajax({
                url: base_url+'admin/license/get_cities/'+country_id,
                type: 'get',
                dataType: 'json',
                success: function (data){
                    var i_lincense = new Select2PagingPlugin();
                    i_lincense.init(sb_city, data);
                }
            })
        });

        /** = = = = = = dataTables = = = = = = = = = = = = */
        var dtTable_licenses = $("#tbl_licenses").DataTable({
            	"iDisplayLength": 100,
            });


        /* = = = = = = dataTables' search field = = = = = */
        txt_license_name.bind("change keyup", function(){
            dtTable_licenses
                .column(0)
                .search(this.value)
                .draw();
        });


        /* = = = = = = = update buttons = = = = = = = = = */
        btn_add_license.on("click", function (){
        	var $this = $(this);

        	$.ajax({
        		url: base_url+"admin/license/create",
        		type: 'post',
        		dataType: 'json',
        		data: {
        			license_name: txt_license_name.val(),
					country_id: sb_country.val(),
					city_id: sb_city.val()
        		},
        		beforeSend: function (){
        			$this.addClass("disabled").attr("disabled", "disabled").text("Please wait...");
        		},
        		success: function (data){
                    if( data.success == true ){
                        licenses.push(data.details.license);

                        var btn_delete = btn_delete_license.clone();

                        btn_delete.attr("data-id", data.details.license.license_id);

                        // I used document.createElement because it's the fastest way to create a dom element
                        // Run some tests here http://jsperf.com/jquery-vs-createelement

                        var div = $(document.createElement('div')).append(btn_delete);

                        dtTable_licenses.row.add([
                            txt_license_name.val(),
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
        $(document).on("click", ".btn-delete-license", function (){
        	var $this = $(this),
                id = $this.attr('data-id');

            bootbox.confirm({
                title: "Delete Confirmation",
                message: "Do you wish to delete this record?",
                buttons: {
                    cancel: {
                        label: '<i class="glyphicon glyphicon-remove"></i> No'
                    },
                    confirm: {
                        label: '<i class="glyphicon glyphicon-ok"></i> Yes'
                    }
                },
                callback: function (ans) {
                    if(ans) {
                        $.ajax({
                            url : base_url + 'admin/license/delete',
                            data: { id: id },
                            dataType: 'json',
                            type: 'post',
                            success: function(data) {
                                if(data.success == true) {
                                    licenses.filter(function (license, index){

                                    });

                                    dtTable_licenses.row( $this.parents('tr') )
                                        .remove()
                                        .draw(false);
                                   
                                    flashdata_status(data.msg, 'Saved.');

                                } else {
                                    flashdata_status(data.msg);
                                }
                            },
                            error: function (data){
                                console.warn(data);
                            }
                        });
                    }
                }
            });
        });

	});

	// The rest of the code goes here

}));