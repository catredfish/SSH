// Permet de formatter les tableaux
$(document).ready( function () {
    $('.conferenciersActifs').DataTable({
        language: {
            url: 'http://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json'
        },
        responsive: true,
        bDestroy: true
    });
});


//Lorsqu'on change d'onglet, met à jour l'onglet sélectionné
var ratioArchives = false;
var ratioActifs = false;
function MiseAJourOnglet(numeroOngletSelectionne) {

    // Met à jous les onglets
    switch (numeroOngletSelectionne) {
        case 1:
            $("#tab1primary").addClass("active");
            $("#tab1primary").addClass("in");
            $("#tab1primary").addClass("show");
            $("#boutonCreer").css("display", "");

            $("#tab2primary").removeClass("active");
            $("#tab2primary").removeClass("in");
            $("#tab2primary").removeClass("show");
            break;
        case 2:
            $("#tab2primary").addClass("active");
            $("#tab2primary").addClass("in");
            $("#tab2primary").addClass("show");
            $("#boutonCreer").css("display", "none");

            $("#tab1primary").removeClass("active");
            $("#tab1primary").removeClass("in");
            $("#tab1primary").removeClass("show");

            $('.conferenciersArchives').DataTable({
                language: {
                    url: 'http://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json'
                },
                responsive: true,
                bDestroy: true
            });
            break;
    }
}

// Permet de prévenir le problème graphique survenant avec les modales
function supprimerRecreerModal() {
    $("#modal").remove();
    $(".modal-backdrop").remove();
    $("#sectionPourModale").append("<div class=\"modal fade\" id=\"modal\" role=\"dialog\"></div>");
}

// Permet de voir le formulaire d'ajout d'un conférencier
function voirCreerConferencier() {
    $.ajax({
        type: 'GET',
        url: "/CreationConferencier",
        data: {},
        success: function (result) {
            $("#modal").empty();
            $("#modal").append("<div class=\"modal-backdrop fade in\"></div>" + result);
        },
        error: function (result) {
            window.location = "/VoirMessageErreur";
        }
    });
}

// Permet de voir le formulaire de modification d'un conférencier
function voirModifierConferencier(id) {
    $.ajax({
        type: 'GET',
        url: "/ModificationConferencier",
        data: {
            Id: id
        },
        success: function (result) {
            $("#modal").empty();
            $("#modal").append("<div class=\"modal-backdrop fade in\"></div>" + result);
        },
        error: function (xhr, status, error) {
            window.location = "/VoirMessageErreur";
        }
    });
}


// Permet d'ajouter un conférencier
function creerConferencier() {
    if (!fichierDejaValide) {
        var formData = new FormData($("#formulaireTeleversement")[0]);
        $.ajax({
            url: "upload.php",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function () {
            },
            success: function (data) {
                if (data != "SUCCESS") {
                    $("#tableauErreurs").empty();
                    $("#tableauErreurs").append("<tr>\n<td align=\"left\"><label class=\"erreur\">" + data + "</label></td>\n</tr>");
                    $("#tableauErreurs").css("margin-bottom", "1.4em");
                } else {
                    fichierDejaValide = true;
                    var CSRF_TOKEN = $('[name=_token]').val();
                    $.ajax({
                        type: 'POST',
                        url: "/CreerConferencier",
                        data: {
                            _token: CSRF_TOKEN,
                            Nom: $("#nom").val(),
                            Prenom: $("#prenom").val(),
                            Courriel: $("#courriel").val(),
                            Expertise: $("#expertise").val(),
                            Biographie: $("#biographie").val(),
                            Photo: $("#photo").val()
                        },
                        success: function (result) {
                            if (result.length > 1) {
                                $("#sectionCreationConferencier").empty();
                                $("#sectionCreationConferencier").append(result);
                                $("#tableauErreurs").replaceWith($("#tableauErreursConferencier"));
                                $("#tableauErreursConferencier").attr("id", "tableauErreurs");
                            } else {
                                window.location.href = window.location.href.replace( /[\?#].*|$/, "?ongletChoisi=" + result );
                            }
                        },
                        error: function (xhr, status, error) {
                            window.location = "/VoirMessageErreur";
                        }
                    });
                }

            },
            error: function (xhr, ajaxOptions, thrownError) {
                window.location = "/VoirMessageErreur";
            }
        });
    } else {
        fichierDejaValide = true;
        var CSRF_TOKEN = $('[name=_token]').val();
        $.ajax({
            type: 'POST',
            url: "/CreerConferencier",
            data: {
                _token: CSRF_TOKEN,
                Nom: $("#nom").val(),
                Prenom: $("#prenom").val(),
                Courriel: $("#courriel").val(),
                Expertise: $("#expertise").val(),
                Biographie: $("#biographie").val(),
                Photo: $("#photo").val()
            },
            success: function (result) {
                if (result.length > 1) {
                    $("#sectionCreationConferencier").empty();
                    $("#sectionCreationConferencier").append(result);
                    $("#tableauErreurs").replaceWith($("#tableauErreursConferencier"));
                    $("#tableauErreursConferencier").attr("id", "tableauErreurs");
                } else {
                    window.location.href = window.location.href.replace( /[\?#].*|$/, "?ongletChoisi=" + result );
                }
            },
            error: function (xhr, status, error) {
                window.location = "/VoirMessageErreur";
            }
        });
    }
}

// Permet de modifier un conférencier
function modifierConferencier() {
    if (!fichierDejaValide) {
        var formData = new FormData($("#formulaireTeleversement")[0]);
        $.ajax({
            url: "upload.php",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function () {
            },
            success: function (data) {
                if (data != "SUCCESS") {
                    $("#tableauErreurs").empty();
                    $("#tableauErreurs").append("<tr>\n<td align=\"left\"><label class=\"erreur\">" + data + "</label></td>\n</tr>");
                    $("#tableauErreurs").css("margin-bottom", "1.4em");
                } else {
                    fichierDejaValide = true;
                    var CSRF_TOKEN = $('[name=_token]').val();
                    $.ajax({
                        type: 'POST',
                        url: "/ModifierConferencier",
                        data: {
                            _token: CSRF_TOKEN,
                            Id: $("#id").val(),
                            Nom: $("#nom").val(),
                            Prenom: $("#prenom").val(),
                            Courriel: $("#courriel").val(),
                            Expertise: $("#expertise").val(),
                            Biographie: $("#biographie").val(),
                            Photo: $("#photo").val(),
                            Actif: $("#actif").val()
                        },
                        success: function (result) {
                            if (result.length > 1) {
                                $("#sectionModificationConferencier").empty();
                                $("#sectionModificationConferencier").append(result);
                                $("#tableauErreurs").replaceWith($("#tableauErreursConferencier"));
                                $("#tableauErreursConferencier").attr("id", "tableauErreurs");
                            } else {
                                window.location.href = window.location.href.replace( /[\?#].*|$/, "?ongletChoisi=" + result );
                            }
                        },
                        error: function (xhr, status, error) {
                            window.location = "/VoirMessageErreur";
                        }
                    });
                }

            },
            error: function (xhr, ajaxOptions, thrownError) {
                window.location = "/VoirMessageErreur";
            }
        });
    } else {
        fichierDejaValide = true;
        var CSRF_TOKEN = $('[name=_token]').val();
        $.ajax({
            type: 'POST',
            url: "/ModifierConferencier",
            data: {
                _token: CSRF_TOKEN,
                Id: $("#id").val(),
                Nom: $("#nom").val(),
                Prenom: $("#prenom").val(),
                Courriel: $("#courriel").val(),
                Expertise: $("#expertise").val(),
                Biographie: $("#biographie").val(),
                Photo: $("#photo").val(),
                Actif: $("#actif").val()
            },
            success: function (result) {
                if (result.length > 1) {

                    $("#sectionModificationConferencier").empty();
                    $("#sectionModificationConferencier").append(result);
                    $("#tableauErreurs").replaceWith($("#tableauErreursConferencier"));
                    $("#tableauErreursConferencier").attr("id", "tableauErreurs");
                } else {
                    window.location.href = window.location.href.replace( /[\?#].*|$/, "?ongletChoisi=" + result );
                }
            },
            error: function (xhr, status, error) {
                window.location = "/VoirMessageErreur";
                //alert(xhr.responseText);
            }
        });
    }
}

// Modifie le statut actif ou inactif du conférencier
function modifierStatutConferencier(){
    if($("#actifSelecteur").find(":selected").val() == "Actif")
    {
        $('#actif').val('1');
    }
    else{
        $('#actif').val('0');
    }
}

// Permet de téléverser un fichier
function televersement() {
    $('#fileToUpload').click();
}

// Spécifie si un fichier doit être téléversé ou non
var fichierDejaValide = true;

// Affiche le nom du fichier à téléverser
function afficherNomFichier(nomDeFichier) {
    $("#texteTeleversement").text(nomDeFichier);
    $("#photo").val(nomDeFichier);
    fichierDejaValide = false;
}

// Permet de voir le formulaire de suppression d'un conférencier
function voirSupprimerConferencier(id) {
    $.ajax({
        type: 'GET',
        url: "/ConfirmerSuppressionConferencier",
        data: {
            Id: id
        },
        success: function (result) {
            $("#modal").empty();
            $("#modal").append("<div class=\"modal-backdrop fade in\"></div>" + result);
        },
        error: function (xhr, status, error) {
            window.location = "/VoirMessageErreur";
            //alert(xhr.responseText);
        }
    });
}

// Permet de voir les informations d'un conférencier
function voirConferencier(id) {
    $.ajax({
        type: 'GET',
        url: "/VoirConferencier",
        data: {
            Id: id
        },
        success: function (result) {
            $("#modal").empty();
            $("#modal").append("<div class=\"modal-backdrop fade in\"></div>" + result);
        },
        error: function (xhr, status, error) {
            window.location = "/VoirMessageErreur";
            //alert(xhr.responseText);
        }
    });
}
