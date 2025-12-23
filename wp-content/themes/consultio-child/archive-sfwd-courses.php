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
                    <p data-aos="fade-up" data-aos-duration="900">
                        At Red Helmet Engineering Academy, we equip fire engineers with the practical knowledge,
                        design principles, and emergency strategies required to protect lives and property.
                        Explore our growing library of online and classroom-based courses designed for real projects,
                        real codes, and real-world fire safety challenges.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Courses Grid -->
    <section class="py-5 courses-archive">
        <div class="container">

            <?php
            // Get current filter values from query string.
            $selected_category = isset( $_GET['course_cat'] ) ? sanitize_text_field( wp_unslash( $_GET['course_cat'] ) ) : '';
            $selected_level    = isset( $_GET['course_level'] ) ? sanitize_text_field( wp_unslash( $_GET['course_level'] ) ) : '';
            $selected_format   = isset( $_GET['delivery_format'] ) ? sanitize_text_field( wp_unslash( $_GET['delivery_format'] ) ) : '';

            // Load LearnDash course categories (if taxonomy exists).
            $course_categories = taxonomy_exists( 'ld_course_category' )
                ? get_terms(
                    array(
                        'taxonomy'   => 'ld_course_category',
                        'hide_empty' => true,
                    )
                )
                : array();
            ?>

            <div class="courses-filter-bar mb-4" data-aos="fade-up" data-aos-duration="700">
                <form method="get" class="courses-filter-form">
                    <div class="row g-3 align-items-end">
                        <div class="col-md-4">
                            <label for="course_cat" class="form-label">Topic</label>
                            <select id="course_cat" name="course_cat" class="form-select">
                                <option value=""><?php esc_html_e( 'All topics', 'consultio-child' ); ?></option>
                                <?php if ( ! empty( $course_categories ) && ! is_wp_error( $course_categories ) ) : ?>
                                    <?php foreach ( $course_categories as $cat ) : ?>
                                        <option value="<?php echo esc_attr( $cat->slug ); ?>" <?php selected( $selected_category, $cat->slug ); ?>>
                                            <?php echo esc_html( $cat->name ); ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label for="course_level" class="form-label">Level</label>
                            <select id="course_level" name="course_level" class="form-select">
                                <option value=""><?php esc_html_e( 'All levels', 'consultio-child' ); ?></option>
                                <option value="Beginner" <?php selected( $selected_level, 'Beginner' ); ?>>Beginner</option>
                                <option value="Intermediate" <?php selected( $selected_level, 'Intermediate' ); ?>>Intermediate</option>
                                <option value="Advanced" <?php selected( $selected_level, 'Advanced' ); ?>>Advanced</option>
                            </select>
                        </div>


                        <div class="col-md-4 d-flex gap-2 justify-content-md-end">
                            <button type="submit" class="btn btn-red w-100">
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

            <div class="row g-4">
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

                        <div class="col-md-6 col-lg-4 course-single-card">
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
                                <div>
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
                                        <?php if($price): ?>
                                            <div class="course-price-wrapper">
                                                <?php echo $price; ?>
                                            </div>
                                            <a href="<?= $wc_enroll_url ?>" class="btn btn-red btn-enroll-now">
                                                <?php esc_html_e( 'Enroll Now', 'consultio-child' ); ?>
                                            </a>
                                        <?php endif; ?>
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
                    <div class="col-12">
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

