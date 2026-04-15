<?php
/**
 * testimonial-post-type.php
 * Registers the testimonial content type.
 */
namespace FoundryFrame\PostTypes;

class TestimonialPostType extends Abstract\AbstractPostType
{
    protected $post_type_name = 'testimonial';
    protected $post_type_name_singular = 'Testimonial';
    protected $post_type_name_plural = 'Testimonials';
    protected $post_type_public = true;
    protected $post_type_has_archive = true;
    protected $post_type_supports = [ 'title', 'editor', 'thumbnail' ];
    protected $post_type_taxonomies = [ 'industry', 'service_type' ];

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
            'not_found'          => 'No testimonials found.',
            'not_found_in_trash' => 'No testimonials found in Trash.',
        ];

        $args = [
            'labels'        => $labels,
            'public'        => $this->post_type_public,
            'has_archive'   => $this->post_type_has_archive,
            'supports'      => $this->post_type_supports,
            'taxonomies'    => $this->post_type_taxonomies,
            'show_in_rest'  => true,
            'menu_position' => 25,
            'menu_icon'     => 'dashicons-format-quote',
            'rewrite'       => [ 'slug' => 'testimonials', 'with_front' => false ],
        ];

        \register_post_type( $this->post_type_name, $args );
    }
}
