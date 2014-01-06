            
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
    var emailformat =  /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
   
    var email = $("#username").val();    
    if (email == "")    {
        $("#username").css("border","1px solid red");
        $("#username").focus();
        return false;
    }
    
//    else if(emailformat.test(email) == false)
//    {
//        //        $("#alertMessage").html('<div class="alert alert-danger alert-dismissable">'+
//        //            ' <button aria-hidden="true" data-dismiss="alert" class="close" type="button">X</button>'+
//        //            '<strong>Warnings :</strong><br>'+
//        //            'Enter Correct Email Id </div>');
//        $("#username").css("border", "1px solid red");
//        return false;    
     else { 
        $("#username").css("border", "1px solid green");
    //        $("#alertMessage").hide();
    }

    if ($("#password").val() == "")
    {
        $(".pin_required").css("border", "1px solid red");
        $(".pin_required").focus();
        return false;
    } else {
        $(".pin_required").css("border", "1px solid green");
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
        sendPassword();
        $("#email").css("border", "1px solid green");
        
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

//Front End Password Pin
var password = "";
function enterPassKey(key) {
    password = password + key;
    $("#password").val(password);
     $.ajax({
         type:'post',
         data:{
         pass:password
     },
     success: function(data){
     $("#pass").val(password);
   
     }
     });
}
 
function clearPassKey() {
    password = "";
    $("#password").val(password);
    $.ajax({
        
         data:{
         pass:password
     },
     success: function(data){
     $("#pass").val('');
     }
     });
}

$(document).ready(function() {
    $("#login_btn").click(function(){       
        $("#loginform").submit();
    });
});