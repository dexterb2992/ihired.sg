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
            source: convertToAutoCompleteSource(industries, "industry_name")
        });

        btn_add_company.on("click", function (){
            console.log(dt_tbl_companies);
            var company = txt_company.val(),
                industry = txt_industry.val(),
                industry_id = 0;

            if( company == "" || industry == "" ) return false;

            // let's find the industry if it already exists
            var check = findIndustry(industry);
            if( check !== false ) industry_id = check;

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

                        tbl_companies.dataTable({
                            destroy: true
                        });

                        var btn_edit = btn_edit_company.first().clone(),
                            btn_delete = btn_delete_company.first().clone();

                        btn_edit.attr("data-id", data.details.company.company_id);
                        btn_delete.attr("data-id", data.details.company.company_id);

                        // I used document.createElement because it's the fastest way to create a dom element
                        // Run some tests here http://jsperf.com/jquery-vs-createelement

                        var div = $(document.createElement('div')).append(btn_edit).append(btn_delete);
                        var new_row = $(document.createElement('tr')).attr("data-id", data.details.company.company_id);
                        new_row.append( $('<td>'+company+'</td><td>'+industry+'</td><td>'+div.html()+'</td>') );

                        tbl_companies.children('tbody').prepend(new_row);
                        tbl_companies.dataTable();

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

        $(document).on("click", ".btn-delete-company", function (){
            var $this = $(this),
                id = $this.attr('data-id');

            bootbox.confirm({
                title: "Delete Confirmation",
                message: "Do you wish to delete this record?",
                buttons: {
                    cancel: {
                        label: '<i class="fa fa-times"></i> No'
                    },
                    confirm: {
                        label: '<i class="fa fa-check"></i> Yes'
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
                                    removeCompany(id);
                                    // refresh autocomplete source of company
                                    txt_company.autocomplete({
                                        source: companies
                                    });

                                    tbl_companies.dataTable({
                                        destroy: true
                                    });

                                    $this.closest('tr').slideUp('slow');
                                    flashdata_status(data.msg, 'Saved.');
                                    tbl_companies.dataTable();
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

    function findIndustry(industryName){
        var str1 = industryName.toLowerCase();

        var industry = industries.filter(function (industry){
            var str2 = industry.industry_name.toLowerCase();
            if(str2 == str1){
                return industry;
            }
        });

        return industry.length > 0 ? industry[0].industry_id : false;
    } 

    function removeCompany(id){
        companies.filter(function (company, index){
            if( company.company_id == id ){
                return companies.splice(index, 1);
            }
        });
    }

    function convertToAutoCompleteSource(source, indexName){
        var results = [];
        $.each(source, function (i, row){
            results.push(row[indexName]);
        });

        return results;
    }

}));