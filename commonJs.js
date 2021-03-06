function keepUserLiveStatusUptoDate ( ) {
    var hr = new XMLHttpRequest() ;
    var url = "keepUserLiveStatusUpToDate.php" ;
    var testArg1=1 ;
    var testArg2=2 ;
    var vars = "testVar1="+testArg1+"&testVar2="+testArg2 ;
    hr.open("POST", url, true);
    //Send the proper header information along with the request
    hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    // hr.setRequestHeader("Content-length", vars.length);
    // hr.setRequestHeader("Connection", "close");
    hr.onreadystatechange = function() {//Call a function when the state changes.
        if(hr.readyState == 4 && hr.status == 200){
            var return_data = hr.responseText ;
            //document.getElementById("showCalendar").innerHTML = return_data ;
            //alert(return_data);
        }
    }
    hr.send(vars);
}

function isLoginFormFilledCorrectly(){
    var emailText = $('#email').val() ;
    var passText = $('#mypass').val() ;
    var errMsg = "<div>";
    var isError = false ;
    if( ! isValidEmailAddress(emailText) ){
        isError = true ;
        errMsg += "<p class='makesmallbigger label label-info'>Email Address is not Valid. </p>" ;
    }

    if(! isValidPassword(passText) ){
        isError = true ;
        errMsg += "<p class='makesmallbigger label label-info'>Password is not Valid. </p>"; 
    }
    errMsg += "</div>" ;

    if(isError){
        $('#loginFormErrors').html(errMsg);
        $('#loginFormErrors').css('display', 'block');
    }else{
        $('#loginFormErrors').html("");
        $('#loginFormErrors').css('display', 'none');
    }
    return !isError ;
}

function isRegisterFormFilledCorrectly(){
    var emailText = $('#email').val() ;
    var passText = $('#mypass').val() ;
    var confPassText = $('#cpass').val() ;
    var errMsg = "<div>";
    var isError = false ;
    var validPass = false ;
    if( ! isValidEmailAddress(emailText) ){
        isError = true ;
        errMsg += "<span class='makesmallbigger label label-info'>Email Address is not Valid. </span><br>" ;
    }

    if(! isValidPassword(passText) ){
        isError = true ;
        errMsg += "<span class='makesmallbigger label label-info'>Password is not Valid. </span><br>";
    }else{
        validPass = true ;
    }
    if(! isValidConfirmPassword(confPassText) ){
        isError = true ;
        if(validPass){
            errMsg += "<span class='makesmallbigger label label-info'>Confirm Password does not match with Password. </span>"; 
        }else{
            errMsg += "<span class='makesmallbigger label label-info'>No valid password entered yet. </span>"; 
        }
    }
    errMsg += "</div>" ;

    if(isError){
        $('#registerFormErrors').html(errMsg);
        $('#registerFormErrors').css('display', 'block');
    }else{
        $('#registerFormErrors').html("");
        $('#registerFormErrors').css('display', 'none');
    }
    return !isError ;
}

function isChangePasswordFormFilledCorrectly(){
    var passText = $('#mypass').val() ;
    var confPassText = $('#cpass').val() ;
    var errMsg = "<div>";
    var isError = false ;
    var validPass = false ;

    if(! isValidPassword(passText) ){
        isError = true ;
        errMsg += "<span class='makesmallbigger label label-info'>Password is not Valid. </span><br>";
    }else{
        validPass = true ;
    }
    if(! isValidConfirmPassword(confPassText) ){
        isError = true ;
        if(validPass){
            errMsg += "<span class='makesmallbigger label label-info'>Confirm Password does not match with Password. </span>"; 
        }else{
            errMsg += "<span class='makesmallbigger label label-info'>No valid password entered yet. </span>"; 
        }
    }
    errMsg += "</div>" ;

    if(isError){
        $('#changePasswordFormErrors').html(errMsg);
        $('#changePasswordFormErrors').css('display', 'block');
    }else{
        $('#changePasswordFormErrors').html("");
        $('#changePasswordFormErrors').css('display', 'none');
    }
    return !isError ;
}

function isforgotPasswordFormFilledCorrectly(){
    var emailText = $('#email').val() ;
    var errMsg = "<div>";
    var isError = false ;
    if( ! isValidEmailAddress(emailText) ){
        isError = true ;
        errMsg += "<span class='makesmallbigger label label-info'>Email Address is not Valid. </span><br>" ;
    }
    errMsg += "</div>" ;

    if(isError){
        $('#forgotPasswordFormErrors').html(errMsg);
        $('#forgotPasswordFormErrors').css('display', 'block');
    }else{
        $('#forgotPasswordFormErrors').html("");
        $('#forgotPasswordFormErrors').css('display', 'none');
    }
    return !isError ;
}

function isValidEmailAddress(emailAddress) {
    var emailRegExPattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
    return emailRegExPattern.test(emailAddress);
};

function isValidPassword(password){
    // only matches that you have 6 to 16 valid characters.
    // Also matches only if you have at least a number, and at least a special character.
    var passwordRegExPattern = /^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{6,16}$/ ;
    return passwordRegExPattern.test(password);
}

function isValidConfirmPassword(confirmPassword){
    var pass = $('#mypass').val() ;
    if(! isValidPassword(pass) ){
        return false ;
    }
    if(confirmPassword == pass){
        return true ;
    }
    return false ;
}



$(document).ready(function(){

    $('input, textarea').placeholder();

    // Run immediately
    keepUserLiveStatusUptoDate() ;

    // Run after every 5 seconds
    setInterval('keepUserLiveStatusUptoDate()',3000);

    var formFieldsValid = false ;

    $('#loginFormErrors').html("");
    $('#registerFormErrors').html("");
    $('#changePasswordFormErrors').html("");
    $('#forgotPasswordFormErrors').html("");
    
    $('#email').keyup(function(){
        formFieldsValid = false ;
        // Ajax call to check whether the entered value is valid or not
        var inputText = $('#email').val() ;
        if(! isValidEmailAddress(inputText) ){
            $('#emailValidity').html("<img src='red_circle.png' style='width: 20px; height: 20px;' />");
        }else{
            $('#emailValidity').html("<img src='green_circle.png' style='width: 20px; height: 20px;' />");
            formFieldsValid = true ;
        }
    });

    $('#email').blur(function(){
        formFieldsValid = false ;
        // Ajax call to check whether the entered value is valid or not
        var inputText = $('#email').val() ;
        if(! isValidEmailAddress(inputText) ){
            $('#emailValidity').html("<img src='red_circle.png' style='width: 20px; height: 20px;' />");
        }else{
            $('#emailValidity').html("<img src='green_circle.png' style='width: 20px; height: 20px;' />");
            formFieldsValid = true ;
        }
    });


    $('#mypass').keyup(function(){
        formFieldsValid = false ;
        // Ajax call to check whether the entered value is valid or not
        var text = $('#mypass').val() ;
        if(! isValidPassword(text) ){
            $('#passwordValidity').html("<img src='red_circle.png' style='width: 20px; height: 20px;' />");
            //alert("Invalid password : " + text);
        }else{
            $('#passwordValidity').html("<img src='green_circle.png' style='width: 20px; height: 20px;' />");
            //alert("Valid password : " + text);
            formFieldsValid = true ;
        }
    });

    $('#mypass').blur(function(){
        formFieldsValid = false ;
        // Ajax call to check whether the entered value is valid or not
        var text = $('#mypass').val() ;
        if(! isValidPassword(text) ){
            $('#passwordValidity').html("<img src='red_circle.png' style='width: 20px; height: 20px;' />");
            //alert("Invalid password : " + text);
        }else{
            $('#passwordValidity').html("<img src='green_circle.png' style='width: 20px; height: 20px;' />");
            //alert("Valid password : " + text);
            formFieldsValid = true ;
        }
    });


    $('#cpass').keyup(function(){
        formFieldsValid = false ;
        // Ajax call to check whether the entered value is valid or not
        var conf = $('#cpass').val() ;
        if(! isValidConfirmPassword(conf) ){
            $('#confirmPasswordValidity').html("<img src='red_circle.png' style='width: 20px; height: 20px;' />");
        }else{
            $('#confirmPasswordValidity').html("<img src='green_circle.png' style='width: 20px; height: 20px;' />");
            formFieldsValid = true ;
        }
    });

    $('#cpass').blur(function(){
        formFieldsValid = false ;
        // Ajax call to check whether the entered value is valid or not
        var conf = $('#cpass').val() ;
        if(! isValidConfirmPassword(conf) ){
            $('#confirmPasswordValidity').html("<img src='red_circle.png' style='width: 20px; height: 20px;' />");
        }else{
            $('#confirmPasswordValidity').html("<img src='green_circle.png' style='width: 20px; height: 20px;' />");
            formFieldsValid = true ;
        }
    });

});


