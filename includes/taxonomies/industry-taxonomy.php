<?php
/**
 * industry-taxonomy.php
 * Registers industry taxonomy.
 */
namespace FoundryFrame\Taxonomies;

class IndustryTaxonomy extends Abstract\AbstractTaxonomy
{
    protected $taxonomy_name = 'industry';
    protected $taxonomy_name_singular = 'Industry';
    protected $taxonomy_name_plural = 'Industries';
    protected $taxonomy_public = true;

    public function register_taxonomy()
    {
        $labels = [
            'name'              => $this->taxonomy_name_plural,
            'singular_name'     => $this->taxonomy_name_singular,
            'search_items'      => 'Search ' . $this->taxonomy_name_plural,
            'all_items'         => 'All ' . $this->taxonomy_name_plural,
            'parent_item'       => 'Parent ' . $this->taxonomy_name_singular,
            'parent_item_colon' => 'Parent ' . $this->taxonomy_name_singular . ':',
            'edit_item'         => 'Edit ' . $this->taxonomy_name_singular,
            'update_item'       => 'Update ' . $this->taxonomy_name_singular,
            'add_new_item'      => 'Add New ' . $this->taxonomy_name_singular,
            'new_item_name'     => 'New ' . $this->taxonomy_name_singular . ' Name',
            'menu_name'         => $this->taxonomy_name_plural,
        ];

        $args = [
            'hierarchical' => true,
            'labels'       => $labels,
            'public'       => $this->taxonomy_public,
            'show_in_rest' => true,
            'rewrite'      => [ 'slug' => 'industry', 'with_front' => false ],
        ];

        \register_taxonomy( $this->taxonomy_name, [ 'project', 'case_study', 'client', 'testimonial' ], $args );
    }
}
