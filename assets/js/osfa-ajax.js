

var UWDOEMAjax = new function() {

    this.call = function(url, post_vars, successCallback, doneFunction) {
    
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
        };
    
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
    };
    
    /**
     * Represents a div which may be reloaded via AJAX
     *
     * @param {string} targetURL The URL from which the div may be refreshed
     * @param {string} targetDivId The Id of this div
     * @constructor
     */
    this.Section = function(targetURL, targetDivId) {
        this.targetURL = targetURL;
        this.targetDivId = targetDivId;
    };
    
    /**
     * A dictionary of Sections, by name or handle
     * @type {{}}
     */
    var SectionRegistry = {};
    
    /**
     * Construct and register AJAXSections by name
     *
     * @param {string} name A name or handle for the div, often semantic, such as "table-of-students" or "awards-table"
     * @param targetURL 
     * @param targetDivId
     */
    this.registerSection = function(name, targetURL, targetDivId) {
        SectionRegistry[name] = new AJAXSection(targetURL, targetDivId);
    };
    
    /**
     * Load a registered AJAXSection by name
     *
     * @param {string} name The name or handle of the AJAXSection, as registered in SectionRegistry by registerAJAXSection
     */
    this.loadSection = function(name) {
        $( "#" + SectionRegistry[name].targetDivId).css("opacity", .7);
        $("<div class=loading-gif style='position:absolute;z-index:100000;top:0;left:50%'></div>").prependTo("#" + SectionRegistry[name].targetDivId);
        $.get( SectionRegistry[name].targetURL + renderGetVars(name), function( data )
            {
                var target = $( "#" + SectionRegistry[name].targetDivId );
    
                target.html( data ).css("opacity", 1);
                doPostSectionActions(target);
    
                initMultiPanelButtons();
            });
    };
    
    var postSectionActions = [];
    this.registerPostSectionAction = function(f) {
        postSectionActions.push(f);
    };
    
    this.doPostSectionActions = function(target) {
        for (var i = 0; i < postSectionActions.length; i++) {
            postSectionActions[i](target);
        }
    };
    
    
    var getVars = {};
    this.registerGetVar = function(sectionName, filterName, argName, value) {
        if(!(sectionName in getVars)) {
            getVars[sectionName] = {};
        }
    
        if(!(filterName in getVars[sectionName])) {
            getVars[sectionName][filterName] = {};
        }
    
        getVars[sectionName][filterName][argName] = value;
    };
    
    this.unsetGetVar = function(sectionName, filterName, argName) {
        if(
            sectionName in getVars &&
            filterName in getVars[sectionName] &&
            argName in getVars[sectionName][filterName]
        ) {
            delete getVars[sectionName][filterName][argName];
        }
    };
    
    /**
     *
     * @param sectionName
     * @param filterName
     * @param argName
     * @returns {*}
     */
    this.getGetVar = function(sectionName, filterName, argName) {
    
        if(
            sectionName in getVars &&
            filterName in getVars[sectionName] &&
            argName in getVars[sectionName][filterName]
        ) {
            return getVars[sectionName][filterName][argName];
        }
        return null;
    };
    
    /**
     * Render the registered get variables for a given AJAXSection into a URL-encoded string
     *
     * @param {string} name The name or handle of the AJAXSection for which we are encoding the get variables
     * @returns {string} The URL-encoded string of get variables
     */
    this.renderGetVars = function(name) {
    
        if(!(name in getVars)) {
            return "";
        }
    
        var ret = "?";
    
        for (var filterName in getVars[name]) {
            for (var argName in getVars[name][filterName]) {
                ret += filterName + "-" + argName + "=" + getVars[name][filterName][argName] + "&";
            }
        }
    
        return ret;
    };
};