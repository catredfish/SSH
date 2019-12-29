$(document).ready( function () {
    $('.atelier').DataTable({
      language: {
              url: 'http://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json'
          }
    });
});

function voirDescriptionAtelier(idAtelier){
    $("#idContenuDescription").html($("#descriptionAtelier" + idAtelier).html());
}

function ouvrirModalSupprimer(numeroAtelier){
    $("#idAtelier").attr("value",numeroAtelier);
}

function annulationAtelier(numeroCompte){
    //Inspiration https://stackoverflow.com/questions/41981922/minimum-working-example-for-ajax-post-in-laravel-5-3
    var CSRF_TOKEN = $('[name=_token]').val();
    $.ajax({
          type: 'POST',
          url: "/AnnulationAtelier/Annulation",
          data: {
            _token: CSRF_TOKEN,
            numeroAtelier: $("#idAtelier").val(),
            numeroCompte: numeroCompte,
            numeroOngletSelectionne: $("#inputNumeroOngletSelectionne").val(),
            numeroCampus:$("#inputNumeroCampusSelectionne").val(),
            dateSelectionnee:$("#inputDateSelectionnee").val()
          },
          success: function (result) {
              window.location = result;
          },
          error: function (result){
              window.location = "/VoirMessageErreur";
          }
      });
}

//Lorsqu'on change de campus
$(".campus").on('change', function(){
    //Met à jour le input
    $("#inputNumeroCampusSelectionne").attr("value",$(this).val());
    //Met à jour la page
    window.location = "AnnulationAtelier?numeroCampus=" + $(this).val() + "&ongletSelectionne=" + $("#inputNumeroOngletSelectionne").val() + "&dateSelectionnee=" + $("#inputDateSelectionnee").val();
})

//Lorsqu'on change de date
$(".inputDate").on('change',function(){
    //Met à jour le input
    $("#inputDateSelectionnee").attr("value",$(this).val());
    //Met à jour la page
    window.location = "AnnulationAtelier?numeroCampus=" + $("#inputNumeroCampusSelectionne").val() + "&ongletSelectionne=" + $("#inputNumeroOngletSelectionne").val() + "&dateSelectionnee=" + $(this).val();
})

//Lorsqu'on change d'onglet, met à jour l'input de du numéro de l'onglet sélectionné.
function MiseAJourOnglet(numeroOngletSelectionne){
    //Met à jour le input
    $("#inputNumeroOngletSelectionne").attr("value",numeroOngletSelectionne);
}

function MiseAJourPage(numeroOngletSelectionne, numeroCampus){
    window.location = "ListeAteliers?numeroCampus=" + numeroCampus.toString() + "&ongletSelectionne=" + numeroOngletSelectionne.toString();
}

$("body").on("change", function(){
    $("body").attr('padding-right',0);
});
