athens.alert = (function () {

    /**
     * Creates an alert div, appends it to the notification area, and schedules it for removal.
     *
     * @param {string} message The message to be displayed on the alert.
     * @param {string} type The type of the message, likely "success", or "failure".
     * @param {number} [duration] How long to leave the alert displayed, in milliseconds.
     * @param {number} [delay] How long to wait to display the alert, in milliseconds.
     */
    var makeAlert = function (message, type, duration, delay) {
    
        if (typeof duration === 'undefined') {
            duration = 5000;
        }

        if (typeof delay === 'undefined') {
            delay = 0;
        }

        if (delay > 0) {
            return DelayedAlert(message, type, duration, delay);
        } else {
            var alert = $("<div class='notification '></div>").html(type + ": " + message);

            alert.appendTo("#notification-area");

            alert.addClass(type).
            fadeTo(0, 0.7).
            delay(duration).
            fadeTo(0, 0).
            delay(300).
            hide(1);

            return {
                close: function () {
                    alert.fadeTo(0, 0).delay(300).hide(1); }
            }
        }
    };

    /**
     * Class which wraps an alert with a delay.
     *
     * @param message
     * @param type
     * @param duration
     * @param delay
     * @returns {DelayedAlert}
     * @constructor
     */
    var DelayedAlert = function (message, type, duration, delay) {
    
        var alert = undefined;

        this.timeout = window.setTimeout(
            function () {
                alert = makeAlert(message, type, duration, 0);
            },
            delay
        );

        this.close = function () {
            window.clearTimeout(this.timeout);

            if (typeof alert !== 'undefined') {
                alert.close();
            }
        };

        return this;
    };

    return {
        makeAlert: makeAlert
    };

}());


