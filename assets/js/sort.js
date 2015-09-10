/* globals uwdoem $ */

uwdoem.sort = (function() {
    
    var setupSortFilter = function (marker) {
        var filterSection = $("div." + marker).parents('.ajax-loaded-section');
        var filterSectionName=filterSection.data('section-name');

        var headers = filterSection.find("th");
        headers.addClass("clickable");
        headers.removeClass("sorted ascending descending");

        var fieldname = uwdoem.ajax_section.getGetVar(filterSectionName, 'sort', 'fieldname');
        var order = uwdoem.ajax_section.getGetVar(filterSectionName, 'sort', 'order');
        filterSection.find("th[data-header-for='" + fieldname + "']").addClass("sorted " + order);

        headers.click(function() {
            var fieldname = $(this).attr("data-header-for");
            uwdoem.ajax_section.registerGetVar(filterSectionName, 'sort', 'fieldname', fieldname);

            var oldOrder = uwdoem.ajax_section.getGetVar(filterSectionName, 'sort', 'order');
            var oldFieldname = uwdoem.ajax_section.getGetVar(filterSectionName, 'sort', 'fieldname');

            var newOrder = "ascending";
            if (fieldname === oldFieldname && oldOrder === "ascending") {
                newOrder = "ascending";
            }
            uwdoem.ajax_section.registerGetVar(filterSectionName, 'sort', 'order', newOrder);
            uwdoem.ajax_section.loadSection(filterSectionName);
        });
    };

    return {
        setupSortFilter: setupSortFilter
    };
}());