<?php
/**
 * Single LearnDash Course Template
 *
 * Post type: sfwd-courses
 *
 * @package Consultio_Child
 */

get_header();

$course_id   = get_the_ID();
$thumbnail   = get_the_post_thumbnail_url( $course_id, 'full' );
$fallback    = get_stylesheet_directory_uri() . '/assets/images/logo-gray.png';
$bg_image    = $thumbnail ? $thumbnail : $fallback;

// LearnDash metadata (wrapped with function_exists to prevent fatals)
$lessons_count = function_exists( 'learndash_get_course_steps_count' )
    ? learndash_get_course_steps_count( $course_id )
    : '';

$course_level = function_exists( 'learndash_get_course_meta_setting' )
    ? learndash_get_course_meta_setting( $course_id, 'course_level' )
    : '';

$course_duration = function_exists( 'learndash_get_course_meta_setting' )
    ? learndash_get_course_meta_setting( $course_id, 'course_duration' )
    : '';

$course_prereqs = function_exists( 'learndash_get_course_meta_setting' )
    ? learndash_get_course_meta_setting( $course_id, 'course_prerequisite' )
    : '';

$course_price_type = function_exists( 'learndash_get_course_meta_setting' )
    ? learndash_get_course_meta_setting( $course_id, 'course_price_type' )
    : '';

// Custom fields (optional, via ACF or similar)
$delivery_format = get_field( 'course_delivery_format', $course_id ); // Online / Classroom / Hybrid
$target_audience = get_field( 'course_target_audience', $course_id );
$key_outcomes    = get_field( 'course_key_outcomes', $course_id ); // repeater or list
$course_language = get_field( 'course_language', $course_id );
$course_location = get_field( 'course_location', $course_id ); // for classroom / hybrid

// Check if user is enrolled in the course
$user_id = get_current_user_id();
$is_enrolled = false;

if ( function_exists( 'sfwd_lms_has_access' ) ) {
    $is_enrolled = sfwd_lms_has_access( $course_id, $user_id );
} elseif ( function_exists( 'learndash_user_get_course_progress' ) && $user_id ) {
    $course_progress = learndash_user_get_course_progress( $user_id, $course_id );
    $is_enrolled = ! empty( $course_progress );
}
?>

<main id="primary" class="site-main single-course-wrapper">


    <!-- Hero Image / Banner -->
    <section class="hero-image-section course-hero-image"
             data-aos="fade-up"
             data-aos-duration="900"
             style="background-image: url(<?php echo esc_url( $bg_image ); ?>)">
        <?php if ( $thumbnail ) : ?>
            <img src="<?php echo esc_url( $thumbnail ); ?>"
                 alt="<?php the_title_attribute(); ?>"
                 class="hero-image">
        <?php endif; ?>

        <div class="hero-gradient"></div>
        <div class="hero-content">
            <div class="container">
                <div class="d-flex flex-wrap align-items-center gap-2 mb-3">
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

                <h1><?php the_title(); ?></h1>

                <div class="hero-meta">
                    <?php if ( $lessons_count ) : ?>
                        <div class="hero-meta-item">
                            <i class="fas fa-layer-group"></i>
                            <span><?php echo esc_html( $lessons_count ); ?> lessons</span>
                        </div>
                    <?php endif; ?>

                    <?php if ( $course_duration ) : ?>
                        <div class="hero-meta-item">
                            <i class="far fa-clock"></i>
                            <span><?php echo esc_html( $course_duration ); ?></span>
                        </div>
                    <?php endif; ?>

                    <?php if ( $course_language ) : ?>
                        <div class="hero-meta-item">
                            <i class="fas fa-globe"></i>
                            <span><?php echo esc_html( $course_language ); ?></span>
                        </div>
                    <?php endif; ?>

                    <?php if ( $course_location ) : ?>
                        <div class="hero-meta-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <span><?php echo esc_html( $course_location ); ?></span>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Course Layout -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <!-- Main Content -->
                <div class="col-lg-8">
                    <!-- About the Course -->
                    <div class="content-section">
                        <h2 data-aos="fade-up" data-aos-duration="800">About this course</h2>
                        <div data-aos="fade-up" data-aos-duration="500" class="course-main-description">
                            <?php the_content(); ?>
                        </div>
                    </div>

                    <!-- Who this is for -->
                    <?php if ( $target_audience ) : ?>
                        <div class="content-section">
                            <h2 data-aos="fade-up" data-aos-duration="800">Who is this for?</h2>
                            <div data-aos="fade-up" data-aos-duration="500">
                                <?php echo wp_kses_post( $target_audience ); ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Key Outcomes -->
                    <?php if ( $key_outcomes ) : ?>
                        <div class="content-section">
                            <h2 data-aos="fade-up" data-aos-duration="800">What you will learn</h2>
                            <div class="course-outcomes-grid" data-aos="fade-up" data-aos-duration="500">
                                <?php
                                if ( is_array( $key_outcomes ) ) :
                                    foreach ( $key_outcomes as $outcome ) :
                                        $label = is_array( $outcome ) && isset( $outcome['course_outcome_item'] )
                                            ? $outcome['course_outcome_item']
                                            : $outcome;

                                        if ( empty( $label ) ) {
                                            continue;
                                        }
                                        ?>
                                        <div class="course-outcome-item">
                                            <i class="fas fa-check-circle"></i>
                                            <span><?php echo esc_html( $label ); ?></span>
                                        </div>
                                    <?php
                                    endforeach;
                                else :
                                    echo wp_kses_post( $key_outcomes );
                                endif;
                                ?>
                            </div>
                        </div>
                    <?php endif; ?>

                </div>

                <!-- Sidebar -->
                <div class="col-lg-4" data-aos="fade-left" data-aos-duration="800">
                    <aside class="sidebar-info course-sidebar">
                        <h3>Enroll in this course</h3>

                        <p class="course-sidebar-intro">
                            Build practical fire engineering skills with structured, real-world lessons from
                            Red Helmet Engineering Academy.
                        </p>

                        <div class="course-sidebar-meta">
                            <?php if ( $lessons_count ) : ?>
                                <div class="info-item">
                                    <div class="info-label">Lessons</div>
                                    <div class="info-value"><?php echo esc_html( $lessons_count ); ?></div>
                                </div>
                            <?php endif; ?>

                            <?php if ( $course_duration ) : ?>
                                <div class="info-item">
                                    <div class="info-label">Duration</div>
                                    <div class="info-value"><?php echo esc_html( $course_duration ); ?></div>
                                </div>
                            <?php endif; ?>

                            <?php if ( $course_level ) : ?>
                                <div class="info-item">
                                    <div class="info-label">Level</div>
                                    <div class="info-value"><?php echo esc_html( $course_level ); ?></div>
                                </div>
                            <?php endif; ?>

                            <?php if ( $delivery_format ) : ?>
                                <div class="info-item">
                                    <div class="info-label">Format</div>
                                    <div class="info-value"><?php echo esc_html( $delivery_format ); ?></div>
                                </div>
                            <?php endif; ?>

                            <?php if ( $course_language ) : ?>
                                <div class="info-item">
                                    <div class="info-label">Language</div>
                                    <div class="info-value"><?php echo esc_html( $course_language ); ?></div>
                                </div>
                            <?php endif; ?>

                            <?php if ( $course_location ) : ?>
                                <div class="info-item">
                                    <div class="info-label">Location</div>
                                    <div class="info-value"><?php echo esc_html( $course_location ); ?></div>
                                </div>
                            <?php endif; ?>

                            <?php if ( $course_prereqs ) : ?>
                                <div class="info-item">
                                    <div class="info-label">Prerequisites</div>
                                    <div class="info-value">
                                        <?php echo esc_html( $course_prereqs ); ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="sidebar-cta">
                            <div class="course-enroll-button">
                                <?php
                                // Render the LearnDash take/continue course button.
                                echo do_shortcode( '[learndash_course_progress course_id="' . intval( $course_id ) . '"]' );
                                echo do_shortcode( '[ld_course_resume course_id="' . intval( $course_id ) . '"]' );
                                ?>
                            </div>

                            <?php

                            // Check if course is linked to a WooCommerce product
                            if ( class_exists( 'WooCommerce' ) ) {
                                $product_id = get_product_id_by_course_id( $course_id );
                                if ( $product_id ) {
                                    $enroll_url = wc_get_cart_url() . '?add-to-cart=' . $product_id;
                                }
                            }


                            // Logic for button display
                            if ( ! is_user_logged_in() ) :
                                $registration_url = learndash_registration_page_get_id();
                                // get the registration page url
                                $registration_page = get_post( $registration_url );
                                $registration_page_url = get_permalink( $registration_page );
                                
                                ?>
                                <a href="<?php echo esc_url( $registration_page_url ); ?>" class="btn btn-red btn-enroll-course">
                                    <?php esc_html_e( 'Login to Enroll', 'consultio-child' ); ?>
                                </a>
                                <?php
                            elseif ( $is_enrolled ) :
                                ?>
                                <a href="<?php echo esc_url( get_permalink( $course_id ) ); ?>" class="btn btn-red btn-enroll-course">
                                    <?php esc_html_e( 'Continue Course', 'consultio-child' ); ?>
                                </a>
                                <p class="course-sidebar-note" style="margin-top: 20px;">
                                    Need this course for your whole team? Get in touch with our training specialists
                                    for group training options and tailored learning paths.
                                </p>

                                <a href="<?php echo esc_url( site_url( '/contact' ) ); ?>" class="btn btn-red">
                                    Talk to Training Team
                                </a>
                                <?php
                            else :
                                // Not enrolled, logged in
                                $enroll_url = get_permalink( $course_id );
                                $button_text = __( 'Enroll Course', 'consultio-child' );

                                if ( 'free' === $course_price_type || 'open' === $course_price_type ) {
                                    $button_text = __( 'Enroll Now', 'consultio-child' );
                                } else {
                                    $button_text = __( 'Buy This Course', 'consultio-child' );
                                }

                                ?>
                                <a href="<?php echo esc_url( $enroll_url ); ?>" class="btn btn-red btn-enroll-course">
                                    <?php echo esc_html( $button_text ); ?>
                                </a>
                            <?php endif; ?>
                        </div>
                    </aside>
                </div>
            </div>
        </div>
    </section>


</main>

<?php
get_footer();


