athens.admin = (function () {
    
    $(function () {
        var adminTablesContainer = $('#admin-tables-container');

        if (adminTablesContainer.length > 0) {
            adminTablesContainer.data('request-uri', adminTablesContainer.data('request-uri') + '?mode=table');
            athens.ajax_section.loadSection('admin-tables-container');
        }

    })

}(athens.ajax_section));



