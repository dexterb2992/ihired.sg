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
            company_id = $("#company_id"),
            company_name = $("#company_name"),
            btn_submit = $("#btn_submit"),
            form_update = $("#form_update"),
            picBox = $('#picBox'),
            uploadBtn = $('#uploadBtn'),
            hasImg = $("#hasImg"),
            readableImg = $("#readableImg");

        /* select boxes */
        var sb_country_ = $("#sb_country"),
            sb_state_ = $("#sb_state"),
            sb_city_ = $("#sb_city"),
            sb_town_ = $("#sb_town"),
            sb_train_ = $("#sb_train"),
            sb_zone_ = $("#sb_zone");

        /* text fields */
        var open_to = $("#open_to"),
            txt_open_to = $("#txt_open_to");

        /* buttons */
        var deleteBtn = $("#deleteBtn"),
            btn_add_opento = $("#btn_add_opento"),
            btn_add_location = $("#btn_add_location"),
            btn_delete_opento = $(".btn-delete-opento").first(),
            btn_delete_location = $(".btn-delete-location").first();

        /* datatables */
        var dt_tbl_opento = $("#tbl_opento").DataTable({
                "iDisplayLength": 100
            }),

            dt_tbl_location = $("#tbl_location").DataTable({
                "iDisplayLength": 100
            });

        /* select2 dropdown boxes */
        var i_country = new Select2PagingPlugin(),
        	i_industry = new Select2PagingPlugin();

        i_country.init(sb_country, countries);
        i_industry.init(sb_industry, industries);

        initializeSelect2Boxes();

        sb_country_.select2({
            placeholder: sb_country_.attr("data-text"),
            width: '100%',
            theme: 'bootstrap',
            allowClear: true,
            ajax: {
                url: base_url+'common/get_countries',
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

        if( sb_country_.val() != "" ){
            instantiateSelect2Boxes( sb_country_.val() );
        }


        /* ================== START select2 dropdown on change events ====================*/
        function instantiateSelect2Boxes(country_id){
            checkCountryHasStates(country_id, function (){
                $('*[data-hide-when="country_has_no_states"]').fadeIn();

                sb_state_.select2({
                    placeholder: sb_state_.attr("data-text"),
                    width: '100%',
                    theme: 'bootstrap',
                    allowClear: true,
                    ajax: {
                        url: base_url+'common/get_states/'+country_id,
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
            }, function (){
                $('*[data-hide-when="country_has_no_states"]').fadeOut();
            });

            sb_city_.select2({
                placeholder: sb_city_.attr("data-text"),
                width: '100%',
                theme: 'bootstrap',
                allowClear: true,
                ajax: {
                    url: base_url+'common/get_cities/'+country_id,
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

            sb_town_.select2({
                placeholder: sb_town_.attr("data-text"),
                width: '100%',
                theme: 'bootstrap',
                allowClear: true,
                ajax: {
                    url: base_url+'common/get_towns/'+country_id,
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

            sb_train_.select2({
                placeholder: sb_train_.attr("data-text"),
                width: '100%',
                theme: 'bootstrap',
                allowClear: true,
                ajax: {
                    url: base_url+'common/get_train_stations/'+country_id,
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

            sb_zone_.select2({
                placeholder: sb_zone_.attr("data-text"),
                width: '100%',
                theme: 'bootstrap',
                allowClear: true,
                ajax: {
                    url: base_url+'common/get_zones/'+country_id,
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
        }

        function initializeSelect2Boxes(){
            $('#sb_state, #sb_city, #sb_town, #sb_train, #sb_zone').each(function (){
                if( !$(this).data('select2') ){
                    $(this).select2({
                        placeholder: $(this).attr("data-text"),
                        width: '100%',
                        theme: 'bootstrap',
                        allowClear: true
                    });
                }
                
            });
        }

        function destroySelect2Boxes(){
            $('#sb_state, #sb_city, #sb_town, #sb_train, #sb_zone').each(function (){
                if( $(this).data('select2') ){
                    $(this).select2('destroy').html("")
                }
            });
        }

        sb_country_.on("change", function(){
            var country_id = $(this).val();
            destroySelect2Boxes();
            instantiateSelect2Boxes(country_id);
        });

        /* ======= END select2 dropdown onchange event ===================== */

        /* autocomplete textfields */
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

        txt_open_to.autocomplete({
            source: _open_to,
            minLength:0,
            select: function (event, ui) {
                console.log(ui.item);
                $("#txt_open_to").val(ui.item.label); // display the selected text
                $("#open_to").val(ui.item.value); // save selected id to hidden input
                return false;
            },
            response: function(event, ui) {
                // ui.content is the array that's about to be sent to the response callback.
                if (ui.content.length === 0) {
                    open_to.val("");
                }
            } 
        }).on('focus', function() { 
            $(this).keydown(); 
        });


        /* = = = = = = dataTables' search field = = = = = */
        txt_open_to.bind("change keyup", function(){
            dt_tbl_opento
                .column(0)
                .search(this.value)
                .draw();
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
                    btn_submit.addClass("disabled").attr("disabled", "disabled")
                        .children("span").text("Please wait...");
                },
                success: function (data){
                    if( data.success ){
                        flashdata_status(data.msg, 'Saved.');
                        $('*[data-bind="company_name"]').text(company_name.val());
                    }else{
                        flashdata_status(data.msg);
                    }
                },
                error: function (data){
                    console.warn(data);
                    flashdata_status('Whoops! Something went wrong. Please try again later.');
                    btn_submit.removeClass("disabled").removeAttr("disabled")
                        .children("span").text("Save Changes");
                }
            }).done(function (){
                btn_submit.removeClass("disabled").removeAttr("disabled")
                    .children("span").text("Save Changes");
            });
        });


        if (hasImg.val() == 'hasImg') {
            deleteBtn.removeClass('hide');
            uploadBtn.addClass('hide');
        } else {
            uploadBtn.removeClass('hide');
            deleteBtn.addClass('hide');
        }

        deleteBtn.on('click', function() {
            bootbox.confirm({
                title: "Confirmation",
                message: "Do you wish to remove this image?",
                buttons: {
                    cancel: {
                        label: '<i class="glyphicon glyphicon-remove"></i> No'
                    },
                    confirm: {
                        label: '<i class="glyphicon glyphicon-ok"></i> Yes'
                    }
                },
                callback: function (ans) {
                    if (ans) {
                        $.ajax({
                            url: base_url + 'admin/company/delete_logo/'+company_id.val(),
                            type: 'post',
                            dataType: 'json',
                            success: function(data) {
                                if( data.success == true ){
                                    picBox.attr("src", base_url + 'assets/images/pix.jpg');
                                    uploadBtn.removeClass('hide');
                                    deleteBtn.addClass('hide');
                                }else{
                                    flashdata_status("Sorry, we're not able to upload your file right now.")
                                    console.warn(data);
                                }
                            }
                        });
                    }
                }
            });
        });

        var uploader = new ss.SimpleUpload({
            button: uploadBtn,
            url: base_url + 'admin/company/update_logo/'+company_id.val(),
            name: 'uploadfile',
            responseType: 'json',
            onSubmit: function() {
                uploadBtn.addClass('hide');
                deleteBtn.removeClass('hide');
            },
            onComplete: function(filename, response) {
                console.log(response);
                if (response.success) {
                    flashdata_status("Company logo has been updated.", "Saved.");
                    picBox.attr("src", response.newFile + "?foo=" + new Date().getTime());
                }
                
            },
            onError: function() {
                flashdata_status("Unable to upload file.");
            }
        });


        /* ======== = START add buttons ========= = =  == */
        btn_add_opento.on("click", function (){
            var opento = txt_open_to.val();
            var company_id = $(this).attr("data-company-id");

            if( open_to.val() != "" ){
                flashdata_status(opento + " already exists.");
                return false;
            }

            $.ajax({
                url: base_url+"admin/company/create_opento",
                type: 'post',
                dataType: 'json',
                data: {
                    company_id: company_id,
                    open_to: opento
                },
                success: function (data){
                    if( data.success == true ){
                        _open_to.push(data.details.opento);

                    
                        var btn_delete = btn_delete_opento.clone();

                        btn_delete.attr("data-id", data.details.opento.open_to_id);

                        var div = $(document.createElement('div')).append(btn_delete);
                        

                        dt_tbl_opento.row.add([
                            opento,
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

        btn_add_location.on("click", function (){
            var company_id = $(this).attr("data-company-id");
            var data = {
                country_id: sb_country_.val(),
                state_id: sb_state_.val(),
                city_id: sb_city_.val(),
                town_id: sb_town_.val(),
                train_id: sb_train_.val(),
                zone_id: sb_zone_.val()
            };

            $.ajax({
                url: base_url+"admin/company/create_location/"+company_id,
                type: 'post',
                dataType: 'json',
                data: data,
                success: function (data){
                    if( data.success == true ){
                        _open_to.push(data.details.location);

                    
                        var btn_delete = btn_delete_location.clone();

                        btn_delete.attr("data-id", data.details.location.location_id);

                        var div = $(document.createElement('div')).append(btn_delete);
                        
                        var a = data.details.location;

                        dt_tbl_location.row.add([
                            a.company_name,
                            a.state_name,
                            a.city_name,
                            a.town_name,
                            a.station_name,
                            a.zone,
                            div.html()
                        ]).draw( false );

                        // refresh select2 boxes
                        $('#sb_state, #sb_city, #sb_town, #sb_train, #sb_zone').select2('destroy').html("");
                        initializeSelect2Boxes();

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


        /*  ========= START delete buttons ============= = */
        $(document).on("click", ".btn-delete-opento", function (){
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
                            url : base_url + 'admin/company/delete_opento',
                            data: { id: id },
                            dataType: 'json',
                            type: 'post',
                            success: function(data) {
                                if(data.success == true) {
                                    // removes company from autocomplete source
                                    _open_to = _open_to.filter(function(row) {
                                        return row.value != id;
                                    });

                                    flashdata_status(data.msg, 'Saved.');

                                    dt_tbl_opento.row( $this.parents('tr') )
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

        $(document).on("click", ".btn-delete-location", function (){
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
                            url : base_url + 'admin/company/delete_location',
                            data: { id: id },
                            dataType: 'json',
                            type: 'post',
                            success: function(data) {
                                if(data.success == true) {
                                    flashdata_status(data.msg, 'Saved.');

                                    dt_tbl_location.row( $this.parents('tr') )
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

    function checkCountryHasStates(country_id, callbackTrue, callbackFalse){
        $.ajax({
            url: base_url+"common/check_country_states/"+country_id,
            type: 'get',
            dataType: 'json',
            success: function (data){
                if( data.response == true ){
                    if( callbackTrue ) callbackTrue();
                }else{
                    if( callbackFalse ) callbackFalse();
                }
            }
        });
    }
}));