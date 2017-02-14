(function (ihired){
	ihired(window.jQuery, window, document);
	
}(function($, window, document){

	$(function (){
		// $ is now locally scoped
		var txt_skills_name = $("#txt_skills_name"),
			skills_name = $("#skills_name"),
            sb_functions = $("#function_id"),
            sb_skills = $("#sb_skills"),
			sb_qualifications = $("#sb_qualifications"),
			tbl_skills = $("#tbl_skills"),
            tbl_skills_qualifications = $("#tbl_skills_qualifications"),
			is_specialised = $("#is_specialised"),
            btn_delete_skill = $(".btn-delete-skill").first(),
            btn_delete_skills_qualifications = $(".btn-delete-skills-qualifications").first(),
            btn_add_skill = $("#btn_add_skill"),
            btn_add_skills_qualifications = $("#btn_add_skills_qualifications");

        /** = = = = = = dropdown boxes = = = = = = =  */
        var i_functions = new Select2PagingPlugin();          
        i_functions.init(sb_functions, functions);


        /* hack: activate select2 on tabchange event to fix issue on select2 inside tabs */
        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            var target = $(e.target).attr("href") // activated tab
            console.log(target);
            if( target == "#q_skills" ){
                i_skills = new Select2PagingPlugin(),
                i_qualifications = new Select2PagingPlugin();

                i_qualifications.init(sb_qualifications, qualifications);
                i_skills.init(sb_skills, skills);
                sb_skills.bind("change focus", function (){
                    var data = $("#sb_skills").select2('data');
                    var text = data.length > 0 ? data[0].text : "";
                    dtTable_skills_qualifications
                        .column(0)
                        .search(text)
                        .draw();
                    console.log(text);
                });
            }
        });

        /** = = = = = = dataTables = = = = = = = = = = = = */
        var dtTable_skills = $("#tbl_skills").DataTable({
            	"iDisplayLength": 100,
            }),
            dtTable_skills_qualifications = $("#tbl_skills_qualifications").DataTable({
                "iDisplayLength": 100,
            });


        /* = = = = = = dataTables' search field = = = = = */
        txt_skills_name.keyup(function(){
            dtTable_skills
                .column(0)
                .search(this.value)
                .draw();
        });


        /* = = = = = = = update buttons = = = = = = = = = */
        btn_add_skill.on("click", function (){
        	var $this = $(this);
        	if( skills_name.val() != "" ){
        		// this means it already exists
        		flashdata_status("")
        	}

        	$.ajax({
        		url: base_url+"admin/skills_master/create",
        		type: 'post',
        		dataType: 'json',
        		data: {
        			skills_name: txt_skills_name.val(),
					function_id: sb_functions.val(),
					specialised: is_specialised.is(":checked") ? 'Y' : 'N'
        		},
        		beforeSend: function (){
        			$this.addClass("disabled").attr("disabled", "disabled").text("Please wait...");
        		},
        		success: function (data){
                    if( data.success == true ){
                        skills.push(data.details.skill);

                        tbl_skills.DataTable({
                            destroy: true
                        });

                        var btn_delete = btn_delete_skill.clone();

                        btn_delete.attr("data-id", data.details.skill.skills_id);

                        // I used document.createElement because it's the fastest way to create a dom element
                        // Run some tests here http://jsperf.com/jquery-vs-createelement

                        var div = $(document.createElement('div')).append(btn_delete);
                        var specialised = is_specialised.is(":checked") ? "Yes" : "No";
                        var new_row = $(document.createElement('tr'));
                        var tds = '<td>'+txt_skills_name.val()+'</td>'+
                                  '<td>'+sb_functions.select2('data')[0].text+'</td>'+
                                  '<td>'+specialised+'</td>'+
                                  '<td>'+div.html()+'</td>';
                        new_row.append( $(tds) );

                        tbl_skills.children('tbody').prepend(new_row);
                        tbl_skills.dataTable();

                        flashdata_status(data.msg, 'Saved.');
                    }else{
                        flashdata_status(data.msg);
                    }

                    $this.removeClass("disabled").removeAttr("disabled").text("Update");
        		},
        		error: function (data){
        			console.error(data);
        			flashdata_status("Whoops! Something went wrong. Please try again later.");
        			$this.removeClass("disabled").removeAttr("disabled").text("Update");
        		}
        	});
        });

        btn_add_skills_qualifications.on("click", function (){
            var $this = $(this);

            $.ajax({
                url: base_url+"admin/skills_master/add_skill_qualification",
                type: 'post',
                dataType: 'json',
                data: {
                    skills_id: sb_skills.val(),
                    qualifications_id: sb_qualifications.val(),
                },
                beforeSend: function (){
                    $this.addClass("disabled").attr("disabled", "disabled").text("Please wait...");
                },
                success: function (data){
                    if( data.success == true ){
                        skills_qualifications.push(data.details.skills_qualifications);

                        tbl_skills_qualifications.DataTable({
                            destroy: true
                        });

                        var btn_delete = btn_delete_skills_qualifications.clone();

                        btn_delete.attr("data-id", data.details.skills_qualifications.skills_qualifications_id);

                        // I used document.createElement because it's the fastest way to create a dom element
                        // Run some tests here http://jsperf.com/jquery-vs-createelement

                        var div = $(document.createElement('div')).append(btn_delete);
                        var new_row = $(document.createElement('tr'));
                        var tds = '<td>'+sb_skills.select2('data')[0].text+'</td>'+
                                  '<td>'+sb_qualifications.select2('data')[0].text+'</td>'+
                                  '<td>'+div.html()+'</td>';
                        new_row.append( $(tds) );

                        tbl_skills_qualifications.children('tbody').prepend(new_row);
                        tbl_skills_qualifications.dataTable();

                        flashdata_status(data.msg, 'Saved.');
                    }else{
                        flashdata_status(data.msg);
                    }

                    $this.removeClass("disabled").removeAttr("disabled").text("Update");
                },
                error: function (data){
                    console.error(data);
                    flashdata_status("Whoops! Something went wrong. Please try again later.");
                    $this.removeClass("disabled").removeAttr("disabled").text("Update");
                }
            });
        });

        $(document).on("click", ".btn-delete-skill", function (){
        	var $this = $(this),
                id = $this.attr('data-id');

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
                            url : base_url + 'admin/skills_master/delete',
                            data: { id: id },
                            dataType: 'json',
                            type: 'post',
                            success: function(data) {
                                if(data.success == true) {
                                    tbl_skills.dataTable({
                                        destroy: true
                                    });

                                    $this.closest('tr').slideUp('slow');
                                    flashdata_status(data.msg, 'Saved.');
                                    tbl_skills.dataTable();
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
        });

        $(document).on("click", ".btn-delete-skills-qualifications", function (){
            var $this = $(this),
                id = $this.attr('data-id');

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
                            url : base_url + 'admin/skills_master/remove_skill_qualification',
                            data: { id: id },
                            dataType: 'json',
                            type: 'post',
                            success: function(data) {
                                if(data.success == true) {
                                    tbl_skills_qualifications.dataTable({
                                        destroy: true
                                    });

                                    $this.closest('tr').slideUp('slow');
                                    flashdata_status(data.msg, 'Saved.');
                                    tbl_skills_qualifications.dataTable();
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
        });

	});

	// The rest of the code goes here

}));