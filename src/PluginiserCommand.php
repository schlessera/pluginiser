<?php

namespace WP_CLI\Pluginiser;

use WP_CLI_Command;

/**
 * Creates and manages plugins for the purpose of enabling use of the WP file editor.
 *
 * @since   0.1.0
 *
 * @package WP_CLI\PluginiserCommand
 * @author  Alain Schlesser <alain.schlesser@gmail.com>
 */
class PluginiserCommand extends WP_CLI_Command {

	/**
	 * Creates an empty plugin.
	 *
	 * Creates the folder for a new empty plugin and adds a placeholder file
	 * that contains basic plugin meta header information so that it is
	 * recognized within the WordPress file editor.
	 *
	 * ## OPTIONS
	 *
	 * <slug>
	 * Slug of the plugin to create.
	 *
	 * ## EXAMPLES
	 *
	 * $ wp pluginiser create my-plugin
	 * Success: Created plugin folder for plugin: "my-plugin"
	 */
	public function create( $args, $assoc_args ) {
		list( $plugin ) = $args;

		$plugin_files = new PluginFileCollection( $plugin );

		if ( $plugin_files->folder_exists() ) {
			\WP_CLI::error( "Plugin folder already exists: \"$plugin\"" );
		}

		if ( ! $plugin_files->folder_exists() && ! $plugin_files->create_folder() ) {
			\WP_CLI::error( "Could not create plugin folder for plugin: \"$plugin\"" );
		}

		if ( ! $plugin_files->init_plugin() ) {
			\WP_CLI::error( "Could not initialize plugin: \"$plugin\"" );
		}

		\WP_CLI::success( "Created plugin folder for plugin: \"$plugin\"" );
	}

	/**
	 * Adds a file to a plugin.
	 *
	 * Adds a new empty file to a given plugin. You can include subfolders in
	 * the file path that are relative to the plugin's root folder.
	 *
	 * ## OPTIONS
	 *
	 * <plugin>
	 * Slug of the plugin to add a file to.
	 *
	 * <filepath>
	 * Path and file name for the file to add. The path should be relative to
	 * the plugin root.
	 *
	 * ## EXAMPLES
	 *
	 * $ wp pluginiser add-file my-plugin subfolder/test-file.php
	 * Success: Created file "subfolder/test-file.php"
	 *
	 * @subcommand add-file
	 */
	public function add_file( $args, $assoc_args ) {
		list( $plugin, $filepath ) = $args;

		if ( 0 === strpos( $filepath, '/' ) ) {
			\WP_CLI::error( 'Absolute paths are not supported. Please provide a file or path relative to the plugin\'s root folder.' );
		}

		$plugin_files = new PluginFileCollection( $plugin );

		if ( ! $plugin_files->folder_exists() ) {
			\WP_CLI::error( "Plugin folder does not exist: \"$plugin\". Use \"wp create $plugin\" first." );
		}

		if ( $plugin_files->filepath_exists( $filepath ) ) {
			\WP_CLI::error( "The provided file path already exists: \"$filepath\"" );
		}

		if ( ! $plugin_files->add( $filepath ) ) {
			\WP_CLI::error( "Error creating file: \"$filepath\"" );
		}

		\WP_CLI::success( "Created file: \"$filepath\"" );
	}
}
