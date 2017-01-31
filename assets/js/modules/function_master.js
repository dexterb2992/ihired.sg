$(function() {

	var deTable 	= $('#tbl_dt_function').DataTable({
									"bSort" : false,
									"iDisplayLength": 100,
								});

  $('#function_name').keyup(function(){
    deTable
	    .column(0)
	    .search(this.value)
	    .draw();
  });

  $("#btn_add_function").on('click', function() {

  	var frm = $("#frm_function").serialize();
  	$.ajax({
  		url : base_url + 'admin/function_master/add_function',
  		data: frm,
  		dataType: 'JSON',
  		type: 'POST',
  		success: function(data) {
				var new_tr = '';
				if( data.success==true ) {

			  	deTable
				    .column(0)
				    .search('')
				    .draw(false);

					$(".frm_add_element").val('');
					$(".dataTables_empty").parent().hide();
					var ctr = data.data['function_id'];

					new_tr = '<tr id="tr_de_'+ ctr +'">';
					new_tr += '<td class="vert-align" id="td_de_name_'+ctr+'">'+ ucwords(data.data['function_name']) +'</td>';
		      new_tr += '<td class="vert-align" id="td_de_date_'+ctr+'">'+ data.data['date_added'] +'</td>';
		      new_tr += '<td class="vert-align" id="td_de_added_'+ctr+'">'+ ucwords(data.data['added_by']) +'</td>';
		      new_tr += '<td class="vert-align" id="td_de_btn_'+ctr+'">';
		      new_tr += '<button type="button" class="btn btn-primary btn-xs btn-noradius edit_de" id="edit_de_'+ctr+'">Edit</button>';
	        new_tr += '&nbsp; <button type="button" id="rm_de_'+ctr+'" class="btn btn-primary btn-xs btn-noradius rm_de">Delete</button>';
		      new_tr += '</td>';
		      new_tr += '</tr>';

					$("#tb_de").prepend(new_tr);
				} else {
					if(data.data==null) {
						flashdata_status("Something went wrong. Please try again.");
					} else {
						flashdata_status(data.data);
					}
				}
  		}
  	});	
  });

  $('body').on('click', '.rm_de', function() {

  	var ctr = ($(this).attr('id')).split('_');
  	// var ans = confirm('Do you wish to delete?');

  	// if(ans) {
  	// 	$.ajax({
  	// 		url : base_url + 'admin/function_master/delete_function',
  	// 		data: { deId : ctr[2] },
  	// 		dataType: 'JSON',
  	// 		type: 'POST',
  	// 		success: function(data) {
  	// 			if(data.data==true) {
  	// 				$("#tr_de_"+ctr[2]).fadeOut('slow');
  	// 			}
  	// 		}
  	// 	});
  	// } else {
  	// 	return false;
  	// }
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
		  			url : base_url + 'admin/function_master/delete_function',
		  			data: { deId : ctr[2] },
		  			dataType: 'JSON',
		  			type: 'POST',
		  			success: function(data) {
		  				if(data.data==true) {
		  					$("#tr_de_"+ctr[2]).fadeOut('slow');
		  				}
		  			}
		  		});
		  	}
	    }
	});
  });
});