var app = app || {};

(function(o) {
    'use strict';
    var ajax, getFormData, setProgress;
    ajax = function(data) {
        var xmlhttp = new XMLHttpRequest(), uploaded;
        xmlhttp.addEventListener('readystatechange', function() {
            if (this.readyState === 4) {
                if (this.status === 200) {
                    uploaded = JSON.parse(this.response);
                    if (typeof o.options.finished == 'function') {
                        o.options.finished(uploaded);
                    }
                } else {
                    if (typeof o.options.error === 'function') {
                        o.options.error();
                    }
                }

            }
        });
        xmlhttp.upload.addEventListener('progress', function(event) {
            var percent;
            if (event.lengthComputable === true) {
//                console.log(event.loaded);
                percent = Math.round((event.loaded / event.total) * 100);
//                console.log(percent);
                setProgress(percent);
            }
        });
//        xmlhttp = (window.XMLHttpRequest) ? new window.XMLHttpRequest() : new window.ActiveXObject("Microsoft.XMLHTTP");
        xmlhttp.open('post', o.options.processor);
        xmlhttp.send(data);
    };
    getFormData = function(source) {
        var data = new FormData(), i;
        for (i = 0; i < source.length; i++) {
            data.append('file[]', source[i]);
        }
        data.append('ajax', true);
        console.log(data);
        return data;
        
    };

    setProgress = function(value) {
        if (o.options.progressBar !== undefined) {
            o.options.progressBar.style.width = value ? value + '%' : 0;
        }
        if (o.options.progressBar !== undefined) {
            o.options.progressText.innerText = value ? value + '%' : '';
        }
    }
    o.uploader = function(options) {
        o.options = options;
//        console.log(o.options);
        if (o.options.files !== undefined) {
            ajax(getFormData(o.options.files.files));            
            console.log(o.options);
        }
    }
}(app));