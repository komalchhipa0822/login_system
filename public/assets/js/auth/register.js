


$(document).ready(function() {
    /* Validation Of Bank Form */
    $("#register_form").validate({
        rules: {
        	 prefix: {
                required: true,
            },
            first_name: {
                required: true,
                normalizer: function(value) {
                    return $.trim(value);
                },
            },
            middle_name: {
                required: true,
                normalizer: function(value) {
                    return $.trim(value);
                },
            },
            last_name: {
                required: true,
                normalizer: function(value) {
                    return $.trim(value);
                },
            },
            email: {
                required: true,	
                emailCheck:true,
            },
            password:{
                required: true,
                minlength: 8,
                pwcheck: true,
            },
            password_confirmation:{
               required: true,
                equalTo: "#password-input",
            }
        },

        messages: {
        	 prefix: {
                required: "Please Select Prefix",
            },
            first_name: {
                required: "Please Enter First Name.",
            },
            middle_name: {
                required: "Please Enter Middle Name.",
            },
            last_name: {
                required: "Please Enter Last Name.",
            },
            email: {
                required: "Please Enter Email",
                emailCheck:"Email Already Exists",
            },
            password:{
                 required: "Please Enter Password.",
                minlength: "Your Password Must Be At Least 8 Characters Long",
                pwcheck: "Please Enter Atleast One Uppercase, Number And Special Character!",
            },
            password_confirmation:{
                required: "This value should not be blank.",
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

     $.validator.addMethod("emailCheck", function(value) {
        var x = 0;
        var x = $.ajax({
            url: aurl + "/email-check",
            type: "POST",
            async: false,
            data: { email: value},
        }).responseText;
        if (x != 0) {
            return false;
        } else return true;
    });
    
});
