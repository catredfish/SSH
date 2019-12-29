var ratioInscriptions = false;
var ratioAnnulations = false;
var ratioAttentes = false;
$(document).ready( function () {
    var onglets = $('.nav > li');
    if($(onglets[0]).hasClass('active')){
        if(!ratioInscriptions){
            $('.inscriptions').DataTable({
                language: {
                    url: 'http://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json'
                },
                responsive: true,
                bDestroy: true,
                "order": [[ 1, "asc" ]]
            });
            ratioInscriptions= true;
        }
    }
    else if($(onglets[1]).hasClass('active')){
        if(!ratioAnnulations){
            setTimeout(function(){
                $('.annulations').DataTable({
                    language: {
                        url: 'http://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json'
                    },
                    responsive: true,
                    bDestroy: true,
                    "order": [[ 1, "asc" ]]
                });
            }, 200);
            ratioAnnulations = true;
        }
    }
    else if($(onglets[2]).hasClass('active')){
        if(!ratioAttentes){
            setTimeout(function(){
                $('.attentes').DataTable({
                    language: {
                        url: 'http://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json'
                    },
                    responsive: true,
                    bDestroy: true,
                    "order": [[ 1, "asc" ]]
                }); }, 200);
            ratioAttentes = true;
        }
    }
});

function inscriptionDesinscription(numeroAtelier, numeroCompte){
    var onglet = $("#inputNumeroOngletSelectionne").val();
    //Inspiration https://stackoverflow.com/questions/41981922/minimum-working-example-for-ajax-post-in-laravel-5-3
    var CSRF_TOKEN = $('[name=_token]').val();

    // Montre une animation de chargement
    var result = "<div class=\"lds-roller\"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>";
    $("#modal").empty();
    $("#modal").append("<div class=\"modal-backdrop fade in\"></div>" + result);

    $.ajax({
          type: 'POST',
          url: "/InscriptionAtelier",
          data: {
            _token: CSRF_TOKEN,
            numeroAtelier: numeroAtelier,
            numeroCompte: numeroCompte,
            numeroOngletSelectionne: $("#inputNumeroOngletSelectionne").val(),
            numeroCampus:$("#inputNumeroCampusSelectionne").val(),
            dateSelectionnee:$("#inputDateSelectionnee").val()
          },
          success: function (result) {
              window.location = result;
          },
          error: function(result){
              window.location = "/VoirMessageErreur";
          }
      });
}

function inscriptionDesinscriptionListeAttente(numeroAtelier, numeroCompte){
    //Inspiration https://stackoverflow.com/questions/41981922/minimum-working-example-for-ajax-post-in-laravel-5-3
    var CSRF_TOKEN = $('[name=_token]').val();

    // Montre une animation de chargement
    var result = "<div class=\"lds-roller\"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>";
    $("#modal").empty();
    $("#modal").append("<div class=\"modal-backdrop fade in\"></div>" + result);
    
    $.ajax({
          type: 'POST',
          url: "/InscriptionListeAttentes",
          data: {
            _token: CSRF_TOKEN,
            numeroAtelier: numeroAtelier,
            numeroCompte: numeroCompte,
            numeroOngletSelectionne: $("#inputNumeroOngletSelectionne").val(),
            numeroCampus:$("#inputNumeroCampusSelectionne").val(),
            dateSelectionnee:$("#inputDateSelectionnee").val()
          },
          success: function (result) {
              window.location = result;
          },
          error: function(result){
              window.location = "/VoirMessageErreur";
          }
      });
}


//Section des modales --------------------------------------------------------------------
function VoirInscriptionAtelier(idAtelier){
  //Inspiration https://stackoverflow.com/questions/41981922/minimum-working-example-for-ajax-post-in-laravel-5-3
  var CSRF_TOKEN = $('[name=_token]').val();
  $.ajax({
        type: 'POST',
        url: "/ConfirmerInscriptionAtelier",
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

function VoirDesinscriptionAtelier(idAtelier){
  //Inspiration https://stackoverflow.com/questions/41981922/minimum-working-example-for-ajax-post-in-laravel-5-3
  var CSRF_TOKEN = $('[name=_token]').val();
  $.ajax({
        type: 'POST',
        url: "/ConfirmerDesinscriptionAtelier",
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

function VoirInscriptionListeAttentes(idAtelier){
  //Inspiration https://stackoverflow.com/questions/41981922/minimum-working-example-for-ajax-post-in-laravel-5-3
  var CSRF_TOKEN = $('[name=_token]').val();
  $.ajax({
        type: 'POST',
        url: "/ConfirmerInscriptionListeAttentes",
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

function VoirDesinscriptionListeAttentes(idAtelier){
  //Inspiration https://stackoverflow.com/questions/41981922/minimum-working-example-for-ajax-post-in-laravel-5-3
  var CSRF_TOKEN = $('[name=_token]').val();
  $.ajax({
        type: 'POST',
        url: "/ConfirmerDesinscriptionListeAttentes",
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
        error: function(xhr, status, error){
            window.location = "/VoirMessageErreur";
        }
    });
}

function VoirDescriptionConflit(idAtelier){
  //Inspiration https://stackoverflow.com/questions/41981922/minimum-working-example-for-ajax-post-in-laravel-5-3
  var CSRF_TOKEN = $('[name=_token]').val();
  $.ajax({
        type: 'POST',
        url: "/VoirDescriptionConflit",
        data: {
          _token: CSRF_TOKEN,
          numeroAtelier: idAtelier,
          numeroCampus: $("#inputNumeroCampusSelectionne").val(),
          ongletSelectionne: $("#inputNumeroOngletSelectionne").val(),
          dateSelectionnee: $("#inputDateSelectionnee").val()
        },
        success: function (result) {
            $("#modal").empty();
            $("#modal").append("<div class=\"modal-backdrop fade in\"></div>" + result);
        },
        error: function(result){
            var test = result;
            window.location = "/VoirMessageErreur";
        }
    });
}

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

// Permet de prévenir le problème graphique survenant avec les modales
function supprimerRecreerModal() {
    $("#modal").remove();
    $(".modal-backdrop").remove();
    $("#sectionPourModale").append("<div class=\"modal fade\" id=\"modal\" role=\"dialog\"></div>");
}

//Lorsqu'on change de campus
$(".campus").on('change', function(){
    //Met à jour le input
    $("#inputNumeroCampusSelectionne").attr("value",$(this).val());
    //Met à jour la page
    window.location = "ListeAteliers?numeroCampus=" + $(this).val() + "&ongletSelectionne=" + $("#inputNumeroOngletSelectionne").val() + "&dateSelectionnee=" + $("#inputDateSelectionnee").val();
})

//Lorsqu'on change de date
$(".inputDate").on('change',function(){
    //Met à jour le input
    $("#inputDateSelectionnee").attr("value",$(this).val());
    //Met à jour la page
    window.location = "ListeAteliers?numeroCampus=" + $("#inputNumeroCampusSelectionne").val() + "&ongletSelectionne=" + $("#inputNumeroOngletSelectionne").val() + "&dateSelectionnee=" + $(this).val();
})

//Lorsqu'on change d'onglet, met à jour l'input de du numéro de l'onglet sélectionné
function MiseAJourOnglet(numeroOngletSelectionne){
    //Met à jour le input
    $("#inputNumeroOngletSelectionne").attr("value",numeroOngletSelectionne);

    switch(numeroOngletSelectionne){
        case 1:
            if(!ratioInscriptions){
                setTimeout(function(){
                    $('.inscriptions').DataTable({
                        language: {
                            url: 'http://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json'
                        },
                        responsive: true,
                        bDestroy: true,
                        "order": [[ 1, "asc" ]]
                    });
                }, 200);
                ratioInscriptions= true;
            }
            break;
        case 2:
            if(!ratioAnnulations){
                setTimeout(function(){
                $('.annulations').DataTable({
                    language: {
                        url: 'http://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json'
                    },
                    responsive: true,
                    bDestroy: true,
                    "order": [[ 1, "asc" ]]
                });
                }, 200);
                ratioAnnulations = true;
            }
            break;
        case 3:
            if(!ratioAttentes){
                setTimeout(function(){
                $('.attentes').DataTable({
                    language: {
                        url: 'http://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json'
                    },
                    responsive: true,
                    bDestroy: true,
                    "order": [[ 1, "asc" ]]
                }); }, 200);
                ratioAttentes = true;
            }
            break;
    }
}

function MiseAJourPage(numeroOngletSelectionne, numeroCampus){
    window.location = "ListeAteliers?numeroCampus=" + numeroCampus.toString() + "&ongletSelectionne=" + numeroOngletSelectionne.toString();
}
