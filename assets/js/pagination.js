/* global uwdoem $ */

uwdoem.pagination = (function() {

    function setupPaginationFilter(marker) {
        $(function() {
            $("div.pagination-container a.pagination-arrow").click(function() {
                var filterSectionName=$(this).parents('.ajax-loaded-section').data('section-name');
                var targetPage = $(this).attr('data-page-for');
                UWDOEMAjax.registerGetVar(filterSectionName, 'pagination', 'page', targetPage);
                UWDOEMAjax.loadSection(filterSectionName);

                return false;
            });

            $("select.pagination-filter." + marker).change(function() {
                var filterSectionName = $(this).parents('.ajax-loaded-section').data('section-name');
                UWDOEMAjax.registerGetVar(filterSectionName, 'pagination', 'page', $( "select.pagination-filter." + marker + " option:selected" ).text());
                UWDOEMAjax.loadSection(filterSectionName);
            });
        });
    }

    return {
        setupPaginationFilter: setupPaginationFilter
    }
}());