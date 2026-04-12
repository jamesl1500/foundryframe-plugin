<?php

/**
 * post-types.php
 * This file is responsible for loading all the custom post types defined in the Foundry Frame plugin.
 * It includes the abstract post type class and all the specific post type classes that extend it.
 * 
 * Author: James Latten <foundryframe>
 * Copyright (c) 2026 Foundry Frame, LLC. All rights reserved.
 */

namespace FoundryFrame\Includes\Loaders;

use FoundryFrame\Config\Config;

class PostTypesLoader
{
    /**
     * $post_types
     * This property holds an array of post types that are defined in the configuration.
     * It is initialized in the constructor by fetching the post types from the Config class.
     * 
     * @var array An array of post types defined in the configuration
     */
    protected $post_types;

    /**
     * __construct
     * This constructor method initializes the PostTypesLoader class by fetching the post types from the Config class and storing them in the $post_types property.
     * 
     * @return void
     */
    public function __construct()
    {
        $this->post_types = Config::get_post_types();
    }

    /**
     * load
     * This method is responsible for loading all the post types defined in the $post_types property.
     * It iterates through each post type and includes the corresponding post type class file based on the post type name.
     * 
     * @return void
     */
    public function load()
    {
        if ($this->post_types && is_array($this->post_types)) {
            foreach ($this->post_types as $post_type) {
                // Find the post type class file based on the post type name
                $post_type_class_file = __DIR__ . '/../post-types/' . $post_type . '-post-type.php';
                
                if (file_exists($post_type_class_file)) {
                    // Require the post type class file
                    require_once $post_type_class_file;

                    // Instantiate the post type class and register the post type
                    $post_type_class_name = 'FoundryFrame\\PostTypes\\' . ucfirst($post_type) . 'PostType';

                    // Check if the post type class exists before instantiating it
                    if (class_exists($post_type_class_name)) {
                        $post_type_instance = new $post_type_class_name();

                        // Activate the post type by calling the register_post_type method
                        $post_type_instance->register_post_type();
                    }
                }
            }
        }
    }
}
