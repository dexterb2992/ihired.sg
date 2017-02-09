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
        	sb_industry = $("#industry_id");
        var i_country = new Select2PagingPlugin(),
        	i_industry = new Select2PagingPlugin();

        i_country.init(sb_country, countries);
        i_industry.init(sb_industry, industries);
    });

    // The rest of the codes goes here

}));