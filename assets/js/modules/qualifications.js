$(function() {

	var quTable = $('#tbl_dt_qualifications').DataTable({
        "bSort" : false,
        "iDisplayLength": 100
	});

    $('#qualifications_name').keyup(function(){
        quTable
            .column(0)
            .search(this.value)
            .draw();
    });

    $("#btn_add_qualifications").on('click', function() {

      	var frm = $("#frm_qualifications").serialize();
      	$.ajax({
      		url : base_url + 'admin/qualifications/add_qualifications',
      		data: frm,
      		dataType: 'JSON',
      		type: 'POST',
      		success: function(data) {
    			var new_tr = '';
    			if( data.success==true ) {

    			  	quTable
    				    .column(0)
    				    .search('')
    				    .draw(false);

    				$(".frm_add_element").val('');
    				$(".dataTables_empty").parent().hide();
    				var ctr = data.data['qualifications_id'];

    				new_tr = '<tr id="tr_qu_'+ ctr +'">';
    				new_tr += '<td class="vert-align" id="td_qu_name_'+ctr+'">'+ ucwords(data.data['qualifications_name']) +'</td>';
                    new_tr += '<td class="vert-align" id="td_qu_date_'+ctr+'">'+ data.data['date_added'] +'</td>';
                    new_tr += '<td class="vert-align" id="td_qu_added_'+ctr+'">'+ ucwords(data.data['added_by']) +'</td>';
                    new_tr += '<td class="vert-align" id="td_qu_btn_'+ctr+'">';
                    new_tr += '<button type="button" class="btn btn-primary btn-xs btn-noradius edit_qu" id="edit_qu_'+ctr+'">Edit</button>';
                    new_tr += '&nbsp; <button type="button" id="rm_qu_'+ctr+'" class="btn btn-primary btn-xs btn-noradius rm_qu">Delete</button>';
                    new_tr += '</td>';
                    new_tr += '</tr>';

    				$("#tb_qu").prepend(new_tr);
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

    $('body').on('click', '.rm_qu', function() {

      	var ctr = ($(this).attr('id')).split('_');

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
                    url : base_url + 'admin/qualifications/delete_qualifications',
                    data: { quId : ctr[2] },
                    dataType: 'JSON',
                    type: 'POST',
                    success: function(data) {
                      if(data.data==true) {
                        $("#tr_qu_"+ctr[2]).fadeOut('slow');
                      }
                    }
                  });
                }
            }
        });

    });
});