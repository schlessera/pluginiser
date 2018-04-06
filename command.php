<?php

namespace WP_CLI\Pluginiser;

if ( ! defined( 'WP_CLI' ) || ! WP_CLI ) {
	return;
}

$autoload = __DIR__ . '/vendor/autoload.php';
if ( is_readable( $autoload ) ) {
	include_once $autoload;
}

\WP_CLI::add_command( 'pluginiser', PluginiserCommand::class );
