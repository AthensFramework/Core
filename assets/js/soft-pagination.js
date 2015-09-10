

uwdoem.soft_pagination = (function() {
    var setupSoftPaginationFilter = function(div) {
        $(function() {

            var paginateBy = 12;

            var table = div.parents('.ajax-loaded-section').find('table:visible');
            var rows = table.find('tr:not(:first)');

            var numPages = Math.ceil(rows.length/paginateBy);

            var select = div.find('select.pagination-filter');

            var page = 1;

            if (numPages <= 1) {
                select.css('display', 'none');
            } else {
                for (var i = 1; i <= numPages; i++) {
                    $('<option>' + i + '</option>').data("page-for", i).appendTo(select);
                }
            }

            revealRows();
            recalculateArrowPageFor();
            reVisArrows();
            updateFeedback();

            function getPage() {
                if (!$.isNumeric(page) || page < 1 || page > numPages) {
                    page = 1;
                }

                return parseInt(page);
            }

            function setPage(newPage) {
                page = newPage;
            }

            function firstRowToDisplay() {
                return (getPage() - 1)*paginateBy;
            }

            function lastRowToDisplay() {
                return Math.min(rows.length, (getPage() - 1)*paginateBy + paginateBy);
            }

            function revealRows() {
                var rowsToDisplay = rows.slice(firstRowToDisplay(), lastRowToDisplay());

                rows.css('display', 'none');
                rowsToDisplay.css('display', 'table-row');
            }

            function updateFeedback() {
                var feedback = "";
                if (rows.length !== 0) {
                    feedback = "Displaying " + (firstRowToDisplay() + 1) + "-" + lastRowToDisplay() + " of " + rows.length + " records.";
                }
                $("#soft-pagination-feedback").html(feedback);
            }

            function recalculateArrowPageFor() {
                var page = getPage();

                div.find('.pagination-arrow.first').data("page-for", 1);
                div.find('.pagination-arrow.previous').data("page-for", page - 1);
                div.find('.pagination-arrow.next').data("page-for", page + 1);
                div.find('.pagination-arrow.last').data("page-for", numPages);
            }

            function reVisArrows() {
                var page = getPage();

                if (page === 1) {
                    div.find('.pagination-arrow.back').css('display', 'none');
                } else {
                    div.find('.pagination-arrow.back').css('display', 'inline');
                }

                if (page >= numPages) {
                    div.find('.pagination-arrow.forward').css('display', 'none');
                } else {
                    div.find('.pagination-arrow.forward').css('display', 'inline');
                }
            }

            function resetPulldownVal() {
                div.find("select.pagination-filter").val(getPage());
            }

            function renewPage() {
                table.fadeTo(200, 0.25);
                setTimeout(function(){
                    revealRows();
                    recalculateArrowPageFor();
                    resetPulldownVal();
                    reVisArrows();
                    updateFeedback();
                    table.fadeTo(200, 1);
                }, 200);
            }

            $("div.soft-pagination-container a.pagination-arrow").click(function() {
                setPage($(this).data('page-for'));
                renewPage();

                return false;
            });

            div.find("select.pagination-filter").change(function() {
                setPage($(this).val());
                renewPage();
            });
        });
    };

    return {
        setupSoftPaginationFilter: setupSoftPaginationFilter
    };
}());