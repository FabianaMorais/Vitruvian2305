function toggleSidebar() {
    $('#nav_sidebar').toggleClass('active');
}

$(document).ready(function () {

    $(document).mouseup(function(e) { // hiding menu when clicking outside of it
        if ( !$('#nav_sidebar').is(e.target) && $('#nav_sidebar').has(e.target).length === 0 ) {
            $('#nav_sidebar').removeClass('active');
        }
    });

});

function logout() { // Logout through the navbar
    document.form_logout.submit();
}