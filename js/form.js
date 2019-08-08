jQuery(document).ready(function($) {
  const plugin_url = window.plugin_url;
  const url_redirect = window.url_redirect;

  $(document).on('submit', '#frm_workspace', function(e) {
    e.preventDefault();
    var ajaxurl = $(this).data('url');
    var name = $("#frm_workspace input[name='name']");
    var HipotecaPendiente = $("#frm_workspace input[name='HipotecaPendiente']");
    var HipotecaMensual = $("#frm_workspace input[name='HipotecaMensual']");

    if(
      name.val().length < 1 ||
      HipotecaPendiente.val().length < 1 ||
      HipotecaMensual.val().length < 1
      ) {
      $("#ax_status-message-error").html('<p>Todos los campos son requeridos.</p>');
      $("#ax_status-message-ok").html("");
    } else {
      $("#form_ajax_arcux").addClass("blocked-form");
      $(this).find('button[type=submit]').prop('disabled', true);
      $("#ax_status-message-ok").html('<p>Procesamiento en curso,<br> espere por favor ... <br /> <img src="' + plugin_url + 'loading.gif"></p>');
      $("#ax_status-message-error").html("");
      $(name).prop('disabled', true);
      $(HipotecaPendiente).prop('disabled', true);
      $(HipotecaMensual).prop('disabled', true);

      var fd = new FormData();
      fd.append('action', 'formDebt');
      fd.append('name', name.val());
      fd.append('HipotecaPendiente', HipotecaPendiente.val());
      fd.append('HipotecaMensual', HipotecaMensual.val());

      $.ajax({
        type: 'POST',
        url: ajaxurl,
        data: fd,
        contentType: false,
        processData: false,
        error:function() {},
        success:function(r) {
          console.log('data1:', r);
          if( r ) {
            $("#ax_status-message-ok").html('<p><strong>Se esta guardando tu información.</strong><br>Espere un momento ...<br /> <img src="' + plugin_url + 'loading.gif"></p>');
            $("#ax_status-message-error").html("");
            setTimeout(function() {
              window.location = url_redirect;
            }, 1000);
          } else {
            $("#ax_status-message-error").html('<p>Se produjo un error.</p>');
            $("#ax_status-message-ok").html("");
          }
        },
      });
    }
  });
});