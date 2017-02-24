athens.multi_adder = (function () {

    var getLastRow = function (multiAdderTable) {
        return multiAdderTable.find("tr.form-row").last();
    };

    var getLastDataRowIndex = function (multiAdderTable) {
        var lastRow = getLastRow(multiAdderTable);

        var lastIndex = 0;
        if (!lastRow.hasClass("prototypical")) {
            lastIndex = parseInt(lastRow.data("row-index") || 0);
        }

        return lastIndex;
    };

    var makeNewRow = function (multiAdderTable) {
        var baseRow = multiAdderTable.find("tr.prototypical");
        return baseRow.clone().removeClass("prototypical actual");
    };

    var activateRemover = function (row) {
        row.find("td[class*='remove']").click(
            function () {
                $(this).closest("tr.form-row").remove();
            }
        );
    };

    var addMultiAdderRow = function (multiAdderTable, dataRow) {
        var defaultDataRow = multiAdderTable.find("tr.prototypical");
        dataRow = dataRow || defaultDataRow;

        var lastDataRowIndex = getLastDataRowIndex(multiAdderTable);

        var newRow = makeNewRow(multiAdderTable).data("row-index", lastDataRowIndex + 1);

        var formElements = newRow.find("input, select");
        var dataElements = dataRow.find("input, select");

        for (var i = 0; i<formElements.length; i++) {
            var formElement = $(formElements[i]);

            formElement.attr('name', (lastDataRowIndex + 1) + "-" + formElement.attr('name'));
            if ($(dataElements[i]).val() !== null) {
                formElement.val($(dataElements[i]).val());}

            formElement.attr('disabled', false);
        }

        activateRemover(newRow);

        newRow.insertAfter(getLastRow(multiAdderTable));
    };

    var disablePrototypicalRows = function () {
        $('tr.prototypical input, tr.prototypical select').prop('disabled', true);
    };

    $(
        function () {
            $("tr.actual.form-row").each(function () {
                activateRemover($(this));
            });

            disablePrototypicalRows();
            $("table.multi-adder tbody").each(
                function () {
                    var actualRows = $(this).find('tr.actual');

                    if (actualRows.length === 0) {
                        addMultiAdderRow($(this));
                    }
                }
            );
            $("table.multi-adder tr.adder").click(
                function () {
                    addMultiAdderRow($(this).parent());
                }
            );
        }
    );

    return {
        disablePrototypicalRows: disablePrototypicalRows
    };
}());





