


$(document).ready(function() {
    /* Validation Of Bank Form */
    $("#edit_profile_form").validate({
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
            },
           
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
            },
            
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

    

     
    
});


//Country State Dependent Dropdown With Ajax
$("#department_id").on("change", function() {
    var department_id = this.value;
    var degination_id=($('#designation_id').val() == null)? 0 : $('#designation_id').val();
    $.ajax({
        url: aurl + "/profile/get-degination",
        type: "POST",
        data: {
            department_id: department_id,
        },
        dataType: "json",
        success: function(result) {
            var html = "<option selected disabled value='0'>Please select";
            
            html += "</option>";
            $("#designation_id").html(html);
            $.each(result.deginations, function(key, value) {

            	var selected =(degination_id == value.id) ? 'selected' : '';
                $("#designation_id").append('<option value="' +value.id +'" '+selected+'>' +value.name +"</option>");
            });
        },
        error: function(request) {
            // toaster_message('Something Went Wrong! Please Try Again.', 'error');
        },
    });
});

$('.remove_profile_img').click(function(){
        $('.profile_image').attr('src','assets/img/admin_logo.png');
        $('.remove_img').val(1);
});
	

var imgupload = $('#OpenImgUpload').click(function(){ $('#imgupload').trigger('click'); });

var loadFile = function(event) {
    var output = document.getElementsByClassName('profile_image');
    $('.profile_image').attr('src',URL.createObjectURL(event.target.files[0]));
    output.src = URL.createObjectURL(event.target.files[0]);
    output.onload = function() {
      URL.revokeObjectURL(output.src) // free memory
    }
  };


get_Degination();
function get_Degination()
{

	var degination_id=($('#exit_designation_id').val() == null)? 0 : $('#exit_designation_id').val();
	var department_id=($('#department_id').val() == null)? 0 : $('#department_id').val();
	$.ajax({
        url: aurl + "/profile/get-degination",
        type: "POST",
        data: {
            department_id: department_id,
        },
        dataType: "json",
        success: function(result) {
             var html = "<option selected disabled value='0'>Please ";
            html += (result.deginations.length == 0) ? "First select Department" : "Select";
            html += "</option>";
            $("#designation_id").html(html);
            $.each(result.deginations, function(key, value) {

            	var selected =(degination_id == value.id) ? 'selected' : '';
                $("#designation_id").append('<option value="' +value.id +'" '+selected+'>' +value.name +"</option>");
            });
        },
        error: function(request) {
            // toaster_message('Something Went Wrong! Please Try Again.', 'error');
        },
    });
}