// IIFE - Immediately Invoked Function Expression
(function(ihired) {

    // The global jQuery object is passed as a parameter
    ihired(window.jQuery, window, document);

}(function($, window, document) {

    // The $ is now locally scoped 

    // Listen for the jQuery ready event on the document
    $(function() {
        // initialize all necessary variables here
        var sb_country = $("#country_id"),
        	sb_industry = $("#industry_id"),
            txt_currency = $("#currency"),
            currency_id = $("#currency_id"),
            btn_submit = $("#btn_submit"),
            form_update = $("#form_update");

        var i_country = new Select2PagingPlugin(),
        	i_industry = new Select2PagingPlugin();

        i_country.init(sb_country, countries);
        i_industry.init(sb_industry, industries);
        txt_currency.autocomplete({
            source: currencies,
            minLength:0,
            select: function (event, ui) {
                console.log(ui.item);
                $("#currency").val(ui.item.label); // display the selected text
                $("#currency_id").val(ui.item.value); // save selected id to hidden input
                return false;
            },
            response: function(event, ui) {
                // ui.content is the array that's about to be sent to the response callback.
                if (ui.content.length === 0) {
                    currency_id.val("");
                }
            } 
        }).on('focus', function() { 
            $(this).keydown(); 
        });

        form_update.on("submit", function (e){
            e.preventDefault();
            var $this = $(this),
                data = form_update.serialize();
            $.ajax({
                url: base_url+"admin/company/update",
                type: 'post',
                dataType: 'json',
                data: data,
                beforeSend: function (){
                    btn_submit.addClass("disabled").attr("disabled", "disabled").text("Please wait...");
                },
                success: function (data){
                    if( data.success ){
                        flashdata_status(data.msg, 'Saved.');
                    }else{
                        flashdata_status(data.msg);
                    }
                },
                error: function (data){
                    console.warn(data);
                    flashdata_status('Whoops! Something went wrong. Please try again later.');
                }
            }).done(function (){
                btn_submit.removeClass("disabled").removeAttr("disabled").text("Save Changes");
            });
        });
    });

    // The rest of the codes goes here

}));