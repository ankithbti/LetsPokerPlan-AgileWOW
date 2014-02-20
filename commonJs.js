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



$(document).ready(function(){

    // Run immediately
    keepUserLiveStatusUptoDate() ;

    // Run after every 5 seconds
    setInterval('keepUserLiveStatusUptoDate()',3000);

});


