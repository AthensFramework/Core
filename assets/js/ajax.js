athens.ajax = (function () {
    
    var defaultSuccessCallback = function () {};

    var call = function (url, postVars, successCallback, doneFunction) {
        var defaultPostVars = []
        var defaultDoneFunction = function (msg) {
            try {
                msg = JSON.parse(msg);
                athens.alert.makeAlert(msg.status, msg.message);
                if (msg.status === "success") {
                    successCallback(msg);
                }
            } catch (err) {
                athens.alert.makeAlert("failure", "Unexpected error: " + err.message + ". More detail may be available in the network response.");
            }
        };
    
        postVars = postVars || defaultPostVars;
        successCallback = successCallback || defaultSuccessCallback;
        doneFunction = doneFunction || defaultDoneFunction;

        postVars.csrf_token = CSRFTOKEN;
    
        $.ajax(
            {
                type: "POST",
                url: url,
                data: postVars
            }
        )
            .done(doneFunction)
            .fail(
                function (msg) {
                    athens.alert.makeAlert("failure", msg);
                }
            );
    };

    function AjaxSubmitForm(form, successCallback)
    {
        var formVars, url, formId, postVars, fieldName;
        var doneFunction, isMultipleChoiceFieldName;

        isMultipleChoiceFieldName = function (fieldName) {
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

                    postVars[fieldName].push(formVars[i].value);
                } else {
                    postVars[fieldName] = formVars[i].value;
                }
            }
        }
        
        doneFunction = function (msg) {
            var formResult, hasErrors;

            try {
                formResult = $("<div>" + msg + "</div>").find("#" + formId);
                hasErrors = formResult.hasClass("has-errors");

                // TODO: Make form set fields to submitted on successful submit, eliminate this js hack
                if (!hasErrors) {
                    $.ajax(
                        {
                            type: "GET",
                            url: url
                        }
                    ).done(
                        function (getMsg) {
                            athens.alert.makeAlert("success", "Form subitted.");
                            formResult = $("<div>" + getMsg + "</div>").find("#" + formId);
                            $(form).replaceWith(formResult);
                            document.getElementById(formId).scrollIntoView();
                            successCallback();
                            athens.ajax_section.doPostSectionActions();
                        }
                    );
                } else {
                    $(form).replaceWith(formResult);
                    document.getElementById(formId).scrollIntoView();
                    athens.alert.makeAlert("failure", "Form has errors.");
                }
            } catch (err) {
                athens.alert.makeAlert("failure", "Unexpected error: " + err.message + ". More detail may be available in the network response.");
            }
        };
        
        call(url, postVars, successCallback, doneFunction);
    }

    return {
        call: call,
        AjaxSubmitForm: AjaxSubmitForm
    };

}());


