<?php
/**
 * meta-fields-manager.php
 * Handles custom agency meta field registration and admin metaboxes.
 * 
 * Author: James Latten <FoundryFrame>
 * Copyright (c) 2026 Foundry Frame, LLC. All rights reserved.
 */
namespace FoundryFrame\Includes\Meta;

class MetaFieldsManager
{
    /**
     * Meta schema by post type.
     *
     * @var array<string,array<string,array<string,mixed>>>
     */
    protected $fields = [
        'project' => [
            'ff_project_client' => [ 'label' => 'Client', 'type' => 'post_select', 'post_type' => 'client' ],
            'ff_project_year' => [ 'label' => 'Project Year', 'type' => 'text' ],
            'ff_project_url' => [ 'label' => 'Project URL', 'type' => 'url' ],
            'ff_project_results' => [ 'label' => 'Key Results', 'type' => 'textarea' ],
        ],
        'case_study' => [
            'ff_case_related_project' => [ 'label' => 'Related Project', 'type' => 'post_select', 'post_type' => 'project' ],
            'ff_case_challenge' => [ 'label' => 'Challenge', 'type' => 'textarea' ],
            'ff_case_solution' => [ 'label' => 'Solution', 'type' => 'textarea' ],
            'ff_case_outcome' => [ 'label' => 'Outcome', 'type' => 'textarea' ],
            'ff_case_metrics' => [ 'label' => 'Metrics Summary', 'type' => 'text' ],
        ],
        'client' => [
            'ff_client_website' => [ 'label' => 'Client Website', 'type' => 'url' ],
            'ff_client_logo_id' => [ 'label' => 'Logo Attachment ID', 'type' => 'number' ],
            'ff_client_location' => [ 'label' => 'Location', 'type' => 'text' ],
            'ff_client_short_name' => [ 'label' => 'Short Name', 'type' => 'text' ],
        ],
        'service' => [
            'ff_service_tagline' => [ 'label' => 'Service Tagline', 'type' => 'text' ],
            'ff_service_starting_price' => [ 'label' => 'Starting Price', 'type' => 'text' ],
            'ff_service_cta_url' => [ 'label' => 'CTA URL', 'type' => 'url' ],
        ],
        'testimonial' => [
            'ff_testimonial_client' => [ 'label' => 'Client', 'type' => 'post_select', 'post_type' => 'client' ],
            'ff_testimonial_person_name' => [ 'label' => 'Person Name', 'type' => 'text' ],
            'ff_testimonial_person_role' => [ 'label' => 'Person Role', 'type' => 'text' ],
            'ff_testimonial_rating' => [ 'label' => 'Rating (1-5)', 'type' => 'number' ],
        ],
    ];

    /**
     * Hook manager actions.
     *
     * @return void
     */
    public function load()
    {
        $this->register_meta_fields();
        \add_action( 'add_meta_boxes', [ $this, 'register_meta_boxes' ] );
        \add_action( 'save_post', [ $this, 'save_meta_boxes' ] );
    }

    /**
     * Register post meta keys for REST/editor support.
     *
     * @return void
     */
    public function register_meta_fields()
    {
        foreach ( $this->fields as $post_type => $meta_fields ) {
            foreach ( $meta_fields as $meta_key => $meta_config ) {
                $type = $this->get_meta_type_for_registration( $meta_config['type'] );

                \register_post_meta(
                    $post_type,
                    $meta_key,
                    [
                        'type'              => $type,
                        'single'            => true,
                        'show_in_rest'      => true,
                        'sanitize_callback' => [ $this, 'sanitize_meta_value' ],
                        'auth_callback'     => function() {
                            return \current_user_can( 'edit_posts' );
                        },
                    ]
                );
            }
        }
    }

    /**
     * Register admin meta boxes.
     *
     * @return void
     */
    public function register_meta_boxes()
    {
        foreach ( array_keys( $this->fields ) as $post_type ) {
            \add_meta_box(
                'foundryframe_' . $post_type . '_meta',
                'Agency Details',
                [ $this, 'render_meta_box' ],
                $post_type,
                'normal',
                'default'
            );
        }
    }

    /**
     * Render all configured fields for the current post type.
     *
     * @param \WP_Post $post Current post object.
     * @return void
     */
    public function render_meta_box( $post )
    {
        $post_type = $post->post_type;

        if ( empty( $this->fields[ $post_type ] ) ) {
            return;
        }

        \wp_nonce_field( 'foundryframe_meta_box_nonce', 'foundryframe_meta_box_nonce' );

        echo '<table class="form-table" role="presentation">';

        foreach ( $this->fields[ $post_type ] as $meta_key => $meta_config ) {
            $value = \get_post_meta( $post->ID, $meta_key, true );

            echo '<tr>';
            echo '<th><label for="' . esc_attr( $meta_key ) . '">' . esc_html( $meta_config['label'] ) . '</label></th>';
            echo '<td>';

            $this->render_field_input( $meta_key, $meta_config, $value );

            echo '</td>';
            echo '</tr>';
        }

        echo '</table>';
    }

    /**
     * Save configured metadata from admin form submission.
     *
     * @param int $post_id Post ID being saved.
     * @return void
     */
    public function save_meta_boxes( $post_id )
    {
        if ( ! isset( $_POST['foundryframe_meta_box_nonce'] ) ) {
            return;
        }

        if ( ! \wp_verify_nonce( \sanitize_text_field( \wp_unslash( $_POST['foundryframe_meta_box_nonce'] ) ), 'foundryframe_meta_box_nonce' ) ) {
            return;
        }

        if ( \defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return;
        }

        if ( ! \current_user_can( 'edit_post', $post_id ) ) {
            return;
        }

        $post_type = \get_post_type( $post_id );

        if ( empty( $this->fields[ $post_type ] ) ) {
            return;
        }

        foreach ( $this->fields[ $post_type ] as $meta_key => $meta_config ) {
            if ( ! isset( $_POST[ $meta_key ] ) ) {
                continue;
            }

            $raw_value = \wp_unslash( $_POST[ $meta_key ] );
            $value = $this->sanitize_value_by_type( $raw_value, $meta_config['type'] );

            \update_post_meta( $post_id, $meta_key, $value );
        }
    }

    /**
     * Render a single input for a configured field.
     *
     * @param string $meta_key Meta key.
     * @param array  $meta_config Meta configuration.
     * @param mixed  $value Saved value.
     * @return void
     */
    protected function render_field_input( $meta_key, $meta_config, $value )
    {
        $type = $meta_config['type'];

        if ( 'textarea' === $type ) {
            echo '<textarea class="widefat" rows="4" id="' . esc_attr( $meta_key ) . '" name="' . esc_attr( $meta_key ) . '">' . esc_textarea( (string) $value ) . '</textarea>';
            return;
        }

        if ( 'post_select' === $type ) {
            $selected = absint( $value );
            $post_type = isset( $meta_config['post_type'] ) ? $meta_config['post_type'] : 'post';
            $posts = \get_posts(
                [
                    'post_type'      => $post_type,
                    'post_status'    => [ 'publish', 'draft', 'pending', 'future', 'private' ],
                    'posts_per_page' => 200,
                    'orderby'        => 'title',
                    'order'          => 'ASC',
                ]
            );

            echo '<select class="widefat" id="' . esc_attr( $meta_key ) . '" name="' . esc_attr( $meta_key ) . '">';
            echo '<option value="">Select</option>';

            foreach ( $posts as $entry ) {
                echo '<option value="' . esc_attr( (string) $entry->ID ) . '" ' . selected( $selected, (int) $entry->ID, false ) . '>' . esc_html( $entry->post_title ) . '</option>';
            }

            echo '</select>';
            return;
        }

        $input_type = 'text';

        if ( 'url' === $type ) {
            $input_type = 'url';
        } elseif ( 'number' === $type ) {
            $input_type = 'number';
        }

        echo '<input class="widefat" type="' . esc_attr( $input_type ) . '" id="' . esc_attr( $meta_key ) . '" name="' . esc_attr( $meta_key ) . '" value="' . esc_attr( (string) $value ) . '" />';
    }

    /**
     * Determine meta schema type for register_post_meta.
     *
     * @param string $field_type Field type.
     * @return string
     */
    protected function get_meta_type_for_registration( $field_type )
    {
        if ( 'number' === $field_type || 'post_select' === $field_type ) {
            return 'integer';
        }

        return 'string';
    }

    /**
     * Generic sanitizer callback for register_post_meta.
     *
     * @param mixed  $value Incoming value.
     * @param string $meta_key Meta key.
     * @return mixed
     */
    public function sanitize_meta_value( $value, $meta_key )
    {
        $field_type = 'text';

        foreach ( $this->fields as $meta_fields ) {
            if ( isset( $meta_fields[ $meta_key ] ) ) {
                $field_type = $meta_fields[ $meta_key ]['type'];
                break;
            }
        }

        return $this->sanitize_value_by_type( $value, $field_type );
    }

    /**
     * Sanitize by configured field type.
     *
     * @param mixed  $value Value to sanitize.
     * @param string $field_type Configured field type.
     * @return mixed
     */
    protected function sanitize_value_by_type( $value, $field_type )
    {
        if ( 'url' === $field_type ) {
            return \esc_url_raw( (string) $value );
        }

        if ( 'number' === $field_type || 'post_select' === $field_type ) {
            return absint( $value );
        }

        if ( 'textarea' === $field_type ) {
            return \sanitize_textarea_field( (string) $value );
        }

        return \sanitize_text_field( (string) $value );
    }
}
