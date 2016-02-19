uwdoem.filter = (function () {

    var initializedFilters = [];

    // TODO: Remove
    function setupFilter(setupFun, handle)
    {
        if (initializedFilters.indexOf(handle) !== -1) {
            setupFun(handle);
        } else {
            initializedFilters.push(handle);
            setupFun(handle);
        }
    }

    return {
        setupFilter: setupFilter
    };

}());
