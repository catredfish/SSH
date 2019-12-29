$("#selectAtelier").on('change', function(){
    //Met à jour le input
    $("#inputAtelier").attr("value",$(this).val());
})

function EnvoyerRappel(){
    //Inspiration https://stackoverflow.com/questions/41981922/minimum-working-example-for-ajax-post-in-laravel-5-3
    var CSRF_TOKEN = $('[name=_token]').val();
    $.ajax({
          type: 'POST',
          url: "/EnvoyerRappel/EnvoyerRappel",
          data: {
            _token: CSRF_TOKEN,
            numeroAtelier: $("#inputAtelier").val()
          },
          success: function (result) {
              window.location = result;
          },
          error: function (result){
              window.location = "/VoirMessageErreur";
          }
      });
}
