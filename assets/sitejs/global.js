var oDefault = {
	'bJQueryUI': false,
	'bStateSave': true,
	'sPaginationType': "full_numbers",
	'bAuthoWidth': true,
	'oLanguage': {
        'oPaginate': {
            'sFirst':    "<<",
            'sPrevious': "<",
            'sNext':     ">",
            'sLast':     ">>"
        }
    },
    'bProcessing': true,
    'bServerSide': true,
	'aLengthMenu': [[5, 10, 25, 50, 100], [5, 10, 25, 50, 100]],
	'iDisplayLength': 5,
};


$(function(){
    //$("form").validate();
    
    
	$("form").each(function () { 
	   var validator = $(this).validate();  //add var here
	   // validator.resetForm();
	   // $("#reset").click(function () {
	       // validator.resetForm();
	   // });
	});    
    
	$("body").on("submit", "form.ajax_form", function(e){
		//$("form").validate().resetForm();
		
		var form = $(this);
	
		var loading_container = $(this).attr("data-loading_container");

		if(typeof loading_container !== 'undefined' && loading_container !== false)
		{
			$(form).find(loading_container).show();
		}
		else
		{
			loading_container = "";
		}


		$.ajax({
			url: $(form).attr("action"),
			type: "POST",
			data: $(form).serialize(),
			success: function (data)
			{
				var is_json = false;
				var json = {};
				var success = window[$(form).attr("data-success")];
				var fail = window[$(form).attr("data-fail")];
			

				try{
					json = $.parseJSON(data);
					is_json = true;
				}
				catch(e)
				{
					is_json = false;
				}

				if(is_json == true)
				{
					if(json.success == true)
					{
						if(typeof success !== 'undefined' && success !== false)
						{
							success(json, form);
						}

						$("#system_message").text(json.message);
						$("#system_message").effect("bounce", {}, 500, callback).highlight();
					}
					else
					{
						if(typeof fail !== 'undefined' && fail !== false)
						{
							fail(json, form);
						}
						
						$("#system_message").text( json.message );
						$("#system_message").effect("bounce", {}, 500, callback).error();
					}

					if(typeof loading_container !== 'undefined' && loading_container !== false)
					{
						$(form).find(loading_container).hide();
					}
				}
				else
				{
					if(typeof success !== 'undefined' && success !== false)
					{
						success(data);
					}
					$("#system_message").text(json.message);
					$("#system_message").effect("bounce", {}, 500, callback).highlight();
				}
			}
		});

		return false;
	});

	$("body").on("click", ".ajax_edit", function(){
		var url = $(this).attr("href");

		var edit_function = $(this).attr("data-edit_function");

		$.ajax({
			url: url,
			type: "POST",
			success: function(data)
			{
				var json = $.parseJSON(data);

				if(typeof edit_function !== 'undefined' && edit_function !== false)
				{
					window[edit_function]( json );
				}
			}
		});

		return false;
	});



	$("body").on("click", ".popupBox", function(){
		$(".popupBox").colorbox(
			{
				iframe			: true,
				opacity			: 0.9,
				transition		: "elastic",
				speed			: 300,
				title			: "",
				innerWidth		: 300,
				innerHeight		: 300,
				scrolling		: false,
				title			: " "
			}
		);
	});

	$("body").on("click", ".popupBoxNoClose", function(){
		$(".popupBoxNoClose").colorbox(
			{
				iframe			: true,
				opacity			: 0.9,
				transition		: "elastic",
				speed			: 300,
				title			: "",
				innerWidth		: 300,
				innerHeight		: 300,
				scrolling		: false,
				escKey			: false,
				overlayClose	: false,
				closeButton		: false,
				title			: " "
			}
		);
	});

	$("body").on("click", ".popupBoxAjax", function(){
		$(".popupBoxAjax").colorbox(
			{
				iframe			: false,
				opacity			: 0.9,
				transition		: "elastic",
				speed			: 300,
				title			: "",
				innerWidth		: 300,
				innerHeight		: 300,
				scrolling		: false,
				title			: " ",
				onComplete			: function(){
					if($(".popupBoxContainer").length)
					{
						   var x = $(".popupBoxContainer").width() + 50;
				           var y = $(".popupBoxContainer").height() + 70;

				           parent.$.colorbox.resize({ width: x, height: y });
					}
				}
			}
		);


	});
	
	$("input.birthdate").datepicker({
		dateFormat: "dd/mm/yy",
		changeYear: true,
		yearRange: '1950:' + (new Date().getFullYear())
	});

	$(".datePicker").datepicker({
        dateFormat: "dd/mm/yy",
        changeYear: true
    });

	
	// $(".monthPicker").monthpicker({
	// 	pattern: "mmm-yyyy",
	// 	openOnFocus: true
	// });

	

    $("body").on("click", ".ajax_delete", function(e){
    	
    	
		e.preventDefault();
		var object = $(this);

		$("#cofirm-box").dialog({
			resizable: false,
			height: 150,
			modal: true,
			buttons: {
				Yes: function(){
						$.ajax({
							url: $(object).attr("href"),
							type: "POST",
							success: function( data )
							{
								var is_json = false;
								var json = {};
								var funcDelete = window[$(object).attr("data-delete")];
								var message = "Record Deleted!";

								try{
									json = $.parseJSON(data);
									is_json = true;
								}
								catch(e)
								{
									is_json = false;
								}

								if(is_json == true)
								{
									if(json.success == true)
									{
										if(typeof funcDelete !== 'undefined' && funcDelete !== false)
										{

											funcDelete(json);
										}
									}

									message = json.message
								}
								else
								{
									if(typeof funcDelete !== 'undefined' && funcDelete !== false)
									{
										funcDelete(data);
									}
								}

								$(object).closest("tr").remove();
								$(object).closest("tr").remove();

								$("#system_message").text( message );
								$("#system_message").effect("bounce", {}, 500, callback).highlight();
							}
						});

						$(this).dialog("close");
					},
				Cancel: function(){
						$(this).dialog("close");
				}
			},
			title: "Delete"
		});


	});

	$("body").on("click", "a.custom_list_ajax_delete", function(e){
		e.preventDefault();
		var object = $(this);

		$("#cofirm-box").dialog({
			resizable: false,
			height: 150,
			modal: true,
			buttons: {
				Yes: function(){
					$.ajax({
						url: $(object).attr("href"),
						type: "POST",
						success: function( data )
						{

							var is_json = false;
							var json = {};
							var funcDelete = $(object).attr("data-delete");
							var message = "Record Deleted!";


							try{
								json = $.parseJSON(data);
								is_json = true;
							}
							catch(e)
							{
								is_json = false;
							}

							if(is_json == true)
							{
								if(json.success == true)
								{
									if(typeof funcDelete !== 'undefined' && funcDelete !== false)
									{
										window[funcDelete](json);
									}
								}
							}
							else
							{
								if(typeof funcDelete !== 'undefined' && funcDelete !== false)
								{
									window[funcDelete](data);
								}
							}

							$(object).closest("tr").next("tr").remove();
							$(object).closest("tr").remove();

							$("#system_message").text( message );

							$("#system_message").effect("bounce", {}, 500, callback).highlight();
						}
					});

					$(this).dialog("close");
				},
				Cancel: function(){
						$(this).dialog("close");
				}
			},
			title: "Delete"
		});
	});


	$("body").on("click", "a.ajax_update", function(e){
		e.preventDefault();
		var object = $(this);
		
		// if(confirm('Do you wish to change?')) {
		// 	$.ajax({
		// 		url: $(this).attr("href"),
		// 		type: "POST",
		// 		success: function( data )
		// 		{
		// 			$(object).text(data);
		// 		}
		// 	});
		// }

		bootbox.confirm({
		    title: "Confirmation",
		    message: "Do you wish to change?",
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
						url: $(this).attr("href"),
						type: "POST",
						success: function( data )
						{
							$(object).text(data);
						}
					});
			  	}
		    }
		});
	});


	$(".clear_button").on("click", function(){
		$(".search_input").val('');
		$(".search_input").trigger("keyup");
	});

	$(".search_input").on("keyup", function(){
		var id = $(this).attr("data-table_id");

		var text = $(this).parent().find("input.search_input").val();

		$("table#"+id).dataTable().fnFilter( text );
	});



	$("body").on("keydown", ".numeric", function(evt){
		 evt = (evt) ? evt : window.event;
		var charCode = (evt.which) ? evt.which : evt.keyCode;

		if(charCode > 31 && (charCode < 48 || charCode > 57) && charCode != 8)
		{
			return false;
		}
		else
		{
			return true;
		}
	});

	$("body").on("mouseover", "input, select, textarea", function(){
		var label_error = $(this).next()

		if($(this).hasClass("error"))
		{
			$(this).attr("title", $(label_error).html());
		}
		else
		{
			$(this).removeAttr("title");
		}
	});

	$("body").on("focus", "input, select, textarea", function(){
		$(this).removeAttr("title");
	});

	$(document).tooltip();


	$(".back_form_button").on("click", function(e){


		$(this).closest("form").unbind('submit').submit();
	});



	$("body").on("change", ".birthdate", function(){
		
		
		var date = $(this).val();

		var dateArray = date.split("/");

		var dob = dateArray[2]+"-"+dateArray[1]+"-"+dateArray[0];

		dob = new Date(dob);
		var today = new Date();
		var age = Math.floor((today-dob) / (365.25 * 24 * 60 * 60 * 1000));

		if(!isNaN(age))
		{
			$(".age").val(age);
			$(".age").html(age);
			$(".age").text(age);
		}
		else
		{
			$(".age").val("");
			$(".age").html("");
			$(".age").text("");
		}
	});


	$(".editor_container .editor").prop('disabled', true);
	
	
	$("body").on("click", "input[type=radio][name=select]", function(){
		$(this).closest("form").find("button[name=make_primary], input[name=make_primary]").removeAttr("disabled");
	});
	
	
	$("body").on("keydown", ".datePicker", function(evt){
		 evt = (evt) ? evt : window.event;
		var charCode = (evt.which) ? evt.which : evt.keyCode;

		if(charCode != 8)
		{
			return false;
		}
		else
		{
			$(this).val("");
			$(".age").val("");
			$(".age").html("");
			$(".age").text("");
			return true;
		}
	});
});







function errorHighlight(e, type, icon) {
    if (!icon) {
        if (type === 'highlight') {
            icon = 'ui-icon-info';
        } else {
            icon = 'ui-icon-alert';
        }
    }
    return e.each(function() {
        $(this).addClass('ui-widget');
        var alertHtml = '<div class="ui-state-' + type + ' ui-corner-all" style="padding: 8px .7em;">';
        alertHtml += '<p>';
        alertHtml += '<span class="ui-icon ' + icon + '" style="float:left; width: 18px; display: block;"></span>';
        alertHtml += '<div style="margin-left: 20px;">'+$(this).text()+'</div>';

        alertHtml += '</p>';
        alertHtml += '</div>';

        $(this).html(alertHtml);
    });
}

//error dialog
(function($) {
    $.fn.error = function() {

        errorHighlight(this, 'error');
    };
})(jQuery);

//highlight (alert) dialog
(function($) {
    $.fn.highlight = function() {
        errorHighlight(this, 'highlight');
    };
})(jQuery);


function callback() {
	setTimeout(function() {
		//$("#system_message").toggle("bounce", { times: 3 }, "slow")
		$("#system_message").fadeOut();
	}, 3000 );
};