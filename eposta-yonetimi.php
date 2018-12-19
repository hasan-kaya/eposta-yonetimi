<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://webcozumevi.com.tr/
 * @since             1.0.0
 * @package           Eposta_Yonetimi
 *
 * @wordpress-plugin
 * Plugin Name:       E-Posta Yonetimi
 * Plugin URI:        http://webcozumevi.com.tr/
 * Description:       Yönetim paneliniz üzerinden yeni eposta adresi oluşturabilir, mevcut eposta adreslerinizin bilgilerini değiştirebilirsiniz.
 * Version:           1.0.0
 * Author:            Hasan Ali Kaya
 * Author URI:        http://webcozumevi.com.tr/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       eposta-yonetimi
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'PLUGIN_NAME_VERSION', '1.0.0' );
define( 'WCE_PATH', plugin_dir_path( __FILE__ ) );
define( 'WCE_URL', plugin_dir_url( __FILE__ ) );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-eposta-yonetimi-activator.php
 */
function activate_eposta_yonetimi() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-eposta-yonetimi-activator.php';
	Eposta_Yonetimi_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-eposta-yonetimi-deactivator.php
 */
function deactivate_eposta_yonetimi() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-eposta-yonetimi-deactivator.php';
	Eposta_Yonetimi_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_eposta_yonetimi' );
register_deactivation_hook( __FILE__, 'deactivate_eposta_yonetimi' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-eposta-yonetimi.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_eposta_yonetimi() {

	$plugin = new Eposta_Yonetimi();
	$plugin->run();

}
run_eposta_yonetimi();
