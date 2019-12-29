// Permet de voir les informations d'un conférencier
function voirConferencier(id, idAtelier) {
    $.ajax({
        type: 'GET',
        url: "/VoirConferencierDescriptionAtelier",
        data: {
            Id: id,
            idAtelier: idAtelier
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
