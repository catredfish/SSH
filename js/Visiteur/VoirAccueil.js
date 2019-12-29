// Permet de mettrer et contrôler une vidéo en pleine écran
//var video = document.getElementById("myVideo");
//var btn = document.getElementById("myBtn");
//function myFunction() {
  //if (video.paused) {
  //  video.play();
 //   btn.innerHTML = "Pause";
 // } else {
  //  video.pause();
  //  btn.innerHTML = "Play";
  //}
//}

document.addEventListener('DOMContentLoaded', function() {
  // Met le signet en haut de la page
  var navigation = document.getElementsByClassName("site-navbar")[0];
  var signet = document.getElementById("hautGauche");
  navigation.appendChild(signet);

  // Change le texte de l'onglet « Accueil »
  var onglet = document.getElementById("accueilNaviation");
  var date = new Date();
  var annee = date.getFullYear();
  var autreNavigation = document.getElementsByClassName("site-navigation")[0];
  var touteLaNavigation = document.getElementById("barreNavigation");
  var dateEvenement = document.getElementById("dateEvenement");
  touteLaNavigation.appendChild(dateEvenement);
  var banniere = document.getElementById("hautGauche");
  dateEvenement.style.color = "rgb(33,58,143)";
  dateEvenement.style.fontWeight = "bolder";
  dateEvenement.style.marginTop = ".5em";

  // Déplace la date de la semaine des sciences humaines si les menus apparaissent
  if(document.getElementById("menuNavigation").getElementsByTagName("li").length > 1){
    
    // Bouge la date
    dateEvenement.style.position = "absolute";
    dateEvenement.style.top = "0";
    $(dateEvenement).addClass("changerLesRights");
    
    // Bouge la bannière
    banniere.style.float ="left";
    banniere.style.width ="10%";
    banniere.style.position="absolute";
    banniere.style.top = "5em";
    banniere.style.marginLeft ="0em";
  }
  else{
    onglet.text= "";
    var elementSupprimer = document.getElementsByClassName("site-menu")[0];
    elementSupprimer.remove();
    
    dateEvenement.style.position = "absolute";
    dateEvenement.style.top = "0";
    dateEvenement.style.left = "0!important";
    $(dateEvenement).removeClass("changerLesRights");
    dateEvenement.style.right = "auto!important";
  }

  // Change le « footer »
  var footer = document.getElementById("footer");
  footer.style.color = "rgb(33,58,143)";
  footer.style.fontWeight = "bolder";
  footer.style.backgroundColor = "white";
  var footerImg = document.getElementById("basCentre");
  footer.innerHTML="";
  footer.appendChild(footerImg);
  footerImg.style.width = "30%";
}, false);