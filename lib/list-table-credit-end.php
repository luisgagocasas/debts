<?php
global $table_credit_end;
$table_credit_end = '0.1';

function credit_end_table_install() {
  global $wpdb;
  global $table_credit_end;

  $sql = "CREATE TABLE " . $wpdb->prefix . "credit_end (
    id int(11) NOT NULL AUTO_INCREMENT,
    NombreFull VARCHAR(200) NOT NULL,
    CorreoE VARCHAR(200) NOT NULL,
    Movil VARCHAR(200) NOT NULL,
    Situacion VARCHAR(200) NOT NULL,
    CapitalInicial VARCHAR(200) NOT NULL,
    Tae VARCHAR(200) NOT NULL,
    CuantoPagado VARCHAR(200) NOT NULL,
    CuantoFalta VARCHAR(200) NOT NULL,
    date_create VARCHAR(10) NOT NULL,
    date_update VARCHAR(10) NOT NULL,
    PRIMARY KEY (id)
  ) COLLATE {$wpdb->collate};";

  require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
  dbDelta($sql);

  add_option('table_credit_end', $table_credit_end);

  $installed_ver = get_option('table_credit_end');
  if ($installed_ver != $table_credit_end) {
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);

    update_option('table_credit_end', $table_credit_end);
  }
}
register_activation_hook(__FILE__, 'credit_end_table_install');

function credit_end_table_update_db_check() {
  global $table_credit_end;

  if (get_site_option('table_credit_end') != $table_credit_end) {
    credit_end_table_install();
  }
}

add_action('plugins_loaded', 'credit_end_table_update_db_check');

if (!class_exists('WP_List_Table')) {
  require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
}

class Credit_End_List_Table extends WP_List_Table {
  function __construct() {
    global $status, $page;

    parent::__construct(
      array(
        'singular' => 'credit_end',
        'plural'   => 'credit_ends',
      )
    );
  }

  function column_default($item, $column_name) {
    return $item[$column_name];
  }

  function column_date_create($item) {
    $resources = new Resources_Debt();
    return $resources->nicetime($item['date_create']);
  }

  function column_date_update($item) {
    $resources = new Resources_Debt();
    return $resources->nicetime($item['date_update']);
  }

  function column_Nombre($item) {
    $actions = array(
      'edit' => sprintf('<a href="?page=credit_end_form&id=%s"><strong>%s</strong></a>', $item['id'], 'Edit'),
      'delete' => sprintf('<a href="?page=%s&action=delete&id=%s"><strong>%s</strong></a>', $_REQUEST['page'], $item['id'], 'Delete'),
    );

    return sprintf('%s %s',
      $item['Nombre'],
      $this->row_actions($actions)
    );
  }

  function column_cb($item) {
    return sprintf(
      '<input type="checkbox" name="id[]" value="%s" />',
      $item['id']
    );
  }

  function get_columns() {
    $columns = array(
      'cb' => '<input type="checkbox" />',
      'Nombre' =>'Nombre',
      'date_create' => 'Fecha/Creado',
      'date_update' => 'Fecha/Actualizado',
    );

    return $columns;
  }

  function get_sortable_columns() {
    $sortable_columns = array(
      'Nombre' => array('Nombre', true),
      'date_create' => array('date_create', false),
      'date_update' => array('date_update', false),
    );

    return $sortable_columns;
  }

  function get_bulk_actions() {
    $actions = array(
      'delete' => 'Delete'
    );
    return $actions;
  }

  function process_bulk_action() {
    global $wpdb;

    if ('delete' === $this->current_action()) {
      $ids = isset($_REQUEST['id']) ? $_REQUEST['id'] : array();
      if (is_array($ids)) $ids = implode(',', $ids);

      if (!empty($ids)) {
        $wpdb->query("DELETE FROM {$wpdb->prefix}credit_end WHERE id IN($ids)");
      }
    }
  }

  function prepare_items() {
    global $wpdb;
    $per_page = 10;
    $columns = $this->get_columns();
    $hidden = array();
    $sortable = $this->get_sortable_columns();
    $this->_column_headers = array($columns, $hidden, $sortable);
    $this->process_bulk_action();

    $paged = isset($_REQUEST['paged']) ? ($per_page * max(0, intval($_REQUEST['paged']) - 1)) : 0;
    $orderby = (isset($_REQUEST['orderby']) && in_array($_REQUEST['orderby'], array_keys($this->get_sortable_columns()))) ? $_REQUEST['orderby'] : 'date_create';
    $order = (isset($_REQUEST['order']) && in_array($_REQUEST['order'], array('asc', 'desc'))) ? $_REQUEST['order'] : 'desc';

    $this->items = $wpdb->get_results(
      $wpdb->prepare(
        "SELECT * FROM {$wpdb->prefix}credit_end ORDER BY $orderby $order LIMIT %d OFFSET %d", $per_page, $paged
      ), ARRAY_A
    );

    $total_items = $wpdb->get_var("SELECT COUNT(id) FROM {$wpdb->prefix}credit_end");

    $this->set_pagination_args(
      array(
        'total_items' => $total_items,
        'per_page' => $per_page,
        'total_pages' => ceil($total_items / $per_page)
      )
    );
  }
}