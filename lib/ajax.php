<?php
class Ajax {
  public function __construct() {
    add_action('wp_ajax_formDebt', [$this, 'formDebt']);
    add_action('wp_ajax_nopriv_formDebt', [$this, 'formDebt']);
    add_action('wp_ajax_formValidate', [$this, 'formValidate']);
    add_action('wp_ajax_nopriv_formValidate', [$this, 'formValidate']);
  }

  function ownName($cadena) {
    $cadena=mb_convert_case($cadena, MB_CASE_TITLE, "utf8");
    return($cadena);
  }

  public function formDebt() {
    global $wpdb;

    $name = $this->ownName($_POST['name']);
    $HipotecaPendiente = $_POST['HipotecaPendiente'];
    $HipotecaMensual = $_POST['HipotecaMensual'];

    $person_model = array(
      'name' => $name,
      'HipotecaPendiente' => $HipotecaPendiente,
      'HipotecaMensual' => $HipotecaMensual,
      'date_create' => time(),
    );

    $lead_new = $wpdb->insert("{$wpdb->prefix}debt", $person_model);
    if ($lead_new) {
      echo 'ok';
    } else {
      echo 'error';
    }
    wp_die();
  }

  public function formValidate() {
    $nonce = sanitize_text_field( $_POST['nonceT'] );
    $hola = wp_strip_all_tags($_POST['hola']);

    if (wp_verify_nonce( $nonce, 'debt') &&  $hola)  {
      $data = array(
        "mensaje"  =>  $hola
      );

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
