uwdoem.pagination = (function() {

    var getPaginationContainer = function(handle) {
        return $("div.pagination-container[data-handle-for=" + handle +"]");
    };

    var getAjaxSectionName = function(handle) {
        return getPaginationContainer(handle).data("ajax-section-name");
    };

    var getFilterSectionName = function(handle) {
        return getPaginationContainer(handle).closest('.ajax-loaded-section').data('section-name');
    };

    var getMaxPages = function(handle) {
        return parseInt(getPaginationContainer(handle).find("option").last().html());
    };

    var setArrows = function(handle, page) {
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

    var setSelect = function(handle, page) {
        getPaginationContainer(handle).find("select").val(page);
    };

    var setControls = function(handle, page) {
        setArrows(handle, page);
        setSelect(handle, page);
    };

    var registerPage = function(handle, page) {
        var filterSectionName, getVar;

        filterSectionName = getFilterSectionName(handle);
        getVar = uwdoem.ajax_section.getVar(filterSectionName, handle, "page", page);

        uwdoem.ajax_section.registerGetVar(getVar);
    };

    var getPage = function(handle) {
        var getVar = uwdoem.ajax_section.getGetVarValue(getAjaxSectionName(handle), handle, 'page');

        return parseInt(getVar ? getVar.value : 1);
    };

    var initializedFilters = [];
    var setupPaginationFilter = function(handle) {
        // If we have already created this filter, return.
        if (initializedFilters.indexOf(handle) !== -1) { return; }

        initializedFilters.push(handle);
        $(function() {
            var paginationContainer, page, filterSectionName, ajaxSectionName;

            paginationContainer = getPaginationContainer(handle);
            filterSectionName = getFilterSectionName(handle);

            ajaxSectionName = paginationContainer.closest("div.ajax-loaded-section").attr("id");

            paginationContainer.data("ajax-section-name", ajaxSectionName);

            paginationContainer.appendTo(paginationContainer.closest("div.section-container").find("div.section-label"));
            page = getPage(handle);

            setControls(handle, page);

            $("div.pagination-container a.pagination-arrow").click(function() {
                var targetPage;

                targetPage = parseInt($(this).attr('data-page-for'));

                uwdoem.ajax_section.registerGetVar(uwdoem.ajax_section.getVar(ajaxSectionName, handle, 'page', targetPage));
                uwdoem.ajax_section.loadSection(ajaxSectionName);

                registerPage(targetPage);
                setControls(handle, targetPage);

                return false;
            });

            $("select.pagination-filter." + handle).change(function() {
                var targetPage = parseInt($("select.pagination-filter." + handle + " option:selected").val());

                uwdoem.ajax_section.registerGetVar(uwdoem.ajax_section.getVar(ajaxSectionName, handle, 'page', targetPage));
                uwdoem.ajax_section.loadSection(ajaxSectionName);

                registerPage(targetPage);
                setControls(handle, targetPage);
            });
        });
    };

    return {
        setupPaginationFilter: setupPaginationFilter
    };
}());