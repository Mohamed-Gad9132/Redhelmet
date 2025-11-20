<?php

if (!class_exists('Consultio_Child_Custom_Taxonomies')) {
    class Consultio_Child_Custom_Taxonomies
    {
        /**
         * Singleton instance.
         *
         * @var Consultio_Child_Custom_Taxonomies|null
         */
        private static $instance = null;

        /**
         * Retrieve singleton instance.
         *
         * @return Consultio_Child_Custom_Taxonomies
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
            add_action('init', array($this, 'register_project_category_taxonomy'));
        }

        /**
         * Register the Category taxonomy for Project CPT.
         */
        public function register_project_category_taxonomy()
        {
            $labels = array(
                'name' => __('Categories', 'consultio-child'),
                'singular_name' => __('Category', 'consultio-child'),
                'menu_name' => __('Project Categories', 'consultio-child'),
                'all_items' => __('All Categories', 'consultio-child'),
                'edit_item' => __('Edit Category', 'consultio-child'),
                'view_item' => __('View Category', 'consultio-child'),
                'update_item' => __('Update Category', 'consultio-child'),
                'add_new_item' => __('Add New Category', 'consultio-child'),
                'new_item_name' => __('New Category Name', 'consultio-child'),
                'parent_item' => __('Parent Category', 'consultio-child'),
                'parent_item_colon' => __('Parent Category:', 'consultio-child'),
                'search_items' => __('Search Categories', 'consultio-child'),
                'not_found' => __('No categories found', 'consultio-child'),
                'back_to_items' => __('← Back to Categories', 'consultio-child'),
            );

            $args = array(
                'labels' => $labels,
                'hierarchical' => true,
                'show_in_rest' => true,
                'show_admin_column' => true,
                'rewrite' => array(
                    'slug' => 'project-category',
                ),
            );

            register_taxonomy('project_category', array('project'), $args);
        }
    }
}

