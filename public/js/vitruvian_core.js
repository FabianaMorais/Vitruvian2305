function scrollToPageTop() {
    $("html, body").animate({ scrollTop: 0 }, "slow");
}

function scrollToElement(element) {
    $([document.documentElement, document.body]).animate({
        scrollTop: $(element).offset().top - $(window).height()/6
    }, 1000);
}

function isLg () {
	//returns true if above lg bootstrap standard
	const width = Math.max( document.documentElement.clientWidth,window.innerWidth || 0 );
	if (width > 992) {
		return true;
	} else {
		return false;
	}
}