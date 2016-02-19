markdown_explorer = (function () {

    var isLocalHref = function (href) {
        return href.indexOf("://") === -1;
    };

    var isMarkdownHref = function (href) {
        return href.indexOf(".md") !== -1;
    };

    var makeLinksHandleMarkdown = function (element, directory) {
        element.find('a').click(
            function () {
                var linkHref = $(this).attr('href');
                if (isLocalHref(linkHref) && isMarkdownHref(linkHref)) {
                    window.location = [location.protocol, '//', location.host, location.pathname].join('') + "?href=" + encodeURIComponent(directory + linkHref);
                    return false;
                }
            }
        );
    };

    var loadFromHref = function (element, href) {
        $.get(
            href,
            function (data) {
                element.html(markdown.toHTML(data));
                makeLinksHandleMarkdown(element, getCurrentDirectory(href));
            }
        );
    };

    var getCurrentDirectory = function (href) {
        return href.substring(0, href.lastIndexOf("/") + 1);
    };

    var getQueryParameterHref = function () {
        return window.location.href.match(/href=([^&]*)/);
    };

    return {
        getCurrentDirectory: getCurrentDirectory,
        getQueryParameterHref: getQueryParameterHref,
        loadFromHref: loadFromHref
    }
})();
