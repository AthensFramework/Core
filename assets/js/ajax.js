athens.ajax = (function () {

    /**
     * Private method which encapsulates retrieving the CSRFTOKEN global.
     *
     * @returns {string}
     */
    var getCSRFToken = function () {
        return CSRFTOKEN;
    };

    /**
     * Turn a response of the form `{"status":"success", "message":"Operation succeeded!"}` into
     * an Athens alert.
     *
     * @param {string} data
     */
    var alertResponseData = function (data) {
        data = JSON.parse(data);
        athens.alert.makeAlert(data.message, data.status);
    };

    /**
     * Make an Ajax call.
     *
     * @param {string} url
     * @param {string} type
     * @param {object} [settings={}]
     * @param {object} [data={}]
     * @param {function} [done]
     * @param {function} [fail]
     * @returns {jqXHR}
     */
    var call = function (url, type, settings, data, done, fail) {
        if (typeof(settings) === 'undefined') {
            settings = {};
        }

        if (typeof(data) === 'undefined') {
            data = {};
        }

        if (typeof(done) === 'undefined') {
            done = function () {};
        }

        if (typeof(fail) === 'undefined') {
            fail = function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR);
                athens.alert.makeAlert('Unexpected error. More detail may be available in the console or network response.', "error");
            }
        }

        settings.url = url;
        settings.type = type;
        settings.data = data;

        return $.ajax(settings).done(done).fail(fail);
    };

    /**
     * GET via Ajax.
     *
     * @param {string} url
     * @param {object} [data={}]
     * @param {function} [done]
     * @param {function} [fail]
     * @returns {jqXHR}
     */
    var get = function (url, data, done, fail) {
        if (typeof(data) === 'undefined') {
            data = {};
        }

        if (typeof(fail) === 'undefined') {
            fail = function (jqXHR, textStatus, errorThrown) {};
        }

        if (typeof(done) === 'undefined') {
            done = function (data, textStatus, jqXHR) {};
        }

        return call(url, 'GET', {}, data, done, fail)
    };

    /**
     * POST data via Ajax.
     *
     * @param {string} url
     * @param {object} [data={}]
     * @param {function} [done]
     * @param {function} [fail]
     * @returns {jqXHR}
     */
    var post = function (url, data, done, fail) {
        if (typeof(data) === 'undefined') {
            data = {};
        }

        if (typeof(fail) === 'undefined') {
            fail = function (jqXHR, textStatus, errorThrown) {};
        }

        if (typeof(done) === 'undefined') {
            done = function (data, textStatus, jqXHR) {
                try {
                    alertResponseData(data);
                    data = JSON.parse(data);
                    if (data.status === "success") {
                        success(data);
                    }
                } catch (err) {
                    console.log(err.message);
                    athens.alert.makeAlert("Unexpected error. More detail may be available in the console or network response.", "error");
                }
            };
        }

        return call(url, 'POST', {'csrf_token': getCSRFToken}, data, done, fail)
    };

    /**
     * Submit a form, via Ajax. Replace the submitted form on the page with the result.
     *
     * If a form has errors, then the form (with error messages) will be displayed to
     * the user.
     *
     * If a form does not have errors, then `submitForm` will issue an additional GET
     * request for the form and display the result of *that* request in place of the
     * submitted form.
     *
     * @param {element} form
     * @param {function} [success]
     * @returns {jqXHR}
     */
    function submitForm(form, success)
    {
        athens.alert.makeAlert("Submitting form.", "info");

        if (typeof(success) === 'undefined') {
            success = function () {};
        }

        var data = new FormData(form);

        form = $(form);

        var url = form.data("request-uri");


        var formId = form.attr('id');

        var done = function (data, textStatus, jqXHR) {
            try {
                var formPOSTResult = $("<div>" + data + "</div>").find("#" + formId);

                var formHasErrors = formPOSTResult.hasClass("has-errors");

                if (formHasErrors === true) {
                    $(form).replaceWith(formPOSTResult);

                    athens.alert.makeAlert("Form has errors.", "error");
                } else {
                    $.ajax(
                        {
                            type: "GET",
                            url: url
                        }
                    ).done(
                        function (data, textStatus, jqXHR) {
                            var formGETResult = $("<div>" + data + "</div>").find("#" + formId);

                            athens.alert.makeAlert("Form submitted.", "success");
                            $(form).replaceWith(formGETResult);
                            success();
                            athens.ajax_section.doPostSectionActions();
                        }
                    );
                }
            } catch (err) {
                console.log(err.message);
                athens.alert.makeAlert("Unexpected error. More detail may be available in the console or network response.", "error");
            }
        };

        $(form).css("opacity", 0.7).append("<div class='loading-gif class-loader'></div>");

        data.append('csrf_token', CSRFTOKEN);

        return call(url, 'POST', {processData: false, contentType: false}, data, done, function (){});
    }

    return {
        alertResponseData: alertResponseData,
        post: post,
        get: get,
        submitForm: submitForm
    };

}());



