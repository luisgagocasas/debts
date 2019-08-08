<?php
include_once('ajax.php');

class shortcode {
  public function __construct() {
    add_shortcode( 'debt', array($this, 'shortcode_debt'));
  }

  function shortcode_debt($atts) {
    ob_start();
    wp_enqueue_style('leads/bootstrap.css', '//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css', false, null);
    wp_enqueue_script('beat/main.js', plugins_url('../js/form.js', __FILE__), ['jquery'], null, true);
    wp_enqueue_style('beat/style.css', plugins_url('../css/style.css', __FILE__), false, null);

    $atts = shortcode_atts(
      array(
        'redirect' => 'https://google.com'
      ), $atts, 'debt' );
    $this->form_public($atts);
    return ob_get_clean();
  }

  function form_public($atts) {
    global $wpdb; ?>
    <div class="only_form">
      <div class="row">
        <div class="col-12">
          <div id="message-subscribe-active"></div>
          <form id="frm_workspace" class="needs-validation" data-toggle="validator" action="#" method="post" data-url="<?php echo admin_url('admin-ajax.php'); ?>" novalidate>
            <div class="form-group">
              <label for="name" class="ax_label">Nombre *</label>
              <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="form-group">
              <label for="HipotecaPendiente" class="ax_label">¿Cuánto te queda por pagar de hipoteca?*</label>
              <input type="text" class="form-control" id="HipotecaPendiente" name="HipotecaPendiente" required>
            </div>
            <div class="form-group">
              <label for="HipotecaMensual" class="ax_label">¿Cuánto pagas al mes de hipoteca?*</label>
              <input type="text" class="form-control" id="HipotecaMensual" name="HipotecaMensual" required>
            </div>
            <div class="form-group">
              <label for="ValorVivienda" class="ax_label">Valor de la vivienda*:</label>
              <input type="text" class="form-control" id="ValorVivienda" name="ValorVivienda" required>
            </div>
            <div class="form-group">
              <label for="Prestamo" class="ax_label">¿Cuánto te queda por pagar de otros préstamos?*</label>
              <input type="text" class="form-control" id="Prestamo" name="Prestamo" required>
            </div>
            <div class="form-group">
              <label for="PrestamoMensual" class="ax_label">¿Cuánto pagas al mes de otros préstamos?*</label>
              <input type="text" class="form-control" id="PrestamoMensual" name="PrestamoMensual" required>
            </div>
            <div class="form-group">
              <label for="TitularEdad" class="ax_label">Edad del titular:*</label>
              <input type="text" class="form-control" id="TitularEdad" name="TitularEdad" required>
            </div>
            <div class="form-group">
              <label for="TitularIngresosMes" class="ax_label">Ingresos mensuales del titular:*</label>
              <input type="text" class="form-control" id="TitularIngresosMes" name="TitularIngresosMes" required>
            </div>
            <div class="form-group">
              <label for="ddlTitularPagas" class="ax_label">Nº pagas al año:</label>
              <select name="ddlTitularPagas" id="ddlTitularPagas" class="form-control" required>
                <option value="12">12</option>
                <option value="13">13</option>
                <option value="14">14</option>
                <option value="15">15</option>
                <option value="16">16</option>
              </select>

            </div>
            <div class="form-group">
              <label for="ddlTitularContrato" class="ax_label">Tipo de contrato:</label>
              <select name="ddlTitularContrato" id="ddlTitularContrato" class="form-control" required>
                <option value="1">Indefinido</option>
                <option value="2">Temporal</option>
                <option value="3">Autónomo</option>
                <option value="4">Funcionario</option>
                <option value="5">Desempleado</option>
                <option value="6">Pensionista</option>
              </select>
            </div>
            <div class="text-center text-md-left">
              <button type="submit" class="d-inline-block btn btn-success btn-action ax_btn-next-form">Calcular</button>
            </div>
            <div id="ax_status-message-ok"></div>
          </form>
          <div id="ax_status-message-error"></div>
        </div>
      </div>
      <div id="form_ajax_arcux"></div>
    </div>
    <script>
      var url_redirect = '<?php echo $atts['redirect']; ?>';
      var plugin_url = '<?php echo plugins_url('../icon/', __FILE__); ?>';
    </script>
    <?php
  }
}