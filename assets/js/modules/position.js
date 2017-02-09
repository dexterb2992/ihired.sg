$(function() {

	var poTable 	= $('#tbl_dt_position').DataTable({
									"bSort" : false,
									"iDisplayLength": 100,
								});

  $('#position_name').keyup(function(){
    poTable
	    .column(0)
	    .search(this.value)
	    .draw();
  });

  $("#btn_add_position").on('click', function() {

  	var frm = $("#frm_position").serialize();
  	$.ajax({
  		url : base_url + 'admin/position/add_position',
  		data: frm,
  		dataType: 'JSON',
  		type: 'POST',
  		success: function(data) {
				var new_tr = '';
				if( data.success==true ) {

			  	poTable
				    .column(0)
				    .search('')
				    .draw(false);

					$(".frm_add_element").val('');
					$(".dataTables_empty").parent().hide();
					var ctr = data.data['position_id'];

					new_tr = '<tr id="tr_po_'+ ctr +'">';
					new_tr += '<td class="vert-align" id="td_po_name_'+ctr+'">'+ ucwords(data.data['position_name']) +'</td>';
		      new_tr += '<td class="vert-align" id="td_po_date_'+ctr+'">'+ data.data['date_added'] +'</td>';
		      new_tr += '<td class="vert-align" id="td_po_added_'+ctr+'">'+ ucwords(data.data['added_by']) +'</td>';
		      new_tr += '<td class="vert-align" id="td_po_btn_'+ctr+'">';
		      new_tr += '<button type="button" class="btn btn-primary btn-xs btn-noradius edit_po" id="edit_po_'+ctr+'">Edit</button>';
	        new_tr += '&nbsp; <button type="button" id="rm_po_'+ctr+'" class="btn btn-primary btn-xs btn-noradius rm_po">Delete</button>';
		      new_tr += '</td>';
		      new_tr += '</tr>';

					$("#tb_po").prepend(new_tr);
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

  	$('body').on('click', '.rm_po', function() {

	  	var ctr = ($(this).attr('id')).split('_');
	  	// var ans = confirm('Do you wish to delete?');

	  	// if(ans) {
	  	// 	$.ajax({
	  	// 		url : base_url + 'admin/position/delete_position',
	  	// 		data: { poId : ctr[2] },
	  	// 		dataType: 'JSON',
	  	// 		type: 'POST',
	  	// 		success: function(data) {
	  	// 			if(data.data==true) {
	  	// 				$("#tr_po_"+ctr[2]).fadeOut('slow');
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
		            label: '<i class="glyphicon glyphicon-remove"></i> No'
		        },
		        confirm: {
		            label: '<i class="glyphicon glyphicon-ok"></i> Yes'
		        }
		    },
		    callback: function (ans) {
		        if(ans) {
			  		$.ajax({
			  			url : base_url + 'admin/position/delete_position',
			  			data: { poId : ctr[2] },
			  			dataType: 'JSON',
			  			type: 'POST',
			  			success: function(data) {
			  				if(data.data==true) {
			  					$("#tr_po_"+ctr[2]).fadeOut('slow');
			  				}
			  			}
			  		});
			  	}
		    }
		});
  	});
});