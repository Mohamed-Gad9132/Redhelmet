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
    wp_enqueue_style(
        'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array($parent_style)
    );

    // Custom child theme styles.
    wp_enqueue_style(
        'consultio-child-custom-styles',
        get_stylesheet_directory_uri() . '/assets/css/custom-styles.css',
        array('child-style'),
        null
    );

    // AOS animation library styles.
    wp_enqueue_style(
        'consultio-child-aos',
        get_stylesheet_directory_uri() . '/assets/css/aos.css',
        array('child-style'),
        '2.3.4'
    );
}

add_action('wp_enqueue_scripts', 'consultio_enqueue_styles');

/**
 * Enqueue child theme scripts.
 */
function consultio_enqueue_scripts()
{
    // Bootstrap 5 bundle (includes Popper) from CDN.
    wp_enqueue_script(
        'consultio-child-bootstrap-bundle',
        get_stylesheet_directory_uri() . '/assets/js/bootstrap.bundle.min.js',
        array('jquery'),
        '5.3.2',
        true
    );

    // custom scripts.
    wp_enqueue_script(
        'consultio-child-custom-scripts',
        get_stylesheet_directory_uri() . '/assets/js/custom-scripts.js',
        array('jquery'),
        rand(0,10),
        true
    );

    // AOS animation library script + init.
    wp_enqueue_script(
        'consultio-child-aos',
        get_stylesheet_directory_uri() . '/assets/js/aos.js',
        array(),
        '2.3.4',
        true
    );

    wp_add_inline_script(
        'consultio-child-aos',
        'document.addEventListener("DOMContentLoaded", function() { if (typeof AOS !== "undefined") { AOS.init(); } });'
    );
}

add_action('wp_enqueue_scripts', 'consultio_enqueue_scripts');

require_once get_stylesheet_directory() . '/inc/class-custom-post-types.php';
require_once get_stylesheet_directory() . '/inc/custom-taxonomy.php';

Consultio_Child_Custom_Post_Types::get_instance();
Consultio_Child_Custom_Taxonomies::get_instance();
    