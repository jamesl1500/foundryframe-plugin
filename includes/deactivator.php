<?php
/**
 * deactivator.php
 * This file contains the code that runs when the plugin is deactivated.
 *
 * Author: James Latten <foundryframe>
 * Copyright (c) 2026 Foundry Frame, LLC. All rights reserved.
 */
namespace FoundryFrame\Includes;

/**
 * deactivate_plugin
 * This function is called when the plugin is deactivated.
 *
 * @return void
 */
function deactivate_plugin()
{
	\flush_rewrite_rules();
}
