<?php
class Ajax {
  public function __construct() {
    add_action('wp_ajax_formDebt', [$this, 'formDebt']);
    add_action('wp_ajax_nopriv_formDebt', [$this, 'formDebt']);
  }

  function ownName($cadena) {
    $cadena=mb_convert_case($cadena, MB_CASE_TITLE, "utf8");
    return($cadena);
  }

  public function formDebt() {
    global $wpdb;

    $nonce = sanitize_text_field( $_POST['nonceT'] );
    $Nombre = wp_strip_all_tags($_POST['Nombre']);
    $Apellidos = wp_strip_all_tags($_POST['Apellidos']);
    $CorreoE = wp_strip_all_tags($_POST['CorreoE']);
    $Movil = wp_strip_all_tags($_POST['Movil']);
    $Fijo = wp_strip_all_tags($_POST['Fijo']);
    $Provincia = wp_strip_all_tags($_POST['Provincia']);
    $Postal = wp_strip_all_tags($_POST['Postal']);

    $HipotecaPendiente = wp_strip_all_tags($_POST['HipotecaPendiente']);
    $HipotecaMensual = wp_strip_all_tags($_POST['HipotecaMensual']);
    $ValorVivienda = wp_strip_all_tags($_POST['ValorVivienda']);
    $Prestamo = wp_strip_all_tags($_POST['Prestamo']);
    $PrestamoMensual = wp_strip_all_tags($_POST['PrestamoMensual']);
    $TitularEdad = wp_strip_all_tags($_POST['TitularEdad']);
    $TitularIngresosMes = wp_strip_all_tags($_POST['TitularIngresosMes']);
    $ddlTitularPagas = $_POST['ddlTitularPagas'];
    $ddlTitularContrato = $_POST['ddlTitularContrato'];

    if (wp_verify_nonce( $nonce, 'debt'))  {

      $person_model = array(
        'Nombre' => $Nombre,
        'Apellidos' => $Apellidos,
        'CorreoE' => $CorreoE,
        'Movil' => $Movil,
        'Fijo' => $Fijo,
        'Postal' => $Postal,
        'Provincia' => $Provincia,
        'HipotecaPendiente' => $HipotecaPendiente,
        'HipotecaMensual' => $HipotecaMensual,
        'ValorVivienda' => $ValorVivienda,
        'Prestamo' => $Prestamo,
        'PrestamoMensual' => $PrestamoMensual,
        'TitularEdad' => $TitularEdad,
        'TitularIngresosMes' => $TitularIngresosMes,
        'ddlTitularPagas' => $ddlTitularPagas,
        'ddlTitularContrato' => $ddlTitularContrato,
        'date_create' => time(),
      );
  
      $debt_data = $wpdb->insert("{$wpdb->prefix}debt", $person_model);
      if ($debt_data) {
        $data = array(
          "state"  =>  true,
          "data"  =>  $person_model,
          "HipotecaPendiente"  =>  $HipotecaPendiente,
        );
      } else {
        $data = array(
          "state"  =>  false,
          "data"  =>  $person_model,
          "HipotecaPendiente"  =>  $HipotecaPendiente,
        );
      }

    } else {
      $data = array(
        "status"  =>  false,
        "message"  =>  "nonce fail"
      );
    }
    wp_send_json($data);
  }
}

new Ajax();
