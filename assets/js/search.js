

uwdoem.search = (function() {

    var maskScreen = $("#mask-screen");
    var searchCriteriaArea = $("#search-criteria-area");
    var searchDiv = $(".search-div");

    /**
     * Fades in the mask screen which is used to temporarily "deactivate" the screen.
     */
    function fadeInMask() {
        maskScreen.css('height', '100%').css('opacity', 0.4);
    }

    /**
     * Fades out the mask screen which is used to temporarily "deactivate" the screen.
     */
    function fadeOutMask() {
        maskScreen.css('opacity', 0).delay(300).height(0);
        fadeOutSearch();
    }

    /**
     * Fades in the table search div.
     */
    function fadeInSearch() {
        searchDiv.fadeTo(1, 1);
    }

    /**
     * Fades out the table search div.
     */
    function fadeOutSearch() {

        searchDiv.fadeTo(150, 0,  function() {
            $(this).css("display", "none");
        });

    }

    var searchSubmitOnclick = function() {
        var i = 0;
        var searchSection = $(this).parents(".ajax-loaded-section").data("section-name");

        $(this).parent().find('tr').each(function() {
            var fieldname = $(this).find('td.fieldname select option:selected').val();
            var operation = $(this).find('td.operation select option:selected').text();
            var value = $(this).find('td.value input').val();
            if (fieldname && operation && value) {
                uwdoem.ajax_section.registerGetVar(searchSection, 'search', 'fieldname' + i, fieldname);
                uwdoem.ajax_section.registerGetVar(searchSection, 'search', 'operation' + i, operation);
                uwdoem.ajax_section.registerGetVar(searchSection, 'search', 'value' + i, value);
            } else {
                uwdoem.ajax_section.unsetGetVar(searchSection, 'search', 'fieldname' + i);
                uwdoem.ajax_section.unsetGetVar(searchSection, 'search', 'operation' + i);
                uwdoem.ajax_section.unsetGetVar(searchSection, 'search', 'value' + i);
            }
            i++;
        });
        uwdoem.ajax_section.registerGetVar(searchSection, 'pagination', 'page', 1);
        uwdoem.ajax_section.loadSection(searchSection);
        fadeOutMask();
        fadeOutSearch();
    };

    var searchIconOnclick = function(marker) {
        fadeInMask();
        fadeInSearch();

        searchCriteriaArea.html($("div.search-table-content." + marker).html());

        var searchSection = $(this).parents(".ajax-loaded-section").data("section-name");

        // Pre-select the existing search criteria
        searchCriteriaArea.find('tr').each(function() {
            var rowNumber = $(this).attr("data-row");

            var fieldName = uwdoem.ajax_section.getGetVar(searchSection, 'search', 'fieldname' + rowNumber);
            $(this).find("td.fieldname select").val(fieldName);

            var operation = uwdoem.ajax_section.getGetVar(searchSection, 'search', 'operation' + rowNumber);
            $(this).find("td.operation select").val(operation);

            var value = uwdoem.ajax_section.getGetVar(searchSection, 'search', 'value' + rowNumber);
            $(this).find("td.value input").val(value);
        });
    };

    var setupSearchFilter = function (marker) {
        $("div.search-icon." + marker).click(searchIconOnclick(marker));

        // This might suppose to be inside searchIconOnclick
        $("input.search-submit." + marker).click(searchSubmitOnclick());
    };

    maskScreen.click(function () {
        fadeOutMask();
    });

    return {
        setupSearchFilter: setupSearchFilter
    };
}());