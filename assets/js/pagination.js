athens.pagination = (function () {

    var getPaginationContainer = function (handle) {
        return $("div.pagination-container[data-handle-for=" + handle +"]");
    };

    var getMaxPages = function (handle) {
        return parseInt(getPaginationContainer(handle).find("option").last().html());
    };

    var setArrows = function (handle, page) {
        var paginationContainer, maxPages;

        paginationContainer = getPaginationContainer(handle);
        maxPages = getMaxPages(handle);

        paginationContainer.find("a.pagination-arrow").css("display", "inline");

        if (page === 1) {
            paginationContainer.find("a.pagination-arrow.back").css("display", "none");
        } else {
            paginationContainer.find("a.pagination-arrow.previous").attr("data-page-for", page - 1);
        }

        if (page === maxPages) {
            paginationContainer.find("a.pagination-arrow.forward").css("display", "none");
        } else {
            paginationContainer.find("a.pagination-arrow.next").attr("data-page-for", page + 1);
        }
    };

    var setSelect = function (handle, page) {
        var maxPages = getMaxPages(handle);
        var paginationContainer = getPaginationContainer(handle);

        if (maxPages === 1) {
            paginationContainer.find("select").css("display", "none");
        } else {
            paginationContainer.find("select").css("display", "inline");
            paginationContainer.find("select").val(page);
        }
    };

    var setControls = function (handle, page) {
        setArrows(handle, page);
        setSelect(handle, page);
    };

    var registerPage = function (ajaxSectionName, handle, page) {
        var getVar;

        getVar = athens.ajax_section.getVar(ajaxSectionName, handle, "page", page);

        athens.ajax_section.registerGetVar(getVar);
    };

    var getPage = function (ajaxSectionName, handle) {
        var getVar = athens.ajax_section.getGetVarValue(ajaxSectionName, handle, 'page');

        return parseInt(getVar ? getVar: 1);
    };

    var getActiveControls = function (handle) {
        return $("div.section-label div.pagination-container[data-handle-for=" + handle + "]");
    };

    var getInactiveControls = function (handle) {
        return $("div.table-container div.filter-controls div.pagination-container[data-handle-for='" + handle + "']");
    };

    var setupPaginationFilter = function (handle) {
        // If we have already created this filter, return.
        $(
            function () {
                var page, ajaxSectionName, inactiveControls, activeControls;
                inactiveControls = getInactiveControls(handle);
                activeControls = getActiveControls(handle);
                ajaxSectionName = inactiveControls.closest('.filter-controls').data('table-for');

            // If this filter is already active...
                if (activeControls.length) {
                    // replace the active controls with the new, inactive controls
                    activeControls.replaceWith(inactiveControls);
                } else {
                    // else just append the new controls to the label.
                    inactiveControls.appendTo(inactiveControls.closest("div.section-container").find("div.section-label"));
                }

                activeControls = inactiveControls;
                page = getPage(ajaxSectionName, handle);
                setControls(handle, page);
                activeControls.find("a.pagination-arrow").click(
                    function () {
                        var targetPage = parseInt($(this).attr('data-page-for'));
                        athens.ajax_section.registerGetVar(athens.ajax_section.getVar(ajaxSectionName, handle, 'page', targetPage));
                        athens.ajax_section.loadSection(ajaxSectionName);
                        registerPage(ajaxSectionName, handle, targetPage);
                        return false;
                    }
                );
                activeControls.find("select.pagination-filter." + handle).change(
                    function () {
                        var targetPage = parseInt($("select.pagination-filter." + handle + " option:selected").val());
                        athens.ajax_section.registerGetVar(athens.ajax_section.getVar(ajaxSectionName, handle, 'page', targetPage));
                        athens.ajax_section.loadSection(ajaxSectionName);
                        registerPage(ajaxSectionName, handle, targetPage);
                    }
                );
            }
        );
    };

    return {
        setupPaginationFilter: setupPaginationFilter
    };
}());

