athens.multi_panel = (function () {

    var getPanel = function (n) {
        var panel = $('div.cd-panel[data-panel-for="' + n + '"]');

        if (panel.length === 0) {
            panel = $('<div class="cd-panel from-right" data-panel-for="' + n + '" style="z-index:' + n*10 + '"></div>');
            panel.append('<div class="cd-panel-container" style="width:' + sizePanel(n) + 'px"><div class="cd-panel-content"></div></div>');
            $('#page-container').append(panel);
            attachClosers();
        }

        return panel;
    };

    var sizePanel = function (n) {
        var screenWidth = $(window).width();
        return 1600 - (2000 - screenWidth)*.75 - (screenWidth/10)*(n-1);
    };

    var openPanel = function (n) {
        setTimeout(function () {
            getPanel(n).addClass('is-visible');

            visPanelButtons();
        }, 30);
    };

    var closePanel = function (n) {
        getPanel(n).removeClass('is-visible');
        visPanelButtons();
    };

    var createPanelButton = function (n, message) {
        var button = getPanelButton(n);

        if (button.length === 0) {
            button = $('<div class="panel-button" data-panel-for="' + n + '" style="z-index:' + (n*10 - 5) + '"></div>');
            button.append('<a href="#" class="cd-btn"><button type="button" style="padding:0 5px"><span class="message"></span></button></a>');
            button.on('click', function (event) {
                openPanel(n); event.preventDefault();});
        }

        button.find('span.message').html(message);

        $('#page-container').append(button);

        visPanelButtons();
    };

    var destroyPanelButton = function (n, message) {
        getPanelButton(n).remove();
    };


    var getPanelButton = function (n) {
        return  $('.panel-button[data-panel-for="' + n + '"]');
    };

    var displayPanelButton = function (n) {
        getPanelButton(n).css('display', 'block');
        setTimeout(
            function () {
                getPanelButton(n).fadeTo(500, 1);
            },
            300
        );
    };

    var hidePanelButton = function (n) {
        getPanelButton(n).fadeTo(
            250,
            0,
            function () {
                $(this).css("display", "none");
            }
        );
    };

    var visPanelButtons = function () {
        var buttons = $('.panel-button');

        for (var i = 0; i < buttons.length; i++) {
            var button = $(buttons[i]);
            var panelFor = parseInt(button.data('panel-for'));

            if (panelFor === 1 || (getPanel(panelFor - 1).length > 0 && getPanel(panelFor - 1).hasClass('is-visible'))) {
                displayPanelButton(panelFor);
            } else {
                hidePanelButton(panelFor);
            }
        }
    };

    var getTargetPanelDiv = function (n) {
        return getPanel(n).find('.cd-panel-content');
    };

    var loadPanel = function (n, targetURL) {
        var targetDiv = getTargetPanelDiv(n);

        if (typeof targetDiv !== "undefined") {
            targetDiv.html("<div class=loading-gif></div>");

            $.get(
                targetURL,
                function ( data ) {
                    data = $(data).find('#page-content-body').html();
                    targetDiv.html(data);
                    athens.ajax_section.doPostSectionActions(targetDiv);
                }
            );
        }
    };

    var attachClosers = function () {
        //close the lateral panel
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
    };

    return {
        loadPanel: loadPanel,
        openPanel: openPanel,
        closePanel: closePanel,
        createPanelButton: createPanelButton,
        destroyPanelButton: destroyPanelButton,
    };

}());
