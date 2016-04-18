athens.soft_pagination = (function () {

    var page, rows, table, paginateBy, numPages, select, div;

    page = 1;

    var getPage = function () {
    
        if (!$.isNumeric(page) || page < 1 || page > numPages) {
            page = 1;
        }

        return parseInt(page);
    };

    var setPage = function (newPage) {
    
        page = newPage;
    };

    var firstRowToDisplay = function (handle) {
    
        return (getPage() - 1)*paginateBy;
    };

    var lastRowToDisplay = function (handle) {
    
        return Math.min(rows.length, (getPage() - 1)*paginateBy + paginateBy);
    };

    var revealRows = function () {
    
        var rowsToDisplay = rows.slice(firstRowToDisplay(), lastRowToDisplay());

        rows.css('display', 'none');
        rowsToDisplay.css('display', 'table-row');
    };

    var updateFeedback = function (handle) {
    
        var feedback = "";
        if (rows.length !== 0) {
            feedback = "Displaying results " + (firstRowToDisplay() + 1) + "-" + lastRowToDisplay() + " of " + rows.length + ".";
        }

        console.log(feedback);

        var feedbackParagraph = $("p.filter-feedback[data-handle-for=" + handle + "]");
        feedbackParagraph.removeClass("hidden");
        feedbackParagraph.text(feedback);

        console.log(feedbackParagraph);
    };

    var recalculateArrowPageFor = function (handle) {
    
        page = getPage();

        var div = getActiveControls(handle);

        $('.pagination-arrow.first').data("page-for", 1);
        $('.pagination-arrow.previous').data("page-for", page - 1);
        $('.pagination-arrow.next').data("page-for", page + 1);
        $('.pagination-arrow.last').data("page-for", numPages);
    };

    var reVisArrows = function (handle) {
    
        var page = getPage();
        var div = getActiveControls(handle);

        console.log(page);

        if (page === 1) {
            $('.pagination-arrow.back').css('display', 'none');
        } else {
            $('.pagination-arrow.back').css('display', 'inline');
        }

        if (page >= numPages) {
            $('.pagination-arrow.forward').css('display', 'none');
        } else {
            $('.pagination-arrow.forward').css('display', 'inline');
        }
    };

    var resetPulldownVal = function (handle) {
    
        var div = getActiveControls(handle);
        div.find("select.pagination-filter").val(getPage());
    };

    var renewPage = function (handle) {
    
        table.fadeTo(200, 0.25);
        setTimeout(
            function () {
                revealRows(handle);
                recalculateArrowPageFor(handle);
                resetPulldownVal(handle);
                reVisArrows(handle);
                updateFeedback(handle);
                table.fadeTo(200, 1);
            },
            200
        );
    };

    var getActiveControls = function (handle) {
        return $("div.section-label div.pagination-container[data-handle-for=" + handle + "]");
    };

    var getInactiveControls = function (handle) {
        return $("div.table-container div.filter-controls div.pagination-container[data-handle-for='" + handle + "']");
    };

    var setupSoftPaginationFilter = function (handle) {
        $(
            function () {
                var inactiveControls = getInactiveControls(handle);
                var activeControls = getActiveControls(handle);

                paginateBy = 5;
                table = inactiveControls.closest('div.table-container').children('table');
                rows = table.find('tr:not(:first)');
                numPages = Math.ceil(rows.length/paginateBy);
                select = inactiveControls.find('select.pagination-filter');

                console.log(table);

                // If this filter is already active...
                if (activeControls.length) {
                    // replace the active controls with the new, inactive controls
                    activeControls.replaceWith(inactiveControls);
                } else {
                    // else just append the new controls to the label.
                    inactiveControls.appendTo(inactiveControls.closest("div.section-container").find("div.section-label"));
                }

                activeControls = inactiveControls;

                if (numPages <= 1) {
                    select.css('display', 'none');
                } else {
                    for (var i = 1; i <= numPages; i++) {
                        $('<option>' + i + '</option>').data("page-for", i).appendTo(select);
                    }
                }

                revealRows(handle);
                recalculateArrowPageFor(handle);
                reVisArrows(handle);
                updateFeedback(handle);

                $("a.pagination-arrow").click(
                    function () {
                        setPage($(this).data('page-for'));
                        renewPage(handle);
                        resetPulldownVal(handle);
                        return false;
                    }
                );

                activeControls.find("select.pagination-filter").change(
                    function () {
                        setPage($(this).val());
                        resetPulldownVal(handle);
                        renewPage(handle);
                    }
                );
            }
        );
    };

    return {
        setupSoftPaginationFilter: setupSoftPaginationFilter
    };
}());



