myID = document.getElementById("fp-pop-header");

var myScrollFunc = function () {
    var y = window.scrollY;
    if (y >= 150) {
        jQuery('#fp-pop-header').show()
    } else {
        jQuery('#fp-pop-header').hide()
    }
};

window.addEventListener("scroll", myScrollFunc);