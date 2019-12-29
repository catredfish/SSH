$(function () {

    $('[data-toggle="tooltip"]').tooltip();

    $(".req-input input, .req-input textarea").on("click input", function () {
        validate($(this).closest("[data-form-container]"));
        setRow(validerConferencier(),$("#spanConferencier"));
    });

    //This is for the on blur, if the form fields are all empty but the target was one of the fields do not reset to defaul state
    var currentlySelected;
    $(document).mousedown(function (e) {
        currentlySelected = $(e.target);
    });

    //Reset to form to the default state of the none of the fields were filled out
    $(".req-input input,  .req-input textarea").on("blur", function (e) {
        var Parent = $(this).closest("[data-form-container]");
        //if the target that was clicked is inside this form then do nothing
        if (typeof currentlySelected != "undefined" && currentlySelected.parent().hasClass("req-input") && Parent.attr("id") == currentlySelected.closest(".form-container").attr("id"))
            return;

        var length = 0;
        Parent.find("input").each(function () {
            length += $(this).val().length;
        });
        Parent.find("textarea").each(function () {
            length += $(this).val().length;
        });
        if (length == 0) {
            var container = $(this).closest(".form-container");
            resetForm(container);
        }
    });

    $(".create-account").on('click', function () {
        if ($(".confirm-password").is(":visible")) {
            $(this).text("Create an Account");
            $(this).closest("[data-form-container]").find(".submit-form").text("Login");
            $(".confirm-password").parent().slideUp(function () {
                validate($(this).closest("[data-form-container]"));
            });
        } else {
            $(this).closest("[data-form-container]").find(".submit-form").text("Create Account");
            $(this).text("Already Have an Account");
            $(".confirm-password").parent().slideDown(function () {
                validate($(this).closest("[data-form-container]"));
            });
        }

    });

    $("[data-toggle='tooltip']").on("mouseover", function () {
        console.log($(this).parent().attr("class"));
        if ($(this).parent().hasClass("invalid")) {
            $(".tooltip").addClass("tooltip-invalid").removeClass("tooltip-valid");
        } else if ($(this).parent().hasClass("valid")) {
            $(".tooltip").addClass("tooltip-valid").removeClass("tooltip-invalid");
        } else {
            $(".tooltip").removeClass("tooltip-invalid tooltip-valid");
        }
    });

})

//Soumet le formulaire au serveur
function modifierAtelier(){

  var CSRF_TOKEN = $('[name=_token]').val();

  //Remet la liste à 0.
  $("#liste-conferenciers").val("");
  //itère au travers des input de conférencier pour créer une liste des conférenciers sélectionnés
  $(".input-conferencier").each(function(){
    //Si l'input est sélectionné et que la liste de conférencier est vide.
    if($(this).is(':checked') && $("#liste-conferenciers").val() == ""){
      $("#liste-conferenciers").val($(this).val());
    }
    else if($(this).is(':checked')){
      $("#liste-conferenciers").val($("#liste-conferenciers").val() + ";" + $(this).val());
    }
  });

  var test = $("#liste-conferenciers").val();
  $.ajax({
        type: 'POST',
        url: "/ModifierAtelier/Modifier",
        data: {
          _token: CSRF_TOKEN,
          idAtelier: $("#idAtelier").val(),
          Nom: $("#Nom").val(),
          Endroit: $("#Endroit").val(),
          HeureDebut: $("#HeureDebut").val(),
          Duree: $("#Duree").val(),
          Description: $("#Description").val(),
          DateAtelier: $("#DateAtelier").val(),
          NombreDePlace: $("#nombreDePlaces").val(),
          idCampus: $("#selectCampus").val(),
          listeConferenciers: $("#liste-conferenciers").val()
        },
        success: function (result) {
          if(result == "success"){
             window.location = "/GestionAteliers?campusSelectionne=" + $("#inputNumeroCampusSelectionne").val() + "&dateSelectionnee=" + $("#inputDateSelectionnee").val() + "&ongletSelectionne=" + $("#inputNumeroOngletSelectionne").val();
          }
          else {
            $("#modal").empty();
            $("#modal").append(result);
          }
        },
        error: function (result){
            window.location = "/VoirMessageErreur";
        }
    });
}

function resetForm(target) {
    var container = target;
    container.find(".valid, .invalid").removeClass("valid invalid")
    container.css("background", "");
    container.css("color", "");
}

function setRow(valid, Parent) {
    var error = 0;
    if (valid) {
        Parent.addClass("valid");
        Parent.removeClass("invalid");
    } else {
        error = 1;
        Parent.addClass("invalid");
        Parent.removeClass("valid");
    }
    return error;
}

function validate(target) {
    var error = 0;
    target.find(".req-input input, .req-input textarea, .req-input select").each(function () {
        var type = $(this).attr("type");
        if ($(this).parent().hasClass("confirm-password") && type == "password") {
            var type = "confirm-password";
        }

        var Parent = $(this).parent();
        var val = $(this).val();

        if ($(this).is(":visible") == false)
            return true; //skip iteration

        switch (type) {
            case "confirm-password":
                var initialPassword = $(".input-password input").val();
                error += setRow(initialPassword == val && initialPassword.length > 0, Parent);
                break;
            case "password":
            case "textarea":
            case "text":
                var minLength = $(this).data("min-length");
                if (typeof minLength == "undefined")
                    minLength = 0;
                error += setRow(val.length >= minLength, Parent);
                if(Parent[0].id == "duree"){
                    error += setRow(validateDuree(val) >= minLength, Parent);
                }
                break;
            case "email":
                error += setRow(validateEmail(val), Parent);
                break;
            case "tel":
                error += setRow(phonenumber(val), Parent);
                break;
            case "number":
                var minLength = $(this).data("min-length");
                if (typeof minLength == "undefined")
                    minLength = 0;
                error += setRow(val.length >= minLength, Parent);
                error += setRow(val >= 1, Parent);
                break;
            case "time":
                var minLength = $(this).data("min-length");
                if (typeof minLength == "undefined")
                    minLength = 0;
                error += setRow(val.length >= minLength, Parent);
                error += setRow(validateTime(val), Parent);
                break;
            case "date":
                var minLength = $(this).data("min-length");
                if (typeof minLength == "undefined")
                    minLength = 0;
                error += setRow(val.length >= minLength, Parent);
                error += setRow(validateDateTime(val), Parent);
                break;
            case "checkbox":
                error += setRow(validerConferencier(), $("#spanConferencier"));
                break;
            default:
                error += setRow(validateCampus(val), Parent);;
        }
    });

    var submitForm = target.find(".submit-form");
    var formContainer = target;
    var formTitle = target.find(".form-title");
    if (error == 0) {
        formContainer.css("background", "#C8E6C9");
        formContainer.css("color", "#2E7D32");
        submitForm.addClass("valid");
        submitForm.removeClass("invalid");
        return true;
    } else {
        formContainer.css("background", "#FFCDD2");
        formContainer.css("color", "#C62828");
        submitForm.addClass("invalid");
        submitForm.removeClass("valid");
        return false;
    }
}

//Si un seul conférencier est sélectionné, c'est valide.
function validerConferencier(){
  return $(".input-conferencier").is(':checked');
}

function validateDuree(value){
    var regex = RegExp('^([0-1]?[0-9]|2[0-4]):([0-5][0-9])(:[0-5][0-9])?$');
    return regex.test(value);
}

function validateTime(value) {
    var regex = RegExp('^([0-1]?[0-9]|2[0-4]):([0-5][0-9])(:[0-5][0-9])?$');
    var ag = regex.test(value);
    return regex.test(value);
}

function validateCampus(value){

    if(value == "1" || value == "2" || value == "3"){
        return true;
    }
    return false;
}

function validateDateTime(value) {
    var regex = RegExp('^[0-9]{4}-[0-9]{1,2}-[0-9]{1,2}$');
    var gsagsasga = regex.test(value);
    return regex.test(value);
}

function phonenumber(inputtxt) {
    if (typeof inputtxt == "undefined")
        return;
    var phoneno = /^\d{10}$/;
    if ((inputtxt.match(phoneno))) {
        return true;
    } else {
        return false;
    }
}

function validateEmail(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}

function validateEmail(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}
