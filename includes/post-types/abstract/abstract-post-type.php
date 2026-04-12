<?php
/**
 * abstract-post-type.php
 * This file defines the AbstractPostType class, which serves as a base class for all custom post types in the Foundry Frame plugin.
 * It provides common functionality and structure for custom post types, allowing for easier development and maintenance of the plugin.
 * 
 * Author: James Latten <foundryframe>
 * Copyright (c) 2026 Foundry Frame, LLC. All rights reserved.
 */
namespace FoundryFrame\PostTypes\Abstract;

abstract class AbstractPostType
{
    /**
     * $post_type_name
     * This property holds the name of the custom post type.
     * It should be defined by all subclasses to specify the post type they represent.
     */
    protected $post_type_name;

    /**
     * $post_type_name_singular
     * This property holds the singular name of the custom post type.
     * It should be defined by all subclasses to specify the singular name of the post type they represent.
     */
    protected $post_type_name_singular;

    /**
     * $post_type_name_plural
     * This property holds the plural name of the custom post type.
     * It should be defined by all subclasses to specify the plural name of the post type they represent.
     */
    protected $post_type_name_plural;

    /**
     * $post_type_public
     * This property indicates whether the custom post type is public or not.
     * It should be defined by all subclasses to specify the visibility of the post type they represent
     */
    protected $post_type_public = true;

    /**
     * $post_type_has_archive
     * This property indicates whether the custom post type has an archive page or not.
     * It should be defined by all subclasses to specify whether the post type they represent has an archive page or not.
     */
    protected $post_type_has_archive = true;

    /**
     * $post_type_supports
     * This property holds an array of features that the custom post type supports.
     * It should be defined by all subclasses to specify the features that the post type they represent supports, such as 'title', 'editor', 'thumbnail', etc.
     */
    protected $post_type_supports = ['title', 'editor', 'thumbnail'];

    /**
     * $post_type_taxonomies
     * This property holds an array of taxonomies that the custom post type is associated with.
     * It should be defined by all subclasses to specify the taxonomies that the post type they represent is associated with, such as 'category', 'post_tag', etc.
     */
    protected $post_type_taxonomies;

    /**
     * register_post_type
     * This method is responsible for registering the custom post type with WordPress.
     * It should be implemented by all subclasses to define the specific post type and its properties.
     */
    abstract public function register_post_type();
}