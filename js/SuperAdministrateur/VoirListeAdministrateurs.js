// Permet de formatter les tableaux
var ratioEmployes = false;
var ratioEleves = false;
var ratioVisiteurs = false;
$(document).ready(function () {
    var onglets = $('.nav > li');
    if($(onglets[0]).hasClass('active')){
        if(!ratioEmployes){
            $('.employes').DataTable({
                language: {
                    url: 'http://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json'
                },
                responsive: true,
                bDestroy: true
            });
            ratioEmployes= true;
        }
    }
    else if($(onglets[1]).hasClass('active')){
        if(!ratioVisiteurs){

            $('.visiteurs').DataTable({
                language: {
                    url: 'http://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json'
                },
                responsive: true,
                bDestroy: true
            });
            ratioVisiteurs = true;
        }
    }
     else if($(onglets[2]).hasClass('active')){
        if(!ratioEleves){
            $('.eleves').DataTable({
                language: {
                    url: 'http://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json'
                },
                responsive: true,
                bDestroy: true
            });
            ratioEleves = true;
        }
    }
});

//Lorsqu'on change d'onglet, met à jour l'onglet sélectionné
function MiseAJourOnglet(numeroOngletSelectionne) {

    // Met à jous les onglets
    switch (numeroOngletSelectionne) {
        case 1:
            $("#tab1primary").addClass("active");
            $("#tab1primary").addClass("in");
            $("#tab1primary").addClass("show");

            $("#tab2primary").removeClass("active");
            $("#tab2primary").removeClass("in");
            $("#tab2primary").removeClass("show");

            $("#tab3primary").removeClass("active");
            $("#tab3primary").removeClass("in");
            $("#tab3primary").removeClass("show");

            if(!ratioEmployes){
                $('.employes').DataTable({
                    language: {
                        url: 'http://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json'
                    },
                    responsive: true,
                    bDestroy: true
                });
                ratioEmployes= true;
            }
            break;
        case 2:
            $("#tab2primary").addClass("active");
            $("#tab2primary").addClass("in");
            $("#tab2primary").addClass("show");

            $("#tab1primary").removeClass("active");
            $("#tab1primary").removeClass("in");
            $("#tab1primary").removeClass("show");

            $("#tab3primary").removeClass("active");
            $("#tab3primary").removeClass("in");
            $("#tab3primary").removeClass("show");

            if(!ratioVisiteurs){

                $('.visiteurs').DataTable({
                    language: {
                        url: 'http://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json'
                    },
                    responsive: true,
                    bDestroy: true
                });
                ratioVisiteurs = true;
            }
            break;
        case 3:
            $("#tab3primary").addClass("active");
            $("#tab3primary").addClass("in");
            $("#tab3primary").addClass("show");

            $("#tab1primary").removeClass("active");
            $("#tab1primary").removeClass("in");
            $("#tab1primary").removeClass("show");

            $("#tab2primary").removeClass("active");
            $("#tab2primary").removeClass("in");
            $("#tab2primary").removeClass("show");

            if(!ratioEleves){
                $('.eleves').DataTable({
                    language: {
                        url: 'http://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json'
                    },
                    responsive: true,
                    bDestroy: true
                });
                ratioEleves = true;
            }
            break;
    }
}

// Permet de prévenir le problème graphique survenant avec les modales
function supprimerRecreerModal() {
    $("#modal").remove();
    $(".modal-backdrop").remove();
    $("#sectionPourModale").append("<div class=\"modal fade\" id=\"modal\" role=\"dialog\"></div>");
}

// Permet de rétrograder un administrateur, de promouvoir un utilisateur, d'activer un compte ou de désactiver un compte
var jeton = null;
function voirModal(id, onglet, methode) {

    // Vide la modale
    $("#modal").empty();

    // Obtient le jeton
    if(jeton == null){
        jeton = $("[name=_token]").get(0).outerHTML;
        $("[name=_token]").remove();
    }

    // Obtient le titre et le message à mettre dans la modale
    titre = "";
    message = "";
    attribut = "";
    valeur = "";
    switch(methode){
        case "RetrograderAdministrateur":
            titre = "Rétrograder un usager";
            message = "Voulez-vous vraiment rétrograder cet usager à un compte de type utilisateur ?";
            attribut = "idTypeCompte";
            valeur = "1";
            break;
        case "PromouvoirUtilisateur":
            titre = "Promouvoir un usager";
            message = "Voulez-vous vraiment promouvoir cet usager à un compte de type administrateur ?";
            attribut = "idTypeCompte";
            valeur = "2";
            break;
        case "ActiverCompte":
            titre = "Activer un compte";
            message = "Voulez-vous vraiment activer ce compte ?";
            attribut = "Actif";
            valeur = "1";
            break;
        case "DesactiverCompte":
            titre = "Désactiver un compte";
            message = "Voulez-vous vraiment désactiver ce compte ?";
            attribut = "Actif";
            valeur = "0";
            break;
    }

    // Crée le contenu de la modale
    contenu = "<div class=\"modal-dialog modal-dialog-centered\">\n" +
        "    <div class=\"modal-content\">\n" +
        "        <div class=\"modal-header\">\n" +
        "            <h4 class=\"modal-title\" id=\"idTitreModal\">" + titre + "</h4>\n" +
        "            <button type=\"button\" class=\"close\" data-dismiss=\"modal\" onclick=\"supprimerRecreerModal()\">&times;\n" +
        "            </button>\n" +
        "        </div>\n" +
        "        <div class=\"modal-body\" id=\"idContenu\">\n" +
        "                <div class=\"card\">\n" +
        "                    <div id=\"contact-form\" class=\"form-container\" data-form-container>\n" +
        "                        <div class=\"input-container\">\n" +
        "                            <form action=\"/" + methode + "\" method=\"POST\">\n" +
                                            jeton +
        "                                <div class=\"row\">\n" +
        "                                    <p>" + message + "\n" +
        "                                    <input id=\"id\" name=\"id\" value=\"" + id + "\" hidden=\"hidden\">\n" +
        "                                    <input id=\"" + attribut + "\" name=\"" + attribut + "\" value=\"" + valeur + "\" hidden=\"hidden\">\n" +
        "                                    <input id=\"onglet\" name=\"ongletChoisi\" value=\"" + onglet + "\" hidden=\"hidden\">\n" +
        "                                </div>\n" +
        "                                <div class=\"row submit-row\">\n" +
        "                                    <button type=\"submit\" class=\"btn btn-block submit-form\">Confirmer</button>\n" +
        "                                </div>\n" +
        "                            </form>\n" +
        "                        </div>\n" +
        "                    </div>\n" +
        "                </div>\n" +
        "        </div>\n" +
        "        <div class=\"modal-footer\">\n" +
        "            <button type=\"button\" class=\"btn btn-danger\" data-dismiss=\"modal\" onclick=\"supprimerRecreerModal()\">Fermer</button>\n" +
        "        </div>\n" +
        "    </div>\n" +
        "</div>\n";

    // Crée la modale
    $("#modal").append(contenu);
}