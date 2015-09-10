/* globals uwdoem */

uwdoem.multi_panel = (function() {
    var openPanel = function(n) {

        if (n === 1) {
            $('.cd-panel.first-panel').addClass('is-visible');
        } else if (n === 2) {
            $('.cd-panel.second-panel').addClass('is-visible');
        }
    };

    var closePanel = function(n) {

        if (n === 1) {
            $('.cd-panel.first-panel').removeClass('is-visible');
            hideSecondPanelButton();
        } else if (n === 2) {
            $('.cd-panel.second-panel').removeClass('is-visible');
        }

    };

    var displaySecondPanelButton = function(message) {
        $('.second-button').css("display", "block").fadeTo(500,1, function() {
            $(this).css("display", "block");  // Ensure that the button is displayed; concurrent animation queues have
                                              // have managed to hide this button following fade-up.
        });
        $('.second-button span.message').html(message);
    };

    var hideSecondPanelButton = function() {
        $('.second-button').fadeTo(250, 0, function() {
            $(this).css("display", "none");
        });
    };

    var loadPanel = function(n, targetURL) {
        var targetDiv;
        if(n === 1) {
            targetDiv = $( "#loadItHere" );
        } else if (n === 2) {
            targetDiv = $( "#loadItHere2" );
        }

        if (typeof targetDiv !== "undefined") {
            targetDiv.html("<div class=loading-gif></div>");

            $.get( targetURL, function( data ) {
                targetDiv.html( data );
                UWDOEMAjax.doPostSectionActions(targetDiv);
            });
        }
    };

    var initMultiPanelButtons = function() {

        jQuery(document).ready(function($){

            var firstSecond = ["first", "second"];

            for (var i = 0; i < firstSecond.length; i++) {
                var panel = $('.cd-panel.' + firstSecond[i] + '-panel');
                var button = $('.cd-btn.' + firstSecond[i] + '-panel');

                //open the lateral panel
                button.on('click', function(event){
                    event.preventDefault();
                    openPanel(i);
                });
                //close the lateral panel
                panel.on('click', function(event){
                    if( $(event.target).is('.cd-panel') || $(event.target).is('.cd-panel-close') ) {
                        closePanel(i);
                        event.preventDefault();
                    }
                });
            }
        });
    };

    return {
        initMultiPanelButtons: initMultiPanelButtons,
        loadPanel: loadPanel,
        hideSecondPanelButton: hideSecondPanelButton,
        displaySecondPanelButton: displaySecondPanelButton,
        closePanel: closePanel,
        openPanel: openPanel
    };

}());