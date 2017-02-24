athens.sort = (function () {
    
    var setupSortFilter = function (handle) {

        var filterSection = $("div.sort-container[data-handle-for=" + handle + "]").closest('.table-container');
        var ajaxSectionName = filterSection.attr('id');

        var headers = filterSection.find("th");
        headers.addClass("clickable");
        headers.removeClass("sorted ascending descending");

        var fieldname = athens.ajax_section.getGetVarValue(ajaxSectionName, handle, 'fieldname');
        var order = athens.ajax_section.getGetVarValue(ajaxSectionName, handle, 'order');
        filterSection.find("th[data-header-for='" + fieldname + "']").addClass("sorted " + order);

        headers.click(
            function () {
                var fieldname = $(this).attr("data-header-for");
                var oldOrder = athens.ajax_section.getGetVarValue(ajaxSectionName, handle, 'order');
                var oldFieldname = athens.ajax_section.getGetVarValue(ajaxSectionName, handle, 'fieldname');
                var newOrder = "ASC";
                if (fieldname === oldFieldname && oldOrder === "ASC") {
                    newOrder = "DESC";
                }

                athens.ajax_section.registerGetVar(athens.ajax_section.getVar(ajaxSectionName, handle, 'fieldname', fieldname));
                athens.ajax_section.registerGetVar(athens.ajax_section.getVar(ajaxSectionName, handle, 'order', newOrder));
                athens.ajax_section.loadSection(ajaxSectionName);
            }
        );
    };

    return {
        setupSortFilter: setupSortFilter
    };
}());




