

uwdoem.sort = (function() {
    
    var setupSortFilter = function (handle) {
        var filterSection = $("div.sort-container[data-handle-for=" + handle + "]").parents('.ajax-loaded-section');
        var filterSectionName = filterSection.data('section-name');
        var ajaxSectionName = filterSection.closest("div.ajax-loaded-section").attr("id");

        var headers = filterSection.find("th");
        headers.addClass("clickable");
        headers.removeClass("sorted ascending descending");

        var fieldname = uwdoem.ajax_section.getGetVarValue(ajaxSectionName, handle, 'fieldname');
        var order = uwdoem.ajax_section.getGetVarValue(ajaxSectionName, handle, 'order');
        filterSection.find("th[data-header-for='" + fieldname + "']").addClass("sorted " + order);

        headers.click(function() {
            var fieldname = $(this).attr("data-header-for");

            var oldOrder = uwdoem.ajax_section.getGetVarValue(ajaxSectionName, handle, 'order');
            var oldFieldname = uwdoem.ajax_section.getGetVarValue(ajaxSectionName, handle, 'fieldname');

            var newOrder = "ascending";
            if (fieldname === oldFieldname && oldOrder === "ascending") {
                newOrder = "descending";
            }

            uwdoem.ajax_section.registerGetVar(uwdoem.ajax_section.getVar(ajaxSectionName, handle, 'fieldname', fieldname));
            uwdoem.ajax_section.registerGetVar(uwdoem.ajax_section.getVar(ajaxSectionName, handle, 'order', newOrder));

            uwdoem.ajax_section.loadSection(ajaxSectionName);
        });
    };

    return {
        setupSortFilter: setupSortFilter
    };
}());