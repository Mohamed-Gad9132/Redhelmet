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

    // Enqueue script for course category filtering.
    wp_enqueue_script(
        'consultio-child-course-filter',
        get_stylesheet_directory_uri() . '/assets/js/filter-course-categories.js',
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
        $course_cats = array_map( 'sanitize_text_field', explode( ',', wp_unslash( $_GET['course_cat'] ) ) );
        $tax_query[] = array(
            'taxonomy' => 'ld_course_category',
            'field'    => 'slug',
            'terms'    => $course_cats,
            'operator' => 'IN',
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

function get_product_id_by_course_id( $course_id ) {
    if ( empty( $course_id ) ) {
        return false;
    }

    $args = array(
        'post_type'      => 'product',
        'posts_per_page' => 1,
        'fields'         => 'ids',
        'meta_query'     => array(
            'relation' => 'OR',
            array(
                'key'     => '_related_course',
                'value'   => '"' . (int) $course_id . '"', // Matches serialized string s:N:"ID";
                'compare' => 'LIKE'
            ),
            array(
                'key'     => '_related_course',
                'value'   => ':' . (int) $course_id . ';', // Matches serialized integer i:ID;
                'compare' => 'LIKE'
            )
        )
    );

    $query = new WP_Query( $args );

    if ( ! empty( $query->posts ) ) {
        return $query->posts[0]; // Product ID
    }

    return false;
}







/**
 * Enqueue Slick Slider and Project Slider assets.
 */
function consultio_child_enqueue_project_slider() {
    // Slick Slider CSS
    wp_enqueue_style('slick-carousel', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css');
    wp_enqueue_style('slick-theme', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css');


    // Slick Slider JS
    wp_enqueue_script('slick-carousel', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js', array('jquery'), '1.8.1', true);

}
add_action('wp_enqueue_scripts', 'consultio_child_enqueue_project_slider');

/**
 * Project Slider Shortcode
 */
function consultio_child_project_slider_shortcode($atts) {
    ob_start();

    $args = array(
        'post_type' => 'project',
        'posts_per_page' => -1,
        'post_status' => 'publish',
    );

    $query = new WP_Query($args);

    if ($query->have_posts()) : ?>
        <div class="project-slider">
            <?php while ($query->have_posts()) : $query->the_post(); ?>
                <?php
                    $post_id = get_the_ID();
                    $project_image = get_field('project_main_image', $post_id);
                    if( empty($project_image) || !isset($project_image) ):
                        $project_image = get_stylesheet_directory_uri() . '/assets/images/redhelmet-logo-main.png';
                    endif;
                ?>
                <a class="project-item" style="background-image: url('<?= $project_image ?>')" href="<?php the_permalink(); ?>">
                    <div class="project-item-inner">
                        <h3 class="project-title">
                            <span><?php the_title(); ?></span>
                        </h3>
                    </div>
                </a>
            <?php endwhile; ?>
        </div>
    <?php endif;
    wp_reset_postdata();

    return ob_get_clean();
}
add_shortcode('project_slider', 'consultio_child_project_slider_shortcode');
