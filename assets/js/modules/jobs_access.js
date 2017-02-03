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
            btn_delete = $(".btn-delete-access").first().clone();

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

        var dt_jobs_access = $("#tbl_jobs_access").DataTable({
            "bSort" : false,
            "iDisplayLength": 50,
        });

        s_user.keyup(function(){
            dt_jobs_access
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
                            //jobs_access.push(data.details.jobs_access);

                            tbl_jobs_access.dataTable({
                                destroy: true
                            });

                            btn_delete.attr("data-id", data.details.jobs_access.id);

                            // I used document.createElement because it's the fastest way to create a dom element
                            // Run some tests here http://jsperf.com/jquery-vs-createelement

                            var btn = $(document.createElement('div')).append(btn_delete).html(),
                                row = $(document.createElement('tr')),
                                jobs_access = data.details.jobs_access,
                                tds = '<td>'+jobs_access.full_name+'</td>'+
                                    '<td>'+jobs_access.company_name+'</td>'+
                                    '<td>'+jobs_access.function_name+'</td>'+
                                    '<td>'+jobs_access.date+'</td>'+
                                    '<td>'+btn+'</td>';

                            row.append( $(tds) );

                            tbl_jobs_access.children('tbody').prepend(row);
                            tbl_jobs_access.dataTable();

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
                        label: '<i class="fa fa-times"></i> No'
                    },
                    confirm: {
                        label: '<i class="fa fa-check"></i> Yes'
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
                                    tbl_jobs_access.dataTable({
                                        destroy: true
                                    });

                                    $this.closest('tr').slideUp('slow');
                                    flashdata_status(data.msg, 'Saved.');
                                    tbl_jobs_access.dataTable();
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

    // converts select element to select2
    function Select2PagingPlugin() {
        var _dataSource = null;
        var _pageSize = 20;
        var $target = null;
        
        this.init = function(target, dataSource, pageSize) {
            _dataSource = dataSource;
            $target = target;
        if (pageSize)
            _pageSize = pageSize;
        }
        
        /* @since select2 v4.0 */
        $.fn.select2.amd.require(["select2/data/array", "select2/utils"],
            function (ArrayData, Utils) {
                function CustomData($select2ement, options) {
                    CustomData.__super__.constructor.call(this, $select2ement, options);
                }
                Utils.Extend(CustomData, ArrayData);

                CustomData.prototype.query = function (params, callback) {
                    if (!params.page) {
                        params.page = 1;
                    }
                    var results = null;
                    if (params.term == undefined) {
                        // results = _dataSource.slice(0, _pageSize); // use _pageSize to disable infinite loading
                        results = _dataSource.slice(0, _dataSource.length); // 
                    }
                    else {
                        results = _.filter(_dataSource, function(item) { 
                            return (item.text.toLowerCase().indexOf(params.term.toLowerCase()) >= 0);
                        }); 
                    }
                    
                    var data = {};
                    data.results = results.slice((params.page - 1) * _pageSize, params.page * _pageSize);
                    data.pagination = {};
                    data.pagination.more = params.page * _pageSize < _dataSource.length;
                    callback(data);
                };

                
                $target.select2({
                    width:'100%',
                    theme: 'bootstrap',
                    dataAdapter: CustomData,
                    placeholder: {
                        id: -1,
                        text: $target.attr("data-text")
                    }
                });
                
            }
        );
    }

}));