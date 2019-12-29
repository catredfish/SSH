$(function(){

  $('[data-toggle="tooltip"]').tooltip();

  $(".req-input input, .req-input textarea").on("click input", function(){
    validate($(this).closest("[data-form-container]"));
  });

  //This is for the on blur, if the form fields are all empty but the target was one of the fields do not reset to defaul state
  var currentlySelected;
  $(document).mousedown(function(e) {
    currentlySelected = $(e.target);
  });

  //Reset to form to the default state of the none of the fields were filled out
  $(".req-input input,  .req-input textarea").on("blur", function(e){
    var Parent = $(this).closest("[data-form-container]");
    //if the target that was clicked is inside this form then do nothing
    if(typeof currentlySelected != "undefined" && currentlySelected.parent().hasClass("req-input") && Parent.attr("id") == currentlySelected.closest(".form-container").attr("id"))
    return;

    var length = 0;
    Parent.find("input").each(function(){
      length += $(this).val().length;
    });
    Parent.find("textarea").each(function(){
      length += $(this).val().length;
    });
    if(length == 0){
      var container = $(this).closest(".form-container");
      resetForm(container);
    }
  });

  $("[data-toggle='tooltip']").on("mouseover", function(){
    console.log($(this).parent().attr("class"));
    if($(this).parent().hasClass("invalid")){
      $(".tooltip").addClass("tooltip-invalid").removeClass("tooltip-valid");
    } else if($(this).parent().hasClass("valid")){
      $(".tooltip").addClass("tooltip-valid").removeClass("tooltip-invalid");
    } else {
      $(".tooltip").removeClass("tooltip-invalid tooltip-valid");
    }
  });

})

function resetForm(target){
  var container = target;
  container.find(".valid, .invalid").removeClass("valid invalid")
  container.css("background", "");
  container.css("color", "");
}

function setRow(valid, Parent){
  var error = 0;
  if(valid){
    Parent.addClass("valid");
    Parent.removeClass("invalid");
  } else {
    error = 1;
    Parent.addClass("invalid");
    Parent.removeClass("valid");
  }
  return error;
}

function validate(target){
  var error = 0;
  target.find(".req-input input").each(function(){
    var type = $(this).attr("data-connexionType");



    var Parent = $(this).parent();
    var val = $(this).val();

    if($(this).is(":visible") == false)
    return true; //skip iteration

    switch(type) {
      case "MotDePasse":
      var minLength = $(this).data("min-length");
      if(typeof minLength == "undefined")
      minLength = 0;
      error += setRow(val.length >= minLength, Parent);
      break;
      case "text":
      var minLength = $(this).data("min-length");
      if(typeof minLength == "undefined")
      minLength = 0;
      error += setRow(val.length >= minLength, Parent);
      break;
      case "etudiant":
      error += setRow(validateNumeroEtudiant(val), Parent);
      break;
      case "employe":
      error += setRow(validateNumeroEmploye(val), Parent);
      break;
      case "courriel":
      error += setRow(validateEmail(val), Parent);
      break;
    }
  });

  var submitForm = target.find(".submit-form");
  var formContainer = target;
  var formTitle = target.find(".form-title");
  if(error == 0){
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
function phonenumber(inputtxt) {
  if(typeof inputtxt == "undefined")
  return;
  var phoneno = /^\d{10}$/;
  if((inputtxt.match(phoneno))) {
    return true;
  }
  else {
    return false;
  }
}

function validateEmail(email) {
  var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  return re.test(email);
}

function validateNumeroEtudiant(numero){
  var re = /^[0-9]{7}$/;
  return re.test(numero);
}

function validateNumeroEmploye(numero){
  var re = /^[0-9]{5}$/;
  return re.test(numero);
}

function changeLoginType(type){
  switch (type) {
    case 1:
    $("#log").attr("placeholder", "Numéro d'étudiant à 7 chiffres");
    $("#log").attr("data-connexionType", "etudiant");
    $("#log-span").attr("data-original-title", "Veuillez entrer votre numéro d'étudiant.");
    $("#type-connexion").val("etudiant");
    validate($("#login-form").closest("[data-form-container]"));
    break;
    case 2:
    $("#log").attr("placeholder", "Numéro d'employé à 5 chiffres");
    $("#log").attr("data-connexionType", "employe");
    $("#log-span").attr("data-original-title", "Veuillez entrer votre numéro d'employé.");
    $("#type-connexion").val("employe");
    validate($("#login-form").closest("[data-form-container]"));
    break;
    case 3:
    $("#log").attr("placeholder", "Adresse courriel");
    $("#log").attr("data-connexionType", "courriel");
    $("#log-span").attr("data-original-title", "Veuillez entrer votre adresse courriel.");
    $("#type-connexion").val("courriel");
    validate($("#login-form").closest("[data-form-container]"));
    break;
  }
}
