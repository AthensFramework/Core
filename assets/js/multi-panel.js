function openPanel(n) {

    if (n === 1) {
        $('.cd-panel.first-panel').addClass('is-visible');
    } else if (n === 2) {
        $('.cd-panel.second-panel').addClass('is-visible');
    }
    
}


function closePanel(n) {

    if (n === 1) {
        $('.cd-panel.first-panel').removeClass('is-visible');
        hideSecondPanelButton();
    } else if (n === 2) {
        $('.cd-panel.second-panel').removeClass('is-visible');
    }
    
}

function displaySecondPanelButton(message) {
    $('.second-button').css("display", "block").fadeTo(500,1, function() {
        $(this).css("display", "block");  // Ensure that the button is displayed; concurrent animation queues have
                                          // have managed to hide this button following fade-up.
    });
    $('.second-button span.message').html(message);
}

function hideSecondPanelButton() {
    $('.second-button').fadeTo(250, 0, function() {
        $(this).css("display", "none");
    });
}


function loadPanel(n, targetURL) {
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
            doPostAJAXSectionActions(targetDiv);
        });
    }
}


function initMultiPanelButtons() {

    jQuery(document).ready(function($){
        //open the lateral panel
        $('.cd-btn.first-panel').on('click', function(event){
            event.preventDefault();
            openPanel(1);
        });
        //close the lateral panel
        $('.cd-panel.first-panel').on('click', function(event){
            if( $(event.target).is('.cd-panel') || $(event.target).is('.cd-panel-close') ) {
                closePanel(1);
                event.preventDefault();
            }
        });
    });


    jQuery(document).ready(function($){
        //open the lateral panel
        $('.cd-btn.second-panel').on('click', function(event){
            event.preventDefault();
            openPanel(2);
        });
        //close the lateral panel
        $('.cd-panel.second-panel').on('click', function(event){
            if( $(event.target).is('.cd-panel') || $(event.target).is('.cd-panel-close') ) {
                closePanel(2);
                event.preventDefault();
            }
        });
    });
}