<?php
include_once('list-table-debt.php');

class initDebt {
  public function __construct() {
    add_action('admin_menu', array($this,'debt_table_admin_menu'));
  }

  function debt_table_admin_menu() {
    add_menu_page('Debt', 'Debt', 'activate_plugins', 'debt', array($this,'debt_menu_init_page_handler'), 'dashicons-welcome-widgets-menus',
    2);

    add_submenu_page('debt','List Debt','List debt', 'activate_plugins', 'debt', array($this,'debt_menu_init_page_handler'));

    add_submenu_page('debt', 'New debt', '+ New debt', 'activate_plugins', 'debt_form', array($this,'debt_admin_form_handler'));
  }

  function debt_menu_init_page_handler() {
    global $wpdb;

    $table = new Debt_List_Table();
    $table->prepare_items();

    $message = '';
    if ('delete' === $table->current_action()) {
      $message = '<div class="notice notice-error" id="message"><p>Debt delete</p></div>';
    }
    ?>
    <div class="wrap">
      <div class="icon32 icon32-posts-post" id="icon-edit"><br></div>
      <h2>
        Debt
        <a class="add-new-h2" href="<?php echo get_admin_url(get_current_blog_id(), 'admin.php?page=debt_form');?>">
          New Debt
        </a>
      </h2>
      <?php echo $message; ?>
      <form id="persons-table" method="GET">
        <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
        <?php
          $table->search_box( 'search', 'search_id' ); 
          $table->display();
        ?>
      </form>
    </div>
  <?php
  }

  function debt_admin_form_handler() {
    global $wpdb;
    $message = '';
    $notice = '';
    $default = array(
      'id' => 0,
      'name' => '',
      'HipotecaPendiente' => '',
      'HipotecaMensual' => '',
      'ValorVivienda' => '',
      'Prestamo' => '',
      'PrestamoMensual' => '',
      'TitularEdad' => '',
      'TitularIngresosMes' => '',
      'ddlTitularPagas' => '',
      'ddlTitularContrato' => '',
    );

    if (wp_verify_nonce($_REQUEST['nonce'], basename(__FILE__))) {
      $item = shortcode_atts($default, $_REQUEST);
      $item_valid = $this->debt_table_example_validate_person($item);
      if ($item_valid === true) {
        if ($item['id'] == 0) {
          echo "hola: ". $item['id'];
          $result = $wpdb->insert("{$wpdb->prefix}debt",
            array(
              'name'=> $item['name'],
              'HipotecaPendiente'=> $item['HipotecaPendiente'],
              'HipotecaMensual' => $item['HipotecaMensual'],
              'ValorVivienda' => $item['ValorVivienda'],
              'Prestamo' => $item['Prestamo'],
              'PrestamoMensual' => $item['PrestamoMensual'],
              'TitularEdad' => $item['TitularEdad'],
              'TitularIngresosMes' => $item['TitularIngresosMes'],
              'ddlTitularPagas' => $item['ddlTitularPagas'],
              'ddlTitularContrato' => $item['ddlTitularContrato'],
              'date_create' => time(),
            )
          );
          $item['id'] = $wpdb->insert_id;
          if ($result) {
            $message = 'Item was successfully create saved';
          } else {
            $notice = 'There was an error while saving item';
          }
        } else {
          $result = $wpdb->update("{$wpdb->prefix}debt",
            array(
              'id'=> $item['id'],
              'name'=> $item['name'],
              'HipotecaPendiente'=> $item['HipotecaPendiente'],
              'HipotecaMensual' => $item['HipotecaMensual'],
              'ValorVivienda' => $item['ValorVivienda'],
              'Prestamo' => $item['Prestamo'],
              'PrestamoMensual' => $item['PrestamoMensual'],
              'TitularEdad' => $item['TitularEdad'],
              'TitularIngresosMes' => $item['TitularIngresosMes'],
              'ddlTitularPagas' => $item['ddlTitularPagas'],
              'ddlTitularContrato' => $item['ddlTitularContrato'],
              'date_update' => time(),
            ), array('id'=>$item['id'])
          );

          if ($result) {
            $message = 'Item was successfully update updated';
          } else {
            $notice = 'There was an error while updating item';
          }
        }
      } else {
        $notice = $item_valid;
      }
    } else {
      $item = $default;
      if (isset($_REQUEST['id'])) {
        $item = $wpdb->get_row(
          $wpdb->prepare(
            "SELECT * FROM {$wpdb->prefix}debt WHERE id = %d",
            $_REQUEST['id']
          ), ARRAY_A
        );
        if (!$item) {
          $item = $default;
          $notice = 'Item not found';
        }
      }
    }

    add_meta_box('debt_form_meta_box', 'Debt data', array($this,'debt_form_handler'), 'debt_form', 'normal', 'default'); ?>
    <div class="wrap">
      <div class="icon32 icon32-posts-post" id="icon-edit">
        <br>
      </div>
      <h2>
        Debt
        <a class="add-new-h2" href="<?php echo get_admin_url(get_current_blog_id(), 'admin.php?page=debt');?>">
          back to list
        </a>
      </h2>

      <?php if (!empty($notice)): ?>
        <div id="notice" class="error">
          <p><?php echo $notice ?></p>
        </div>
      <?php endif;?>

      <?php if (!empty($message)): ?>
        <div id="message" class="updated"><p><?php echo $message ?></p></div>
      <?php endif;?>

      <form id="form" method="POST">
        <input type="hidden" name="nonce" value="<?php echo wp_create_nonce(basename(__FILE__))?>" />
        <input type="hidden" name="id" value="<?php echo $item['id'] ?>"/>
        <div class="metabox-holder" id="poststuff">
          <div id="post-body" class="metabox-holder columns-2">
            <div id="postbox-container-1" class="postbox-container">
              <div id="side-sortables" class="meta-box-sortables ui-sortable">
                <div id="submitdiv" class="postbox ">
                  <h2 class="hndle ui-sortable-handle"><span>Publicar</span></h2>
                  <div class="inside">
                    <div class="submitbox" id="submitpost">
                      <div id="minor-publishing">
                        <div class="misc-pub-section">
                          <p></p>
                        </div>
                      </div>
                      <div id="major-publishing-actions">
                        <div id="publishing-action">
                          <input type="submit" value="Save Person" id="submit" class="button button-primary button-large" name="submit">
                        </div>
                        <div class="clear"></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div id="postbox-container-2" class="postbox-container">
              <div id="post-body">
                <div id="post-body-content">
                  <?php do_meta_boxes('debt_form', 'normal', $item); ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
    <?php
  }

  function debt_form_handler($item) {
    global $wpdb; ?>
    <table cellspacing="2" cellpadding="5" style="width: 100%;" class="form-table">
      <tbody>
        <tr class="form-field">
          <th valign="top" scope="row">
            <label for="name">Name</label>
          </th>
          <td>
            <input id="name" name="name" type="text" style="width: 95%" value="<?php echo esc_attr($item['name']); ?>" size="50" class="code" required>
          </td>
          <th valign="top" scope="row">
            <label for="HipotecaPendiente">HipotecaPendiente</label>
          </th>
          <td>
            <input id="HipotecaPendiente" name="HipotecaPendiente" type="text" style="width: 95%" value="<?php echo esc_attr($item['HipotecaPendiente']); ?>" size="50" class="code" required>
          </td>
        <tr class="form-field">
          <th valign="top" scope="row">
            <label for="HipotecaMensual">HipotecaMensual</label>
          </th>
          <td>
            <input id="HipotecaMensual" name="HipotecaMensual" type="text" style="width: 95%" value="<?php echo esc_attr($item['HipotecaMensual']); ?>" size="50" class="code" required>
          </td>
          <th valign="top" scope="row">
            <label for="ValorVivienda">ValorVivienda</label>
          </th>
          <td>
            <input id="ValorVivienda" name="ValorVivienda" type="text" style="width: 95%" value="<?php echo esc_attr($item['ValorVivienda']); ?>" size="50" class="code" required>
          </td>
        </tr>
        <tr class="form-field">
          <th valign="top" scope="row">
            <label for="Prestamo">Prestamo</label>
          </th>
          <td>
            <input id="Prestamo" name="Prestamo" type="text" style="width: 95%" value="<?php echo esc_attr($item['Prestamo']); ?>" size="50" class="code" required>
          </td>
          <th valign="top" scope="row">
            <label for="PrestamoMensual">PrestamoMensual</label>
          </th>
          <td>
            <input id="PrestamoMensual" name="PrestamoMensual" type="text" style="width: 95%" value="<?php echo esc_attr($item['PrestamoMensual']); ?>" size="50" class="code" required>
          </td>
        </tr>
        <tr class="form-field">
          <th valign="top" scope="row">
            <label for="TitularEdad">TitularEdad</label>
          </th>
          <td>
            <input id="TitularEdad" name="TitularEdad" type="text" style="width: 95%" value="<?php echo esc_attr($item['TitularEdad']); ?>" size="50" class="code" required>
          </td>
          <th valign="top" scope="row">
            <label for="TitularIngresosMes">TitularIngresosMes</label>
          </th>
          <td>
            <input id="TitularIngresosMes" name="TitularIngresosMes" type="text" style="width: 95%" value="<?php echo esc_attr($item['TitularIngresosMes']); ?>" size="50" class="code" required>
          </td>
        </tr>
        <tr class="form-field">
          <th valign="top" scope="row">
            <label for="ddlTitularPagas">ddlTitularPagas</label>
          </th>
          <td>
            <input id="ddlTitularPagas" name="ddlTitularPagas" type="text" style="width: 95%" value="<?php echo esc_attr($item['ddlTitularPagas']); ?>" size="50" class="code" required>
          </td>
          <th valign="top" scope="row">
            <label for="ddlTitularContrato">ddlTitularContrato</label>
          </th>
          <td>
            <input id="ddlTitularContrato" name="ddlTitularContrato" type="text" style="width: 95%" value="<?php echo esc_attr($item['ddlTitularContrato']); ?>" size="50" class="code" required>
          </td>
        </tr>
      </tbody>
    </table>
    <?php
  }

  function debt_table_example_validate_person($item) {
    $messages = array();

    if (empty($item['name'])) $messages[] = 'Name name is required';
    if (empty($item['HipotecaPendiente'])) $messages[] = 'HipotecaPendiente name is required';
    if (empty($item['HipotecaMensual'])) $messages[] = 'HipotecaMensual is required';
    if (empty($item['ValorVivienda'])) $messages[] = 'ValorVivienda is required';
    if (empty($item['Prestamo'])) $messages[] = 'Prestamo is required';
    if (empty($item['PrestamoMensual'])) $messages[] = 'PrestamoMensual is required';
    if (empty($item['TitularEdad'])) $messages[] = 'TitularEdad is required';
    if (empty($item['TitularIngresosMes'])) $messages[] = 'TitularIngresosMes is required';
    if (empty($item['ddlTitularPagas'])) $messages[] = 'ddlTitularPagas is required';
    if (empty($item['ddlTitularContrato'])) $messages[] = 'ddlTitularContrato is required';

    if (empty($messages)) return true;
    return implode('<br />', $messages);
  }
}