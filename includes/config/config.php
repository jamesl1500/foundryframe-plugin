<?php
/**
 * config.php
 * This file contains the configuration settings for the application.
 * It includes database connection details, API keys, and other global settings.
 * 
 * Author: James Latten <foundryframe>
 * 
 * Copyright (c) 2026 Foundry Frame, LLC. All rights reserved.
 */
namespace FoundryFrame\Config;

class Config
{
    // Plugin information
    public static $plugin_name = 'Foundry Frame Plugin';
    public static $plugin_slug = 'foundryframe-plugin';
    public static $plugin_version = '1.0.0';
    public static $plugin_author = 'James Latten <Foundryframe>';

    // Plugin description and URLs
    public static $plugin_description = 'A plugin to integrate Foundry Frame with WordPress.';
    public static $plugin_uri = 'https://foundryframe.com';
    public static $plugin_author_uri = 'https://foundryframe.com';

    // Post types
    public static $post_types = [
        'project',
    ];

    /**
     * get_plugin_name
     * This method returns the plugin name.
     * 
     * @return string The plugin name
     */
    public static function get_plugin_name()
    {
        return self::$plugin_name;
    }

    /**
     * get_plugin_slug
     * This method returns the plugin slug.
     * 
     * @return string The plugin slug
     */
    public static function get_plugin_slug()
    {
        return self::$plugin_slug;
    }

    /**
     * get_plugin_version
     * This method returns the plugin version.
     * 
     * @return string The plugin version
     */
    public static function get_plugin_version()
    {
        return self::$plugin_version;
    }

    /**
     * get_plugin_author
     * This method returns the plugin author.
     * 
     * @return string The plugin author
     */
    public static function get_plugin_author()
    {
        return self::$plugin_author;
    }

    /**
     * get_plugin_description
     * This method returns the plugin description.
     * 
     * @return string The plugin description
     */
    public static function get_plugin_description()
    {
        return self::$plugin_description;
    }

    /**
     * get_plugin_uri
     * This method returns the plugin URI.
     * 
     * @return string The plugin URI
     */
    public static function get_plugin_uri()
    {
        return self::$plugin_uri;
    }

    /**
     * get_plugin_author_uri
     * This method returns the plugin author URI.
     * 
     * @return string The plugin author URI
     */
    public static function get_plugin_author_uri()
    {
        return self::$plugin_author_uri;
    }

    /**
     * get_post_types
     * This method returns the array of post types defined in the configuration.
     * 
     * @return array The array of post types
     */    
    public static function get_post_types()
    {        
        return self::$post_types;
    }
}