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
require_once get_stylesheet_directory() . '/inc/acf-data.php';

Consultio_Child_Custom_Post_Types::get_instance();
Consultio_Child_Custom_Taxonomies::get_instance();




/**
 * Check if a post has a translation in TranslatePress database.
 */
function consultio_child_has_translation($post_id, $current_lang, $default_lang) {
    global $wpdb;
    
    if (!$post_id) return false;
    
    $post = get_post($post_id);
    if (!$post || empty($post->post_title)) return false;
    
    // Table name format: wp_trp_dictionary_fr_fr_en_us
    $table = $wpdb->prefix . 'trp_dictionary_' . strtolower($current_lang) . '_' . strtolower($default_lang);
    
    // Check if table exists to avoid errors
    if ($wpdb->get_var("SHOW TABLES LIKE '$table'") != $table) {
        return false;
    }
    
    // Check if title is translated
    // status != 0 means translated (2=human, 1=auto)
    $query = $wpdb->prepare(
        "SELECT id FROM $table WHERE original = %s AND status != 0 AND translated != '' LIMIT 1",
        $post->post_title
    );
    
    return (bool) $wpdb->get_var($query);
}

add_filter('body_class', function ($classes) {

    // Check if TranslatePress is active
    if (!defined('TRP_PLUGIN_VERSION')) {
        return $classes;
    }

    // Get current language
    $current_lang = function_exists('trp_get_current_language')
        ? trp_get_current_language()
        : '';

    // Get default language
    $default_lang = get_option('trp_settings')['default_language'] ?? '';

    // If NOT default language → it's a translated view
    if ($current_lang && $default_lang && $current_lang !== $default_lang) {
        
        $is_translated = false;

        if (is_singular()) {
            global $post;
            if ($post && consultio_child_has_translation($post->ID, $current_lang, $default_lang)) {
                $is_translated = true;
            }
        } else {
            // For archives, we assume it's translated if we are in the language view
            // or we can choose to NOT add the class. 
            // Based on user request "if the post or page has translation", we'll default to true for non-singular 
            // to avoid breaking archives, or false if they want strict check.
            // Let's assume true for archives to be safe, as they are usually auto-generated.
            $is_translated = true; 
        }

        if ($is_translated) {
            $classes[] = 'is-translated';
        }
        
        $classes[] = 'lang-' . esc_attr($current_lang); // optional: lang-ar, lang-fr, etc.
    } else {
        $classes[] = 'is-default-language';
    }

    return $classes;
});



add_theme_support('learndash');

/**
 * Filter LearnDash course archive (sfwd-courses) by topic, level and format.
 */
function consultio_child_filter_learndash_courses_archive( $query ) {
    if ( is_admin() || ! $query->is_main_query() ) {
        return;
    }

    if ( ! is_post_type_archive( 'sfwd-courses' ) ) {
        return;
    }

    $tax_query  = array();
    $meta_query = array();

    // Filter by LearnDash course category taxonomy if set.
    if ( isset( $_GET['course_cat'] ) && $_GET['course_cat'] !== '' && taxonomy_exists( 'ld_course_category' ) ) {
        $tax_query[] = array(
            'taxonomy' => 'ld_course_category',
            'field'    => 'slug',
            'terms'    => sanitize_text_field( wp_unslash( $_GET['course_cat'] ) ),
        );
    }

    // Filter by course level (stored as meta).
    if ( isset( $_GET['course_level'] ) && $_GET['course_level'] !== '' ) {
        $meta_query[] = array(
            'key'     => 'course_level',
            'value'   => sanitize_text_field( wp_unslash( $_GET['course_level'] ) ),
            'compare' => '=',
        );
    }

    // Filter by delivery format (ACF field).
    if ( isset( $_GET['delivery_format'] ) && $_GET['delivery_format'] !== '' ) {
        $meta_query[] = array(
            'key'     => 'course_delivery_format',
            'value'   => sanitize_text_field( wp_unslash( $_GET['delivery_format'] ) ),
            'compare' => '=',
        );
    }

    if ( ! empty( $tax_query ) ) {
        $query->set( 'tax_query', $tax_query );
    }

    if ( ! empty( $meta_query ) ) {
        $query->set( 'meta_query', $meta_query );
    }
}
add_action( 'pre_get_posts', 'consultio_child_filter_learndash_courses_archive' );