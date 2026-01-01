<?php
/**
 * Archive Template for LearnDash Courses
 *
 * Post type: sfwd-courses
 *
 * @package Consultio_Child
 */

get_header();
?>

    <!-- Hero Section -->
    <section class="hero-section courses-hero">
        <div class="container">
            <div class="row">
                <div class="col-lg-10">
                    <h1 data-aos="fade-up" data-aos-duration="900">
                        Fire Engineering Learning Hub
                    </h1>
                </div>
            </div>
        </div>
    </section>

    <!-- Courses Grid -->
    <section class="py-5 courses-archive">
        <div class="container d-flex gap-5">

            <?php
            // Get current filter values from query string.
            $selected_category = array();

            // Handle 'course_cat' (clean string)
            if ( isset( $_GET['course_cat'] ) && is_string( $_GET['course_cat'] ) ) {
                $raw_cat = wp_unslash( $_GET['course_cat'] );
                if ( strpos( $raw_cat, ',' ) !== false ) {
                     $selected_category = array_map( 'sanitize_text_field', explode( ',', $raw_cat ) );
                } else {
                     $selected_category = array( sanitize_text_field( $raw_cat ) );
                }
            }
            
            // Handle 'course_cat_arr' (fallback array from unchecked JS form submit)
            if ( empty( $selected_category ) && isset( $_GET['course_cat_arr'] ) ) {
                 $selected_category = array_map( 'sanitize_text_field', (array) wp_unslash( $_GET['course_cat_arr'] ) );
            }
            // Allow legacy 'course_cat[]' array if it accidentally comes through
             if ( empty( $selected_category ) && isset( $_GET['course_cat'] ) && is_array( $_GET['course_cat'] ) ) {
                 $selected_category = array_map( 'sanitize_text_field', (array) wp_unslash( $_GET['course_cat'] ) );
            }
            $selected_level    = isset( $_GET['course_level'] ) ? sanitize_text_field( wp_unslash( $_GET['course_level'] ) ) : '';
            $selected_format   = isset( $_GET['delivery_format'] ) ? sanitize_text_field( wp_unslash( $_GET['delivery_format'] ) ) : '';

            // Load LearnDash course categories (if taxonomy exists).
            $course_categories = taxonomy_exists( 'ld_course_category' )
                ? get_terms(
                    array(
                        'taxonomy'   => 'ld_course_category',
                        'hide_empty' => false,
                    )
                )
                : array();
            ?>

            <div class="courses-filter-bar mb-4 col-md-4" data-aos="fade-up" data-aos-duration="700">
                <form method="get" class="courses-filter-form">
                    <div class="row g-3 align-items-end justify-content-between gap-5">
                        <div class="col-md-12">
                            <label class="form-label"> Course Categories </label>
                            <div class="course-category-filter">
                                <?php
                                if ( ! empty( $course_categories ) && ! is_wp_error( $course_categories ) ) {


                                    // Hidden input for clean URL
                                    $initial_cats_str = implode(',', $selected_category); // Use the processed $selected_category from top
                                    echo '<input type="hidden" name="course_cat" id="course_cat_hidden" value="' . esc_attr($initial_cats_str) . '">';

                                    // Organize categories by parent for efficient recursion
                                    $cats_by_parent = array();
                                    foreach ( $course_categories as $cat ) {
                                        $cats_by_parent[ $cat->parent ][] = $cat;
                                    }

                                    // Recursive function to check for selected descendants
                                    function consultio_child_has_selected_descendant( $parent_id, $cats_map, $selected_slugs ) {
                                        if ( ! isset( $cats_map[ $parent_id ] ) ) {
                                            return false;
                                        }
                                        foreach ( $cats_map[ $parent_id ] as $child ) {
                                            if ( in_array( $child->slug, $selected_slugs ) ) {
                                                return true;
                                            }
                                            if ( consultio_child_has_selected_descendant( $child->term_id, $cats_map, $selected_slugs ) ) {
                                                return true;
                                            }
                                        }
                                        return false;
                                    }

                                    // Recursive display function
                                    function consultio_child_display_cats_hierarchical( $parent_id, $cats_map, $selected_slugs ) {
                                        if ( ! isset( $cats_map[ $parent_id ] ) ) {
                                            return;
                                        }

                                        foreach ( $cats_map[ $parent_id ] as $cat ) {
                                            $has_children = isset( $cats_map[ $cat->term_id ] );
                                            $is_selected = in_array( $cat->slug, $selected_slugs );
                                            $has_selected_child = consultio_child_has_selected_descendant( $cat->term_id, $cats_map, $selected_slugs );
                                            $is_expanded = $has_selected_child; 
                                            $toggle_symbol = $is_expanded ? '-' : '+';
                                            
                                            echo '<div class="cat-item-wrap">';
                                            echo '<label class="filter-checkbox-item">';
                                            
                                            if ( $has_children ) {
                                                echo '<span class="cat-toggle">' . $toggle_symbol . '</span>';
                                            } else {
                                                 echo '<span class="cat-spacer"></span>';
                                            }
                                            
                                            echo '<input type="checkbox" class="course-cat-checkbox" value="' . esc_attr( $cat->slug ) . '" ' . ( $is_selected ? 'checked' : '' ) . '>';
                                            echo '<span>' . esc_html( $cat->name ) . '</span>';
                                            echo '</label>';

                                            if ( $has_children ) {
                                                echo '<div class="cat-children ' . ( $is_expanded ? 'expanded' : '' ) . '">';
                                                consultio_child_display_cats_hierarchical( $cat->term_id, $cats_map, $selected_slugs );
                                                echo '</div>';
                                            }
                                            echo '</div>';
                                        }
                                    }

                                    consultio_child_display_cats_hierarchical( 0, $cats_by_parent, $selected_category );
                                }
                                ?>
                            </div>
                        </div>


                        <div class="col-md-12 d-flex filter-buttons">
                            <button type="submit" class="btn btn-red w-100 filter-submit">
                                <?php esc_html_e( 'Filter', 'consultio-child' ); ?>
                            </button>
                            <?php if ( $selected_category || $selected_level || $selected_format ) : ?>
                                <a href="<?php echo esc_url( get_post_type_archive_link( 'sfwd-courses' ) ); ?>" class="btn btn-outline-secondary d-none d-md-inline-flex">
                                    <?php esc_html_e( 'Reset', 'consultio-child' ); ?>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </form>
            </div>

            <div class="row g-4 col-md-8">
                <?php if ( have_posts() ) : ?>
                    <?php while ( have_posts() ) : the_post(); ?>
                        <?php
                        $course_id   = get_the_ID();
                        $thumbnail   = get_the_post_thumbnail_url( $course_id, 'large' );
                        $fallback    = get_stylesheet_directory_uri() . '/assets/images/logo-gray.png';
                        $bg_image    = $thumbnail ? $thumbnail : $fallback;

                        // LearnDash helpers (wrapped to avoid fatal errors if plugin is disabled)
                        $lessons_count = function_exists( 'learndash_get_course_steps_count' )
                            ? learndash_get_course_steps_count( $course_id )
                            : '';

                        $course_level = function_exists( 'learndash_get_course_meta_setting' )
                            ? learndash_get_course_meta_setting( $course_id, 'course_level' )
                            : '';

                        $course_duration = function_exists( 'learndash_get_course_meta_setting' )
                            ? learndash_get_course_meta_setting( $course_id, 'course_duration' )
                            : '';

                        // You can map these to actual LearnDash/ACF fields as needed
                        $delivery_format = get_field( 'course_delivery_format', $course_id ); // e.g., Online / Classroom / Hybrid
                        
                        // Get course price (WooCommerce integration or LearnDash pricing)
                        $course_price      = '';
                        $course_price_html = '';
                        $is_free           = true;
                        $price = 0;
                        
                        // Check if course is linked to a WooCommerce product
                        if ( class_exists( 'WooCommerce' ) ) {
                            $product_id = get_product_id_by_course_id( $course_id );
                            if ( $product_id ) {
                                $wc_enroll_url = wc_get_cart_url() . '?add-to-cart=' . $product_id;
                                $product    = wc_get_product( $product_id );
                                if ( $product ) {
                                    $price = wc_price( $product->get_price() );
                                    $is_free = false;
                                }

                            }
                        }

                        
                        // Display "Free" if no price found
                        if ( $is_free ) {
                            $course_price_html = '<span class="course-price-free">' . esc_html__( 'Free', 'consultio-child' ) . '</span>';
                        }
                        ?>

                        <div class="course-single-card">
                            <div class="course-card" data-aos="fade-up" data-aos-duration="1000">
                                <a href="<?php the_permalink(); ?>" class="course-image-link">
                                    <div class="course-image-wrapper" style="background-image: url(<?php echo esc_url( $bg_image ); ?>)">
                                        <?php if ( $thumbnail ) : ?>
                                            <img src="<?php echo esc_url( $thumbnail ); ?>"
                                                 alt="<?php the_title_attribute(); ?>"
                                                 class="course-image">
                                        <?php endif; ?>
                                        <div class="course-overlay">
                                            <div class="view-course">
                                                <span>View Course</span>
                                                <i class="bi bi-arrow-right"></i>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <div class="course-info-wrapper">
                                    <div class="d-flex align-items-center gap-2 mb-3 flex-wrap">
                                        <?php if ( $course_level ) : ?>
                                            <span class="course-badge-level">
                                                <?php echo esc_html( $course_level ); ?>
                                            </span>
                                        <?php endif; ?>

                                        <?php if ( $delivery_format ) : ?>
                                            <span class="course-badge-format">
                                                <?php echo esc_html( $delivery_format ); ?>
                                            </span>
                                        <?php endif; ?>
                                    </div>

                                    <a href="<?php the_permalink(); ?>" class="course-title-link">
                                        <h3><?php the_title(); ?></h3>
                                    </a>

                                    <div class="course-meta-small">
                                        <?php if ( $lessons_count ) : ?>
                                            <span>
                                                <i class="fas fa-layer-group"></i>
                                                <?php echo esc_html( $lessons_count ); ?> lessons
                                            </span>
                                        <?php endif; ?>

                                        <?php if ( $course_duration ) : ?>
                                            <span>
                                                <i class="far fa-clock"></i>
                                                <?php echo esc_html( $course_duration ); ?>
                                            </span>
                                        <?php endif; ?>
                                    </div>

                                    <div class="course-price-enroll">
                                        <?php //if($price): ?>
                                            <div class="course-price-wrapper d-none">
                                                <?php echo $price; ?>
                                            </div>
                                            <a href="<?= get_the_permalink() ?>" class="btn btn-red btn-enroll-now">
                                                <?php esc_html_e( 'View More', 'consultio-child' ); ?>
                                            </a>
                                        <?php //endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>

                    <div class="col-12">
                        <?php
                        the_posts_pagination(
                            array(
                                'prev_text' => __( 'Previous', 'consultio-child' ),
                                'next_text' => __( 'Next', 'consultio-child' ),
                            )
                        );
                        ?>
                    </div>

                <?php else : ?>
                    <div class="col-12 text-center mt-5">
                        <p><?php esc_html_e( 'No courses found.', 'consultio-child' ); ?></p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

<?php
// Reset postdata and load footer.
wp_reset_postdata();
get_footer();

