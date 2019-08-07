<?php
global $table_debt;
$table_debt = '0.1';

function debt_table_install() {
  global $wpdb;
  global $table_debt;

  $sql = "CREATE TABLE " . $wpdb->prefix . "debt (
    id int(11) NOT NULL AUTO_INCREMENT,
    name VARCHAR(200) NOT NULL,
    HipotecaPendiente VARCHAR(200) NOT NULL,
    HipotecaMensual VARCHAR(200) NOT NULL,
    ValorVivienda VARCHAR(200) NOT NULL,
    Prestamo VARCHAR(200) NOT NULL,
    PrestamoMensual VARCHAR(200) NOT NULL,
    TitularEdad VARCHAR(200) NOT NULL,
    TitularIngresosMes VARCHAR(200) NOT NULL,
    ddlTitularPagas VARCHAR(4) NOT NULL,
    ddlTitularContrato VARCHAR(4) NOT NULL,
    date_create VARCHAR(10) NOT NULL,
    date_update VARCHAR(10) NOT NULL,
    PRIMARY KEY (id)
  ) COLLATE {$wpdb->collate};";

  require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
  dbDelta($sql);

  add_option('table_debt', $table_debt);

  $installed_ver = get_option('table_debt');
  if ($installed_ver != $table_debt) {
    $sql = "CREATE TABLE " . $wpdb->prefix . "debt (
      id int(11) NOT NULL AUTO_INCREMENT,
      name VARCHAR(200) NOT NULL,
      HipotecaPendiente VARCHAR(200) NOT NULL,
      HipotecaMensual VARCHAR(200) NOT NULL,
      ValorVivienda VARCHAR(200) NOT NULL,
      Prestamo VARCHAR(200) NOT NULL,
      PrestamoMensual VARCHAR(200) NOT NULL,
      TitularEdad VARCHAR(200) NOT NULL,
      TitularIngresosMes VARCHAR(200) NOT NULL,
      ddlTitularPagas VARCHAR(4) NOT NULL,
      ddlTitularContrato VARCHAR(4) NOT NULL,
      date_create VARCHAR(10) NOT NULL,
      date_update VARCHAR(10) NOT NULL,
      PRIMARY KEY (id)
    ) COLLATE {$wpdb->collate};";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);

    update_option('table_debt', $table_debt);
  }
}
register_activation_hook(__FILE__, 'debt_table_install');

function debt_table_update_db_check() {
  global $table_debt;

  if (get_site_option('table_debt') != $table_debt) {
    debt_table_install();
  }
}

add_action('plugins_loaded', 'debt_table_update_db_check');

if (!class_exists('WP_List_Table')) {
  require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
}

class Debt_List_Table extends WP_List_Table {
  function __construct() {
    global $status, $page;

    parent::__construct(
      array(
        'singular' => 'debt',
        'plural' => 'debts',
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

  function column_name($item) {
    $actions = array(
      'edit' => sprintf('<a href="?page=debt_form&id=%s"><strong>%s</strong></a>', $item['id'], 'Edit'),
      'delete' => sprintf('<a href="?page=%s&action=delete&id=%s"><strong>%s</strong></a>', $_REQUEST['page'], $item['id'], 'Delete'),
    );

    return sprintf('%s %s',
      $item['name'],
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
      'name' =>'Nombre',
      'date_create' => 'Fecha/Creado',
      'date_update' => 'Fecha/Actualizado',
    );

    return $columns;
  }

  function get_sortable_columns() {
    $sortable_columns = array(
      'name' => array('name', true),
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
        $wpdb->query("DELETE FROM {$wpdb->prefix}debt WHERE id IN($ids)");
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
    $orderby = (isset($_REQUEST['orderby']) && in_array($_REQUEST['orderby'], array_keys($this->get_sortable_columns()))) ? $_REQUEST['orderby'] : 'name';
    $order = (isset($_REQUEST['order']) && in_array($_REQUEST['order'], array('asc', 'desc'))) ? $_REQUEST['order'] : 'asc';

    $this->items = $wpdb->get_results(
      $wpdb->prepare(
        "SELECT * FROM {$wpdb->prefix}debt ORDER BY $orderby $order LIMIT %d OFFSET %d", $per_page, $paged
      ), ARRAY_A
    );

    $total_items = $wpdb->get_var("SELECT COUNT(id) FROM {$wpdb->prefix}debt");

    $this->set_pagination_args(
      array(
        'total_items' => $total_items,
        'per_page' => $per_page,
        'total_pages' => ceil($total_items / $per_page)
      )
    );
  }
}