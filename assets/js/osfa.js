/* jshint unused: false */
/* global UWDOEMAjax */

/**
 * Creates an alert div, appends it to the notification area, and schedules it for removal.
 *
 * @param {string} type The type of the message, likely "success", or "failure".
 * @param {string} msg The message to be displayed on the alert.
 * @param {number} duration How long to leave the alert displayed, in milliseconds.
 */
function makeAlert(type, msg, duration) {
    duration = typeof duration !== 'undefined' ? duration : 3000;

    $("<div class='notification '></div>").
        html(type + ": " + msg).
        appendTo("#notification-area").
        addClass(type).
        fadeTo(0, 0.7).
        delay(duration).
        fadeTo(0, 0).
        delay(300).
        hide(1);
}

/**
 * Fades in the mask screen which is used to temporarily "deactivate" the screen.
 */
function fadeInMask() {
    $("#mask-screen").css('height', '100%').css('opacity', 0.4);
}

/**
 * Fades out the mask screen which is used to temporarily "deactivate" the screen.
 */
function fadeOutMask() {
    $("#mask-screen").css('opacity', 0).delay(300).height(0);
    fadeOutSearch();
}

/**
 * Fades in the table search div.
 */
function fadeInSearch() {
    $(".search-div").fadeTo(1, 1);
}

/**
 * Fades out the table search div.
 */
function fadeOutSearch() {

    $(".search-div").fadeTo(150, 0,  function() {
        $(this).css("display", "none");
    });

}

function setupSortFilter(marker) {
    var filterSection = $("div." + marker).parents('.ajax-loaded-section');
    var filterSectionName=filterSection.data('section-name');

    var headers = filterSection.find("th");
    headers.addClass("clickable");
    headers.removeClass("sorted ascending descending");

    var fieldname = UWDOEMAjax.getGetVar(filterSectionName, 'sort', 'fieldname');
    var order = UWDOEMAjax.getGetVar(filterSectionName, 'sort', 'order');
    filterSection.find("th[data-header-for='" + fieldname + "']").addClass("sorted " + order);

    headers.click(function() {
        var fieldname = $(this).attr("data-header-for");
        UWDOEMAjax.registerGetVar(filterSectionName, 'sort', 'fieldname', fieldname);

        var oldOrder = UWDOEMAjax.getGetVar(filterSectionName, 'sort', 'order');
        var oldFieldname = UWDOEMAjax.getGetVar(filterSectionName, 'sort', 'fieldname');

        var newOrder = "ascending";
        if (fieldname === oldFieldname && oldOrder === "ascending") {
            newOrder = "ascending";
        }
        UWDOEMAjax.registerGetVar(filterSectionName, 'sort', 'order', newOrder);
        UWDOEMAjax.loadSection(filterSectionName);
    });
}

function setupSearchFilter(marker) {
    $("div.search-icon." + marker).click(function() {
        fadeInMask();
        fadeInSearch();
        $("#search-criteria-area").html($("div.search-table-content." + marker).html());

        var searchSection = $(this).parents(".ajax-loaded-section").data("section-name");

        // Pre-select the existing search criteria
        $("#search-criteria-area").find('tr').each(function() {
            var rowNumber = $(this).attr("data-row");

            var fieldName = UWDOEMAjax.getGetVar(searchSection, 'search', 'fieldname' + rowNumber);
            $(this).find("td.fieldname select").val(fieldName);

            var operation = UWDOEMAjax.getGetVar(searchSection, 'search', 'operation' + rowNumber);
            $(this).find("td.operation select").val(operation);

            var value = UWDOEMAjax.getGetVar(searchSection, 'search', 'value' + rowNumber);
            $(this).find("td.value input").val(value);

        });

        $("input.search-submit." + marker).click(function() {

            var i = 0;
            $(this).parent().find('tr').each(function() {
                var fieldname = $(this).find('td.fieldname select option:selected').val();
                var operation = $(this).find('td.operation select option:selected').text();
                var value = $(this).find('td.value input').val();
                if (fieldname && operation && value) {
                    UWDOEMAjax.registerGetVar(searchSection, 'search', 'fieldname' + i, fieldname);
                    UWDOEMAjax.registerGetVar(searchSection, 'search', 'operation' + i, operation);
                    UWDOEMAjax.registerGetVar(searchSection, 'search', 'value' + i, value);
                } else {
                    UWDOEMAjax.unsetGetVar(searchSection, 'search', 'fieldname' + i);
                    UWDOEMAjax.unsetGetVar(searchSection, 'search', 'operation' + i);
                    UWDOEMAjax.unsetGetVar(searchSection, 'search', 'value' + i);
                }
                i++;
            });
            UWDOEMAjax.registerGetVar(searchSection, 'pagination', 'page', 1);
            UWDOEMAjax.loadSection(searchSection);
            fadeOutMask();
            fadeOutSearch();
        });
    });
}

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

function setupSelectFilter(marker) {

    var filterSectionName = $("div." + marker).parents('.ajax-loaded-section').data('section-name');
    var filterName = $("select." + marker).attr("data-filter-name");
    $("select." + marker).attr("data-filter-section-for", filterSectionName);

    // Register a filter once on load
    var selectedText = $("select." + marker).find("option:selected").text();
    UWDOEMAjax.registerGetVar($("select." + marker).attr("data-filter-section-for"), filterName, 'value', selectedText);

    $("select." + marker).change(function() {

        var selectedText = $(this).find("option:selected").text();

        UWDOEMAjax.registerGetVar($("select." + marker).attr("data-filter-section-for"), filterName, 'value', selectedText);
        UWDOEMAjax.registerGetVar($("select." + marker).attr("data-filter-section-for"), 'pagination', 'page', 1);
        UWDOEMAjax.loadSection($("select." + marker).attr("data-filter-section-for"));
    });
}

function revealSelectASection(selectASection, targetSelectionName) {
    var selectedOption = selectASection.find("div.option.selectable[data-section-for=" + targetSelectionName + "]");
    var selectedSelection = selectASection.find("div.selection[data-selection-name=" + targetSelectionName +"]");

    selectedOption.find('input[type="radio"]').prop('checked', true);

    selectASection.find("div.option.selectable").removeClass("selected");
    selectASection.find("div.selection input, textarea, select").prop('disabled', true);
    selectASection.find("div.selection").css('display', 'none');

    selectedOption.addClass("selected");
    selectedSelection.find("input, textarea, select").prop('disabled', false);
    selectedSelection.css('display', 'block');

    disablePrototypicalRows();

}

// Move these to always do
$('#mask-screen').click(function () {
    fadeOutMask();
});

$(function() {
    $("div.select-a-section-container div.option.selectable").click(function() {
        var selectASection = $(this).closest("div.select-a-section-container");
        var targetSelectionName = ($(this).attr('data-section-for'));

        revealSelectASection(selectASection, targetSelectionName);
    });

    $("div.select-a-section-container div.option.selectable div.control-container input[type=radio]:checked").each( function() {
        var selectASection = $(this).closest("div.select-a-section-container");
        var targetSelectionName = $(this).val();

        revealSelectASection(selectASection, targetSelectionName);
    });

});

// Move these to always do
$(function() {
    $("form.prevent-double-submit").submit(function() {
        $(this).find("input[type=submit]").click(function() {
            event.preventDefault();
        });
    });
});

function addMultiAdderRow(multiAdderTable, dataRow) {
    if (typeof(dataRow) === 'undefined') {dataRow = multiAdderTable.find("tr.prototypical");}
    var baseRow = multiAdderTable.find("tr.prototypical");

    var lastRow = multiAdderTable.find("tr.form-row").last();

    var lastIndex;
    if (!lastRow.hasClass("prototypical") && typeof(lastRow.data("row-index")) !== 'undefined') {
        lastIndex = parseInt(lastRow.data("row-index"));
    } else {
        lastIndex = 0;
    }

    var newRow = baseRow.clone().removeClass("prototypical actual").data("row-index", lastIndex+1);
    var formElements = newRow.find("input, select");
    var dataElements = dataRow.find("input, select");

    for(var i = 0; i<formElements.length; i++) {
        var formElement = $(formElements[i]);
        formElement.attr('name', formElement.attr('name') + "-" + (lastIndex + 1));
        if ($(dataElements[i]).val() !== null) {formElement.val($(dataElements[i]).val());}
    }

    newRow.find("td[class*='remove']").click(function() {
        $(this).closest("tr.form-row").remove();
    });

    newRow.insertAfter(lastRow);
}

function disablePrototypicalRows() {
    $(this).find('tr.prototypical input, tr.prototypical select').prop('disabled', true);
}

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

$(function() {
    $("input.slashless-date-entry").focusout(function() {
        var val = $(this).val();

        if(/^[0-9]+$/.test(val) && val.length === 8) {
            var newVal = [val.slice(0, 2), '/', val.slice(2, 4), '/', val.slice(4)].join('');
            $(this).val(newVal);
        }

    });
});

function AJAXSubmit(form, successCallback) {

    var formVars = $(form).serializeArray();

    var newVars = {};
    for (var i = 0; i < formVars.length; i++) {
        newVars[formVars[i].name] = formVars[i].value;
    }

    OSFAAjax($(form).attr('action'), newVars, successCallback);
}

// Some duplication here
function AJAXSubmitForm(form, successCallback) {
    if (typeof(successCallback)==='undefined') { successCallback = function() {}; }

    var formVars = $(form).serializeArray();
    var url = $(form).data("request-uri");
    var formId = $(form).attr('id');

    console.log(formVars);

    var post_vars = {};
    for (var i = 0; i < formVars.length; i++) {
        if (formVars[i].value) {
            post_vars[formVars[i].name] = formVars[i].value;
        }
    }

    console.log(post_vars);

    if (typeof(post_vars)==='undefined') { post_vars = []; }
    if (typeof(successCallback)==='undefined') { successCallback = function() {}; }

    post_vars.csrf_token = CSRFTOKEN;

    $.ajax({
        type: "POST",
        url: url,
        data: post_vars
    })
        .done(function(msg) {
            try {
                $(form).replaceWith($("<div>" + msg + "</div>").find("#" + formId));
                document.getElementById(formId).scrollIntoView();
                makeAlert("success", "Form subitted.");
                successCallback();
            } catch(err) {
                makeAlert("failure", "Unexpected error: " + err.message + ". More detail may be available in the network response.");
            }
        })
        .fail(function(msg) {
            makeAlert("failure", msg);
        });
}

function UWDOEM() {
    this.softPaginationPage = 1;
}

var uwdoem = new UWDOEM();


function setupSoftPaginationFilter(div) {
    $(function() {

        var paginateBy = 12;

        var table = div.parents('.ajax-loaded-section').find('table:visible');
        var rows = table.find('tr:not(:first)');

        var numPages = Math.ceil(rows.length/paginateBy);

        var select = div.find('select.pagination-filter');

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
            var page = uwdoem.softPaginationPage;

            if (!$.isNumeric(page) || page < 1 || page > numPages) {
                page = 1;
            }

            return parseInt(page);
        }

        function setPage(page) {
            uwdoem.softPaginationPage = page;
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



}



