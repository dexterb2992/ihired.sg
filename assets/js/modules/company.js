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
            btn_addCompany = $("#btn_add_company");

    });

    // The rest of the codes goes here

}));