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

    $name = $_POST['name'];
    $HipotecaPendiente = $_POST['HipotecaPendiente'];
    $HipotecaMensual = $_POST['HipotecaMensual'];
    // $first_name = $this->ownName($_POST['first_name']);

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
}

new Ajax();
