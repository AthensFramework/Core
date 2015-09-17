uwdoem.ajax = (function() {
    
    var defaultSuccessCallback = function() {};

    var call = function(url, postVars, successCallback, doneFunction) {
        var defaultPostVars = [];
        var defaultDoneFunction = function(msg) {
            try {
                msg = JSON.parse(msg);
                uwdoem.alert.makeAlert(msg.status, msg.message);
                if (msg.status === "success") {
                    successCallback(msg);
                }
            } catch (err) {
                uwdoem.alert.makeAlert("failure", "Unexpected error: " + err.message + ". More detail may be available in the network response.");
            }
        };
    
        postVars = postVars || defaultPostVars;
        successCallback = successCallback || defaultSuccessCallback;
        doneFunction = doneFunction || defaultDoneFunction;

        postVars.csrf_token = CSRFTOKEN;
    
        $.ajax({
            type: "POST",
            url: url,
            data: postVars
        })
            .done(doneFunction)
            .fail(function(msg) {
                uwdoem.alert.makeAlert("failure", msg);
            });
    };

    //var AjaxSubmit = function (form, successCallback) {
    //
    //    var formVars = $(form).serializeArray();
    //
    //    var newVars = {};
    //    for (var i = 0; i < formVars.length; i++) {
    //        newVars[formVars[i].name] = formVars[i].value;
    //    }
    //
    //    // Double check that this line works...
    //    call($(form).attr('action'), newVars, successCallback);
    //};


    function AjaxSubmitForm(form, successCallback) {
        var formVars, url, formId, postVars, fieldName;
        var doneFunction, isMultipleChoiceFieldName;

        isMultipleChoiceFieldName = function(fieldName) {
            return fieldName.indexOf("[]") !== -1;
        };

        formVars = $(form).serializeArray();
        url = $(form).data("request-uri");
        formId = $(form).attr('id');

        postVars = {};
        for (var i = 0; i < formVars.length; i++) {
            if (formVars[i].value) {
                fieldName = formVars[i].name;

                if (isMultipleChoiceFieldName(fieldName)) {
                    fieldName = fieldName.replace("[]", "");

                    if (!postVars.hasOwnProperty(fieldName)) {
                        postVars[fieldName] = [];
                    }

                    postVars[fieldName].push(formVars[i].value)
                } else {
                    postVars[fieldName] = formVars[i].value;
                }
            }
        }
        
        doneFunction = function(msg) {
            var formResult, hasErrors;

            try {
                formResult = $("<div>" + msg + "</div>").find("#" + formId);
                hasErrors = formResult.hasClass("has-errors");

                // TODO: Make form set fields to submitted on successful submit, eliminate this js hack
                if (!hasErrors) {
                    $.ajax({
                        type: "GET",
                        url: url
                    }).done(function(getMsg) {
                        uwdoem.alert.makeAlert("success", "Form subitted.");
                        formResult = $("<div>" + getMsg + "</div>").find("#" + formId);
                        $(form).replaceWith(formResult);
                        document.getElementById(formId).scrollIntoView();
                    });

                } else {

                    $(form).replaceWith(formResult);
                    document.getElementById(formId).scrollIntoView();
                    uwdoem.alert.makeAlert("failure", "Form has errors.");
                    successCallback();
                }
            } catch(err) {
                uwdoem.alert.makeAlert("failure", "Unexpected error: " + err.message + ". More detail may be available in the network response.");
            }
        };
        
        call(url, postVars, successCallback, doneFunction);
    }

    return {
        call: call,
        AjaxSubmitForm: AjaxSubmitForm
    };

}());