

uwdoem.select_a_section = (function () {
    var revealSelectASection = function (selectASection, targetSelectionName) {
        var selectedOption = selectASection.find("div.option.selectable[data-section-for=" + targetSelectionName + "]");
        var selectedSelection = selectASection.find("div.selection[data-selection-name=" + targetSelectionName +"]");

        selectedOption.find('input[type="radio"]').prop('checked', true);

        selectASection.find("div.option.selectable").removeClass("selected");
        selectASection.find("div.selection input, textarea, select").prop('disabled', true);
        selectASection.find("div.selection").css('display', 'none');

        selectedOption.addClass("selected");
        selectedSelection.find("input, textarea, select").prop('disabled', false);
        selectedSelection.css('display', 'block');

        uwdoem.multi_adder.disablePrototypicalRows();
    };

    // Move these to always do
    $(function () {
        $("div.select-a-section-container div.option.selectable").click(function () {
            var selectASection = $(this).closest("div.select-a-section-container");
            var targetSelectionName = ($(this).attr('data-section-for'));

            revealSelectASection(selectASection, targetSelectionName);
        });

        $("div.select-a-section-container div.option.selectable div.control-container input[type=radio]:checked").each(function () {
            var selectASection = $(this).closest("div.select-a-section-container");
            var targetSelectionName = $(this).val();

            revealSelectASection(selectASection, targetSelectionName);
        });

    });

    return {
        revealSelectASection: revealSelectASection
    };
}());
