


$(document).ready(function() {
    /* Validation Of Bank Form */
    $("#change_password_form").validate({
        rules: {
            currentPassword: {
                required: true,
                minlength: 8,
                pwcheck: true,
                oldpwdCheck:true,	
            },
            password:{
                required: true,
                minlength: 8,
                pwcheck: true,
            },
            password_confirmation:{
               required: true,
                equalTo: "#newPassword",
            }
        },

        messages: {
            currentPassword: {
                required: "Please Enter Current Password.",
                minlength: "Your Password Must Be At Least 8 Characters Long",
                pwcheck: "Please Enter Atleast One Uppercase, Number And Special Character!",
                oldpwdCheck:"Invalid Current Password",
            },
            password:{
                 required: "Please Enter Password.",
                minlength: "Your Password Must Be At Least 8 Characters Long",
                pwcheck: "Please Enter Atleast One Uppercase, Number And Special Character!",
            },
            password_confirmation:{
                required: "Please Enter Password.",
            }

        },
        errorPlacement: function(error, element) {
            if (
                element.parents("div").hasClass("has-feedback") ||
                element.hasClass("select2-hidden-accessible") 
            ) {
                error.appendTo(element.parent());
            } else if (
                element.parents("div").hasClass("uploader") ||
                element.hasClass("datepicker") ||  element.parents().hasClass("email-input")
            ) {
                error.appendTo(element.parent().parent());
            } else {
                error.insertAfter(element);
            }
        },

        highlight: function(element) {
            $(element).removeClass("error");
        },
    });

    $.validator.addMethod("pwcheck", function(value, element) {
            return (
                value.match(/[a-z]/) &&
                value.match(/[A-Z]/) &&
                value.match(/[0-9]/) &&
                value.match(/[_!#@$%^&*]/)
            );
        });

    $.validator.addMethod("oldpwdCheck", function(value) {
        var x = 0;
        var x = $.ajax({
            url: aurl + "/change-password/old-password-check",
            type: "POST",
            async: false,
            data: { currentPassword: value},
        }).responseText;
        console.log(x);
        if (x != 0) {
            return false;
        } else return true;
    });
    
});
