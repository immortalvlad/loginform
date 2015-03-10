var fileUploader = fileUploader || function(options) {
    o = options;
    fileUploader.AllowedfileTypes = ['jpg', 'png', 'gif', 'jpeg'];
    o.maxFileSize = 10000000;
    o.err = [];
    fileUploader.dropZoneId = document.getElementById(o.dropZoneId);
    fileUploader.InputfilesId = document.getElementById(o.InputfilesId);
    o.transFile = '';
};



(function(FU) {
    FU.upload = function() {
        FU.InputfilesId.addEventListener('change', FU.fileSelect, false);
        FU.dropZoneId.addEventListener('click', FU.handleClick, false);
    }
    FU.getError = function() {
        return FU.err;
    }

    FU.fileSelect = function(e) {
        e.stopPropagation();
        e.preventDefault();
        this.className = '';

        if (e.type == 'change') {
            var files = e.target.files; // FileList object
        } else
        if (e.type == 'drop') {
            var files = e.dataTransfer.files; // FileList object.
        } else {
        }

        file = files[0];
        FU.err = "";
       
        FU.err = FU.validate(file);
       
        var reader = new FileReader();
        // files is a FileList of File objects. List some properties.

        // Closure to capture the file information.
        reader.onload = (function(theFile) {
            return function(e) {
                // Render thumbnail.
                lists = FU.dropZoneId;
                lists.innerHTML = '';
                spanList = lists.querySelectorAll('span');
                if (spanList.length) {
                    removeChildren(lists);
                }

                var span = document.createElement('span');
                span.innerHTML = ['<img class="thumb" src="', e.target.result,
                    '" title="', escape(theFile.name), '"/>'].join('');
                FU.dropZoneId.insertBefore(span, null);
            };
        })(file);

        // Read in the image file as a data URL.
        reader.readAsDataURL(file);
    }
    FU.validate = function(file) {
        var err = [];
        if (file.size > o.maxFileSize) {
            var m = t("The file is too large. Its size cannot exceed $1 bytes.", [o.maxFileSize]);
            err.push(m);
        }
        s = file.type.split('/');
        if (!file.type.match('image.*') && !in_array(s[1], fileUploader.AllowedfileTypes)) {
            var str = '';
            for (allowtype in fileUploader.AllowedfileTypes) {
                str += fileUploader.AllowedfileTypes[allowtype] + " ";
            }
            var m = t("The file cannot be uploaded. Only files with these extensions are allowed: $1.", [str]);
            err.push(m);
        }

        return err;


    }
    FU.removeChildren = function(elem) {
        while (elem.lastChild) {
            elem.removeChild(elem.lastChild);
        }
    }
    FU.handleClick = function(e) {
        e.preventDefault();

        FU.InputfilesId.click();
    }

})(fileUploader);
t = function(key, rep) {
    text = '';
    for (str in LangText) {
        if (key == str) {
            text = LangText[str];
        }
    }
    if (rep != null) {
        for (var i = 0; i < rep.length; i++) {
            text = text.replace(new RegExp("\\$" + (i + 1), 'g'), rep[i]);
        }
    }
    return text;
}
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

