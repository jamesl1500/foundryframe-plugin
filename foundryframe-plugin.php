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
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Include autoload
if ( file_exists( __DIR__. '/vendor/autoload.php' ) ) {
    require_once __DIR__ . '/vendor/autoload.php';
}

// Ensure config class is available before constants are defined.
require_once __DIR__ . '/includes/config/config.php';

// Load the define file to set up constants
require_once __DIR__ . '/includes/config/define.php';

// Load the bootstrap file to initialize the plugin
require_once __DIR__ . '/includes/bootstrap.php';

// Load activation/deactivation callbacks.
require_once __DIR__ . '/includes/activator.php';
require_once __DIR__ . '/includes/deactivator.php';

\register_activation_hook( __FILE__, 'FoundryFrame\\Includes\\activate_plugin' );
\register_deactivation_hook( __FILE__, 'FoundryFrame\\Includes\\deactivate_plugin' );

// Initialize the plugin
\add_action( 'plugins_loaded', 'FoundryFrame\\Includes\\initialize_plugin' );