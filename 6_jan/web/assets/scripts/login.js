            
function forgotpassword()
{
    $("#login-form").hide();
    $("#forgot-form").show();
}
            
function login()
{
    $("#forgot-form").hide();
    $("#login-form").show();
}

function valLogin()
{   
    var emailformat = " /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/";
    var email=$("#username").val();
    if (email == "")
    {
        $("#username").css("border", "1px solid red");
        $("#username").focus();
        return false;
    
//    else if(emailformat.test(email) == false)
//    { 
//        bootbox.alert("Please enter email in correct format");
//        $("#username").css("border", "1px solid red");
//        return false;
    
    }
    else {
        $("#username").css("border", "1px solid green");
    }

    if ($("#password").val() == "")
    {
        $("#password").css("border", "1px solid red");
        $("#password").focus();
        return false;
    } else {
        $("#password").css("border", "1px solid green");
    }

    return true;
}

function valForgot()
{  
    var emailformat =  /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
    if ($("#email").val() == "")
    {
        $("#email").css("border", "1px solid red");
        $("#email").focus();
        return false;
    }else if(emailformat.test($("#email").val()) == false){        
        $("#email").css("border", "1px solid red");
        
    }else{
        $("#email").css("border", "1px solid green");
         sendPassword();
    }
   
}

function sendPassword()
{
    $.ajax({
        type: 'post',
        dataType: 'json',
        async: false,
        url: site_path + 'auth/sendPassword', 
        data: {
            'email': $("#email").val()
        },
        success: function(data) {
            
            if (data.success) {
                $("#forgot-msg").html('<div class="alert alert-success alert-dismissable">' +
                    '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' +
                    '<strong>Info Message :</strong>' +
                    data.success+
                    '</div>');
            }
            if (data.error) {
                $("#forgot-msg").html('<div class="alert alert-danger alert-dismissable">' +
                    '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' +
                    '<strong>Info Message :</strong>' +
                    data.error+
                    '</div>');
            }
        }
    });
}
