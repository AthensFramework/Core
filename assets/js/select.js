athens.select = (function () {
    var getVar = athens.ajax_section.getVar;

    var getActiveControls = function (handle) {
        return $("#top-filters select[data-handle-for=" + handle + "]");
    };

    var getInactiveControls = function (handle) {
        return $("div.filter-controls select[data-handle-for=" + handle + "]");
    };

    var getCurrentSelection = function (ajaxSectionName, handle) {
        var selection = athens.ajax_section.getGetVarValue(ajaxSectionName, handle, 'value');

        if (!selection) {
            selection = getActiveControls(handle).val();
        }

        return decodeURIComponent(selection);
    };

    var setupSelectFilter = function (handle) {

        var activeControls = getActiveControls(handle);
        var inactiveControls = getInactiveControls(handle);
        var ajaxSectionName = inactiveControls.closest('.filter-controls').data('table-for');

        if (activeControls.length === 0) {
            inactiveControls.appendTo("#top-filters");

            var selectedText = getCurrentSelection(ajaxSectionName, handle);
            athens.ajax_section.registerGetVar(getVar(ajaxSectionName, handle, 'value', selectedText));
        } else {
            activeControls.replaceWith(inactiveControls);
        }
        activeControls = inactiveControls;

        activeControls.val(getCurrentSelection(ajaxSectionName, handle));

        activeControls.change(
            function () {
                var selectedText = $(this).find("option:selected").text();
                athens.ajax_section.registerGetVar(getVar(ajaxSectionName, handle, 'value', selectedText));
                athens.ajax_section.loadSection(ajaxSectionName);
            }
        );
    };

    return {
        setupSelectFilter: setupSelectFilter
    };
}());


