<?php

namespace WP_CLI\Pluginiser;

use WP_Filesystem_Base;

/**
 * Class PluginFileCollection.
 *
 * @since  0.1.0
 *
 * @author Alain Schlesser <alain.schlesser@gmail.com>
 */
class PluginFileCollection {

	/** @var string Plugin slug. */
	private $slug;

	/** @var string Plugin folder. */
	private $folder;

	/** @var WP_Filesystem_Base Reference to WP_Filesystem instance. */
	private $filesystem;

	/**
	 * Instantiate a PluginFileCollection object.
	 *
	 * @param string $slug Plugin slug.
	 */
	public function __construct( $slug ) {
		$this->slug       = $slug;
		$this->folder     = $this->get_folder();
		$this->filesystem = $this->init_wp_filesystem();
	}

	/**
	 * Add a new file to the plugin.
	 *
	 * @param string $filepath File path relative to the plugin root folder.
	 *
	 * @return bool Whether adding the file succeeded.
	 */
	public function add( $filepath ) {
		$filepath   = str_replace( '\\', '/', $filepath );
		$components = explode( '/', $filepath );
		$root       = $this->folder;

		while ( count( $components ) > 1 ) {

			$subfolder = array_shift( $components );
			if ( ! is_dir( $root . $subfolder ) ) {
				$this->filesystem->mkdir( $root . $subfolder );
			}
			$root = "{$root}{$subfolder}/";
		}

		return (bool) $this->filesystem->put_contents(
			$root . $components[0],
			'<?php // Generated through Pluginiser command.' . PHP_EOL
		);
	}

	/**
	 * Check whether the plugin folder exists.
	 *
	 * @return bool Whether the plugin folder exists.
	 */
	public function folder_exists() {
		return is_dir( $this->folder );
	}

	/**
	 * Check whether the plugin folder exists.
	 *
	 * @param string $filepath File path relative to the plugin root folder.
	 *
	 * @return bool Whether the plugin folder exists.
	 */
	public function filepath_exists( $filepath ) {
		return is_file( $this->folder . $filepath );
	}

	/**
	 * Create the plugin folder.
	 *
	 * @return bool Whether creating the folder succeeded.
	 */
	public function create_folder() {
		return (bool) $this->filesystem->mkdir( $this->folder );
	}

	/**
	 * Initialize an empty folder to be recognized as a plugin.
	 *
	 * @return bool Whether creation of the plugin header file succeeded.
	 */
	public function init_plugin() {
		return (bool) $this->filesystem->put_contents(
			$this->folder . $this->slug . '.php',
			'<?php' . PHP_EOL
			. '/*' . PHP_EOL
			. ' * Plugin Name: ' . $this->slug . PHP_EOL
			. ' */' . PHP_EOL
		);
	}

	/**
	 * Get the absolute folder name of the plugin.
	 *
	 * @return string Absolute folder of the plugin.
	 */
	private function get_folder() {
		return \trailingslashit( \trailingslashit( WP_PLUGIN_DIR ) . $this->slug );
	}

	/**
	 * Initialize the WordPress Filesystem.
	 *
	 * @return WP_Filesystem_Base
	 */
	private function init_wp_filesystem() {
		global $wp_filesystem;
		\WP_Filesystem();

		return $wp_filesystem;
	}
}
