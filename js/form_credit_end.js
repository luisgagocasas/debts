"use strict";
jQuery(document).ready(function($) {
  var form = $("#example-form");
  form.validate({
    errorPlacement: function errorPlacement(error, element) {
      element.before(error);
    },
    rules: {
      confirm: {
        equalTo: "#password"
      }
    }
  });

  form.children("div").steps({
    headerTag: "h3",
    bodyTag: "section",
    transitionEffect: "fade",
    labels: {
      finish: "¡Envíame resultados!",
      next: "Calcular ahora",
      previous: "Atrás",
    },
    onStepChanging: function (event, currentIndex, newIndex) {
      $('a[href$="next"]').text('Siguiente');
      form.validate().settings.ignore = ":disabled,:hidden";
      return form.valid();
    },
    onFinishing: function (event, currentIndex) {
      form.validate().settings.ignore = ":disabled";
      return form.valid();
    },
    onFinished: function (event, currentIndex) {
      console.log("finalizado...");
    }
  });
});