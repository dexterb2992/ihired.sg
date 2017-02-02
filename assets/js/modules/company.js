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

        $(".datatable").dataTable();

        txt_company.autocomplete({
            source: convertToAutoCompleteSource(companies, "company_name")
        });

        txt_industry.autocomplete({
            source: convertToAutoCompleteSource(industries, "company_name")
        });

        btn_add_company.on("click", function (){
            var company = txt_company.val(),
                industry = txt_industry.val(),
                industry_id = 0;

            if( company == "" || industry == "" ) return false;

            // let's find the industry if it already exists
            var check = findIndustry(industry);
            if( check !== false ) industry_id = check;

            $.ajax({
                url: base_url+"admin/create",
                type: 'post',
                dataType: 'json',
                data: {
                    company_name: company,
                    industry_name: industry,
                    industry_id: industry_id // defaults to 0 if not exists
                },
                success: function (data){
                    if( data.success == true ){
                        // I used document.createElement because it's the fastest way to create a dom element
                        // Run some tests here http://jsperf.com/jquery-vs-createelement
                        var new_row = $(document.createElement('tr'));
                        new_row.append( $('<td>'+company+'</td><td>'+industry+'</td>') );
                        tbl_companies.dataTable('destroy').children('tbody').append(new_row);
                        tbl_companies.dataTable();
                        flashdata_status(data.msg);
                    }else{
                        flashdata_status(data.msg);
                    }
                },
                error: function (data){
                    console.warn(data);
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

        return industry.length > 0 ? industry.industry_id : false;
    } 

    function convertToAutoCompleteSource(source, indexName){
        var results = source.filter(function (result){
            return result[indexName];
        });

        return results;
    }

}));