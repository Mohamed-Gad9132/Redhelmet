<?php
/**
 * The template for displaying Archive Projects
 *
 * @package Consultio
 */
get_header();
?>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-10">
                    <h1>Our Projects</h1>
                    <p>
                        Explore our portfolio of successful fire protection and life safety projects across the Middle East.
                        Each project demonstrates our commitment to innovation, compliance, and exceptional client service.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Projects Grid -->
    <section class="py-5">
        <div class="container">
            <div class="row g-4">
                <?php if ( have_posts() ) : ?>
                    <?php while ( have_posts() ) : the_post();
                        $project_image = get_field('project_main_image');
                        $bg_image = '';
                        if( empty($project_image) || !isset($project_image) ):
                            $bg_image = get_stylesheet_directory_uri() . '/assets/images/logo-gray  .png';
                        endif;
                        $project_location = get_field('project_location');
                        $project_year_date = get_field('project_year');
                        $project_year = '';
                        if ( $project_year_date ) {
                            $date_object = DateTime::createFromFormat('d/m/Y', $project_year_date);
                            if ( $date_object ) {
                                $project_year = $date_object->format('Y');
                            }
                        }
                        $terms = get_the_terms( get_the_ID(), 'project_category' );
                        $project_category = '';
                        if ( $terms && ! is_wp_error( $terms ) ) {
                            $project_category = $terms[0]->name;
                        }
                    ?>
                    <div class="col-md-6 col-lg-4">
                        <a href="<?php the_permalink(); ?>" class="project-card">
                            <div class="project-image-wrapper" style="background-image: url(<?= $bg_image ?>)">
                                <?php if ( $project_image ) : ?>
                                    <img src="<?php echo esc_url( $project_image ); ?>"
                                         alt="<?php the_title_attribute(); ?>"
                                         class="project-image">
                                <?php endif; ?>
                                <div class="project-overlay">
                                    <div class="view-project">
                                        <span>View Project</span>
                                        <i class="bi bi-arrow-right"></i>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="d-flex align-items-center gap-2 mb-3">
                                    <?php if ( $project_category ) : ?>
                                        <span class="project-badge"><?php echo esc_html( $project_category ); ?></span>
                                    <?php endif; ?>
                                    <?php if ( $project_year ) : ?>
                                        <span class="text-muted small"><?php echo esc_html( $project_year ); ?></span>
                                    <?php endif; ?>
                                </div>
                                <h3><?php the_title(); ?></h3>
                                <?php if ( $project_location ) : ?>
                                    <p class="project-location"><?php echo esc_html( $project_location ); ?></p>
                                <?php endif; ?>
                                <div class="project-description">
                                    <?php the_excerpt(); ?>
                                </div>
                            </div>
                        </a>
                    </div>
                    <?php endwhile; ?>
                    
                    <div class="col-12">
                        <?php
                        the_posts_pagination( array(
                            'prev_text' => __( 'Previous', 'consultio-child' ),
                            'next_text' => __( 'Next', 'consultio-child' ),
                        ) );
                        ?>
                    </div>

                <?php else : ?>
                    <div class="col-12">
                        <p><?php esc_html_e( 'No projects found.', 'consultio-child' ); ?></p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <h2>Ready to Start Your Project?</h2>
                    <p class="text-muted mb-4">
                        Contact us today to discuss how our fire protection expertise can add value to your next project.
                    </p>
                    <button class="btn btn-red">Get In Touch</button>
                </div>
            </div>
        </div>
    </section>

<?php get_footer(); ?>