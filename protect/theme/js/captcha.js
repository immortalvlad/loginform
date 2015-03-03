var captcha = function() {
    return this;
}();
captcha.reload = function() {
    var f = document.getElementById('iframe');
    f.src = f.src;
};

var ajax = function() {
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

window.onload = function() {
    var test = document.getElementById('country');
    var city = document.getElementById('city');
//        city.remove(1);
//        city.remove(0);
//        city.remove();


    addEvent(test, 'change', function() {
        for (var di = city.length; di >= 0; di--) {
//            console.log(di);
            city.remove(di);
        }

        code = test.value;
//        console.log(test.value);

        ajax.ajax('/index/getcities/id/' +code, function(data, xmlhttp) {
//            console.log(data);
            var cities = JSON.parse(data);

            for (i = 0; i < cities.length; i++) {
                var option = document.createElement("option");
                option.text = cities[i].Name;
                option.value = cities[i].ID;
                city.add(option);
            }

        })
    });
    function addEvent(elem, type, handler) {
        if (elem.addEventListener) {
            elem.addEventListener(type, handler, false)
        }
        else {
            elem.attachEvent("on" + type, handler)
        }
    }

};

