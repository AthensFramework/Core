/* global uwdoem $ */

uwdoem.ajax_section = (function() {

    /**
     * The set of get variables which shall be included when requesting a section
     *
     * @type {{}}
     */
    var getVarRegistry = {};

    /**
     * A dictionary of sections, by name or handle
     *
     * @type {{}}
     */
    var sectionRegistry = {};

    /**
     * An array of functions to call following every section load
     *
     * @type {Array}
     */
    var postSectionActions = [];

    /**
     * Represents a div which may be reloaded via AJAX
     *
     * @param {string} url The URL from which the div may be refreshed
     * @param {string} divId The Id of this div
     */
    var section = function(url, divId) {
        return {
            url: url,
            divId: divId
        }
    };

    /**
     * Represents a "get variable" to be encoded into a url string
     *
     * @param sectionName
     * @param filterName
     * @param argName
     * @param value
     * @returns {{sectionName: *, filterName: *, argName: *, value: *}}
     */
    var getVar = function (sectionName, filterName, argName, value) {
        return {
            sectionName: sectionName,
            filterName: filterName,
            argName: argName,
            value: value
        }
    };

    /**
     * Register a get var for inclusion in section requests
     *
     * @param getVar
     */
    var registerGetVar = function(getVar) {
        if(!(getVar.sectionName in getVarRegistry)) {
            getVarRegistry[sectionName] = {};
        }

        if(!(getVar.filterName in getVarRegistry[getVar.sectionName])) {
            getVarRegistry[getVar.sectionName][getVar.filterName] = {};
        }

        getVarRegistry[getVar.sectionName][getVar.filterName][getVar.argName] = value;
    };

    /**
     * De-register a getVar
     *
     * @param getVar
     */
    var unsetGetVar = function(getVar) {
        if(
            getVar.sectionName in getVarRegistry &&
            getVar.filterName in getVarRegistry[getVar.sectionName] &&
            getVar.argName in getVarRegistry[getVar.sectionName][getVar.filterName]
        ) {
            delete getVarRegistry[getVar.sectionName][getVar.filterName][getVar.argName];
        }
    };

    /**
     *
     * @param sectionName
     * @param filterName
     * @param argName
     * @returns {*}
     */
    var getGetVarValue = function(sectionName, filterName, argName) {

        if(
            sectionName in getVarRegistry &&
            filterName in getVarRegistry[sectionName] &&
            argName in getVarRegistry[sectionName][filterName]
        ) {
            return getVarRegistry[sectionName][filterName][argName];
        }
        return null;
    };

    /**
     * Render the registered get variables for a given AJAXSection into a URL-encoded string
     *
     * @param {string} name The name or handle of the AJAXSection for which we are encoding the get variables
     * @returns {string} The URL-encoded string of get variables
     */
    var renderGetVars = function(name) {

        if(!(name in getVarRegistry)) {
            return "";
        }

        var ret = "?";

        for (var filterName in getVarRegistry[name]) {
            if (getVarRegistry[name].hasOwnProperty(filterName)) {

                for (var argName in getVarRegistry[name][filterName]) {
                    if (getVarRegistry[name][filterName].hasOwnProperty(argName)) {
                        ret += filterName + "-" + argName + "=" + getVarRegistry[name][filterName][argName] + "&";
                    }
                }
            }
        }

        return ret;
    };

    /**
     * Construct and register sections by name
     *
     * @param {string} name A name or handle for the div, often semantic, such as "table-of-students" or "awards-table"
     * @param targetURL
     * @param targetDivId
     */
    var registerSection = function(name, targetURL, targetDivId) {
        sectionRegistry[name] = section(targetURL, targetDivId);
    };

    /**
     * Load a registered section by name
     *
     * @param {string} name The name or handle of the sction, as registered in sectionRegistry by registerAJAXSection
     */
    var loadSection = function(name) {
        $( "#" + sectionRegistry[name].targetDivId).css("opacity", .7);
        $("<div class=loading-gif style='position:absolute;z-index:100000;top:0;left:50%'></div>").prependTo("#" + sectionRegistry[name].targetDivId);
        $.get( sectionRegistry[name].targetURL + renderGetVars(name), function( data )
        {
            var target = $( "#" + sectionRegistry[name].targetDivId );

            target.html( data ).css("opacity", 1);
            doPostSectionActions(target);

            initMultiPanelButtons();
        });
    };

    /**
     * Add a function to the array of callables to perform after every section load.
     *
     * @param f
     */
    var registerPostSectionAction = function(f) {
        postSectionActions.push(f);
    };

    /**
     * Execute those callables which should be called after every section load
     * @param target
     */
    var doPostSectionActions = function(target) {
        for (var i = 0; i < postSectionActions.length; i++) {
            postSectionActions[i](target);
        }
    };

    return {
        registerPostSectionAction: registerPostSectionAction,
        loadSection: loadSection,
        registerSection: registerSection,
        registerGetVar: registerGetVar,
        getVar: getVar,
        section: section

    }
}());