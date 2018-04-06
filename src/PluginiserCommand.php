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
	 * Create an empty plugin.
	 *
	 * <slug>
	 * Slug of the plugin to create.
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

		\WP_CLI::success( "Created plugin folder for plugin: \"$plugin\"" );
	}

	/**
	 * Add a file to a plugin.
	 *
	 * <plugin>
	 * Slug of the plugin to add a file to.
	 *
	 * <filepath>
	 * Path and file name for the file to add. The patn should be relative to
	 * the plugin root.
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
