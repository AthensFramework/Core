athens.multi_panel = (function () {
    var openPanel = function (n) {

        if (n === 1) {
            $('.cd-panel.first-panel').addClass('is-visible');
        } else if (n === 2) {
            $('.cd-panel.second-panel').addClass('is-visible');
        }
    };

    var closePanel = function (n) {

        if (n === 1) {
            $('.cd-panel.first-panel').removeClass('is-visible');
            hideSecondPanelButton();
        } else if (n === 2) {
            $('.cd-panel.second-panel').removeClass('is-visible');
        }

    };

    var displaySecondPanelButton = function (message) {
        $('.second-button').css("display", "block").fadeTo(
            500,
            1,
            function () {
                $(this).css("display", "block");  // Ensure that the button is displayed; concurrent animation queues have
            // have managed to hide this button following fade-up.
            }
        );
        $('.second-button span.message').html(message);
    };

    var hideSecondPanelButton = function () {
        $('.second-button').fadeTo(
            250,
            0,
            function () {
                $(this).css("display", "none");
            }
        );
    };

    var loadPanel = function (n, targetURL) {
        var targetDiv;
        if (n === 1) {
            targetDiv = $("#loadItHere");
        } else if (n === 2) {
            targetDiv = $("#loadItHere2");
        }

        if (typeof targetDiv !== "undefined") {
            targetDiv.html("<div class=loading-gif></div>");

            $.get(
                targetURL,
                function ( data ) {
                    targetDiv.html(data);
                    athens.ajax_section.doPostSectionActions(targetDiv);
                }
            );
        }
    };

    $().ready(
        function ($) {
        //open the lateral panel
            $('.cd-btn').on(
                'click',
                function (event) {
                /** The number of the panel we would like to open */
                    var panelNum = $(this).data("for-panel");
                    openPanel(panelNum);
                    event.preventDefault();
                }
            );
        //close the lateral panel
            $('.cd-panel').on(
                'click',
                function (event) {
                    if ($(event.target).is('.cd-panel') || $(event.target).is('.cd-panel-close') ) {

                        /** The number of the panel we would like to close */
                        var panelNum = $(this).data("for-panel");

                        closePanel(panelNum);
                        event.preventDefault();
                    }
                }
            );
        }
    );

    return {
        loadPanel: loadPanel,
        hideSecondPanelButton: hideSecondPanelButton,
        displaySecondPanelButton: displaySecondPanelButton,
        closePanel: closePanel,
        openPanel: openPanel
    };

}());



