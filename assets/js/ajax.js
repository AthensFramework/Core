/* global UWDOEMAjax CSRFToken */

uwdoem.ajax = (function() {
    
    var defaultSuccessCallback = function() {};

    var call = function(url, postVars, successCallback, doneFunction) {
        var defaultPostVars = [];
        var defaultDoneFunction = function(msg) {
            try {
                msg = JSON.parse(msg);
                makeAlert(msg.status, msg.message);
                if (msg.status == "success") {
                    successCallback(msg);
                }
            } catch (err) {
                makeAlert("failure", "Unexpected error: " + err.message + ". More detail may be available in the network response.");
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
                makeAlert("failure", msg);
            })
    };

    var AjaxSubmit = function (form, successCallback) {

        var formVars = $(form).serializeArray();

        var newVars = {};
        for (var i = 0; i < formVars.length; i++) {
            newVars[formVars[i].name] = formVars[i].value;
        }

        // Double check that this line works...
        call($(form).attr('action'), newVars, successCallback);
    };


    function AjaxSubmitForm(form, successCallback) {
        var formVars = $(form).serializeArray();
        var url = $(form).data("request-uri");
        var formId = $(form).attr('id');

        var postVars = {};
        for (var i = 0; i < formVars.length; i++) {
            if (formVars[i].value) {
                postVars[formVars[i].name] = formVars[i].value;
            }
        }
        
        var doneFunction = function(msg) {
            try {
                $(form).replaceWith($("<div>" + msg + "</div>").find("#" + formId));
                document.getElementById(formId).scrollIntoView();
                makeAlert("success", "Form subitted.");
                successCallback();
            } catch(err) {
                makeAlert("failure", "Unexpected error: " + err.message + ". More detail may be available in the network response.");
            }
        };
        
        call(url, postVars, successCallback, doneFunction);
    }

    return {
        call: call,
        AjaxSubmitForm: AjaxSubmitForm
    };

}());