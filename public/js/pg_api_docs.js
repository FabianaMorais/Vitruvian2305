function scrollDocs(el) {
    var container = document.getElementById('container-docs');
    var scrollTo = document.getElementById( $(el).attr('href').slice(1) );
    container.scrollTop = scrollTo.offsetTop;

    if (!isLg()) {
        $('#navbar-api-index').collapse('hide');
    }

    return false;
}
