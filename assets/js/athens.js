athens = (function () {

    var maskScreen = $("#mask-screen");
    /**
     * Fades in the mask screen which is used to temporarily "deactivate" the screen.
     */
    var fadeInMask = function () {
        $("#mask-screen")
            .css("display", "block")
            .css("height", "100%")
            .css('opacity', 1);
    };

    /**
     * Fades out the mask screen which is used to temporarily "deactivate" the screen.
     */
    function fadeOutMask()
    {
        $("#mask-screen").fadeOut(
            300,
            function () {
                $(this).css("display", "none");
            }
        );
    }

    function highlightRow(row)
    {
        $(row).toggleClass("highlighted");
    }

    $(
        function () {
            $("form.prevent-double-submit").submit(
                function () {
                    $(this).find("input[type=submit]").click(
                        function () {
                            event.preventDefault();
                        }
                    );
                }
            );
        }
    );

    $(
        function () {
            $("input.slashless-date-entry").focusout(
                function () {
                    var val = $(this).val();
                    if (/^[0-9]+$/.test(val) && val.length === 8) {
                        var newVal = [val.slice(0, 2), '/', val.slice(2, 4), '/', val.slice(4)].join('');
                        $(this).val(newVal);
                    }
                }
            );
        }
    );

    $(
        function () {
            $("#mask-screen").click(
                function () {
                    fadeOutMask(); }
            );
            $("div.search-div").click(
                function (event) {
                    event.stopPropagation();
                }
            )
        }
    );

    return {
        fadeInMask: fadeInMask,
        fadeOutMask: fadeOutMask,
        highlightRow: highlightRow
    };
}());





