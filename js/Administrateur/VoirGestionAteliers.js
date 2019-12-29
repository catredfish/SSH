$(document).ready( function () {
        $('.ateliersActifs').DataTable({
            language: {
                url: 'http://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json'
            },
            responsive: true,
            bDestroy: true,
            "order": [[ 1, "asc" ]]
        });

        $('.ateliersArchives').DataTable({
            language: {
                url: 'http://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json'
            },
            responsive: true,
            bDestroy: true,
            "order": [[ 1, "asc" ]]
        });
});

function voirDescriptionAtelier(idAtelier){
  //Inspiration https://stackoverflow.com/questions/41981922/minimum-working-example-for-ajax-post-in-laravel-5-3
  var CSRF_TOKEN = $('[name=_token]').val();
  $.ajax({
        type: 'POST',
        url: "/AfficherDescriptionAtelier",
        data: {
          _token: CSRF_TOKEN,
          numeroAtelier: idAtelier
        },
        success: function (result) {
            $("#modal").empty();
            $("#modal").append("<div class=\"modal-backdrop fade in\"></div>" + result);
        },
        error: function(result){
            window.location = "/VoirMessageErreur";
        }
    });
}

//Section des courriels

function VoirEnvoyerRappelGenerique(){
  var CSRF_TOKEN = $('[name=_token]').val();
  $.ajax({
        type: 'POST',
        url: "/VoirEnvoyerRappelGenerique",
        data: {
          _token: CSRF_TOKEN,
        },
        success: function (result) {
            $("#modal").empty();
            $("#modal").append("<div class=\"modal-backdrop fade in\"></div>" + result);
        },
        error: function(result){
            window.location = "/VoirMessageErreur";
        }
    });
}

function VoirEnvoyerRappelSpecifique(idAtelier){
  var CSRF_TOKEN = $('[name=_token]').val();
  $.ajax({
        type: 'POST',
        url: "/VoirEnvoyerRappelSpecifique",
        data: {
          _token: CSRF_TOKEN,
          idAtelier: idAtelier
        },
        success: function (result) {
            $("#modal").empty();
            $("#modal").append("<div class=\"modal-backdrop fade in\"></div>" + result);
        },
        error: function(result){
            window.location = "/VoirMessageErreur";
        }
    });
}

//Section des modales --------------------------------------------------------------------

function ouvrirModalSupprimer(numeroAtelier){
  $.ajax({
        type: 'GET',
        url: "/VoirAnnulerAtelier",
        data: {
          idAtelier: numeroAtelier
        },
        success: function (result) {
            $("#modal").empty();
            $("#modal").append("<div class=\"modal-backdrop fade in\"></div>" + result);
        },
        error: function (result){
            window.location = "/VoirMessageErreur";
        }
    });
}

function ouvrirModalModifier(numeroAtelier){
  var CSRF_TOKEN = $('[name=_token]').val();
  $.ajax({
        type: 'GET',
        url: "/ModifierAtelier",
        data: {
          _token: CSRF_TOKEN,
          idAtelier: numeroAtelier
        },
        success: function (result) {
            $("#modal").empty();
            $("#modal").append("<div class=\"modal-backdrop fade in\"></div>" + result);
        },
        error: function (result){
            window.location = "/VoirMessageErreur";
        }
    });
}

function ouvrirModalCreer(){
  var CSRF_TOKEN = $('[name=_token]').val();
  $.ajax({
        type: 'GET',
        url: "/CreationAtelier",
        data: {
          _token: CSRF_TOKEN
        },
        success: function (result) {
            $("#modal").empty();
            $("#modal").append("<div class=\"modal-backdrop fade in\"></div>" + result);
        },
        error: function (result){
            window.location = "/VoirMessageErreur";
        }
    });
}

function voirListeParticipants(numeroAtelier){
  //Inspiration https://stackoverflow.com/questions/41981922/minimum-working-example-for-ajax-post-in-laravel-5-3
  var CSRF_TOKEN = $('[name=_token]').val();
  $.ajax({
        type: 'POST',
        url: "/ListeParticipants",
        data: {
          _token: CSRF_TOKEN,
          numeroAtelier: numeroAtelier
        },
        success: function (result) {
            $("#modal").empty();
            $("#modal").append("<div class=\"modal-backdrop fade in\"></div>" + result);
        },
        error: function(result){
            window.location = "/VoirMessageErreur";
        }
    });
}

//Lorsqu'on change de campus
$(".campus").on('change', function(){
    //Met à jour le input
    $("#inputNumeroCampusSelectionne").attr("value",$(this).val());
    //Met à jour la page
    window.location = "/GestionAteliers?campusSelectionne=" + $("#inputNumeroCampusSelectionne").val() + "&dateSelectionnee=" + $("#inputDateSelectionnee").val() + "&ongletSelectionne=" + $("#inputNumeroOngletSelectionne").val();
})

//Lorsqu'on change de date
$(".inputDate").on('change',function(){
    //Met à jour le input
    $("#inputDateSelectionnee").attr("value",$(this).val());
    //Met à jour la page
    window.location = "/GestionAteliers?campusSelectionne=" + $("#inputNumeroCampusSelectionne").val() + "&dateSelectionnee=" + $("#inputDateSelectionnee").val() + "&ongletSelectionne=" + $("#inputNumeroOngletSelectionne").val();
})

//Lorsqu'on change d'onglet, met à jour l'input de du numéro de l'onglet sélectionné
var ratioArchives = false;
function MiseAJourOnglet(numeroOngletSelectionne){
    //Met à jour le input
    $("#inputNumeroOngletSelectionne").attr("value",numeroOngletSelectionne);
    //Cache le bouton créer et le bouton pour envoyer un message générique lorsque l'onglet des ateliers archivés est sélectionné.
    if(numeroOngletSelectionne == 2){
      $("#boutonCreer").attr("hidden",true);
      $("#boutonEnvoyerRappelGenerique").attr("hidden",true);

        // Stabilise le ratio des « Datatables »
        if(!ratioArchives) {
            setTimeout(function () {
                $('.ateliersArchives').DataTable().responsive.recalc();
            }, 200);
            ratioArchives = true;
        }
    }
    else{
      $("#boutonCreer").attr("hidden",false);
      $("#boutonEnvoyerRappelGenerique").attr("hidden",false);
    }
}

//Met à jour la page selon les onglets sélectionné
function MiseAJourPage(numeroOngletSelectionne, numeroCampus){
    window.location = "ListeAteliers?numeroCampus=" + numeroCampus.toString() + "&ongletSelectionne=" + numeroOngletSelectionne.toString();
}

$("body").on("change", function(){
    $("body").attr('padding-right',0);
});


// Permet de prévenir le problème graphique survenant avec les modales
function supprimerRecreerModal() {
    $("#modal").remove();
    $(".modal-backdrop").remove();
    $("#sectionPourModale").append("<div class=\"modal fade\" id=\"modal\" role=\"dialog\"></div>");
}
