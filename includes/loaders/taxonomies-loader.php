<?php
/**
 * taxonomies-loader.php
 * This file defines the TaxonomiesLoader class, which is responsible for loading and registering custom taxonomies in the Foundry Frame plugin.
 * 
 * Author: James Latten <foundryframe>
 * Copyright (c) 2026 Foundry Frame, LLC. All rights reserved.
 */
namespace FoundryFrame\Includes\Loaders;
use FoundryFrame\Config\Config;

require_once __DIR__ . '/../taxonomies/abstract/abstract-taxonomy.php';

class TaxonomiesLoader
{
    /**
     * $taxonomies
     * This property holds an array of taxonomies that are defined in the configuration.
     * It is initialized in the constructor by fetching the taxonomies from the Config class.
     * 
     * @var array An array of taxonomies defined in the configuration
     */
    protected $taxonomies;

    /**
     * __construct
     * This constructor method initializes the TaxonomiesLoader class by fetching the taxonomies from the Config class and storing them in the $taxonomies property.
     * 
     * @return void
     */
    public function __construct()
    {
        $this->taxonomies = Config::get_taxonomies();
    }

    /**
     * load
     * This method is responsible for loading all the taxonomies defined in the $taxonomies property.
     * It iterates through each taxonomy and includes the corresponding taxonomy class file based on the taxonomy name.
     * 
     * @return void
     */
    public function load()
    {
        if ( $this->taxonomies && is_array( $this->taxonomies ) ) {
            foreach ( $this->taxonomies as $taxonomy ) {
                // Find the taxonomy class file based on the taxonomy name
                $taxonomy_class_file = __DIR__ . '/../taxonomies/' . $taxonomy . '-taxonomy.php';
                
                if ( file_exists( $taxonomy_class_file ) ) {
                    // Require the taxonomy class file
                    require_once $taxonomy_class_file;

                    // Instantiate the taxonomy class and register the taxonomy
                    $taxonomy_class_name = 'FoundryFrame\\Taxonomies\\' . $this->slug_to_studly( $taxonomy ) . 'Taxonomy';

                    // Check if the taxonomy class exists before instantiating it
                    if ( class_exists( $taxonomy_class_name ) ) {
                        $taxonomy_instance = new $taxonomy_class_name();
                        $taxonomy_instance->register_taxonomy();
                    }
                }
            }
        }
    }

    /**
     * Convert a kebab/underscore slug into StudlyCase.
     *
     * @param string $slug The slug to transform.
     * @return string
     */
    protected function slug_to_studly( $slug )
    {
        $parts = preg_split( '/[-_]+/', (string) $slug );
        $parts = array_map( 'ucfirst', $parts );

        return implode( '', $parts );
    }
}