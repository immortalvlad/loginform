var app = function() {
    "use strict";
    return {
        ajax: function(url, callback, error) {
            var xmlhttp = (window.XMLHttpRequest) ? new window.XMLHttpRequest() : new window.ActiveXObject("Microsoft.XMLHTTP");
            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState === 4) {
                    if (xmlhttp.status === 200) {
                        if (typeof callback === 'function') {
                            callback(xmlhttp.responseText, xmlhttp);
                        }

                    } else {
                        if (typeof error === 'function') {
                            error(xmlhttp.statusText, xmlhttp);
                        }
                    }
                }
            }
            xmlhttp.open('GET', url, true)
            xmlhttp.send();
        }
    }
}();

//app.ajax('/protect/theme/js/file.json', function(data, xmlhttp) {
//    obj = JSON.parse(data);
//    console.log(obj);
//}, function(error, xmlhttp) {
//    console.log("Error", error);
//})


//app.ajax();