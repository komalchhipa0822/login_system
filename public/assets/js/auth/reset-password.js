


$(document).ready(function() {
    /* Validation Of Bank Form */
    $("#reset_password_form").validate({
        rules: {
            email: {
                required: true,	
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
            email: {
                required: "Please Enter Email.",
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
    
});
