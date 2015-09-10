/* global uwdoem $ */

uwdoem.multi_adder = (function() {

    var getLastRow = function() {
        return multiAdderTable.find("tr.form-row").last();
    };

    var getLastDataRowIndex = function() {
        var lastRow = getLastRow();

        var lastIndex = 0;
        if (!lastRow.hasClass("prototypical")) {
            lastIndex = parseInt(lastRow.data("row-index") || 0);
        }

        return lastIndex;
    };

    var makeNewRow = function(multiAdderTable) {
        var baseRow = multiAdderTable.find("tr.prototypical");
        return baseRow.clone().removeClass("prototypical actual");
    };

    var activateRemover = function(row) {
        row.find("td[class*='remove']").click(function() {
            $(this).closest("tr.form-row").remove();
        });
    };

    var addMultiAdderRow = function(multiAdderTable, dataRow) {
        var defaultDataRow = multiAdderTable.find("tr.prototypical");
        dataRow = dataRow || defaultDataRow;
        
        var lastDataRowIndex = getLastDataRowIndex();

        var newRow = makeNewRow(multiAdderTable).data("row-index", lastDataRowIndex + 1);

        var formElements = newRow.find("input, select");
        var dataElements = dataRow.find("input, select");

        for(var i = 0; i<formElements.length; i++) {
            var formElement = $(formElements[i]);
            formElement.attr('name', formElement.attr('name') + "-" + (lastDataRowIndex + 1));
            if ($(dataElements[i]).val() !== null) {formElement.val($(dataElements[i]).val());}
        }

        activateRemover(newRow);

        newRow.insertAfter(getLastRow());
    };

    var disablePrototypicalRows = function() {
        $(this).find('tr.prototypical input, tr.prototypical select').prop('disabled', true);
    };

    $(function() {
        disablePrototypicalRows();

        $("table.multi-adder tbody").each(function() {
            var actualRows = $(this).find('tr.actual');

            if (actualRows.length === 0) {
                addMultiAdderRow($(this));
            } else {
                var table = $(this);
                actualRows.each(function() {
                    addMultiAdderRow(table, $(this));
                });
            }
        });
        $("table.multi-adder tr.adder").click(function() {
            addMultiAdderRow($(this).parent());
        });
    });

    return {
    }
}());