<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       http://webcozumevi.com.tr/
 * @since      1.0.0
 *
 * @package    Eposta_Yonetimi
 * @subpackage Eposta_Yonetimi/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Eposta_Yonetimi
 * @subpackage Eposta_Yonetimi/includes
 * @author     Hasan Ali Kaya <hasan@webcozumevi.com.tr>
 */
class Eposta_Yonetimi_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'eposta-yonetimi',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
