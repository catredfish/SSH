// Cache le « footer » pour offrir plus d'espace sur la page si besoin est
$(window).scroll(function() {
    if ($(this).scrollTop() < 1) {
        $("#footer").show();
    }
    else {
        $("#footer").hide();
    }
});