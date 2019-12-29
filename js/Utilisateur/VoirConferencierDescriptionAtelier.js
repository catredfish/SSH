function retourDescriptionAtelier(idAtelier) {
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
