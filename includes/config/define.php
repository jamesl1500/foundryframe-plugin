<?php
/**
 * define.php
 * This file defines constants for the plugin.
 * It is included in the bootstrap process to ensure that the constants are available throughout the plugin.
 * 
 * Author: James Latten <foundryframe>
 * Copyright (c) 2026 Foundry Frame, LLC. All rights reserved.
 */
namespace FoundryFrame\Config;

/**
 * Plugin Name
 */
if ( ! defined( 'FOUNDARY_FRAME_PLUGIN_NAME' ) ) {
	define( 'FOUNDARY_FRAME_PLUGIN_NAME', Config::get_plugin_name() );
}

/**
 * Plugin Slug
 */
if ( ! defined( 'FOUNDARY_FRAME_PLUGIN_SLUG' ) ) {
	define( 'FOUNDARY_FRAME_PLUGIN_SLUG', Config::get_plugin_slug() );
}

/**
 * Plugin Version
 */
if ( ! defined( 'FOUNDARY_FRAME_PLUGIN_VERSION' ) ) {
	define( 'FOUNDARY_FRAME_PLUGIN_VERSION', Config::get_plugin_version() );
}

/**
 * Plugin Author
 */
if ( ! defined( 'FOUNDARY_FRAME_PLUGIN_AUTHOR' ) ) {
	define( 'FOUNDARY_FRAME_PLUGIN_AUTHOR', Config::get_plugin_author() );
}

/**
 * Plugin Description
 */
if ( ! defined( 'FOUNDARY_FRAME_PLUGIN_DESCRIPTION' ) ) {
	define( 'FOUNDARY_FRAME_PLUGIN_DESCRIPTION', Config::get_plugin_description() );
}

/**
 * Plugin URI
 */
if ( ! defined( 'FOUNDARY_FRAME_PLUGIN_URI' ) ) {
	define( 'FOUNDARY_FRAME_PLUGIN_URI', Config::get_plugin_uri() );
}

/**
 * Plugin Author URI
 */
if ( ! defined( 'FOUNDARY_FRAME_PLUGIN_AUTHOR_URI' ) ) {
	define( 'FOUNDARY_FRAME_PLUGIN_AUTHOR_URI', Config::get_plugin_author_uri() );
}

/**
 * Plugin Path
 */
$plugin_root_path = dirname( __DIR__, 2 ) . '/';

if ( ! defined( 'FOUNDARY_FRAME_PLUGIN_PATH' ) ) {
	define( 'FOUNDARY_FRAME_PLUGIN_PATH', $plugin_root_path );
}

/**
 * Plugin URL
 */
if ( ! defined( 'FOUNDARY_FRAME_PLUGIN_URL' ) ) {
	define( 'FOUNDARY_FRAME_PLUGIN_URL', \plugin_dir_url( $plugin_root_path . 'foundryframe-plugin.php' ) );
}

