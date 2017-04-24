athens.multi_panel = (function () {

    /**
     * Private method for creating a slider panel.
     *
     * @param {number} n the depth of panel to create, eg: panel number *1*,
     *                   panel number *2*, etc.
     * @returns {jQuery}
     */
    var createPanel = function (n) {
        var screenWidth, panelSize, panel;

        screenWidth = $(window).width();
        panelSize =  1600 - (2000 - screenWidth)*.75 - (screenWidth/10)*(n-1);

        panel = $('<div class="cd-panel from-right" data-panel-for="' + n + '" style="z-index:' + n*10 + '"></div>');
        panel.append('<div class="cd-panel-container" style="width:' + panelSize + 'px"><div class="cd-panel-content"></div></div>');
        $('#page-container').append(panel);

        $('.cd-panel').on(
            'click',
            function (event) {
                if ($(event.target).is('.cd-panel') || $(event.target).is('.cd-panel-close') ) {

                    /** The number of the panel we would like to close */
                    var panelNum = $(this).data("panel-for");

                    closePanel(panelNum);
                    event.preventDefault();
                }
            }
        );

        return panel;
    };

    /**
     * Private method for getting the panel at depth n, or creating it if
     * it does not exist.
     *
     * @param n
     * @returns {jQuery}
     */
    var getPanel = function (n) {
        var panel = $('div.cd-panel[data-panel-for="' + n + '"]');

        if (panel.length === 0) {
            panel = createPanel(n);
        }

        return panel;
    };

    /**
     * Private method for displaying all panel buttons at depth n
     *
     * @param {number} n the depth of panel buttons to display
     */
    var displayPanelButtons = function (n) {
        getPanelButtons(n).css('display', 'block');
        setTimeout(
            function () {
                getPanelButtons(n).fadeTo(500, 1);
            },
            300
        );
    };

    /**
     * Private method for hiding all panel buttons at depth n
     *
     * @param {number} n the depth of panel buttons to hide
     */
    var hidePanelButtons = function (n) {
        getPanelButtons(n).fadeTo(
            250,
            0,
            function () {
                $(this).css("display", "none");
            }
        );
    };

    /**
     * Private method for redetermining the visibility of all panel buttons.
     */
    var visPanelButtons = function () {
        var buttons = $('.panel-button-container');

        for (var i = 0; i < buttons.length; i++) {
            var button = $(buttons[i]);
            var panelFor = parseInt(button.data('panel-for'));

            if (panelFor === 1 || (getPanel(panelFor - 1).length > 0 && getPanel(panelFor - 1).hasClass('is-visible'))) {
                displayPanelButtons(panelFor);
            } else {
                hidePanelButtons(panelFor);
            }
        }
    };

    /**
     *
     * @param n
     * @returns {*|jQuery|HTMLElement}
     */
    var getPanelButtonsContainer = function (n) {
        var buttonContainer = $('.panel-button-container[data-panel-for=' + n + ']');

        if (buttonContainer.length === 0) {
            buttonContainer = $('<div class="panel-button-container" data-panel-for="' + n + '" style="z-index:' + (n*10 - 5) + '"></div>');
            $('#page-container').append(buttonContainer);
        }

        return buttonContainer;
    };

    /**
     * Slide the given panel open.
     *
     * @param {number} n
     */
    var openPanel = function (n) {
        setTimeout(function () {
            getPanel(n).addClass('is-visible');

            visPanelButtons();
        }, 30);
    };

    /**
     * Slide the given panel closed.
     *
     * @param {number} n
     */
    var closePanel = function (n) {
        getPanel(n).removeClass('is-visible');
        visPanelButtons();
    };


    var createPanelButton = function (n, message, callback, id) {
        var button = $('<a href="#" class="cd-btn"><button type="button"><span class="message"></span></button></a>');

        if (typeof(id) !== 'undefined') {
            button.attr('id', id);
        }

        if (typeof(callback) === 'undefined') {
            callback = function (event) {
                openPanel(n); event.preventDefault();
            }
        }

        button.on('click', callback);
        button.find('span.message').html(message);

        getPanelButtonsContainer(n).append(button);
        visPanelButtons();

        return button;
    };

    /**
     * Get all panel buttons of the given depth.
     *
     * @param {number} n
     * @returns {jQuery}
     */
    var getPanelButtons = function (n) {
        return  $('.panel-button-container[data-panel-for="' + n + '"]');
    };

    /**
     * Destroy all panel buttons of the given depth.
     * @param {number} n
     */
    var destroyPanelButtons = function (n) {
        getPanelButtons(n).remove();
    };

    /**
     * Load the panel of the given depth with the given URL.
     *
     * @param {number} n
     * @param {string} targetURL
     */
    var loadPanel = function (n, targetURL) {
        var targetDiv = getPanel(n).find('.cd-panel-content');

        if (typeof targetDiv !== "undefined") {
            targetDiv.html("<div class=loading-gif></div>");

            $.get(
                targetURL,
                function ( data ) {

                    if ($(data).find('#page-content-body').length > 0) {
                        data = $(data).find('#page-content-body').html();
                    }

                    targetDiv.html(data);
                    athens.ajax_section.doPostSectionActions(targetDiv);
                }
            );
        }
    };

    return {
        loadPanel: loadPanel,
        openPanel: openPanel,
        closePanel: closePanel,
        createPanelButton: createPanelButton,
        destroyPanelButtons: destroyPanelButtons,
    };

}());



