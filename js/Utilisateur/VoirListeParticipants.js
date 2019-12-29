//Permet d'imprimer la liste de présence
function ImprimerListePresence() {
  var CSRF_TOKEN = $('[name=_token]').val();
  $.ajax({
        type: 'Get',
        url: "/ImprimerListePresence",
        data: {
          _token: CSRF_TOKEN,
          numeroAtelier: $("#idAtelierModalVoirListeParticipants").val()
        },
        success: function (result) {

          var mywindow = window.open('', 'PRINT', 'height=400,width=600');

    mywindow.document.write(result);

    mywindow.document.close(); // necessary for IE >= 10
    mywindow.focus(); // necessary for IE >= 10*/

    mywindow.print();
    mywindow.close();

        },
        error: function(result){
            window.location = "/VoirMessageErreur";
        }
    });
}
