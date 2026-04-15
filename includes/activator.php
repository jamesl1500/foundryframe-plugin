<?php
/**
 * activator.php
 * This file contains the code that runs when the plugin is activated.
 * It is responsible for setting up the necessary environment for the plugin to function properly.
 * 
 * Author: James Latten <foundryframe>
 * Copyright (c) 2026 Foundry Frame, LLC. All rights reserved.
 */
namespace FoundryFrame\Includes;

/**
 * activate_plugin
 * This function is called when the plugin is activated.
 * It performs necessary setup tasks such as creating database tables, initializing options, and flushing rewrite rules.
 * 
 * @return void
 */
function activate_plugin()
{
	\update_option( 'foundryframe_plugin_flush_rewrite', 1 );
}