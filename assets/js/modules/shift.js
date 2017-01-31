$(function() {

	var shTable 	= $('#tbl_dt_shift').DataTable({
									"bSort" : false,
									"iDisplayLength": 100,
								});

  	$('#shift_name').keyup(function(){
	    shTable
		    .column(0)
		    .search(this.value)
		    .draw();
  	});

  	$("#btn_add_shift").on('click', function() {

	  	var frm = $("#frm_shift").serialize();
	  	$.ajax({
	  		url : base_url + 'admin/shift/add_shift',
	  		data: frm,
	  		dataType: 'JSON',
	  		type: 'POST',
	  		success: function(data) {
					var new_tr = '';
					if( data.success==true ) {

				  	shTable
					    .column(0)
					    .search('')
					    .draw(false);

						$(".frm_add_element").val('');
						$(".dataTables_empty").parent().hide();
						var ctr = data.data['shift_id'];

						new_tr = '<tr id="tr_sh_'+ ctr +'">';
						new_tr += '<td class="vert-align" id="td_sh_name_'+ctr+'">'+ ucwords(data.data['shift_name']) +'</td>';
			      new_tr += '<td class="vert-align" id="td_sh_date_'+ctr+'">'+ data.data['date_added'] +'</td>';
			      new_tr += '<td class="vert-align" id="td_sh_added_'+ctr+'">'+ ucwords(data.data['added_by']) +'</td>';
			      new_tr += '<td class="vert-align" id="td_sh_btn_'+ctr+'">';
			      new_tr += '<button type="button" class="btn btn-primary btn-xs btn-noradius edit_sh" id="edit_sh_'+ctr+'">Edit</button>';
		        new_tr += '&nbsp; <button type="button" id="rm_sh_'+ctr+'" class="btn btn-primary btn-xs btn-noradius rm_sh">Delete</button>';
			      new_tr += '</td>';
			      new_tr += '</tr>';

						$("#tb_sh").prepend(new_tr);
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

	$('body').on('click', '.rm_sh', function() {

	  	var ctr = ($(this).attr('id')).split('_');

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
			  			url : base_url + 'admin/shift/delete_shift',
			  			data: { shId : ctr[2] },
			  			dataType: 'JSON',
			  			type: 'POST',
			  			success: function(data) {
			  				if(data.data==true) {
			  					$("#tr_sh_"+ctr[2]).fadeOut('slow');
			  				}
			  			}
			  		});
			  	}
		    }
		});
	});
});