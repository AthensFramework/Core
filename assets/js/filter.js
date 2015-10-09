uwdoem.alert = (function() {

    var initializedFilters = [];

    function setupFilter(setupFun, handle) {
        if (initializedFilters.indexOf(handle) !== -1) {
            // Do nothing, this filter has already been initialized
        } else {
            initializedFilters.push(handle);
            setupFun(handle);
        }
    }

    return {
        setupFilter: setupFilter
    };

}());