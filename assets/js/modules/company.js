// IIFE - Immediately Invoked Function Expression
(function(ihired) {

    // The global jQuery object is passed as a parameter
    ihired(window.jQuery, window, document);

}(function($, window, document) {

    // The $ is now locally scoped 

    // Listen for the jQuery ready event on the document
    $(function() {
        // initialize all necessary variables here
        var txt_company = $("#txt_company"), 
            txt_industry = $("#txt_industry"),
            btn_add_company = $("#btn_add_company"),
            btn_edit_company = $(".btn-edit-company"),
            btn_delete_company = $(".btn-delete-company"),
            open_to = $("#open_to"),
            txt_open_to = $("#txt_open_to"),

            // hidden fields for autocomplete
            hidden_industry_id = $("#industry_id"),

            tbl_companies = $("#tbl_companies");

        var dt_tbl_companies = $("#tbl_companies").DataTable({
                "bSort" : false,
                "iDisplayLength": 100,
            });

        txt_company.keyup(function(){
            dt_tbl_companies
                .column(0)
                .search(this.value)
                .draw();
        });

        txt_industry.autocomplete({
            source: industries,
            minLength:0,
            select: function (event, ui) {
                console.log(ui.item);
                $("#txt_industry").val(ui.item.label); // display the selected text
                hidden_industry_id.val(ui.item.value); // save selected id to hidden input
                return false;
            },
            response: function(event, ui) {
                // ui.content is the array that's about to be sent to the response callback.
                if (ui.content.length === 0) {
                    hidden_industry_id.val(0);
                }
            } 
        }).on('focus', function() { 
            $(this).keydown(); 
        });


        /* ================= add buttons =====================================*/ 
        btn_add_company.on("click", function (){
            console.log(dt_tbl_companies);
            var company = txt_company.val(),
                industry_id = hidden_industry_id.val(),
                industry = txt_industry.val();

            if( company == "" || industry_id == 0 ) return false;

            $.ajax({
                url: base_url+"admin/company/create",
                type: 'post',
                dataType: 'json',
                data: {
                    company_name: company,
                    industry_name: industry,
                    industry_id: industry_id // defaults to 0 if not exists
                },
                success: function (data){
                    if( data.success == true ){
                        companies.push(data.details.company);

                        var btn_edit = btn_edit_company.first().clone(),
                            btn_delete = btn_delete_company.first().clone();

                        btn_edit.attr("data-id", data.details.company.company_id);
                        btn_delete.attr("data-id", data.details.company.company_id);

                        // I used document.createElement because it's the fastest way to create a dom element
                        // Run some tests here http://jsperf.com/jquery-vs-createelement

                        var div = $(document.createElement('div')).append(btn_edit).append(btn_delete);
                        
                        dt_tbl_companies.row.add([
                            company,
                            industry,
                            div.html()
                        ]).draw( false );

                        flashdata_status(data.msg, 'Saved.');
                    }else{
                        flashdata_status(data.msg);
                    }
                },
                error: function (data){
                    console.warn(data);
                }
            });
        });


        /* ================================ delete buttons =============================== */
        $(document).on("click", ".btn-delete-company", function (){
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
                            url : base_url + 'admin/company/delete',
                            data: { id: id },
                            dataType: 'json',
                            type: 'post',
                            success: function(data) {
                                if(data.success == true) {

                                    // removes company from autocomplete source
                                    companies = companies.filter(function(company) {
                                        return company.value != id;
                                    });


                                    flashdata_status(data.msg, 'Saved.');

                                    dt_tbl_companies.row( $this.parents('tr') )
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

    // The rest of the codes goes here

}));