<?php

/**
 * Add child styles.
 * 
 * @author CaseThemes
 */
function consultio_enqueue_styles()
{
    $parent_style = 'consultio-style';
    
    wp_enqueue_style($parent_style, get_template_directory_uri() . '/style.css');
    wp_enqueue_style('child-style', get_stylesheet_directory_uri() . '/style.css', array(
        $parent_style
    ));
}

add_action('wp_enqueue_scripts', 'consultio_enqueue_styles');

require_once get_stylesheet_directory() . '/inc/class-custom-post-types.php';
require_once get_stylesheet_directory() . '/inc/custom-taxonomy.php';

Consultio_Child_Custom_Post_Types::get_instance();
Consultio_Child_Custom_Taxonomies::get_instance();
