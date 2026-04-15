<?php
/**
 * abstract-taxonomy.php
 * This file defines the AbstractTaxonomy class, which serves as a base class for all custom taxonomies in the Foundry Frame plugin.
 * It provides common functionality and structure for custom taxonomies, allowing for easier development and maintenance of the plugin.
 * 
 * Author: James Latten <foundryframe>
 * Copyright (c) 2026 Foundry Frame, LLC. All rights reserved.
 */
namespace FoundryFrame\Taxonomies\Abstract;

abstract class AbstractTaxonomy
{
    /**
     * $taxonomy_name
     * This property holds the name of the custom taxonomy.
     * It should be defined by all subclasses to specify the taxonomy they represent.
     */
    protected $taxonomy_name;

    /**
     * $taxonomy_name_singular
     * This property holds the singular name of the custom taxonomy.
     * It should be defined by all subclasses to specify the singular name of the taxonomy they represent.
     */
    protected $taxonomy_name_singular;

    /**
     * $taxonomy_name_plural
     * This property holds the plural name of the custom taxonomy.
     * It should be defined by all subclasses to specify the plural name of the taxonomy they represent.
     */
    protected $taxonomy_name_plural;

    /**
     * $taxonomy_public
     * This property indicates whether the custom taxonomy is public or not.
     * It should be defined by all subclasses to specify the visibility of the taxonomy they represent
     */
    protected $taxonomy_public = true;

    /**
     * Register taxonomy with WordPress.
     *
     * @return void
     */
    abstract public function register_taxonomy();

}