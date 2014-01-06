function editprofile(id)
{
    var ack = 0;
    var emailformat =  /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
    var password = $("#password").val();
    var confirm_pass = $("#confirm_password").val();   
    $(".required").each(function() {
        if ($(this).val() == "")
        {
            ack = 0;
            $(this).css("border", "1px solid red");
            return false;
        }else if(emailformat.test($("#email").val()) == false){
            bootbox.alert("Please entre email correct format");
            $("#email").css("border", "1px solid red");
            return false;
        }else if(password!=confirm_pass){
            bootbox.alert("Your password not matched");
            $(".password").css("border", "1px solid red");
            return false;
        }else{
            $("#admin_profile").submit();
        }
    });  
}