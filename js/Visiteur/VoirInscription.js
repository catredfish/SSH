$(window).on('load',function(){
        $('#modalChoixTypeCompte').modal('show');
    });

function retourAccueil(){
    //Retourne à la page d'accueil
    window.location = "/Accueil";
}

function changeLoginType(type){
  switch (type) {
    case 1:
    $("#type-connexion").val("1");
    $(".bouton-continuer").prop('disabled', false);
    break;
    case 2:
    $("#type-connexion").val("2");
    $(".bouton-continuer").prop('disabled', false);
    break;
    case 3:
    $("#type-connexion").val("3");
    $(".bouton-continuer").prop('disabled', false);
    break;
  }
}
