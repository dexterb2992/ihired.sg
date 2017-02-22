(function (ihired){
	ihired(window.jQuery, window, document);
	
}(function($, window, document){

	$(function (){
		// $ is now locally scoped

        /* tables */
        var tbl_qualifications = $("#tbl_qualifications");

        /* form text inputs */
		var qualification_name = $("#qualification_name"),
			txt_qualification_name = $("#txt_qualification_name");

        /* text inputs autocomplete */
        initAutoComplete(txt_qualification_name, $("#txt_qualification_name"), qualifications, qualification_name);

        /* form select boxes */
        var sb_qualification_type = $("#sb_qualification_type"),
            sb_function = $("#sb_function");

        /* form buttons */
        var btn_delete_qualification = $(".btn-delete-qualification").first(),
            btn_add_qualification = $("#btn_add_qualification");

        /** = = = = = = dropdown boxes = = = = = = =  */
        var i_functions = new Select2PagingPlugin(),
            i_types = new Select2PagingPlugin();

        i_functions.init(sb_function, functions);
        i_types.init(sb_qualification_type, qualification_types);


        /** = = = = = = dataTables = = = = = = = = = = = = */
        var dtTable_qualifications = $("#tbl_qualifications").DataTable({
            	"iDisplayLength": 100,
            });


        /* = = = = = = dataTables' search field = = = = = */
        txt_qualification_name.bind("change keyup", function(){
            dtTable_qualifications
                .column(0)
                .search(this.value)
                .draw();
        });


        /* = = = = = = = update buttons = = = = = = = = = */
        btn_add_qualification.on("click", function (){
        	var $this = $(this);

        	$.ajax({
        		url: base_url+"admin/qualification/create",
        		type: 'post',
        		dataType: 'json',
        		data: {
        			qualification_name: txt_qualification_name.val(),
					qt_id: sb_qualification_type.val(),
					function_id: sb_function.val()
        		},
        		beforeSend: function (){
        			$this.addClass("disabled").attr("disabled", "disabled").text("Please wait...");
        		},
        		success: function (data){
                    if( data.success == true ){
                        qualifications.push({
                            label: data.details.qualification.qualifications_name,
                            value: data.details.qualification.qualifications_id
                        });

                        var btn_delete = btn_delete_qualification.clone();

                        btn_delete.attr("data-id", data.details.qualification.qualifications_id);

                        // I used document.createElement because it's the fastest way to create a dom element
                        // Run some tests here http://jsperf.com/jquery-vs-createelement

                        var div = $(document.createElement('div')).append(btn_delete);

                        dtTable_qualifications.row.add([
                            txt_qualification_name.val(),
                            sb_qualification_type.select2('data')[0].text,
                            sb_function.select2('data')[0].text,
                            data.details.qualification.date_added,
                            data.details.qualification.full_name,
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
        $(document).on("click", ".btn-delete-qualification", function (){
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
                            url : base_url + 'admin/qualification/delete',
                            data: { id: id },
                            dataType: 'json',
                            type: 'post',
                            success: function(data) {
                                if(data.success == true) {
                                    // remove from source
                                    qualifications = qualifications.filter(function(qualification) {
                                        return qualification.value != id;
                                    });

                                    // refresh autocomplete
                                    initAutoComplete(txt_qualification_name, $("#txt_qualification_name"), qualifications, qualification_name);

                                    dtTable_qualifications.row( $this.parents('tr') )
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