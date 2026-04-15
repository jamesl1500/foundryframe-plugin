<?php
/**
 * project_category-taxonomy.php
 * This file defines the ProjectCategoryTaxonomy class, which represents the custom taxonomy for project categories in the Foundry Frame plugin.
 * It provides specific properties and functionality for the project category taxonomy.
 * 
 * Author: James Latten <foundryframe>
 * Copyright (c) 2026 Foundry Frame, LLC. All rights reserved.
 */
namespace FoundryFrame\Taxonomies;

class ProjectCategoryTaxonomy extends Abstract\AbstractTaxonomy
{
    /**
     * $taxonomy_name
     * This property holds the name of the custom taxonomy, which is 'project_category' in this case.
     */
    protected $taxonomy_name = 'project_category';

    /**
     * $taxonomy_name_singular
     * This property holds the singular name of the custom taxonomy, which is 'Project Category' in this case.
     */
    protected $taxonomy_name_singular = 'Project Category';

    /**
     * $taxonomy_name_plural
     * This property holds the plural name of the custom taxonomy, which is 'Project Categories' in this case.
     */
    protected $taxonomy_name_plural = 'Project Categories';

    /**
     * $taxonomy_public
     * This property indicates that the custom taxonomy is public, meaning it can be accessed and displayed on the front end of the website.
     */
    protected $taxonomy_public = true;

    /**
     * register_taxonomy
     * This method is responsible for registering the custom taxonomy with WordPress.
     */     
    public function register_taxonomy()
    {
        $labels = [
            'name' => $this->taxonomy_name_plural,
            'singular_name' => $this->taxonomy_name_singular,
            'search_items' => 'Search ' . $this->taxonomy_name_plural,
            'all_items' => 'All ' . $this->taxonomy_name_plural,
            'parent_item' => 'Parent ' . $this->taxonomy_name_singular,
            'parent_item_colon' => 'Parent ' . $this->taxonomy_name_singular . ':',
            'edit_item' => 'Edit ' . $this->taxonomy_name_singular,
            'update_item' => 'Update ' . $this->taxonomy_name_singular,
            'add_new_item' => 'Add New ' . $this->taxonomy_name_singular,
            'new_item_name' => 'New ' . $this->taxonomy_name_singular . ' Name',
            'menu_name' => $this->taxonomy_name_plural,
        ];

        $args = [
            'hierarchical' => true,
            'labels' => $labels,
            'public' => $this->taxonomy_public,
        ];

        \register_taxonomy($this->taxonomy_name, ['project'], $args);
    }
}