


function OSFAAjax(url, post_vars, successCallback, doneFunction) {

    if (typeof(post_vars)==='undefined') post_vars = [];
    if (typeof(successCallback)==='undefined') successCallback = function() {};

    if (typeof(doneFunction)==='undefined') doneFunction = function(msg) {
        try {
            msg = JSON.parse(msg);
            makeAlert(msg.status, msg.message);
            if (msg.status=="success") {
                successCallback(msg);
            }
        } catch(err) {
            makeAlert("failure", "Unexpected error: " + err.message + ". More detail may be available in the network response.");
        }
    }

    post_vars.csrf_token = CSRFTOKEN;

    $.ajax({
        type: "POST",
        url: url,
        data: post_vars
    })
        .done(doneFunction)
        .fail(function(msg) {
            makeAlert("failure", msg);
        })
}

/**
 * Represents a div which may be reloaded via AJAX
 *
 * @param {string} targetURL The URL from which the div may be refreshed
 * @param {string} targetDivId The Id of this div
 * @constructor
 */
function AJAXSection(targetURL, targetDivId) {
    this.targetURL = targetURL;
    this.targetDivId = targetDivId;
}

/**
 * A dictionary of AJAXSections, by name or handle
 * @type {{}}
 */
var AJAXSectionRegistry = {};

/**
 * Construct and register AJAXSections by name
 *
 * @param {string} name A name or handle for the div, often semantic, such as "table-of-students" or "awards-table"
 * @param targetURL 
 * @param targetDivId
 */
function registerAJAXSection(name, targetURL, targetDivId) {
    AJAXSectionRegistry[name] = new AJAXSection(targetURL, targetDivId);
}

/**
 * Load a registered AJAXSection by name
 *
 * @param {string} name The name or handle of the AJAXSection, as registered in AJAXSectionRegistry by registerAJAXSection
 */
function loadAJAXSection(name) {
    $( "#" + AJAXSectionRegistry[name].targetDivId).css("opacity", .7);
    $("<div class=loading-gif style='position:absolute;z-index:100000;top:0;left:50%'></div>").prependTo("#" + AJAXSectionRegistry[name].targetDivId);
    $.get( AJAXSectionRegistry[name].targetURL + renderAJAXGetVars(name), function( data )
        {
            var target = $( "#" + AJAXSectionRegistry[name].targetDivId );

            target.html( data ).css("opacity", 1);
            doPostAJAXSectionActions(target);

            initMultiPanelButtons();
        });
}

var postAJAXSectionActions = [];
function registerPostAJAXSectionAction(f) {
    postAJAXSectionActions.push(f);
}

function doPostAJAXSectionActions(target) {
    for (var i = 0; i < postAJAXSectionActions.length; i++) {
        postAJAXSectionActions[i](target);
    }
}


var AJAXGetVars = {};
function registerAJAXGetVar(sectionName, filterName, argName, value) {
    if(!(sectionName in AJAXGetVars)) {
        AJAXGetVars[sectionName] = {};
    }

    if(!(filterName in AJAXGetVars[sectionName])) {
        AJAXGetVars[sectionName][filterName] = {};
    }

    AJAXGetVars[sectionName][filterName][argName] = value;
}

function unsetAJAXGetVar(sectionName, filterName, argName) {
    if(
        sectionName in AJAXGetVars &&
        filterName in AJAXGetVars[sectionName] &&
        argName in AJAXGetVars[sectionName][filterName]
    ) {
        delete AJAXGetVars[sectionName][filterName][argName];
    }
}

/**
 *
 * @param sectionName
 * @param filterName
 * @param argName
 * @returns {*}
 */
function getAJAXGetVar(sectionName, filterName, argName) {

    if(
        sectionName in AJAXGetVars &&
        filterName in AJAXGetVars[sectionName] &&
        argName in AJAXGetVars[sectionName][filterName]
    ) {
        return AJAXGetVars[sectionName][filterName][argName];
    }
    return null;
}

/**
 * Render the registered get variables for a given AJAXSection into a URL-encoded string
 *
 * @param {string} name The name or handle of the AJAXSection for which we are encoding the get variables
 * @returns {string} The URL-encoded string of get variables
 */
function renderAJAXGetVars(name) {

    if(!(name in AJAXGetVars)) {
        return "";
    }

    var ret = "?";

    for (var filterName in AJAXGetVars[name]) {
        for (var argName in AJAXGetVars[name][filterName]) {
            ret += filterName + "-" + argName + "=" + AJAXGetVars[name][filterName][argName] + "&";
        }
    }

    return ret;
}