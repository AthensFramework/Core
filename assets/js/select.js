/* globals uwdoem $ */

uwdoem.select = (function() {

    var setupSelectFilter = function(marker) {

        var filterSelect = $("select." + marker);

        var filterSectionName = $("div." + marker).parents('.ajax-loaded-section').data('section-name');
        var filterName = filterSelect.attr("data-filter-name");
        filterSelect.attr("data-filter-section-for", filterSectionName);

        // Register a filter once on load
        var selectedText = filterSelect.find("option:selected").text();
        uwdoem.ajax_section.registerGetVar(filterSelect.attr("data-filter-section-for"), filterName, 'value', selectedText);

        filterSelect.change(function() {

            var selectedText = $(this).find("option:selected").text();

            uwdoem.ajax_section.registerGetVar(filterSelect.attr("data-filter-section-for"), filterName, 'value', selectedText);
            uwdoem.ajax_section.registerGetVar(filterSelect.attr("data-filter-section-for"), 'pagination', 'page', 1);
            uwdoem.ajax_section.loadSection(filterSelect.attr("data-filter-section-for"));
        });
    };

    return {
        setupSelectFilter: setupSelectFilter
    };
}());