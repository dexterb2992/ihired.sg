// IIFE - Immediately Invoke Function Expression
(function (ihired){
    // We pass the global jQuery object as a parameter
    ihired(window.jQuery, window, document);
}(function ihired($, window, document){
    // $ is now locally scoped

    // Listen for the jQuery even
    $(function (){
        // The DOM is now ready
        var selected_user_id = $("#selected_user_id"),
            s_user = $("#select_user"),
            s_company = $("#select_company"),
            s_function = $("#select_function"),
            btn_add_access = $("#btn_add_access"),
            tbl_jobs_access = $("#tbl_jobs_access")
            btn_delete = $('<button type="button" class="btn btn-primary btn-xs btn-delete-access" title="Delete this record">'+
                                '<i class="glyphicon glyphicon-remove"></i>'+
                            '</button>');

        var i_companies = new Select2PagingPlugin(),
            i_functions = new Select2PagingPlugin();

        i_companies.init(s_company, companies);
        i_functions.init(s_function, functions);

        s_user.autocomplete({
            source: users,
            minLength:0,
            select: function (event, ui) {
                console.log(ui.item);
                $("#select_user").val(ui.item.label); // display the selected text
                selected_user_id.val(ui.item.value); // save selected id to hidden input
                return false;
            },
            // keyup: function( event, ui ) {
            //     selected_user_id.val( ui.item? ui.item.value : null );
            // },
            response: function(event, ui) {
                // ui.content is the array that's about to be sent to the response callback.
                if (ui.content.length === 0) {
                    selected_user_id.val("");
                }
            } 
        }).on('focus', function() { 
            $(this).keydown(); 
        });

        var dt_tbl_jobs_access = $("#tbl_jobs_access").DataTable({
            "iDisplayLength": 50,
        });

        s_user.keyup(function(){
            dt_tbl_jobs_access
                .column(0)
                .search(this.value)
                .draw();
        });


        btn_add_access.on("click", function (){
            var $this = $(this),
                company_id = s_company.val(),
                company_name = s_company.text(),
                user_id = selected_user_id.val(),
                user_name = s_user.val(),
                function_id = s_function.val(),
                function_name = s_function.text();

            if( company_id && user_id && function_id ){
                $.ajax({
                    url: base_url+"admin/jobs_access/create",
                    type: 'post',
                    dataType: 'json',
                    data: {
                        company_id: company_id,
                        company_name: company_name,
                        user_id: user_id,
                        user_name: user_name,
                        function_id: function_id,
                        function_name: function_name
                    },
                    beforeSend: function (){
                        $this.addClass("disabled").attr("disabled", "disabled").text("Please wait...");
                    },
                    success: function (data){
                        if( data.success == true ){

                            btn_delete.attr("data-id", data.details.jobs_access.id);

                            // I used document.createElement because it's the fastest way to create a dom element
                            // Run some tests here http://jsperf.com/jquery-vs-createelement

                            var btn = $(document.createElement('div')).append(btn_delete).html();

                            var jobs_access = data.details.jobs_access;

                            dt_tbl_jobs_access.row.add([
                                jobs_access.full_name,
                                jobs_access.company_name,
                                jobs_access.function_name,
                                jobs_access.date,
                                btn
                            ]).draw( false );

                            flashdata_status(data.msg, 'Saved.');
                        }else{
                            flashdata_status(data.msg);
                        }
                    }
                }).done(function (){
                    $this.removeClass("disabled").removeAttr("disabled").text("Update");
                });
            }

        });


        $(document).on("click", ".btn-delete-access", function (){
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
                            url : base_url + 'admin/jobs_access/delete',
                            data: { id: id },
                            dataType: 'json',
                            type: 'post',
                            success: function(data) {
                                if(data.success == true) {

                                    flashdata_status(data.msg, 'Saved.');

                                    dt_tbl_jobs_access.row( $this.parents('tr') )
                                        .remove()
                                        .draw(false);

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

    // The rest of code goes here


}));