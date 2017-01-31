(function($, undefined){
	$.fn.getCursorPosition = function() {
        var el = $(this).get(0);
        var pos = 0;
        if('selectionStart' in el) {
            pos = el.selectionStart;
        } else if('selection' in document) {
            el.focus();
            var Sel = document.selection.createRange();
            var SelLength = document.selection.createRange().text.length;
            Sel.moveStart('character', -el.value.length);
            pos = Sel.text.length - SelLength;
        }
        return pos;
    }

    $.fn.autosuggest = function(options){
    	// var url = options['url'];
		// var callback = options['callback'];

		var obj = $(this);
		var list = {};
		var value = "";
		var string_length = 0;
		var string_value = "";
		var position = 0;

		$(this).on("keyup", function(e){
			if(e.which == 8)
			{
				if($.isFunction(options['callback']))
				{

					options['callback'].call($(obj), "");
				}
				return false;
			}

			value = "";
			string_value = $(obj).val();

			$.each(list, function(i, o){

				if(o.substr(0, string_value.length) == string_value)
				{
					value = o;
					return false;
				}
			});

			if(value == "")
			{
				$.ajax({
					url			: options['url'],
					dataType	: "json",
					data		: { term: $(obj).val() },
					success		: function ( data )
					{
						list = data;

						$.each(list, function(i, o){
							if(o.substr(1, string_length) == $(obj).val())
							{
								value = o;
								return false;
							}
						});
					}
				});
			}

			suggest();
		});


		function suggest()
		{
			if(value != "")
			{
				position = $(obj).getCursorPosition();
				$(obj).val(value);
				obj[0].selectionStart = position;
				obj[0].selectionEnd = value.length;
			}

			if($.isFunction(options['callback']))
			{
				options['callback'].call($(obj), value);
			}
		}
	}

})(jQuery);