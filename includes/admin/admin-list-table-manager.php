<?php
/**
 * admin-list-table-manager.php
 * Adds custom admin columns, sorting, and filters for agency content.
 * 
 * Author: James Latten <FoundryFrame>
 * Copyright (c) 2026 Foundry Frame, LLC. All rights reserved.
 */
namespace FoundryFrame\Includes\Admin;

class AdminListTableManager
{
    /**
     * Register admin hooks.
     *
     * @return void
     */
    public function load()
    {
        \add_filter( 'manage_project_posts_columns', [ $this, 'project_columns' ] );
        \add_action( 'manage_project_posts_custom_column', [ $this, 'render_project_columns' ], 10, 2 );
        \add_filter( 'manage_edit-project_sortable_columns', [ $this, 'project_sortable_columns' ] );

        \add_filter( 'manage_case_study_posts_columns', [ $this, 'case_study_columns' ] );
        \add_action( 'manage_case_study_posts_custom_column', [ $this, 'render_case_study_columns' ], 10, 2 );

        \add_action( 'restrict_manage_posts', [ $this, 'render_filters' ] );
        \add_action( 'pre_get_posts', [ $this, 'apply_admin_filters_and_sorting' ] );
    }

    /**
     * Add custom columns for Projects.
     *
     * @param array $columns Existing columns.
     * @return array
     */
    public function project_columns( $columns )
    {
        $columns['ff_client'] = 'Client';
        $columns['ff_service_type'] = 'Service Type';
        $columns['ff_industry'] = 'Industry';
        $columns['ff_year'] = 'Year';

        return $columns;
    }

    /**
     * Render Project column values.
     *
     * @param string $column Column name.
     * @param int    $post_id Post ID.
     * @return void
     */
    public function render_project_columns( $column, $post_id )
    {
        if ( 'ff_client' === $column ) {
            $client_id = (int) \get_post_meta( $post_id, 'ff_project_client', true );
            echo esc_html( $this->get_post_title_by_id( $client_id ) );
            return;
        }

        if ( 'ff_service_type' === $column ) {
            echo esc_html( $this->get_terms_as_text( $post_id, 'service_type' ) );
            return;
        }

        if ( 'ff_industry' === $column ) {
            echo esc_html( $this->get_terms_as_text( $post_id, 'industry' ) );
            return;
        }

        if ( 'ff_year' === $column ) {
            $year = \get_post_meta( $post_id, 'ff_project_year', true );
            echo esc_html( (string) $year );
        }
    }

    /**
     * Mark sortable columns for Projects.
     *
     * @param array $columns Existing sortable columns.
     * @return array
     */
    public function project_sortable_columns( $columns )
    {
        $columns['ff_client'] = 'ff_client';
        $columns['ff_year'] = 'ff_year';

        return $columns;
    }

    /**
     * Add custom columns for Case Studies.
     *
     * @param array $columns Existing columns.
     * @return array
     */
    public function case_study_columns( $columns )
    {
        $columns['ff_related_project'] = 'Related Project';
        $columns['ff_service_type'] = 'Service Type';
        $columns['ff_industry'] = 'Industry';

        return $columns;
    }

    /**
     * Render Case Study column values.
     *
     * @param string $column Column name.
     * @param int    $post_id Post ID.
     * @return void
     */
    public function render_case_study_columns( $column, $post_id )
    {
        if ( 'ff_related_project' === $column ) {
            $project_id = (int) \get_post_meta( $post_id, 'ff_case_related_project', true );
            echo esc_html( $this->get_post_title_by_id( $project_id ) );
            return;
        }

        if ( 'ff_service_type' === $column ) {
            echo esc_html( $this->get_terms_as_text( $post_id, 'service_type' ) );
            return;
        }

        if ( 'ff_industry' === $column ) {
            echo esc_html( $this->get_terms_as_text( $post_id, 'industry' ) );
        }
    }

    /**
     * Render list filters in wp-admin.
     *
     * @param string $post_type Current post type.
     * @return void
     */
    public function render_filters( $post_type )
    {
        if ( 'project' === $post_type ) {
            $selected_client = isset( $_GET['ff_admin_client_filter'] ) ? absint( \wp_unslash( $_GET['ff_admin_client_filter'] ) ) : 0;
            $selected_year = isset( $_GET['ff_admin_year_filter'] ) ? \sanitize_text_field( \wp_unslash( $_GET['ff_admin_year_filter'] ) ) : '';

            $this->render_client_filter_dropdown( $selected_client );
            $this->render_year_filter_dropdown( $selected_year );
            $this->render_taxonomy_filter_dropdown( 'industry', 'Industry' );
            $this->render_taxonomy_filter_dropdown( 'service_type', 'Service Type' );
        }

        if ( 'case_study' === $post_type ) {
            $this->render_taxonomy_filter_dropdown( 'industry', 'Industry' );
            $this->render_taxonomy_filter_dropdown( 'service_type', 'Service Type' );
            $this->render_taxonomy_filter_dropdown( 'project_category', 'Project Category' );
        }
    }

    /**
     * Apply selected filters and sorting rules.
     *
     * @param \WP_Query $query Query instance.
     * @return void
     */
    public function apply_admin_filters_and_sorting( $query )
    {
        if ( ! \is_admin() || ! $query->is_main_query() ) {
            return;
        }

        $post_type = $query->get( 'post_type' );

        if ( 'project' !== $post_type && 'case_study' !== $post_type ) {
            return;
        }

        $orderby = $query->get( 'orderby' );

        if ( 'project' === $post_type && 'ff_client' === $orderby ) {
            $query->set( 'meta_key', 'ff_project_client' );
            $query->set( 'orderby', 'meta_value_num' );
        }

        if ( 'project' === $post_type && 'ff_year' === $orderby ) {
            $query->set( 'meta_key', 'ff_project_year' );
            $query->set( 'orderby', 'meta_value' );
        }

        if ( 'project' === $post_type ) {
            $meta_query = [];

            if ( isset( $_GET['ff_admin_client_filter'] ) && '' !== $_GET['ff_admin_client_filter'] ) {
                $meta_query[] = [
                    'key'     => 'ff_project_client',
                    'value'   => absint( \wp_unslash( $_GET['ff_admin_client_filter'] ) ),
                    'compare' => '=',
                    'type'    => 'NUMERIC',
                ];
            }

            if ( isset( $_GET['ff_admin_year_filter'] ) && '' !== $_GET['ff_admin_year_filter'] ) {
                $meta_query[] = [
                    'key'     => 'ff_project_year',
                    'value'   => \sanitize_text_field( \wp_unslash( $_GET['ff_admin_year_filter'] ) ),
                    'compare' => '=',
                ];
            }

            if ( ! empty( $meta_query ) ) {
                $query->set( 'meta_query', $meta_query );
            }
        }
    }

    /**
     * Render taxonomy dropdown filter.
     *
     * @param string $taxonomy Taxonomy name.
     * @param string $label Label text.
     * @return void
     */
    protected function render_taxonomy_filter_dropdown( $taxonomy, $label )
    {
        if ( ! \taxonomy_exists( $taxonomy ) ) {
            return;
        }

        $selected = isset( $_GET[ $taxonomy ] ) ? \sanitize_text_field( \wp_unslash( $_GET[ $taxonomy ] ) ) : '';

        \wp_dropdown_categories(
            [
                'show_option_all' => $label,
                'taxonomy'        => $taxonomy,
                'name'            => $taxonomy,
                'orderby'         => 'name',
                'selected'        => $selected,
                'hierarchical'    => true,
                'depth'           => 3,
                'show_count'      => false,
                'hide_empty'      => false,
                'value_field'     => 'slug',
            ]
        );
    }

    /**
     * Render project client filter dropdown.
     *
     * @param int $selected_client Selected client post ID.
     * @return void
     */
    protected function render_client_filter_dropdown( $selected_client )
    {
        $clients = \get_posts(
            [
                'post_type'      => 'client',
                'post_status'    => [ 'publish', 'draft', 'pending', 'future', 'private' ],
                'posts_per_page' => 500,
                'orderby'        => 'title',
                'order'          => 'ASC',
            ]
        );

        echo '<select name="ff_admin_client_filter">';
        echo '<option value="">All Clients</option>';

        foreach ( $clients as $client ) {
            echo '<option value="' . esc_attr( (string) $client->ID ) . '" ' . selected( $selected_client, (int) $client->ID, false ) . '>' . esc_html( $client->post_title ) . '</option>';
        }

        echo '</select>';
    }

    /**
     * Render project year filter dropdown.
     *
     * @param string $selected_year Selected year.
     * @return void
     */
    protected function render_year_filter_dropdown( $selected_year )
    {
        global $wpdb;

        $years = $wpdb->get_col(
            "SELECT DISTINCT meta_value
            FROM {$wpdb->postmeta}
            WHERE meta_key = 'ff_project_year'
            AND meta_value <> ''
            ORDER BY meta_value DESC"
        );

        echo '<select name="ff_admin_year_filter">';
        echo '<option value="">All Years</option>';

        foreach ( $years as $year ) {
            $year = (string) $year;
            echo '<option value="' . esc_attr( $year ) . '" ' . selected( $selected_year, $year, false ) . '>' . esc_html( $year ) . '</option>';
        }

        echo '</select>';
    }

    /**
     * Get readable term list text.
     *
     * @param int    $post_id Post ID.
     * @param string $taxonomy Taxonomy slug.
     * @return string
     */
    protected function get_terms_as_text( $post_id, $taxonomy )
    {
        $terms = \get_the_terms( $post_id, $taxonomy );

        if ( empty( $terms ) || \is_wp_error( $terms ) ) {
            return '';
        }

        $names = \wp_list_pluck( $terms, 'name' );

        return implode( ', ', $names );
    }

    /**
     * Resolve title from related post ID.
     *
     * @param int $post_id Post ID.
     * @return string
     */
    protected function get_post_title_by_id( $post_id )
    {
        if ( $post_id <= 0 ) {
            return '';
        }

        $title = \get_the_title( $post_id );

        if ( '' === $title ) {
            return '(no title)';
        }

        return (string) $title;
    }
}
