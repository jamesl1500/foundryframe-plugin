<?php
/**
 * Plugin Name: Foundry Frame Plugin
 * Plugin URI: https://foundryframe.com
 * Description: A plugin to integrate Foundry Frame with WordPress.
 * Version: 1.0.0
 * Author: James Latten <Foundryframe>
 * Author URI: https://foundryframe.com
 * License: GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: foundryframe-plugin
 * 
 * foundryframe-plugin.php
 * This is the main plugin file for the Foundry Frame WordPress plugin.
 * It is responsible for initializing the plugin and loading the necessary files.
 * 
 * Author: James Latten <foundryframe>
 * Copyright (c) 2026 Foundry Frame, LLC. All rights reserved.
 */

// If this file is called directly, abort.
if (!defined('WPINC') or !defined('ABSPATH')) {
    die;
}

// Include autoload
if ( file_exists( __DIR__. '/vendor/autoload.php' ) ) {
    require_once __DIR__ . '/vendor/autoload.php';
}

// Load the define file to set up constants
require_once __DIR__ . '/includes/config/define.php';

// Load the bootstrap file to initialize the plugin
require_once __DIR__ . '/includes/bootstrap.php';

// Initialize the plugin
FoundryFrame\Includes\initialize_plugin();