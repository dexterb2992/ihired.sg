$(function() {

/*******
** init country
*/ 
	var deleteCountry;
	var deleteCity;
	var deleteTown;
	var oTable 	= $('#tbl_dt_country').DataTable({
									"bSort" : false,
									"iDisplayLength": 100,
								});

  $('#co_input_country').keyup(function(){
    oTable
	    .column(0)
	    .search(this.value)
	    .draw();
  });

  $('body').on('keyup', '.co_name', function() {
    var txtVal = $(this).val();
    var myElem = $(this);
		$.ajax({
			url: base_url + 'admin/country/all_countries',
			type: 'post',
			dataType: 'json',
			data: { txtVal: txtVal },
			success: function(data) {

				myElem.autocomplete({
					source: data,
					minLength: 1,
					messages: {
		        noResults: '',
		        results: function() {}
	    		}
				});
			}
		});
  });

  $('body').on('keyup', '.co_nati', function() {
    var txtVal = $(this).val();
    var myElem = $(this);
		$.ajax({
			url: base_url + 'admin/country/all_nationalities',
			type: 'post',
			dataType: 'json',
			data: { txtVal: txtVal },
			success: function(data) {

				myElem.autocomplete({
					source: data,
					minLength: 1,
					messages: {
		        noResults: '',
		        results: function() {}
	    		}
				});
			}
		});
  });

  $("#btn_add_country").on('click', function() {

  	var frm = $("#frm_country").serialize();
  	$.ajax({
  		url : base_url + 'admin/country/add_country',
  		data: frm,
  		dataType: 'json',
  		type: 'post',
  		success: function(data) {
				var new_tr = '';
				if( data.success==true ) {

			  	oTable
				    .column(0)
				    .search('')
				    .draw(false);

					$(".frm_add_element").val('');
					$(".dataTables_empty").parent().hide();
					var ctr = data.data['country_id'];

					new_tr = '<tr id="tr_co_'+ ctr +'">';
					new_tr += '<input type="hidden" id="h_jsspawn_'+ctr+'">';
					new_tr += '<td class="vert-align" id="td_co_name_'+ctr+'">'+ ucwords(data.data['country_name']) +'</td>';
		      new_tr += '<td class="vert-align" id="td_co_nationality_'+ctr+'">'+ ucwords(data.data['nationality']) +'</td>';
		      new_tr += '<td class="vert-align" id="td_co_currency_'+ctr+'">'+ ucwords(data.data['currency_name']) +'</td>';
		      new_tr += '<td class="vert-align" id="td_co_symbol_'+ctr+'">'+ data.data['currency_symbol'] +'</td>';
		      new_tr += '<td class="vert-align" id="td_co_date_'+ctr+'">'+ data.data['date_added'] +'</td>';
		      new_tr += '<td class="vert-align" id="td_co_added_'+ctr+'">'+ ucwords(data.data['added_by']) +'</td>';
		      new_tr += '<td class="vert-align" id="td_co_btn_'+ctr+'">';
		      new_tr += '<button type="button" class="btn btn-primary btn-xs btn-noradius edit_co" id="edit_co_'+ctr+'">Edit</button>';
	        new_tr += '&nbsp; <button type="button" id="rm_co_'+ctr+'" class="btn btn-primary btn-xs btn-noradius rm_co">Delete</button>';
		      new_tr += '</td>';
		      new_tr += '</tr>';

					$("#tb_co").prepend(new_tr);
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
  
  $('body').on('click', '#deleteCountry', function() {
		
		$.ajax({
  			url : base_url + 'admin/country/delete_country',
  			data: { coId : deleteCountry[2] },
  			dataType: 'JSON',
  			type: 'POST',
  			success: function(data) {

  				if(data.data==true) {
					$("#tr_co_"+deleteCountry[2]).fadeOut('slow');
  					$('#deleteCountryModal').modal('hide');
  				}
				else{
					$('#deleteCountryModal').modal('hide');
				}
  			}
  		});
		
   });
   
   $('body').on('click', '#deleteCity', function() {
		
		$.ajax({
  			url : base_url + 'admin/country/delete_city',
  			data: { ciId : deleteCity[2] },
  			dataType: 'JSON',
  			type: 'POST',
  			success: function(data) {
				if(data.data==true) {
			 		$("#tr_ci_"+deleteCity[2]).fadeOut('slow');
					$('#deleteCityModal').modal('hide');
  				}
  				
				else{
					$('#deleteCityModal').modal('hide');
				}
  			}
  		});
		
   });
   
  $('body').on('click', '.rm_co', function() {

  	var ctr = ($(this).attr('id')).split('_');
	deleteCountry = ctr;  	
	$('#deleteCountryModal').modal({
	  keyboard: false,
	  backdrop: 'static'
	})
	
  });

	$("#co_input_nationality").on('keyup', function(){
		
		var txtVal = $(this).val();
		
		$.ajax({
			url: base_url + 'admin/country/all_nationalities',
			type: 'post',
			dataType: 'json',
			data: { txtVal: txtVal },
			success: function(data) {
				
				$("#co_input_nationality").autocomplete({
					source: data,
					minLength: 0,
					messages: {
						noResults: '',
						results: function() {}
				 	},
					select: function(event, ui){
						if (ui.item) {							
							$('#co_input_nationality').val(ui.item.id);
						} else {
							$('#co_input_nationality').val('');
						}
					}
				});
			}
		});
	});

	$('body').on('click','.edit_co',function() {

		var ctr = ($(this).attr('id')).split('_');
		// var thisTr = $("#tr_co_"+ctr[2]);

		// console.log($(this.parentNode.parentNode));

	  var jqTds = $('>td', $(this.parentNode.parentNode));

		var new_co_name = '';
		var new_co_nati = '';
		var new_co_curr = '';
		var new_co_symb = '';

		if($("#h_jsspawn_"+ctr[2]).length>0) {
			if(this.parentNode.parentNode.childNodes[1].childNodes[0]!=undefined) {
				new_co_name = this.parentNode.parentNode.childNodes[1].childNodes[0].data;
			}
			if(this.parentNode.parentNode.childNodes[2].childNodes[0]!=undefined) {
				new_co_nati = this.parentNode.parentNode.childNodes[2].childNodes[0].data;
			}
			if(this.parentNode.parentNode.childNodes[3].childNodes[0]!=undefined) {
				new_co_curr = this.parentNode.parentNode.childNodes[3].childNodes[0].data;
			}
			if(this.parentNode.parentNode.childNodes[4].childNodes[0]!=undefined) {
				new_co_symb = this.parentNode.parentNode.childNodes[4].childNodes[0].data;
			}
		} 
		else {
		  if(this.parentNode.parentNode.childNodes[1].childNodes[0]!=undefined) {
				new_co_name = this.parentNode.parentNode.childNodes[1].childNodes[0].data;
		  }
			if(this.parentNode.parentNode.childNodes[3].childNodes[0]!=undefined) {
				new_co_nati = this.parentNode.parentNode.childNodes[3].childNodes[0].data;
			}
			if(this.parentNode.parentNode.childNodes[5].childNodes[0]!=undefined) {
				new_co_curr = this.parentNode.parentNode.childNodes[5].childNodes[0].data;
			}
			if(this.parentNode.parentNode.childNodes[7].childNodes[0]!=undefined) {
				new_co_symb = this.parentNode.parentNode.childNodes[7].childNodes[0].data;
			}
		}

	  jqTds[0].innerHTML = '<input type="text" value="'+new_co_name+'" class="form-control input-sm co_name" >';
	  jqTds[0].innerHTML += '<input type="hidden" id="old_co_name_'+ctr[2]+'" value="'+new_co_name+'" class="form-control input-sm co_name" >';
	  jqTds[1].innerHTML = '<input type="text" value="'+new_co_nati+'" class="form-control input-sm co_nati" >';
	  jqTds[1].innerHTML += '<input type="hidden" id="old_co_nati_'+ctr[2]+'" value="'+new_co_nati+'" class="form-control input-sm co_nati" >';
	  jqTds[2].innerHTML = '<input type="text" value="'+new_co_curr+'" class="form-control input-sm" >';
	  jqTds[2].innerHTML += '<input type="hidden" id="old_co_curr_'+ctr[2]+'" value="'+new_co_curr+'" class="form-control input-sm" >';
	  jqTds[3].innerHTML = '<input type="text" value="'+new_co_symb+'" class="form-control input-sm" >';
	  jqTds[3].innerHTML += '<input type="hidden" id="old_co_symb_'+ctr[2]+'" value="'+new_co_symb+'" class="form-control input-sm" >';
	  jqTds[6].innerHTML = '<button type="button" class="btn btn-primary btn-xs btn-noradius save_co">save</button>';
	  jqTds[6].innerHTML += '&nbsp; <button type="button" class="btn btn-default btn-xs btn-noradius can_co" >cancel</button>';
	});

	$('body').on('click', '.can_co', function() {
		
		var thisTr = $(this).parent().parent();
		var ctr = (thisTr.attr('id')).split('_');

	  var jqTds = $('>td', $(this.parentNode.parentNode));

		var new_co_name = '';
		var new_co_nati = '';
		var new_co_curr = '';
		var new_co_symb = '';

		if($("#h_jsspawn_"+ctr[2]).length>0) {
			if(this.parentNode.parentNode.childNodes[1].childNodes[1]!=undefined) {
				new_co_name = this.parentNode.parentNode.childNodes[1].lastChild.value;
			}
			if(this.parentNode.parentNode.childNodes[2].childNodes[1]!=undefined) {
				new_co_nati = this.parentNode.parentNode.childNodes[2].lastChild.value;
			}
			if(this.parentNode.parentNode.childNodes[3].childNodes[1]!=undefined) {
				new_co_curr = this.parentNode.parentNode.childNodes[3].lastChild.value;
			}
			if(this.parentNode.parentNode.childNodes[4].childNodes[1]!=undefined) {
				new_co_symb = this.parentNode.parentNode.childNodes[4].lastChild.value;
			}
		} 
		else {
		  if(this.parentNode.parentNode.childNodes[1].childNodes[1]!=undefined) {
				new_co_name = this.parentNode.parentNode.childNodes[1].lastChild.value;
		  }
			if(this.parentNode.parentNode.childNodes[3].childNodes[1]!=undefined) {
				new_co_nati = this.parentNode.parentNode.childNodes[3].lastChild.value;
			}
			if(this.parentNode.parentNode.childNodes[5].childNodes[1]!=undefined) {
				new_co_curr = this.parentNode.parentNode.childNodes[5].lastChild.value;
			}
			if(this.parentNode.parentNode.childNodes[7].childNodes[1]!=undefined) {
				new_co_symb = this.parentNode.parentNode.childNodes[7].lastChild.value;
			}
		}

	  jqTds[0].innerHTML = new_co_name;
	  jqTds[1].innerHTML = new_co_nati;
	  jqTds[2].innerHTML = new_co_curr;
	  jqTds[3].innerHTML = new_co_symb;
	  jqTds[6].innerHTML = '<button type="button" class="btn btn-primary btn-xs btn-noradius edit_co" id="edit_co_'+ctr[2]+'">Edit</button>';
	  jqTds[6].innerHTML += '&nbsp; <button type="button" id="rm_co_'+ctr[2]+'" class="btn btn-primary btn-xs btn-noradius rm_co">Delete</button>';
	});

	$('body').on('click','.save_co',function() {

		var thisTr = $(this).parent().parent();
		var ctr = (thisTr.attr('id')).split('_');

		var new_co_id = '';
		var new_co_name = '';
		var new_co_nati = '';
		var new_co_curr = '';
		var new_co_symb = '';

		if($("#h_jsspawn_"+ctr[2]).length>0) {
			if(this.parentNode.parentNode.childNodes[1].childNodes[0]!=undefined) {
				new_co_name = this.parentNode.parentNode.childNodes[1].childNodes[0].value;
			}
			if(this.parentNode.parentNode.childNodes[2].childNodes[0]!=undefined) {
				new_co_nati = this.parentNode.parentNode.childNodes[2].childNodes[0].value;
			}
			if(this.parentNode.parentNode.childNodes[3].childNodes[0]!=undefined) {
				new_co_curr = this.parentNode.parentNode.childNodes[3].childNodes[0].value;
			}
			if(this.parentNode.parentNode.childNodes[4].childNodes[0]!=undefined) {
				new_co_symb = this.parentNode.parentNode.childNodes[4].childNodes[0].value;
			}
		} 
		else {
			new_co_name = this.parentNode.parentNode.childNodes[1].childNodes[0].value;
			new_co_nati = this.parentNode.parentNode.childNodes[3].childNodes[0].value;
			new_co_curr = this.parentNode.parentNode.childNodes[5].childNodes[0].value;
			new_co_symb = this.parentNode.parentNode.childNodes[7].childNodes[0].value;
		}
		var new_btn = '<button type="button" class="btn btn-primary btn-xs btn-noradius edit_co" id="edit_co_'+ctr[2]+'">Edit</button>';
				new_btn += '&nbsp; <button type="button" id="rm_co_'+ctr[2]+'" class="btn btn-primary btn-xs btn-noradius rm_co">Delete</button>';

		$.ajax({
			url: base_url + 'admin/country/edit_country',
			type: 'post',
			dataType: 'json',
			data: { co_name : new_co_name,
							co_nationality : new_co_nati,
							co_currency : new_co_curr,
							co_symbol : new_co_symb,
							co_id : ctr[2]
						},
			success: function(data) {

			if( data.success==true ) {
				document.getElementById('td_co_name_'+ctr[2]).innerHTML 				= ucwords(new_co_name);
				document.getElementById('td_co_nationality_'+ctr[2]).innerHTML 	= ucwords(new_co_nati);
				document.getElementById('td_co_currency_'+ctr[2]).innerHTML 		= ucwords(new_co_curr);
				document.getElementById('td_co_symbol_'+ctr[2]).innerHTML 			= new_co_symb.toUpperCase();
				document.getElementById('td_co_btn_'+ctr[2]).innerHTML 					= new_btn;
			} else {
				if(data.data==null) {
					flashdata_status("No changes detected. Click Cancel.");
				} else {
					flashdata_status(data.data);
				}
			}
		}
		});
	});

// *******
// city
	var iTable 	= $('#tbl_dt_city').DataTable({
									"bSort" : false,
									"iDisplayLength": 100,
								});

  $('#ci_input_city').keyup(function(){
    iTable
	    .column(0)
	    .search(this.value)
	    .draw();
  });

	$("#ci_input_country").on('keyup', function(){

		var txtVal = $(this).val();
		if(txtVal=='') {
			$('#h_ci_country_id').val('');
		} else {
			$('#h_ci_country_id').val('-1');
		}

		$.ajax({
			url: base_url + 'admin/country/all_countries',
			type: 'post',
			dataType: 'json',
			data: { txtVal: txtVal },
			success: function(data) {
				
				$("#ci_input_country").autocomplete({
					source: data,
					minLength: 1,
					messages: {
		        noResults: '',
		        results: function() {}
	    		},
		    	select: function(event, ui){
	    			if(ui) {
		    			$('#h_ci_country_id').val(ui.item.id);
	    			} 
		    		$('#ci_input_country').val(ui.item.label);
		    	}
				});
			}
		});
	});

  $("#btn_add_city").on('click', function() {

  	var frm = $("#frm_city").serialize();
  	$.ajax({
  		url : base_url + 'admin/country/add_city',
  		data: frm,
  		dataType: 'JSON',
  		type: 'POST',
  		success: function(data) {
				var new_tr = '';
				if( data.success==true ) {

			  	iTable
				    .column(0)
				    .search('')
				    .draw(false);

					$(".frm_add_element").val('');
					$(".dataTables_empty").parent().hide();
					var ctr = data.data['city_id'];

					new_tr = '<tr id="tr_ci_'+ ctr +'">';
					new_tr += '<td class="vert-align" id="td_ci_name_'+ctr+'">'+ ucwords(data.data['city_name']) +'</td>';
		      new_tr += '<td class="vert-align" id="td_ci_country_'+ctr+'">'+ ucwords(data.data['country_name']) +'</td>';
		      new_tr += '<td class="vert-align" id="td_ci_date_'+ctr+'">'+ data.data['date_added'] +'</td>';
		      new_tr += '<td class="vert-align" id="td_ci_added_'+ctr+'">'+ ucwords(data.data['added_by']) +'</td>';
		      new_tr += '<td class="vert-align" id="td_ci_btn_'+ctr+'">';
		      new_tr += '<button type="button" class="btn btn-primary btn-xs btn-noradius edit_ci" id="edit_ci_'+ctr+'">Edit</button>';
	        new_tr += '&nbsp; <button type="button" id="rm_ci_'+ctr+'" class="btn btn-primary btn-xs btn-noradius rm_ci">Delete</button>';
		      new_tr += '</td>';
		      new_tr += '</tr>';

					$("#tb_ci").prepend(new_tr);
					$('#h_ci_country_id').val('');
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

	// $('body').on('click','.edit_ci',function() {

	// 	var ctr = ($(this).attr('id')).split('_');
	// 	var thisTr = $("#tr_ci_"+ctr[2]);

	//   var aData = oTable.row(thisTr).data();
	//   var jqTds = $('>td', thisTr);

	//   jqTds[0].innerHTML = '<input type="text" value="'+aData[0]+'" class="form-control input-sm" >';
	//   jqTds[1].innerHTML = '<input type="text" value="'+aData[1]+'" class="form-control input-sm ci_name" >';
	//   jqTds[4].innerHTML = '<button type="button" class="btn btn-primary btn-xs btn-noradius save_ci">save</button>';
	//   jqTds[4].innerHTML += '&nbsp; <button type="button" class="btn btn-default btn-xs btn-noradius can_ci" >cancel</button>';
	// });

  $('body').on('click', '.rm_ci', function() {

  	var ctr = ($(this).attr('id')).split('_');
	deleteCity = ctr;  	
	$('#deleteCityModal').modal({
	  keyboard: false,
	  backdrop: 'static'
	})
  	//var ans = confirm('Do you wish to delete?');
	/*
  	if(ans) {
  		$.ajax({
  			url : base_url + 'admin/country/delete_city',
  			data: { ciId : ctr[2] },
  			dataType: 'JSON',
  			type: 'POST',
  			success: function(data) {

  				if(data.data==true) {
			  	iTable
				    .column(0)
				    .search('')
				    .draw(false);
  					$("#tr_ci_"+ctr[2]).fadeOut('slow');
  				}
  			}
  		});
  	}
	*/
  });

/*******
** init Town
*/ 
	var tTable 	= $('#tbl_dt_town').DataTable({
									"bSort" : false,
									"iDisplayLength": 100,
								});

  $('#to_input_town').keyup(function(){
    tTable
	    .column(0)
	    .search(this.value)
	    .draw();
  });

	$("#to_input_country").on('keyup', function(){

		var txtVal = $(this).val();
		if(txtVal=='') {
			$('#h_to_country_id').val('');
		} else {
			$('#h_to_country_id').val('-1');
		}

		$.ajax({
			url: base_url + 'admin/country/all_countries',
			type: 'post',
			dataType: 'json',
			data: { txtVal: txtVal },
			success: function(data) {

				$("#to_input_country").autocomplete({
					source: data,
					minLength: 1,
					messages: {
		        noResults: '',
		        results: function() {}
	    		},
		    	select: function(event, ui){
	    			if(ui) {
		    			$('#h_to_country_id').val(ui.item.id);
	    			} 
		    		$('#to_input_country').val(ui.item.label);
		    	}
				});
			}
		});
	});

	$("#to_input_city").on('keyup', function(){

		var txtVal = $(this).val();
		if(txtVal=='') {
			$('#h_to_city_id').val('');
		} else {
			$('#h_to_city_id').val('-1');
		}

		$.ajax({
			url: base_url + 'admin/country/all_cities',
			type: 'post',
			dataType: 'json',
			data: { txtVal: txtVal },
			success: function(data) {

				$("#to_input_city").autocomplete({
					source: data,
					minLength: 1,
					messages: {
		        noResults: '',
		        results: function() {}
	    		},
		    	select: function(event, ui){
	    			if(ui) {
		    			$('#h_to_city_id').val(ui.item.id);
	    			} 
		    		$('#to_input_city').val(ui.item.label);
		    	}
				});
			}
		});
	});

  $("#btn_add_town").on('click', function() {

  	var frm = $("#frm_town").serialize();
  	$.ajax({
  		url : base_url + 'admin/country/add_town',
  		data: frm,
  		dataType: 'JSON',
  		type: 'POST',
  		success: function(data) {
				var new_tr = '';
				if( data.success==true ) {

			  	tTable
				    .column(0)
				    .search('')
				    .draw(false);

					$(".frm_add_element").val('');
					$(".dataTables_empty").parent().hide();
					var ctr = data.data['town_id'];

					new_tr = '<tr id="tr_to_'+ ctr +'">';
					new_tr += '<td class="vert-align" id="td_to_name_'+ctr+'">'+ ucwords(data.data['town_name']) +'</td>';
		      new_tr += '<td class="vert-align" id="td_to_city_'+ctr+'">'+ ucwords(data.data['city_name']) +'</td>';
		      new_tr += '<td class="vert-align" id="td_to_country_'+ctr+'">'+ ucwords(data.data['country_name']) +'</td>';
		      new_tr += '<td class="vert-align" id="td_to_date_'+ctr+'">'+ data.data['date_added'] +'</td>';
		      new_tr += '<td class="vert-align" id="td_to_added_'+ctr+'">'+ ucwords(data.data['added_by']) +'</td>';
		      new_tr += '<td class="vert-align" id="td_to_btn_'+ctr+'">';
		      new_tr += '<button type="button" class="btn btn-primary btn-xs btn-noradius edit_to" id="edit_to_'+ctr+'">Edit</button>';
	        new_tr += '&nbsp; <button type="button" id="rm_to_'+ctr+'" class="btn btn-primary btn-xs btn-noradius rm_to">Delete</button>';
		      new_tr += '</td>';
		      new_tr += '</tr>';

					$("#tb_to").prepend(new_tr);

					$('#h_to_city_id').val('');
					$('#h_to_country_id').val('');
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
  
  $('body').on('click', '#deleteTown', function() {
		
		$.ajax({
  			url : base_url + 'admin/country/delete_town',
  			data: { toId : deleteTown[2] },
  			dataType: 'JSON',
  			type: 'POST',
  			success: function(data) {
				if(data.data==true) {
			 		$("#tr_to_"+deleteTown[2]).fadeOut('slow');
					$('#deleteTownModal').modal('hide');
  				}
  				
				else{
					$('#deleteTownModal').modal('hide');
				}
  			}
  		});
		
   });

  $('body').on('click', '.rm_to', function() {

  	var ctr = ($(this).attr('id')).split('_');
	deleteTown = ctr;  	
	$('#deleteTownModal').modal({
	  keyboard: false,
	  backdrop: 'static'
	})  	
  });
});