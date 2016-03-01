athens.alert = (function () {
    /**
     * Creates an alert div, appends it to the notification area, and schedules it for removal.
     *
     * @param {string} type The type of the message, likely "success", or "failure".
     * @param {string} msg The message to be displayed on the alert.
     * @param {number} duration How long to leave the alert displayed, in milliseconds.
     */
    var makeAlert = function (type, msg, duration) {
        duration = typeof duration !== 'undefined' ? duration : 3000;

        $("<div class='notification '></div>").
            html(type + ": " + msg).
            appendTo("#notification-area").
            addClass(type).
            fadeTo(0, 0.7).
            delay(duration).
            fadeTo(0, 0).
            delay(300).
            hide(1);
    };

    return {
        makeAlert: makeAlert
    };

}());


