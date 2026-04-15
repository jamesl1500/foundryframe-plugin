<?php
/**
 * loader.php
 * This file is responsible for loading all the necessary components of the plugin.
 * It ensures that all the required files are included and that the plugin is properly initialized.
 * 
 * Author: James Latten <FoundryFrame>
 * Copyright (c) 2026 Foundry Frame, LLC. All rights reserved.
 */
namespace FoundryFrame\Includes;

// Load the post types loader to register custom post types
require_once __DIR__ . '/loaders/post-types-loader.php';
require_once __DIR__ . '/loaders/taxonomies-loader.php';
require_once __DIR__ . '/meta/meta-fields-manager.php';
require_once __DIR__ . '/admin/admin-list-table-manager.php';

class Loader
{
    /**
     * load
     * This method is responsible for loading all the necessary components of the plugin.
     * It calls the load_components method to initialize the various components of the plugin.
     * 
     * @return void
     */
    public function load()
    {
        \add_action( 'init', array( $this, 'load_components' ) );
    }

    /**
     * load_components
     * This method is responsible for loading all the necessary components of the plugin.
     * It initializes the post types loader to register custom post types.
     * 
     * @return void
     */
    public function load_components()
    {
        // Initialize the post types loader to register custom post types
        $post_types_loader = new Loaders\PostTypesLoader();
        $post_types_loader->load();

        // Initialize the taxonomies loader to register custom taxonomies.
        $taxonomies_loader = new Loaders\TaxonomiesLoader();
        $taxonomies_loader->load();

        $meta_fields_manager = new Meta\MetaFieldsManager();
        $meta_fields_manager->load();

        if ( \is_admin() ) {
            $admin_list_table_manager = new Admin\AdminListTableManager();
            $admin_list_table_manager->load();
        }

        // Flush rewrites once after activation, only after content types are registered.
        if ( \get_option( 'foundryframe_plugin_flush_rewrite' ) ) {
            \flush_rewrite_rules();
            \delete_option( 'foundryframe_plugin_flush_rewrite' );
        }
    }
}