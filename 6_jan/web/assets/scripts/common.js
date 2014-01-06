function usernamesize(){
    var username= $("#username").val();
    if(username.length < 6 ){       
        $("#username").css("border", "1px solid red"); 
        return false;       
    }else{
         $("#username").css("border", "1px solid green"); 
        return true;
    }
    
}
function updusernamesize(){
    var username= $("#upd_username").val();
    if(username.length < 6 ){        
        $("#upd_username").css("border", "1px solid red"); 
        return false;       
    }else{
        $("#upd_username").css("border", "1px solid green"); 
        return true;
    }
}



function isNumberKey(evt)
{

    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;

    return true;
}

function validateEmail(email) {
    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,6})?$/;
    if (!emailReg.test(email)) {
        return false;
    } else {
        return true;
    }
}

function isValidURL(url) {
    //var RegExp1 = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;
    var RegExp = /((?:https?\:\/\/|www\.)(?:[-a-z0-9]+\.)*[-a-z0-9]+.*)/i;
    if (RegExp.test(url)) {
        return true;
    } else {
        return false;
    }
}