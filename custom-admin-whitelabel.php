<?php
/**
 * @link              https://devnel.com
 * @since             1.0.0
 * @package           Custom_Admin_Whitelabel
 *
 * @wordpress-plugin
 * Plugin Name:       Custom Admin Whitelabel
 * Plugin URI:        https://devnel.com
 * Description:       A plugin to allow simple customisations of the admin area
 * Version:           1.0.0
 * Author:            Kyle Nel
 * Author URI:        https://devnel.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       custom-admin-whitelabel
 * Domain Path:       /languages
 */
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

/**
* Define Constants
*/
define( 'CAW_PLUGIN_PATH', plugin_dir_url( __FILE__ ) );

/**
* Include any necessary files
*/
require_once plugin_dir_path( __FILE__ ) . '/admin/admin.php';
require_once plugin_dir_path( __FILE__ ) . '/public/public.php';
