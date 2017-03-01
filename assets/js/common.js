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
    var $target = null,
        _callback = null;
    
    this.init = function(target, dataSource, pageSize, callback) {
        _dataSource = dataSource;
        $target = target;
        if(pageSize) _pageSize = pageSize;
        if(callback) _callback = callback;
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

            if( _callback ){
                _callback();
            }
            
        }
    );
}

/**
 * Initializes autocomplete function to a html element
 *
 */
function initAutoComplete(autocomplete_field, txt_field, source, hidden_field){
    autocomplete_field.autocomplete({
        source: source,
        minLength:0,
        select: function (event, ui) {
            console.log(ui.item);
            txt_field.val(ui.item.label); // display the selected text
            hidden_field.val(ui.item.value); // save selected id to hidden input
            return false;
        },
        response: function(event, ui) {
            // ui.content is the array that's about to be sent to the response callback.
            if (ui.content.length === 0) {
                hidden_field.val("");
            }
        } 
    }).on('focus', function() { 
        $(this).keydown(); 
    });
}

function clearFormValues($form){
    $form.find('input[type="text"]').val("");
    $form.find('texarea').html("");
}

/**
 * Adds a delete function to a specific element
 *
 * @param DOM $element
 * @param string $postUrl
 * @param DataTable $dataTable
 *
 * @return void
 */
function addDeleteFunction($element, $postUrl, $dataTable, callback){
    var $this = $element,
        id = $this.attr('data-id');

    if( id == "" || id == null || id == undefined ){
        console.error('An addDeleteFunction requires the element to have a data-id attribute.');
        return false;
    }

    if( $postUrl == "" || $postUrl == null || $postUrl == undefined){
        console.error('addDeleteFunction needs a POST url.');
        return false;
    }

    if( $dataTable.row == undefined ){
        console.error("addDeleteFunction: $dataTable should be an instance of jQuery DataTable. ");
        return false;
    }

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
                    url : $postUrl+id,
                    dataType: 'json',
                    type: 'post',
                    success: function(data) {
                        if(data.success == true) {
                            $dataTable
                                .row( $this.parents('tr') )
                                .remove()
                                .draw(false);

                            flashdata_status(data.msg, 'Saved.');

                            if( callback ) callback();

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
}


/**
 * Converts a select element to a select2 with remote data
 *
 * @param DOM select $element
 * @param string $sourceUrl
 *
 * @return void
 */
function ajaxSelect2($element, $sourceUrl){
    $element.select2({
        placeholder: $element.attr("data-text"),
        width: '100%',
        theme: 'bootstrap',
        allowClear: true,
        ajax: {
            url: $sourceUrl,
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

/**
 * Checks if a country has a states
 * 
 * @param integer country_id
 * @param function callbackTrue
 * @param function callFalse
 *
 * @return boolean
 */
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