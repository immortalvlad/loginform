var fileUploader = fileUploader || function(options) {
    o = options;
    o.AllowedfileTypes = ['jpg', 'png', 'gif', 'jpeg'];
    o.maxFileSize = 10000000;
    o.dropZoneId = document.getElementById(o.dropZoneId);
    o.InputfilesId = document.getElementById(o.InputfilesId);
    o.transFile = '';
};



(function(FU) {
    FU.upload = function() {
        o.InputfilesId.addEventListener('change', FU.fileSelect, false);
        o.dropZoneId.addEventListener('dragover', FU.handleDragOver, false);
        o.dropZoneId.addEventListener('dragleave', FU.handleDragLeave, false);
        o.dropZoneId.addEventListener('drop', FU.fileSelect, false);
        o.dropZoneId.addEventListener('click', FU.handleClick, false);
    }
    FU.handleDragOver = function(evt) {
        evt.stopPropagation();
        evt.preventDefault();

        evt.dataTransfer.dropEffect = 'copy'; // Explicitly show this is a copy.
        o.transFile = evt.dataTransfer.files;

//        console.log(f);
        this.className = 'dragover';
    }
    FU.handleDragLeave = function(evt) {
        evt.stopPropagation();
        evt.preventDefault();
        this.className = '';
    }
    FU.fileSelect = function(e) {
        e.stopPropagation();
        e.preventDefault();
        this.className = '';
//                    console.log(e);
        var data = new FormData();
        data.append('file', 'fgfgdf');
        var content = '<a id="a"><b id="b">hey!</b></a>'; // the body of the new file...
        var blob = new Blob([content], {type: "text/xml"});
//        el_f = document.createElement('input');
//        el_f.type = 'file';
//        el_f.name = 'fdsdfd';
        o.InputfilesId.parentNode.insertBefore(blob, null);


        if (e.type == 'change') {
            var files = e.target.files; // FileList object

        } else
        if (e.type == 'drop') {
            var files = e.dataTransfer.files; // FileList object.
        } else {
            console.log('Error');
        }
//        console.log(o.InputfilesId.value);

        file = files[0];
//        console.log(file);
//        console.log(file);
        err = FU.validate(file);
//        console.log(err.length);
        var reader = new FileReader();
        // files is a FileList of File objects. List some properties.

        // Closure to capture the file information.
        reader.onload = (function(theFile) {
            return function(e) {
                // Render thumbnail.
                lists = o.dropZoneId;
                lists.innerHTML = '';
                spanList = lists.querySelectorAll('span');
//                            console.log(spanList);
                if (spanList.length) {
                    removeChildren(lists);
                }

                var span = document.createElement('span');
                span.innerHTML = ['<img class="thumb" src="', e.target.result,
                    '" title="', escape(theFile.name), '"/>'].join('');
                o.dropZoneId.insertBefore(span, null);
            };
        })(file);

        // Read in the image file as a data URL.
        reader.readAsDataURL(file);
    }
    FU.validate = function(file) {
//        console.log(file);
        var err = [];
        if (file.size > o.maxFileSize) {
            err.push('File to big');
        }
        if (!file.type.match('image.*')) {
            err.push('Wrong type file');
        }
        s = file.type.split('/');

        if (!in_array(s[1], o.AllowedfileTypes)) {
            err.push('File not allowed to load');
        }
//        console.log(err.length);
        return err;
//        console.log(s);
//
//        console.log(file.type);


    }
    FU.removeChildren = function(elem) {
        while (elem.lastChild) {
            elem.removeChild(elem.lastChild);
        }
    }
    FU.handleClick = function(e) {
        e.preventDefault();
        o.InputfilesId.click();
    }

})(fileUploader);

function in_array(needle, haystack, strict) {

    var found = false, key, strict = !!strict;

    for (key in haystack) {
        if ((strict && haystack[key] === needle) || (!strict && haystack[key] == needle)) {
            found = true;
            break;
        }
    }

    return found;
}

