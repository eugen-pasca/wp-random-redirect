<?php
/**
 *
 * Plugin Name:       WP Random Redirect
 * Plugin URI:        https://github.com/eugen-pasca/wp-random-redirect
 * Description:       Redirects to a random page
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Eugen Pasca
 * Author URI:        https://github.com/eugen-pasca/wp-random-redirect
 * Text Domain:       wp-random-redirect
 * License:           GPL v2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */


class WpRandomRedirect {

	public static $pluginFolderPath;
	public $files = [
		'admin-settings',
		'redirect-processor',
		'helper'
	];

	public function __construct() {
		$this->importFiles();

		self::$pluginFolderPath = plugin_dir_path( __FILE__ );
	}

	public function importFiles() {
		foreach ( $this->files as $file ) {
			require_once( self::$pluginFolderPath . $file . '.php' );
		}
	}
}

new WpRandomRedirect;