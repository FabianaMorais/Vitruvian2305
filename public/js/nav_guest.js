var topBarGuest = $('#nav_topbar_guest');

$(window).scroll(function() {
    if ($(window).scrollTop() > 200) {
        topBarGuest.addClass('vstyle-nav-dark');
    } else {
        topBarGuest.removeClass('vstyle-nav-dark');
    }
});

$(function () {
    $('#navGuestMarkup').on('show.bs.collapse', function () {
        topBarGuest.addClass('vstyle-nav-dark');
    })

    $('#navGuestMarkup').on('hidden.bs.collapse', function () {
        if ($(window).scrollTop() <= 200) {
            topBarGuest.removeClass('vstyle-nav-dark');
        }
      });
});