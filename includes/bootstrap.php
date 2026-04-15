<?php
/**
 * boostrap.php
 * This file is responsible for bootstrapping the application.
 * It loads the necessary configuration and initializes the application.
 * 
 * Author: James Latten <foundryframe>
 * Copyright (c) 2026 Foundry Frame, LLC. All rights reserved.
 */
namespace FoundryFrame\Includes;

require_once __DIR__ . '/loader.php';

// Initialize the application
function initialize_plugin()
{
    // Load the necessary components of the plugin
    $loader = new Loader();
    $loader->load();
}