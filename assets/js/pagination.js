/* globals uwdoem $ */

uwdoem.pagination = (function() {

    function setupPaginationFilter(marker) {
        $(function() {
            $("div.pagination-container a.pagination-arrow").click(function() {
                var filterSectionName=$(this).parents('.ajax-loaded-section').data('section-name');
                var targetPage = $(this).attr('data-page-for');
                uwdoem.ajax_section.registerGetVar(filterSectionName, 'pagination', 'page', targetPage);
                uwdoem.ajax_section.loadSection(filterSectionName);

                return false;
            });

            $("select.pagination-filter." + marker).change(function() {
                var filterSectionName = $(this).parents('.ajax-loaded-section').data('section-name');
                uwdoem.ajax_section.registerGetVar(filterSectionName, 'pagination', 'page', $( "select.pagination-filter." + marker + " option:selected" ).text());
                uwdoem.ajax_section.loadSection(filterSectionName);
            });
        });
    }

    return {
        setupPaginationFilter: setupPaginationFilter
    }
}());