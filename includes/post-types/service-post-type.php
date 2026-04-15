<?php
/**
 * service-post-type.php
 * Registers the service content type.
 * 
 * Author: James Latten <FoundryFrame>
 * Copyright (c) 2026 Foundry Frame, LLC. All rights reserved.
 */
namespace FoundryFrame\PostTypes;

class ServicePostType extends Abstract\AbstractPostType
{
    /**
     * $post_type_name
     * This property holds the name of the custom post type, which is 'service' in this case.
     */
    protected $post_type_name = 'service';

    /**
     * $post_type_name_singular
     * This property holds the singular name of the custom post type, which is 'Service' in this case.
     */
    protected $post_type_name_singular = 'Service';

    /**
     * $post_type_name_plural
     * This property holds the plural name of the custom post type, which is 'Services' in this case.
     */
    protected $post_type_name_plural = 'Services';

    /**
     * $post_type_public
     * This property indicates that the custom post type is public, meaning it can be accessed and
     */
    protected $post_type_public = true;

    /**
     * $post_type_has_archive
     * This property indicates that the custom post type has an archive page, allowing users to view a list of all services on a dedicated page.
     */
    protected $post_type_has_archive = true;

    /**
     * $post_type_supports
     * This property holds an array of features that the custom post type supports, such as title, editor, excerpt, and thumbnail.
     */
    protected $post_type_supports = [ 'title', 'editor', 'excerpt', 'thumbnail' ];

    /**
     * $post_type_taxonomies
     * This property holds an array of taxonomies associated with the custom post type, in this case, 'service_type'.
     */
    protected $post_type_taxonomies = [ 'service_type' ];

    /**
    * register_post_type
    * This method is responsible for registering the custom post type with WordPress.
    *
    * @return void
    */
    public function register_post_type()
    {
        $labels = [
            'name'               => $this->post_type_name_plural,
            'singular_name'      => $this->post_type_name_singular,
            'menu_name'          => $this->post_type_name_plural,
            'name_admin_bar'     => $this->post_type_name_singular,
            'add_new'            => 'Add New',
            'add_new_item'       => 'Add New ' . $this->post_type_name_singular,
            'new_item'           => 'New ' . $this->post_type_name_singular,
            'edit_item'          => 'Edit ' . $this->post_type_name_singular,
            'view_item'          => 'View ' . $this->post_type_name_singular,
            'all_items'          => 'All ' . $this->post_type_name_plural,
            'search_items'       => 'Search ' . $this->post_type_name_plural,
            'parent_item_colon'  => 'Parent ' . $this->post_type_name_plural . ':',
            'not_found'          => 'No services found.',
            'not_found_in_trash' => 'No services found in Trash.',
        ];

        $args = [
            'labels'        => $labels,
            'public'        => $this->post_type_public,
            'has_archive'   => $this->post_type_has_archive,
            'supports'      => $this->post_type_supports,
            'taxonomies'    => $this->post_type_taxonomies,
            'show_in_rest'  => true,
            'menu_position' => 24,
            'menu_icon'     => 'dashicons-admin-tools',
            'rewrite'       => [ 'slug' => 'services', 'with_front' => false ],
        ];

        \register_post_type( $this->post_type_name, $args );
    }
}
