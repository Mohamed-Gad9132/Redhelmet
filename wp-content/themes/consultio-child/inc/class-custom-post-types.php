<?php

if (!class_exists('Consultio_Child_Custom_Post_Types')) {
    class Consultio_Child_Custom_Post_Types
    {
        /**
         * Singleton instance.
         *
         * @var Consultio_Child_Custom_Post_Types|null
         */
        private static $instance = null;

        /**
         * Get singleton instance.
         *
         * @return Consultio_Child_Custom_Post_Types
         */
        public static function get_instance()
        {
            if (null === self::$instance) {
                self::$instance = new self();
            }

            return self::$instance;
        }

        /**
         * Constructor.
         */
        private function __construct()
        {
            add_action('init', array($this, 'register_project_cpt'));
        }

        /**
         * Register the Project custom post type.
         */
        public function register_project_cpt()
        {
            $labels = array(
                'name' => __('Projects', 'consultio-child'),
                'singular_name' => __('Project', 'consultio-child'),
                'menu_name' => __('Projects', 'consultio-child'),
                'name_admin_bar' => __('Project', 'consultio-child'),
                'add_new' => __('Add New', 'consultio-child'),
                'add_new_item' => __('Add New Project', 'consultio-child'),
                'new_item' => __('New Project', 'consultio-child'),
                'edit_item' => __('Edit Project', 'consultio-child'),
                'view_item' => __('View Project', 'consultio-child'),
                'all_items' => __('All Projects', 'consultio-child'),
                'search_items' => __('Search Projects', 'consultio-child'),
                'parent_item_colon' => __('Parent Projects:', 'consultio-child'),
                'not_found' => __('No projects found.', 'consultio-child'),
                'not_found_in_trash' => __('No projects found in Trash.', 'consultio-child'),
                'featured_image' => __('Project Image', 'consultio-child'),
                'set_featured_image' => __('Set project image', 'consultio-child'),
                'remove_featured_image' => __('Remove project image', 'consultio-child'),
                'use_featured_image' => __('Use as project image', 'consultio-child'),
                'archives' => __('Project Archives', 'consultio-child'),
                'insert_into_item' => __('Insert into project', 'consultio-child'),
                'uploaded_to_this_item' => __('Uploaded to this project', 'consultio-child'),
            );

            $args = array(
                'labels' => $labels,
                'public' => true,
                'show_in_rest' => true,
                'has_archive' => true,
                'rewrite' => array(
                    'slug' => 'projects',
                ),
                'supports' => array(
                    'title',
                    'editor',
                    'thumbnail',
                    'excerpt',
                    'author',
                    'revisions',
                ),
                'menu_icon' => 'dashicons-portfolio',
                'menu_position' => 5,
            );

            register_post_type('project', $args);
        }
    }
}

