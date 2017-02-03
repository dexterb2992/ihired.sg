// IIFE - Immediately Invoke Function Expression
(function (ihired){
    // We pass the global jQuery object as a parameter
    ihired(window.jQuery, window, document);
}(function ihired($, window, document){
    // $ is now locally scoped

    // Listen for the jQuery even
    $(function (){
        // The DOM is now ready
        var s_user = $("#select_user"),
            s_company = $("#select_company"),
            s_function = $("#select_function"),
            btn_add_access = $("#btn_add_access");

        var i_users = new Select2PagingPlugin(),
            i_companies = new Select2PagingPlugin(),
            i_functions = new Select2PagingPlugin();
            
        i_users.init(s_user, users);
        i_companies.init(s_company, companies);
        i_functions.init(s_function, functions);

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
                function CustomData($element, options) {
                    CustomData.__super__.constructor.call(this, $element, options);
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
                    ajax: {},
                    dataAdapter: CustomData,
                    placeholder: $(this).attr("data-placeholder")
                });
                
            }
        );
    }

}));