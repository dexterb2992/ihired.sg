(function (ihired){
	ihired(window.jQuery, window, document);
	
}(function($, window, document){

	$(function (){
		// $ is now locally scoped

        /* tables */
        var tbl_skills = $("#tbl_skills"),
            tbl_skills_qualifications = $("#tbl_skills_qualifications"),
            tbl_skills_licenses = $("#tbl_skills_licenses"),
            tbl_skills_memberships = $("#tbl_skills_memberships");

        /* form text inputs */
		var txt_skills_name = $("#txt_skills_name"),
			skills_name = $("#skills_name"),
			is_specialised = $("#is_specialised");

        /* form select boxes */
        var sb_functions = $("#function_id"),
            sb_skills = $("#sb_skills"),
            sb_qualifications = $("#sb_qualifications"),
            sb_licenses = $("#sb_licenses"),
            sb_license_skills = $("#sb_license_skills"),
            sb_membership_skills = $("#sb_membership_skills"),
            sb_memberships = $("#sb_memberships");

        /* form buttons */
        var raw_btn_delete = $('<button type="button" class="btn btn-primary btn-xs btn-noradius" title="Delete this record">'+
                                    '<i class="glyphicon glyphicon-remove"></i>'+
                                '</button>'),

            btn_delete_skill = raw_btn_delete.clone().addClass('btn-delete-skill'),
            btn_delete_skills_qualifications = raw_btn_delete.clone().addClass("btn-delete-skills-qualifications"),
            btn_delete_skills_licenses = raw_btn_delete.clone().addClass("btn-delete-skills-licenses"),
            btn_delete_skills_memberships = raw_btn_delete.clone().addClass("btn-delete-skills-memberships"),

            btn_add_skill = $("#btn_add_skill"),
            btn_add_skills_qualifications = $("#btn_add_skills_qualifications"),
            btn_add_skills_licenses = $("#btn_add_skills_licenses"),
            btn_add_skills_memberships = $("#btn_add_skills_memberships");

        /** = = = = = = dropdown boxes = = = = = = =  */
        var i_functions = new Select2PagingPlugin();          
        i_functions.init(sb_functions, functions);

        /** = = = = = = dataTables = = = = = = = = = = = = */
        var dtTable_skills = $("#tbl_skills").DataTable({
            	"iDisplayLength": 100,
            }),
            dtTable_skills_qualifications = $("#tbl_skills_qualifications").DataTable({
                "iDisplayLength": 100,
            }),
            dtTable_skills_licenses = $("#tbl_skills_licenses").DataTable({
                "iDisplayLength": 100,
            }),
            dtTable_skills_memberships = $("#tbl_skills_memberships").DataTable({
                "iDisplayLength": 100,
            });


        /* hack: activate select2 on tabchange event to fix issue on select2 inside tabs */
        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            var target = $(e.target).attr("href") // activated tab
            if( target == "#q_skills" ){ // Qualifications for Skills
                var i_skills = new Select2PagingPlugin(),
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
            }else if( target == "#l_skills" ){ // License for Skills
                var i_license_skills = new Select2PagingPlugin(),
                    i_licenses = new Select2PagingPlugin();
                i_license_skills.init(sb_license_skills, skills);
                i_licenses.init(sb_licenses, licenses);

                sb_license_skills.bind("change focus", function (){
                    var data = $("#sb_license_skills").select2('data');
                    var text = data.length > 0 ? data[0].text : "";
                    dtTable_skills_licenses
                        .column(0)
                        .search(text)
                        .draw();
                });
            }else if( target == "#mem_skills" ){ // Memberships for Skills
                var i_membership_skills = new Select2PagingPlugin(),
                    i_memberships = new Select2PagingPlugin();
                i_membership_skills.init(sb_membership_skills, skills);
                i_memberships.init(sb_memberships, memberships);

                sb_membership_skills.bind("change focus", function (){
                    var data = $("#sb_membership_skills").select2('data');
                    var text = data.length > 0 ? data[0].text : "";
                    dtTable_skills_memberships
                        .column(0)
                        .search(text)
                        .draw();
                });
            }
        });


        /* = = = = = = dataTables' search field = = = = = */
        txt_skills_name.bind("change keyup", function(){
            dtTable_skills
                .column(0)
                .search(this.value)
                .draw();
        });


        /* = = = = = = = add buttons = = = = = = = = = */
        btn_add_skill.on("click", function (){
        	var $this = $(this);

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

                        var btn_delete = btn_delete_skill.clone();

                        btn_delete.attr("data-id", data.details.skill.skills_id);

                        // I used document.createElement because it's the fastest way to create a dom element
                        // Run some tests here http://jsperf.com/jquery-vs-createelement

                        var div = $(document.createElement('div')).append(btn_delete);
                        var specialised = is_specialised.is(":checked") ? "Yes" : "No";

                        dtTable_skills.row.add([
                            txt_skills_name.val(),
                            sb_functions.select2('data')[0].text,
                            specialised,
                            div.html()
                        ]).draw( false );

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

                        var skill_name = sb_skills.select2('data')[0].text;
                        var qualification_name = sb_qualifications.select2('data')[0].text;

                        var btn_delete = btn_delete_skills_qualifications.clone();

                        btn_delete.attr("data-id", data.details.skills_qualifications.sq_id);

                        // I used document.createElement because it's the fastest way to create a dom element
                        // Run some tests here http://jsperf.com/jquery-vs-createelement

                        var div = $(document.createElement('div')).append(btn_delete);

                        dtTable_skills_qualifications.row.add([
                            skill_name,
                            qualification_name,
                            div.html()
                        ]).draw( false );

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


        btn_add_skills_licenses.on("click", function (){
            var $this = $(this);

            $.ajax({
                url: base_url+"admin/skills_master/add_skill_license",
                type: 'post',
                dataType: 'json',
                data: {
                    skills_id: sb_license_skills.val(),
                    license_id: sb_licenses.val(),
                },
                beforeSend: function (){
                    $this.addClass("disabled").attr("disabled", "disabled").text("Please wait...");
                },
                success: function (data){
                    if( data.success == true ){
                        skills_licenses.push(data.details.skills_licenses);

                        var skill_name = sb_license_skills.select2('data')[0].text;
                        var license_name = sb_licenses.select2('data')[0].text;

                        var btn_delete = btn_delete_skills_licenses.clone();

                        btn_delete.attr("data-id", data.details.skills_licenses.sl_id);

                        // I used document.createElement because it's the fastest way to create a dom element
                        // Run some tests here http://jsperf.com/jquery-vs-createelement

                        var div = $(document.createElement('div')).append(btn_delete);

                        dtTable_skills_licenses.row.add([
                            skill_name,
                            license_name,
                            div.html()
                        ]).draw( false );

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

        btn_add_skills_memberships.on("click", function (){
            var $this = $(this);

            $.ajax({
                url: base_url+"admin/skills_master/add_skill_membership",
                type: 'post',
                dataType: 'json',
                data: {
                    skills_id: sb_membership_skills.val(),
                    license_id: sb_memberships.val(),
                },
                beforeSend: function (){
                    $this.addClass("disabled").attr("disabled", "disabled").text("Please wait...");
                },
                success: function (data){
                    if( data.success == true ){
                        skills_memberships.push(data.details.skills_memberships);

                        var skill_name = sb_membership_skills.select2('data')[0].text;
                        var membership_name = sb_memberships.select2('data')[0].text;

                        var btn_delete = btn_delete_skills_memberships.clone();

                        btn_delete.attr("data-id", data.details.skills_memberships.sm_id);

                        // I used document.createElement because it's the fastest way to create a dom element
                        // Run some tests here http://jsperf.com/jquery-vs-createelement

                        var div = $(document.createElement('div')).append(btn_delete);

                        dtTable_skills_memberships.row.add([
                            skill_name,
                            membership_name,
                            div.html()
                        ]).draw( false );

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

        /* = = = = = = = delete buttons = = = = = = = = = */
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
                                    dtTable_skills.row( $this.parents('tr') )
                                        .remove()
                                        .draw(false);
                                   
                                    flashdata_status(data.msg, 'Saved.');

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

                                    dtTable_skills_qualifications
                                        .row( $this.parents('tr') )
                                        .remove()
                                        .draw(false);

                                    flashdata_status(data.msg, 'Saved.');
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

        $(document).on("click", ".btn-delete-skills-licenses", function (){
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
                            url : base_url + 'admin/skills_master/remove_skill_license',
                            data: { id: id },
                            dataType: 'json',
                            type: 'post',
                            success: function(data) {
                                if(data.success == true) {
                                    dtTable_skills_licenses
                                        .row( $this.parents('tr') )
                                        .remove()
                                        .draw(false);

                                    flashdata_status(data.msg, 'Saved.');
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

        $(document).on("click", ".btn-delete-skills-memberships", function (){
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
                            url : base_url + 'admin/skills_master/remove_skill_membership',
                            data: { id: id },
                            dataType: 'json',
                            type: 'post',
                            success: function(data) {
                                if(data.success == true) {
                                    dtTable_skills_memberships
                                        .row( $this.parents('tr') )
                                        .remove()
                                        .draw(false);

                                    flashdata_status(data.msg, 'Saved.');
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