<?php
/*
  Plugin Name: Plugin Deudas
  Plugin URI: https://wordpress.org
  Description: Debt
  Version: 1.0.0
  Author: WordPress
  Developer: Luis Gago Casas
  Author URI: https://wordpress.org
  * License:     GPL2
  * License URI: https://www.gnu.org/licenses/gpl-2.0.html
  * Text Domain: wordpress
*/

include_once('lib/init_debt.php');
include_once('lib/init_credit_end.php');
include_once('lib/resources.php');
include_once('lib/shortcode_debt.php');
include_once('lib/shortcode_credit_end.php');
include_once('ajax.php');
if ( ! defined( 'ABSPATH' ) )
  exit;

if ( !class_exists( 'debt' ) ) {
  class debt {
    function __construct() {
      new initDebt();
      new initCreditEnd();
      new shortCodeDebt();
      new shortcodeCreditEnd();
    }
  }
}
new debt;