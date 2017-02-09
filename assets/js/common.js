$(function(){

	/***************
	* jQuery Chosen 
	* Universal init
	*/
	// $(".chosen").chosen();
	$(".chosen").chosen({search_contains:true});
	// $(".chosen_strict").chosen();

	/***************
	* Tooltip init
	*/
	$('[data-toggle="tooltip"]').tooltip({'placement': 'right'});

}); //end onload

/**	allow only number and decimal point
 * **/
function isNumberKey(evt) {
	
   var charCode = (evt.which) ? evt.which : evt.keyCode
   if (charCode > 31 && (charCode < 48 || charCode > 57))
	   return false;
   return true;
}

function ucwords (str) {

  return (str + '').replace(/^([a-z])|\s+([a-z])/g, function ($1) {
      return $1.toUpperCase();
  });
}

function flashdata_status(data, type) {
	var color = 'alert-danger';
	
	if (type != undefined || (data == 'Saved.')) {
		color = 'alert-success';
	}
	
	var wrap = '<div class="alert alert-block '+color+'">'
		wrap += '<button type="button" class="close" data-dismiss="alert">×</button>';
      	wrap += '<div class="container">';
		wrap += data;
		wrap += '</div>';
		wrap += '</div>';

	$('#f_msg').html(wrap).fadeIn("slow", function() { $(this).delay(5000).fadeOut("slow"); });
}

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