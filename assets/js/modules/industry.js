$(function() {

	var inTable 	= $('#tbl_dt_industry').DataTable({
									"bSort" : false,
									"iDisplayLength": 100,
								});

  $('#industry_name').keyup(function(){
    inTable
	    .column(0)
	    .search(this.value)
	    .draw();
  });

  $("#btn_add_industry").on('click', function() {

  	var frm = $("#frm_industry").serialize();
  	$.ajax({
  		url : base_url + 'admin/industry/add_industry',
  		data: frm,
  		dataType: 'JSON',
  		type: 'POST',
  		success: function(data) {
				var new_tr = '';
				if( data.success==true ) {

			  	inTable
				    .column(0)
				    .search('')
				    .draw(false);

					$(".frm_add_element").val('');
					$(".dataTables_empty").parent().hide();
					var ctr = data.data['industry_id'];

					new_tr = '<tr id="tr_in_'+ ctr +'">';
					new_tr += '<td class="vert-align" id="td_in_name_'+ctr+'">'+ ucwords(data.data['industry_name']) +'</td>';
		      new_tr += '<td class="vert-align" id="td_in_date_'+ctr+'">'+ data.data['date_added'] +'</td>';
		      new_tr += '<td class="vert-align" id="td_in_added_'+ctr+'">'+ ucwords(data.data['added_by']) +'</td>';
		      new_tr += '<td class="vert-align" id="td_in_btn_'+ctr+'">';
		      new_tr += '<button type="button" class="btn btn-primary btn-xs btn-noradius edit_in" id="edit_in_'+ctr+'">Edit</button>';
	        new_tr += '&nbsp; <button type="button" id="rm_in_'+ctr+'" class="btn btn-primary btn-xs btn-noradius rm_in">Delete</button>';
		      new_tr += '</td>';
		      new_tr += '</tr>';

					$("#tb_in").prepend(new_tr);
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

  $('body').on('click', '.rm_in', function() {

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
		  			url : base_url + 'admin/industry/delete_industry',
		  			data: { inId : ctr[2] },
		  			dataType: 'JSON',
		  			type: 'POST',
		  			success: function(data) {
		  				if(data.data==true) {
		  					$("#tr_in_"+ctr[2]).fadeOut('slow');
		  				}
		  			}
		  		});
		  	}
	    }
	});
  });
});