var btnToTop = $('#btn_to_top');

$(window).scroll(function() {
    if ($(window).scrollTop() > 300) {
        btnToTop.addClass('show');
    } else {
        btnToTop.removeClass('show');
    }
});

btnToTop.on('click', function(e) {
    e.preventDefault();
    $('html, body').animate({scrollTop:0}, '300');
});