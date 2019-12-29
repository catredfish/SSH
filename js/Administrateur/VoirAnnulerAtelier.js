function annulationAtelier(idAtelier){

    // Montre une animation de chargement
    var result = "<div class=\"lds-roller\"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>";
    $("#modal").empty();
    $("#modal").append("<div class=\"modal-backdrop fade in\"></div>" + result);

    //Inspiration https://stackoverflow.com/questions/41981922/minimum-working-example-for-ajax-post-in-laravel-5-3
    var CSRF_TOKEN = $('[name=_token]').val();
    $.ajax({
          type: 'POST',
          url: "/AnnulationAtelier/Annulation",
          data: {
            _token: CSRF_TOKEN,
            numeroAtelier: idAtelier
          },
          success: function (result) {
            if(result == "success"){
               window.location = "/GestionAteliers?campusSelectionne=" + $("#inputNumeroCampusSelectionne").val() + "&dateSelectionnee=" + $("#inputDateSelectionnee").val() + "&ongletSelectionne=" + $("#inputNumeroOngletSelectionne").val();
            }
          },
          error: function (result){
              window.location = "/VoirMessageErreur";
          }
      });
}
