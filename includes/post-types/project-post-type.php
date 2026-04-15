<?php
/**
 * project-post-type.php
 * This file defines the ProjectPostType class, which represents the custom post type for projects in the Foundry Frame plugin.
 * It extends the AbstractPostType class and provides specific properties and functionality for the project post type.
 * 
 * Author: James Latten <foundryframe>
 * Copyright (c) 2026 Foundry Frame, LLC. All rights reserved.
 */
namespace FoundryFrame\PostTypes;

class ProjectPostType extends Abstract\AbstractPostType
{
    /**
     * $post_type_name
     * This property holds the name of the custom post type, which is 'project' in this case.
     */
    protected $post_type_name = 'project';

    /**
     * $post_type_name_singular
     * This property holds the singular name of the custom post type, which is 'Project' in this case.
     */
    protected $post_type_name_singular = 'Project';

    /**
     * $post_type_name_plural
     * This property holds the plural name of the custom post type, which is 'Projects' in this case.
     */
    protected $post_type_name_plural = 'Projects';

    /**
     * $post_type_public
     * This property indicates that the custom post type is public, meaning it can be accessed and displayed on the front end of the website.
     */
    protected $post_type_public = true;

    /**
     * $post_type_has_archive
     * This property indicates that the custom post type has an archive page, allowing users to view a list of all projects on a dedicated page.
     */
    protected $post_type_has_archive = true;

    /**
     * $post_type_supports
     * This property holds an array of features that the project post type supports, including 'title', 'editor', and 'thumbnail'.
     */
    protected $post_type_supports = [ 'title', 'editor', 'thumbnail', 'excerpt' ];

    /**
     * $post_type_taxonomies
     * This property holds an array of taxonomies that the project post type is associated with, including 'category' and 'post_tag'.
     */
    protected $post_type_taxonomies = [ 'project_category', 'service_type', 'industry', 'technology' ];

    /**
     * register_post_type
     * This method is responsible for registering the custom post type with WordPress.
     */
    public function register_post_type()
    {
        $labels = [
            'name' => $this->post_type_name_plural,
            'singular_name' => $this->post_type_name_singular,
            'menu_name' => $this->post_type_name_plural,
            'name_admin_bar' => $this->post_type_name_singular,
            'add_new' => 'Add New',
            'add_new_item' => 'Add New ' . $this->post_type_name_singular,
            'new_item' => 'New ' . $this->post_type_name_singular,
            'edit_item' => 'Edit ' . $this->post_type_name_singular,
            'view_item' => 'View ' . $this->post_type_name_singular,
            'all_items' => 'All ' . $this->post_type_name_plural,
            'search_items' => 'Search ' . $this->post_type_name_plural,
            'parent_item_colon' => 'Parent ' . $this->post_type_name_plural . ':',
            'not_found' => 'No ' . strtolower($this->post_type_name_plural) . ' found.',
            'not_found_in_trash' => 'No ' . strtolower($this->post_type_name_plural) . ' found in Trash.',
        ];

        $args = [
            'labels'        => $labels,
            'public'        => $this->post_type_public,
            'has_archive'   => $this->post_type_has_archive,
            'supports'      => $this->post_type_supports,
            'taxonomies'    => $this->post_type_taxonomies,
            'show_in_rest'  => true,
            'menu_position' => 21,
            'menu_icon'     => 'dashicons-portfolio',
            'rewrite'       => [ 'slug' => 'projects', 'with_front' => false ],
        ];

        \register_post_type( $this->post_type_name, $args );
    }

}