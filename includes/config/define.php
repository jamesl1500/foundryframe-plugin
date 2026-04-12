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
define('FOUNDARY_FRAME_PLUGIN_NAME', Config::get_plugin_name());

/**
 * Plugin Slug
 */
define('FOUNDARY_FRAME_PLUGIN_SLUG', Config::get_plugin_slug());

/**
 * Plugin Version
 */
define('FOUNDARY_FRAME_PLUGIN_VERSION', Config::get_plugin_version());

/**
 * Plugin Author
 */
define('FOUNDARY_FRAME_PLUGIN_AUTHOR', Config::get_plugin_author());

/**
 * Plugin Description
 */
define('FOUNDARY_FRAME_PLUGIN_DESCRIPTION', Config::get_plugin_description());

/**
 * Plugin URI
 */
define('FOUNDARY_FRAME_PLUGIN_URI', Config::get_plugin_uri());

/**
 * Plugin Author URI
 */
define('FOUNDARY_FRAME_PLUGIN_AUTHOR_URI', Config::get_plugin_author_uri());

/**
 * Plugin Path
 */
define('FOUNDARY_FRAME_PLUGIN_PATH', plugin_dir_path(__FILE__));

/**
 * Plugin URL
 */
define('FOUNDARY_FRAME_PLUGIN_URL', plugin_dir_url(__FILE__));

