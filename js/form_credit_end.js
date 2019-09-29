"use strict";
var data_nonce = window.data_nonce;

jQuery(document).ready(function($) {
  var form = $("#example-form");
  form.validate({
    errorPlacement: function errorPlacement(error, element) {
      element.before(error);
    },
    rules: {
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
      console.log("casi listo para guardar la informacion ...");
      let situaciones = $("input[name='situaciones']").val();
      let capital = $("input[name='capital']").val();
      let intereses = $("input[name='intereses']").val();
      let recibos = $("input[name='recibos']").val();
      let faltapagar = $("input[name='faltapagar']").val();
      let name_user = $("input[name='name_user']").val();
      let email_user = $("input[name='email_user']").val();
      let phone_user = $("input[name='phone_user']").val();

      var fd = new FormData();
      fd.append('action', 'formCreditEnd');
      fd.append('nonceT', data_nonce);
      fd.append('situaciones', situaciones);
      fd.append('capital', capital);
      fd.append('intereses', intereses);
      fd.append('recibos', recibos);
      fd.append('faltapagar', faltapagar);
      fd.append('name_user', name_user);
      fd.append('email_user', email_user);
      fd.append('phone_user', phone_user);

      $.ajax({
        type: 'POST',
        url: data_url,
        data: fd,
        contentType: false,
        processData: false,
        error:function() {},
        success:function( r ) {
          console.log('data2: ', r);
        },
      });
    }
  });
});