var GLOBALNAMEPROP;
var Node = function(name) {
    this.children = [];
    GLOBALNAMEPROP = name;
    this.create = function(clsName, val, tName) {
        className = "new " + clsName + "()";
        classObj = eval(className);
        classObj.val = val;
        classObj.tName = tName;
        this.children.push(classObj);
    }
}

Node.prototype = {
    add: function(type, val, tName) {
        if (type == 'type' || type == 'unique' || type == 'matches') {
            if (val == 'obj' || type == 'matches' || val == 'captcha') {
                return false;
            }
            this.create(val, val, tName);
        } else {
            this.create(type, val, tName);
        }
    },
    validate: function() {
        var length = this.children.length;
        for (var child in this.children) {
            validObj = this.children[child].validate();
        }
    },
    remove: function(child) {
        var length = this.children.length;
        for (var i = 0; i < length; i++) {
            if (this.children[i] === child) {
                this.children.splice(i, 1);
                return;
            }
        }
    },
    getChild: function(i) {
        return this.children[i];
    },
    hasChildren: function() {
        return this.children.length > 0;
    },
    getChilds: function() {
        return this.children;
    }
}

var required = function() {
    this.val;
    this.tName;
    return {
        validate: function() {
            var m = t("$1 cannot be blank.", [this.tName]);
            if (GLOBALNAMEPROP.Inputvalue == '') {
                GLOBALNAMEPROP.hasError = true;
                GLOBALNAMEPROP.addError(m);
            } else {
                GLOBALNAMEPROP.hasError = false;
                GLOBALNAMEPROP.delError(m);
            }
        }
    };
}

var min = function() {
    this.val;
    this.tName;
    return {
        validate: function() {
            var m = t("$1 is too short (minimum is $2 characters).", [this.tName, this.val]);
            if (GLOBALNAMEPROP.Inputvalue.length < parseInt(this.val)
                    && GLOBALNAMEPROP.Inputvalue != "") {
                GLOBALNAMEPROP.hasError = true;
                GLOBALNAMEPROP.addError(m);
            } else {
                if (!GLOBALNAMEPROP.hasError) {
                    GLOBALNAMEPROP.delError(m);
                    GLOBALNAMEPROP.hasError = false;
                }
            }
        }
    };
}
var max = function() {
    this.val;
    this.tName;
    return {
        validate: function() {
            var m = t("$1 is too long (maximum is $2 characters).", [this.tName, this.val]);
            if (GLOBALNAMEPROP.Inputvalue.length > parseInt(this.val)
                    && GLOBALNAMEPROP.Inputvalue != "") {
                GLOBALNAMEPROP.hasError = true;
                GLOBALNAMEPROP.addError(m);
            } else {
                if (!GLOBALNAMEPROP.hasError) {
                    GLOBALNAMEPROP.delError(m);
                    GLOBALNAMEPROP.hasError = false;
                }
            }
        }
    };
}
var email = function() {
    this.val;
    this.tName;
    return {
        validate: function() {
            var m = t("Field $1 is not a valid email address.", [this.tName]);
            var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

            if (!re.test(GLOBALNAMEPROP.Inputvalue)) {
                GLOBALNAMEPROP.hasError = true;
                GLOBALNAMEPROP.addError(m);
            } else {
                if (!GLOBALNAMEPROP.hasError) {
                    GLOBALNAMEPROP.delError(m);
                    GLOBALNAMEPROP.hasError = false;
                }
            }
        }
    };
}
var login = function() {
    this.val;
    this.tName;
    return {
        validate: function() {
            var m = t("The format of $1 is invalid.", [this.tName]);
            var re = /^[A-Za-z0-9]{1,20}$/;
            if (!re.test(GLOBALNAMEPROP.Inputvalue) &&
                    GLOBALNAMEPROP.Inputvalue != "") {
                GLOBALNAMEPROP.hasError = true;
                GLOBALNAMEPROP.addError(m);
            } else {
                if (!GLOBALNAMEPROP.hasError) {
                    GLOBALNAMEPROP.delError(m);
                    GLOBALNAMEPROP.hasError = false;
                }
            }
        }
    };
}
var phone = function() {
    this.val;
    this.tName;
    return {
        validate: function() {

            var m = t("The format of $1 is invalid.", [this.tName]);
            var re = /^(\(\d{1,4}\)){0,1}([\+{0,1},\s{0,1}]{0,})([\d,\s]{0,}){0,}$/;
            if (!re.test(GLOBALNAMEPROP.Inputvalue)) {
                GLOBALNAMEPROP.hasError = true;
                GLOBALNAMEPROP.addError(m);
            } else {
                if (!GLOBALNAMEPROP.hasError) {
                    GLOBALNAMEPROP.delError(m);
                    GLOBALNAMEPROP.hasError = false;
                }
            }
        }
    };
}
var image = function() {
    this.val;
    this.tName;
    return {
        validate: function() {
            var d = fileUploader.getError();
            var mess = '';
            for (err in d) {
                mess += d[err] + "\n";
            }
            if (mess) {
                alert(mess);

            }
        }
    };
}




var Validator = {};

(function(v) {

    v.selObjName = '';
    v.tableVal = '';
    v.tableName = '';
    v.Inputvalue = '';
    v.err = [];
    v.typeVal = '';
    v.fieldErr = [];
    v.hasError = false;
    v.init = function() {
        inp = document.querySelectorAll('input[type=text],input[type=password]');
        for (var i = 0; i < inp.length; i++) {
            id = inp[i].id;
            if (id) {
                document.getElementById(id).addEventListener('blur', v.startValidate, false);
            }
        }
        imageObj = document.getElementById("image");
        form = document.getElementById("form")
        if (imageObj) {
            imageObj.addEventListener('change', v.startValidate, false);
        }
        if (form) {
            form.addEventListener('submit', v.submit, false);
        }
    };
    v.submit = function(e) {
        e.stopPropagation();
        e.preventDefault();
        inp = document.querySelectorAll('input[type=text],input[type=password]');
        for (var i = 0; i < inp.length; i++) {
            id = inp[i].id;
            if (id) {
                document.getElementById(id).addEventListener('click', v.startValidate, false);
                document.getElementById(id).click();
            }
        }
        if (!v.hasError) {
            document.getElementById("form").submit();
        }
    }
    v.startValidate = function() {
        v.selObjId = this.id;
        v.selObjName = this.name;
        v.Inputvalue = this.value;
        v.setValues();
        v.getRule();
    }

    v.getRule = function() {
        i = v.getIndex(v.tableName, j);
        p_i = v.getIndex(v.tableVal, j[i][v.tableName]);
        props = j[i][v.tableName][p_i][v.tableVal];
        v.validate(props);

    }


    v.validate = function(props) {
        node = new Node(v);
        v.hasError = false;
        for (var i = 0; i < props.length; i++) {
            for (var prop in props[i]) {
                type = prop;
                v.typeVal = props[i][prop];
                v.field = t(v.tableVal);
//                console.log(v.field);
                node.add(type, v.typeVal, v.field);
            }
        }

        node.validate();

    }

    v.showError = function() {
        for (id in v.fieldErr) {
            console.log(id);
            document.getElementById(id).className = 'error';
        }
    }
    v.addErrorClass = function(id) {
        doc = document.getElementById(id);
        doc.className = "error";
        div = document.createElement('div');
        div.className = 'errorMessage';
        div.textContent = v.getErrorById(id);
        doc.parentNode.insertBefore(div, null);

    }
    v.getErrorById = function(id) {
        var key, key_name;
        for (key in v.fieldErr) {
            for (key_name in v.fieldErr[key]) {
//                    console.log(key2);
                if (key_name == id) {
                    return v.fieldErr[key][id];
                    break;
                }
            }
        }
        return false;
    }
    v.removeErrorClass = function(id) {
        doc = document.getElementById(id);
        doc.className = '';
        lab = doc.parentNode.getElementsByTagName("label");
        for (var i = 0; i < lab.length; i++) {
            lab[i].className = '';
        }
        selDivs = doc.parentNode.querySelectorAll(".errorMessage");

        for (var i = 0; i < selDivs.length; i++) {
            selDivs[i].remove();

        }
    }
    v.addError = function(m) {
        v.removeErrorClass(v.selObjId);
        if (!in_array(m, v.err)) {
            v.err.push(m);
        }
        if (!in_Obj_array(m)) {
            o = '{"' + v.selObjId + '":"' + m + '"}';
            v.fieldErr.push(JSON.parse(o));
        }
        v.addErrorClass(v.selObjId);
    }
    v.setValues = function() {
        v.getNameFromId(v.selObjName);
    }

    v.getIndex = function(name, obj) {
        for (var i = 0; i < obj.length; i++) {
            for (var prop in obj[i]) {
                if (prop == name) {
                    return i;
                }
            }
        }
    };


    v.getNameFromId = function(name) {

        tableValPat = /\[(.*)\]/i;
        match = tableValPat.exec(name);
        v.tableVal = match[1];

        tableNamePat = /^(.*)\[/i;
        match = tableNamePat.exec(name);
        v.tableName = match[1];
    }
    v.delError = function(m) {
        deleteIndexArray(m, v.err);
        deleteIndexObjArray(m);
        v.removeErrorClass(v.selObjId);
    }
    in_array = function(needle, haystack, strict) {

        var found = false, key, strict = !!strict;

        for (key in haystack) {
            if ((strict && haystack[key] === needle) || (!strict && haystack[key] == needle)) {
                found = true;
                break;
            }
        }
        return found;
    }
    in_Obj_array = function(m) {
        var found = false, key;
        if (v.fieldErr.length == 0) {
            return false;
        }
        for (key in v.fieldErr) {
            for (keyName in  v.fieldErr[key]) {
                if (keyName == v.selObjId) {
                    found = true;
                }
            }
            if (v.fieldErr[key][v.selObjId] == m) {
                found = true;
                break;
            }
        }
        return found;
    }
    deleteIndexObjArray = function(m) {
        for (key in v.fieldErr) {
            if (v.fieldErr[key][v.selObjId] == m) {
                v.fieldErr.splice(key, 1);
                break;
            }
        }
    }
    deleteIndexArray = function(needle, haystack) {

        for (var i = 0; i < haystack.length; i++) {
            if (haystack[i] == needle) {
                haystack.splice(i, 1);
                break;
            }
        }

    }
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
})(Validator);
