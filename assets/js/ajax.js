athens.ajax = (function () {

    var defaultSuccessCallback = function () {};

    var call = function (url, postVars, successCallback, doneFunction) {
        var defaultPostVars = []
        var defaultDoneFunction = function (msg) {
            try {
                msg = JSON.parse(msg);
                athens.alert.makeAlert(msg.message, msg.status);
                if (msg.status === "success") {
                    successCallback(msg);
                }
            } catch (err) {
                athens.alert.makeAlert("Unexpected error: " + err.message + ". More detail may be available in the network response.", "error");
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
                data: postVars,
                processData:false,
                contentType:false,
            }
        )
            .done(doneFunction)
            .fail(
                function (msg) {
                    athens.alert.makeAlert(msg, "error");
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

        postVars = new FormData(form[0]);
        url = $(form).data("request-uri");
        formId = $(form).attr('id');

        postVars.append('csrf_token', CSRFTOKEN);

        $(form).css("opacity", 0.7).append("<div class='loading-gif class-loader'></div>");

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
                            athens.alert.makeAlert("Form submitted.", "success");
                            formResult = $("<div>" + getMsg + "</div>").find("#" + formId);
                            $(form).replaceWith(formResult);
                            // document.getElementById(formId).scrollIntoView();
                            successCallback();
                            athens.ajax_section.doPostSectionActions();
                        }
                    );
                } else {
                    $(form).replaceWith(formResult);
                    document.getElementById(formId).scrollIntoView();
                    athens.alert.makeAlert("Form has errors.", "error");
                }
            } catch (err) {
                athens.alert.makeAlert("Unexpected error: " + err.message + ". More detail may be available in the network response.", "error");
            }
        };
        athens.alert.makeAlert("Submitting form.", "info");
        call(url, postVars, successCallback, doneFunction);
    }

    return {
        call: call,
        AjaxSubmitForm: AjaxSubmitForm
    };

}());



