/* jshint unused: false */
/* global $ */


uwdoem = (function() {

    $(function() {
        $("form.prevent-double-submit").submit(function() {
            $(this).find("input[type=submit]").click(function() {
                event.preventDefault();
            });
        });
    });

    $(function() {
        $("input.slashless-date-entry").focusout(function() {
            var val = $(this).val();

            if(/^[0-9]+$/.test(val) && val.length === 8) {
                var newVal = [val.slice(0, 2), '/', val.slice(2, 4), '/', val.slice(4)].join('');
                $(this).val(newVal);
            }

        });
    });

    return {};
}());



