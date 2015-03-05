

var Validator = {};

(function(v) {

    v.selObjName = '';
    v.tableVal = '';
    v.tableName = '';
    v.Inputvalue = '';
    v.err = [];
    v.fieldErr = [];
    v.init = function() {
//            inp = document.getElementsByTagName('input');
        inp = document.querySelectorAll('input[type=text],input[type=password]');
        for (var i = 0; i < inp.length; i++) {
            id = inp[i].id;
//                console.log(id);
            if (id) {
                document.getElementById(id).addEventListener('blur', v.startValidate, false);
            }
        }
    };
    v.startValidate = function() {
        v.selObjId = this.id;
        v.selObjName = this.name;
        v.Inputvalue = this.value;
        v.setValues();
        v.getRule();
    }

    v.getRule = function() {
        i = v.getIndex(v.tableName, j);
//            console.log(j[i][v.tableName]);
        p_i = v.getIndex(v.tableVal, j[i][v.tableName]);
        props = j[i][v.tableName][p_i][v.tableVal];
//            console.log(props);
        v.validate(props);

    }

    v.validate = function(props) {
//            console.log(v.selObjId);
        
        for (var i = 0; i < props.length; i++) {
            for (var prop in props[i]) {
                type = prop;
                typeVal = props[i][prop];
                var field = t(v.tableVal);
//                    console.log(field);
                if (type == 'required' && v.Inputvalue == '') {
                    console.log("req");
                    m = t("$1 is required", [field]);
                    v.addError(m);                    
//                        v.addFieldError(m);
                } else if (v.Inputvalue != '') {
                    if (type == 'required' && v.Inputvalue != '') {
                        m = t("$1 is required", [field]);
//                            v.delError(m);
                      //  v.removeErrorClass(v.selObjId);
//                        console.log(v.err);
                        if (in_array(m, v.err)) {
                            v.delError(m);
                        }
                    }
                    switch (type) {
                        case 'min' :
                            m = v.tableVal + " must be a minimum of " + typeVal + " characters";
                            if (v.Inputvalue.length < parseInt(typeVal)) {
                            console.log('dfgdfgdf');
                                v.addError(m);
                            } else {

                                if (in_array(m, v.err)) {
                                  //  v.delError(m);
                                }
                            }
                            break;
                        case 'max' :
                            m = v.tableVal + " must be a minimum of " + typeVal + " characters";
                            if (v.Inputvalue.length > parseInt(typeVal)) {
                                v.addError(m);
                            } else {

                                if (in_array(m, v.err)) {
                                   // v.delError(m);
                                }
                            }
                            break;
                        case 'type' :

                            switch (typeVal) {
                                case 'email':
                                    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                                    m = v.tableVal + " must be a minimum of " + typeVal + " characters";
                                    if (!re.test(v.Inputvalue)) {
                                        v.addError(m);
                                    } else {

//                                            console.log(v.Inputvalue);
                                        v.delError(m);
                                        if (in_array(m, v.err)) {
                                        }
                                    }
                                    break;
                                case 'login':
                                    var re = /^[A-Za-z0-9]{1,20}$/;
                                    m = "Incorect " + v.tableVal + ", use only letters or digits";
                                    if (!re.test(v.Inputvalue)) {
//                                            console.log('errr');
                                        v.addError(m);
                                    } else {

                                        v.delError(m);
                                        /*if (in_array(m, v.err)) {
                                         v.delError(m);
                                         }*/
                                    }
                                    break;
                                case 'phone':
                                    var re = /^(\(\d{1,4}\)){0,1}([\+{0,1},\s{0,1}]{0,})([\d,\s]{0,}){0,}$/;
                                    m = "Incorect " + v.tableVal + "";
                                    if (!re.test(v.Inputvalue)) {
                                        v.addError(m);
                                    } else {
                                        v.delError(m);
                                        /*if (in_array(m, v.err)) {
                                         }*/
                                    }
                                    break;
                                case 'image':
                                    var d = fileUploader.getError();
                                    var mess = '';
                                    for (err in d) {
                                        mess += d[err] + "\n";
                                    }
                                    if (mess) {
                                        alert(mess);

                                    }
                                    console.log(d);

                                    break;
                            }
                            break;
                    }
                }
                //   console.log("value = " + v.Inputvalue + " " + type + " = " + typeVal);
            }
        }
//            v.showError();
//            console.log(v.err);
        console.log(v.fieldErr);
    }
    v.showError = function() {
        for (id in v.fieldErr) {
            console.log(id);
            document.getElementById(id).className = 'error';
        }
    }
    v.addErrorClass = function(id) {
//            console.log(id);
        doc = document.getElementById(id);
//            doc.classList.add("error");
//            console.log(doc);
//            doc.value="dfd";
        doc.className = "error";
//            doc.classList.add("error");
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
//               selDivs[i];
            selDivs[i].remove();
//                console.log(selDivs[i]);

        }
    }
    v.addError = function(m) {
        if (!in_array(m, v.err)) {
            v.err.push(m);
        }
        if (!in_Obj_array(m)) {
            o = '{"' + v.selObjId + '":"' + m + '"}';
            v.fieldErr.push(JSON.parse(o));
        }
            v.addErrorClass(v.selObjId);
//            console.log(v.fieldErr);
//            s.push(m);
//            v.fieldErr[v.selObjId] = m;
        // v.showError();
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
//            name = 'user_entity[username]';

        tableValPat = /\[(.*)\]/i;
        match = tableValPat.exec(name);
        v.tableVal = match[1];
//            console.log(v.tableVal);

        tableNamePat = /^(.*)\[/i;
        match = tableNamePat.exec(name);
        v.tableName = match[1];
//            console.log(v.tableName);
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
//                    console.log(keyName);
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
//                console.log(key);
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
//                    console.log(str + " = " + LangText[str]);
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
