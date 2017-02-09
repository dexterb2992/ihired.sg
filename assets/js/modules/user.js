// IIFE - Immediately Invoked Function Expression
(function(ihired) {

    // The global jQuery object is passed as a parameter
    ihired(window.jQuery, window, document);

}(function($, window, document) {

    // The $ is now locally scoped 

    // Listen for the jQuery ready event on the document
    $(function() {
    	var btn_delete_user = $(".btn-delete-user"),
    		btn_add_user = $("#btn_add_user"),
    		frm_add_user = $("#frm_add_user"),
    		btn_dashInvite = $("#btn_dashInvite"),
    		mod_user_name = $("#mod_user_name"),
    		mod_email_id = $("#mod_email_id"),
            mod_user_id = $("#mod_user_id"),
            btn_dash_invite = $(".btn-dash-invite"),
            modal_dashInvite = $("#modal_dashInvite"),
            modal_dashInvite_success = $("#modal_dashInvite_success"),
            btn_invited = $('<button class="btn btn-primary btn-xs" style="border-radius:0;background-color:#71c05b;color:#FFFFFF;border-color:#71c05b">Invited</button>');

    		
        btn_delete_user.on("click", function (){
            var $this = $(this), 
                id = $this.attr("data-id");

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
                            url : base_url + 'user/delete',
                            data: { id: id },
                            dataType: 'json',
                            type: 'post',
                            success: function(data) {

                                if(data.success == true) {
                                    $this.closest('tr').slideUp('slow');
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

        btn_add_user.on("click", function (){
            var frm = $("#frm_add_user").serialize();
            $.ajax({
                url: base_url + 'user/create',
                data: frm,
                dataType: 'json',
                type: 'post',
                success: function(data) {
                    if( data.success == true ){
                        location.reload();
                    }else{
                        flashdata_status(data.data);
                    }
                    
                }
            });
        });

        btn_dashInvite.on("click", function (){
            var full_name = mod_user_name.text();
            var email_id = mod_email_id.text();
            var u_id = mod_user_id.val();
            $.ajax({
                url : base_url + 'dashboard/invite',
                type : 'post',
                dataType: 'json',
                data: { 
                    email_id : email_id, 
                    name : full_name,
                    u_id : u_id 
                },
                success : function(data) {
                    modal_dashInvite.modal('hide');

                    if(data.success == true) {
                        $("#input_dashemail").val(email_id);
                        modal_dashInvite_success.modal('show');
                        $(".btn-dash-invite[data-id='"+u_id+"']").replaceWith(btn_invited);
                    }else{
                        if( data.error ){
                            console.warn(data.error);
                        }
                        flashdata_status(data.msg);
                    }
                }
            });
        });

        btn_dash_invite.on("click", function (){
            var $this = $(this);
            mod_user_name.text( $this.attr("data-name") );
            mod_email_id.text( $this.attr("data-email") );
            mod_user_id.val( $this.attr("data-id") );

        });

    });

}));