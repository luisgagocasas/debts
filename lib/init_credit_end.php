<?php
include_once('list-table-credit-end.php');

class initCreditEnd {
  public function __construct() {
    add_action('admin_menu', array($this,'credit_end_table_admin_menu'));
  }

  function credit_end_table_admin_menu() {
    add_menu_page('Credit End', 'Credit End', 'activate_plugins', 'credit_end', array($this,'credit_end_menu_init_page_handler'), 'dashicons-welcome-widgets-menus',
    2);

    add_submenu_page('credit_end','List Credit End','List Credit End', 'activate_plugins', 'credit_end', array($this,'credit_end_menu_init_page_handler'));

    add_submenu_page('credit_end', 'New Credit End', '+ New Credit End', 'activate_plugins', 'credit_end_form', array($this,'credit_end_admin_form_handler'));
  }

  function credit_end_menu_init_page_handler() {
    global $wpdb;

    $table = new Credit_End_List_Table();
    $table->prepare_items();

    $message = '';
    if ('delete' === $table->current_action()) {
      $message = '<div class="notice notice-error" id="message"><p>Credit End delete</p></div>';
    }
    ?>
    <div class="wrap">
      <div class="icon32 icon32-posts-post" id="icon-edit"><br></div>
      <h2>
        Credit End
        <a class="add-new-h2" href="<?php echo get_admin_url(get_current_blog_id(), 'admin.php?page=credit_end_form');?>">
          New Credit End
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

  function credit_end_admin_form_handler() {
    global $wpdb;
    $message = '';
    $notice = '';
    $default = array(
      'id' => 0,
      'name_user'=> '',
      'email_user'=> '',
      'phone_user'=> '',
      'situaciones'=> '',
      'capital'=> '',
      'intereses'=> '',
      'recibos' => '',
      'faltapagar' => '',
    );

    if (wp_verify_nonce($_REQUEST['nonce'], basename(__FILE__))) {
      $item = shortcode_atts($default, $_REQUEST);
      $item_valid = $this->credit_end_table_example_validate_person($item);
      if ($item_valid === true) {
        if ($item['id'] == 0) {
          $result = $wpdb->insert("{$wpdb->prefix}credit_end",
            array(
              'name_user'=> $item['name_user'],
              'email_user'=> $item['email_user'],
              'phone_user'=> $item['phone_user'],
              'situaciones'=> $item['situaciones'],
              'capital'=> $item['capital'],
              'intereses'=> $item['intereses'],
              'recibos'=> $item['recibos'],
              'faltapagar'=> $item['faltapagar'],
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
          $result = $wpdb->update("{$wpdb->prefix}credit_end",
            array(
              'id'=> $item['id'],
              'name_user'=> $item['name_user'],
              'email_user'=> $item['email_user'],
              'phone_user'=> $item['phone_user'],
              'situaciones'=> $item['situaciones'],
              'capital'=> $item['capital'],
              'intereses'=> $item['intereses'],
              'recibos'=> $item['recibos'],
              'faltapagar'=> $item['faltapagar'],
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
            "SELECT * FROM {$wpdb->prefix}credit_end WHERE id = %d",
            $_REQUEST['id']
          ), ARRAY_A
        );
        if (!$item) {
          $item = $default;
          $notice = 'Item not found';
        }
      }
    }

    add_meta_box('credit_end_form_meta_box', 'Credit End data', array($this,'credit_end_form_handler'), 'credit_end_form', 'normal', 'default'); ?>
    <div class="wrap">
      <div class="icon32 icon32-posts-post" id="icon-edit">
        <br>
      </div>
      <h2>
        Credit End
        <a class="add-new-h2" href="<?php echo get_admin_url(get_current_blog_id(), 'admin.php?page=credit_end');?>">
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
                  <?php do_meta_boxes('credit_end_form', 'normal', $item); ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
    <?php
  }

  function credit_end_form_handler($item) {
    global $wpdb; ?>
    <table cellspacing="2" cellpadding="5" style="width: 100%;" class="form-table">
      <tbody>
        <tr class="form-field">
          <th valign="top" scope="row">
            <label for="name_user">Name</label>
          </th>
          <td>
            <input id="name_user" name="name_user" type="text" style="width: 95%" value="<?php echo esc_attr($item['name_user']); ?>" size="50" class="code" required>
          </td>
          <th valign="top" scope="row">
            <label for="email_user">email_user</label>
          </th>
          <td>
            <input id="email_user" name="email_user" type="text" style="width: 95%" value="<?php echo esc_attr($item['email_user']); ?>" size="50" class="code" required>
          </td>
        </tr>
        <tr class="form-field">
          <th valign="top" scope="row">
            <label for="phone_user">phone_user</label>
          </th>
          <td>
            <input id="phone_user" name="phone_user" type="text" style="width: 95%" value="<?php echo esc_attr($item['phone_user']); ?>" size="50" class="code" required>
          </td>
          <th valign="top" scope="row">
            <label for="situaciones">situaciones</label>
          </th>
          <td>
            <input id="situaciones" name="situaciones" type="text" style="width: 95%" value="<?php echo esc_attr($item['situaciones']); ?>" size="50" class="code" required>
          </td>
        </tr>
        <tr class="form-field">
          <th valign="top" scope="row">
            <label for="capital">capital</label>
          </th>
          <td>
            <input id="capital" name="capital" type="text" style="width: 95%" value="<?php echo esc_attr($item['capital']); ?>" size="50" class="code" required>
          </td>
          <th valign="top" scope="row">
            <label for="intereses">intereses</label>
          </th>
          <td>
            <input id="intereses" name="intereses" type="text" style="width: 95%" value="<?php echo esc_attr($item['intereses']); ?>" size="50" class="code" required>
          </td>
        </tr>
        <tr class="form-field">
          <th valign="top" scope="row">
            <label for="recibos">recibos</label>
          </th>
          <td>
            <input id="recibos" name="recibos" type="text" style="width: 95%" value="<?php echo esc_attr($item['recibos']); ?>" size="50" class="code" required>
          </td>
        </tr>
      </tbody>
    </table>
    <hr>
    <table cellspacing="2" cellpadding="5" style="width: 100%;" class="form-table">
      <tbody>
        <tr class="form-field">
          <th valign="top" scope="row">
            <label for="faltapagar">faltapagar</label>
          </th>
          <td>
            <input id="faltapagar" name="faltapagar" type="text" style="width: 95%" value="<?php echo esc_attr($item['faltapagar']); ?>" size="50" class="code" required>
          </td>
        </tr>
      </tbody>
    </table>
    <?php
  }

  function credit_end_table_example_validate_person($item) {
    $messages = array();

    if (empty($item['name_user'])) $messages[] = 'name_user is required';
    if (empty($item['email_user'])) $messages[] = 'email_user is required';
    if (empty($item['phone_user'])) $messages[] = 'phone_user is required';
    if (empty($item['situaciones'])) $messages[] = 'situaciones is required';
    if (empty($item['capital'])) $messages[] = 'capital is required';
    if (empty($item['intereses'])) $messages[] = 'intereses is required';
    if (empty($item['recibos'])) $messages[] = 'recibos is required';
    if (empty($item['faltapagar'])) $messages[] = 'faltapagar is required';

    if (empty($messages)) return true;
    return implode('<br />', $messages);
  }
}