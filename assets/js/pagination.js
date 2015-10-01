uwdoem.pagination = (function() {

    var getPaginationContainer = function(handle) {
        return $("div.pagination-container[data-handle-for=" + handle +"]");
    };

    var getFilterSectionName = function(handle) {
        return getPaginationContainer(handle).closest('.ajax-loaded-section').data('section-name');
    };

    var getMaxPages = function(handle) {
        return getPaginationContainer().find("option").last().html();
    };

    var setArrows = function(handle, page) {
        var paginationContainer, maxPages;

        paginationContainer = getPaginationContainer(handle);
        maxPages = getMaxPages(handle);

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
        getPaginationContainer().find("select").val(page);
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
        var filterSectionName = getFilterSectionName(handle);
        return uwdoem.ajax_section.getGetVarValue(filterSectionName, 'pagination', 'page').value || 1;
    };

    var setupPaginationFilter = function(handle) {
        $(function() {
            var paginationContainer, page, filterSectionName;

            paginationContainer = getPaginationContainer(handle);

            paginationContainer.appendTo(paginationContainer.closest("div.section-container").find("div.section-label"));
            page = getPage(handle);

            setControls(handle, page);

            $("div.pagination-container a.pagination-arrow").click(function() {
                var targetPage = $(this).attr('data-page-for');
                uwdoem.ajax_section.registerGetVar(filterSectionName, handle, 'page', targetPage);
                uwdoem.ajax_section.loadSection(filterSectionName);

                registerPage(targetPage);
                setControls(handle, page);

                return false;
            });

            $("select.pagination-filter." + handle).change(function() {
                var targetPage = $( "select.pagination-filter." + handle + " option:selected" ).text();

                registerPage(targetPage);
                setControls(handle, page);
            });
        });
    };

    return {
        setupPaginationFilter: setupPaginationFilter
    };
}());