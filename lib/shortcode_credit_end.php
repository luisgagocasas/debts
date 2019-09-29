<?php
class shortcodeCreditEnd {
  public function __construct() {
    add_shortcode( 'creditend', array($this, 'shortcode_credit_end'));
  }

  function shortcode_credit_end($atts) {
    ob_start();
    wp_enqueue_style('leads/bootstrap.css', '//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css', false, null);
    wp_enqueue_script('beat/jquery.validate.js', '//cdn.jsdelivr.net/npm/jquery-validation@1.19.1/dist/jquery.validate.js', null, true);
    wp_enqueue_script('beat/form_credit_end.js', plugins_url('../js/form_credit_end.js', __FILE__), ['jquery'], null, true);
    wp_enqueue_script('beat/jquery.steps.min.js', plugins_url('../js/jquery.steps.min.js', __FILE__), ['jquery'], null, true);
    wp_enqueue_style('beat/style.css', plugins_url('../css/style.css', __FILE__), false, null);
    wp_enqueue_style('beat/jquery.steps.css', plugins_url('../css/jquery.steps.css', __FILE__), false, null);

    $atts = shortcode_atts(
      array(
        'redirect' => 'https://google.com'
      ), $atts, 'creditend' );
    $this->form_public($atts);
    return ob_get_clean();
  }

  function form_public($atts) {
    global $wpdb; ?>
    <form id="example-form" action="#">
      <div>
        <h3></h3>
        <section>
          <div class="center-step d-flex flex-column justify-content-center">
            <h2 class="text-center">¿La deuda de tu tarjeta de crédito nunca TERMINA?</h2>
            <p class="text-center">Es posible que tengas una tarjeta con intereses abusivos, calcula ahora lo que has pagado de más o lo que podrás recuperar</p>
          </div>
        </section>
        <h3></h3>
        <section>
          <div class="center-step d-flex flex-column justify-content-center">
            <h3 class="text-center">¿En cuál de las dos situaciones te encuentras?*</h3>
            <div class="form-row align-items-center">
              <div class="col-auto my-1">
                <div class="custom-control custom-radio mr-sm-2">
                  <input type="radio" class="custom-control-input required" name="situaciones" id="situaciones_1" value="Tengo una tarjeta, me falta mucho para pagar y siento que nunca acaba">
                  <label class="custom-control-label" for="situaciones_1">Tengo una tarjeta, me falta mucho para pagar y siento que nunca acaba</label>
                </div>
              </div>
              <div class="col-auto my-1">
                <div class="custom-control custom-radio mr-sm-2">
                  <input type="radio" class="custom-control-input required" name="situaciones" id="situaciones_2" value="He tenido una tarjeta y he pagado mucho dinero">
                  <label class="custom-control-label" for="situaciones_2">He tenido una tarjeta y he pagado mucho dinero</label>
                </div>
              </div>
            </div>
          </div>
        </section>
        <h3></h3>
        <section>
          <div class="center-step d-flex flex-column justify-content-center">
            <h3 class="text-center">Capital Inicial*</h3>
            <label for="capital">El saldo disponible</label>
            <input id="capital" name="capital" type="number" class="required">
          </div>
        </section>
        <h3></h3>
        <section>
          <div class="center-step d-flex flex-column justify-content-center">
            <h3 class="text-center">¿Conoces los intereses de tu tarjeta?</h3>
            <h3 class="text-center">¿ El TAE?*</h3>
            <p>Si tienes un recibo a mano lo podrás ver</p>
            <div class="form-row align-items-center">
              <div class="col-12 my-1">
                <div class="custom-control custom-radio mr-sm-2">
                  <input type="radio" class="custom-control-input required" name="intereses" id="intereses_1" value="Si el TAE es más del 20%">
                  <label class="custom-control-label" for="intereses_1">Sí, el TAE es más del 20%</label>
                </div>
              </div>
              <div class="col-12 my-1">
                <div class="custom-control custom-radio mr-sm-2">
                  <input type="radio" class="custom-control-input required" name="intereses" id="intereses_2" value="Si el TAE es menos del 20%">
                  <label class="custom-control-label" for="intereses_2">Sí, el TAE es menos del 20%</label>
                </div>
              </div>
              <div class="col-12 my-1">
                <div class="custom-control custom-radio mr-sm-2">
                  <input type="radio" class="custom-control-input required" name="intereses" id="intereses_3" value="No conozco y no se donde encontrarlo">
                  <label class="custom-control-label" for="intereses_3">No conozco y no se donde encontrarlo</label>
                </div>
              </div>
            </div>
          </div>
        </section>
        <h3></h3>
        <section>
          <div class="center-step d-flex flex-column justify-content-center">
            <h3 class="text-center">¿Cuánto has pagado hasta ahora?*</h3>
            <label for="recibos">Tienes que sumar todos los recibos que has pagado hasta ahora</label>
            <input id="recibos" name="recibos" type="number" class="required">
          </div>
        </section>
        <h3></h3>
        <section>
          <div class="center-step d-flex flex-column justify-content-center">
            <h3 class="text-center">¿Cuánto te falta para pagar?*</h3>
            <label for="faltapagar">Tienes que sumar cuantos recibos te faltan para pagar o la cuantia que te requieren</label>
            <input id="faltapagar" name="faltapagar" type="number" class="required">
          </div>
        </section>
        <h3></h3>
        <section>
          <div class="center-step d-flex flex-column justify-content-center">
            <h3 class="text-center">¿Dónde te enviamos los resultados?</h3>
            <p>Déjanos tus datos y te enviaremos los intereses que puedes reclamar.</p>
            <label for="name_user">MI NOMBRE ES*</label>
            <input id="name_user" name="name_user" type="text" class="required">
            <label for="email_user">MI EMAIL ES*</label>
            <input id="email_user" name="email_user" type="email" class="required">
            <label for="phone_user">MI TELÉFONO ES*</label>
            <input id="phone_user" name="phone_user" type="tel" class="required">
            <div class="custom-control custom-checkbox">
              <input type="checkbox" name="acceptTerms" class="custom-control-input required" id="acceptTerms">
              <label class="custom-control-label" for="acceptTerms">Aceptar las Políticas de privacidad</label>
            </div>
            <div class="text-center message_return" id="message_return"></div>
          </div>
        </section>
      </div>
    </form>
    <script>
      var url_redirect =  '<?php echo $atts['redirect']; ?>';
      var data_url     =  '<?php echo admin_url('admin-ajax.php'); ?>';
      var data_nonce   =  '<?php echo wp_create_nonce('nonceT'); ?>'
    </script>
    <?php
  }
}