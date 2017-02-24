athens.search = (function () {

    var searchDiv = $(".search-div");

    /**
     * Fades in the table search div.
     */
    function fadeInSearch()
    {
        athens.fadeInMask();
        $(".search-div").fadeTo(1, 1);
    }

    /**
     * Fades out the table search div.
     */
    function fadeOutSearch()
    {
        searchDiv.fadeTo(
            150,
            0,
            function () {
                $(this).css("display", "none");
            }
        );

    }

    var searchSubmitOnclick = function () {
        var handle = $(this).closest("div.search-table-content").data("handle-for");
        var ajaxSectionName = $("div.search-container[data-handle-for=" + handle + "]").closest(".filter-controls").data('table-for');

        var i = 0;

        var getVar = athens.ajax_section.getVar;

        $(this).parent().find('tr').each(
            function () {
                var fieldname = $(this).find('td.fieldname select option:selected').val();
                var operation = $(this).find('td.operation select option:selected').text();
                var value = $(this).find('td.value input').val();
                if (fieldname && operation && value) {
                    athens.ajax_section.registerGetVar(getVar(ajaxSectionName, handle, 'fieldname' + i, fieldname));
                    athens.ajax_section.registerGetVar(getVar(ajaxSectionName, handle, 'operation' + i, operation));
                    athens.ajax_section.registerGetVar(getVar(ajaxSectionName, handle, 'value' + i, value));
                } else {
                    athens.ajax_section.unsetGetVar(getVar(ajaxSectionName, handle, 'fieldname' + i));
                    athens.ajax_section.unsetGetVar(getVar(ajaxSectionName, handle, 'operation' + i));
                    athens.ajax_section.unsetGetVar(getVar(ajaxSectionName, handle, 'value' + i));
                }
                i++;
            }
        );
        athens.ajax_section.registerGetVar(getVar(ajaxSectionName, 'pagination', 'page', 1));
        athens.ajax_section.loadSection(ajaxSectionName);
        athens.fadeOutMask();
        fadeOutSearch();
    };

    var searchIconOnclick = function () {
        var handle = $(this).data("handle-for");
        var ajaxSectionName = $("div.search-container[data-handle-for=" + handle + "]").closest(".filter-controls").data('table-for');

        athens.fadeInMask();
        fadeInSearch();

        // Pre-select the existing search criteria
        $("#search-criteria-area").find('tr').each(
            function () {
                var rowNumber = $(this).attr("data-row");
                var fieldName = athens.ajax_section.getGetVarValue(ajaxSectionName, handle, 'fieldname' + rowNumber);
                $(this).find("td.fieldname select").val(fieldName);
                var operation = athens.ajax_section.getGetVarValue(ajaxSectionName, handle, 'operation' + rowNumber);
                $(this).find("td.operation select").val(operation);
                var value = athens.ajax_section.getGetVarValue(ajaxSectionName, handle, 'value' + rowNumber);
                $(this).find("td.value input").val(value);
            }
        );
    };

    var setupSearchFilter = function (handle) {
        // Move the search icon to the label
        var searchContainer = $("div.search-container[data-handle-for=" + handle + "]");
        var label = searchContainer.closest("div.table-container").prev("div.section-label");
        var searchIcon = $("div.search-icon[data-handle-for=" + handle + "]");

        $("#search-criteria-area").empty();
        $("div.search-table-content[data-handle-for=" + handle + "]").prependTo("#search-criteria-area");
        $("input.search-submit." + handle).click(searchSubmitOnclick);

        if (label.find("div.search-icon[data-handle-for=" + handle + "]").length === 0) {
            searchIcon.prependTo(label);
            searchIcon.click(searchIconOnclick);
        }

        // If this search filter has feedback, add a clear search link:
        $("p.filter-feedback[data-handle-for=" + handle + "]")
            .append(" <a onClick='athens.search.clearSearch(\"" + handle + "\");'>Clear Search</a>");

    };

    var clearSearch = function (handle) {
        var getVar = athens.ajax_section.getVar;
        var ajaxSectionName = $("div.search-container[data-handle-for=" + handle + "]").closest(".filter-controls").data('table-for');

        for (var i = 0; i <= 5; i++) {
            athens.ajax_section.unsetGetVar(getVar(ajaxSectionName, handle, 'fieldname' + i));
            athens.ajax_section.unsetGetVar(getVar(ajaxSectionName, handle, 'operation' + i));
            athens.ajax_section.unsetGetVar(getVar(ajaxSectionName, handle, 'value' + i));
        }

        athens.ajax_section.bareLoadSection(ajaxSectionName);
    };

    return {
        setupSearchFilter: setupSearchFilter,
        clearSearch: clearSearch
    };
}());




