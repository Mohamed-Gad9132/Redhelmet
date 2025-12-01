<?php
/**
 * Single Project Template (Child Theme)
 *
 * This template displays single Project CPT entries.
 *
 * @package Consultio_Child
 */


get_header();
?>

    <main id="primary" class="site-main single-project-wrapper">
        <!-- Navigation -->
        <nav class="navbar navbar-custom" data-aos="fade-down" data-aos-duration="700">
            <div class="container py-3">
                <a href="<?= home_url() . '/projects' ?>" class="back-link">
                    <i class="fas fa-arrow-left"></i>
                    Back to All Projects
                </a>
            </div>
        </nav>

        <!-- Hero Image -->
        <?php
            $project_main_image = get_field('project_main_image');
            $bg_image = '';
            if( empty($project_main_image) || !isset($project_main_image) ):
                $bg_image = get_stylesheet_directory_uri() . '/assets/images/logo-gray.png';
            endif;

        ?>
        <section class="hero-image-section" data-aos="fade-up" data-aos-duration="900" style="background-image: url(<?= $bg_image ?>)">
            <?php
                if( !empty($project_main_image) ):
            ?>
                <img id="heroImageBanner"
                     src="<?= $project_main_image ?>"
                     alt="RedHelmet" class="hero-image">

            <?php endif; ?>
            <div class="hero-gradient"></div>
            <div class="hero-content">
                <div class="container">
                    <span id="projectBadge" class="project-badge-hero">
                        <?php
                        $terms = get_the_terms(get_the_ID(), 'project_category');
                        if (!empty($terms) && !is_wp_error($terms)) {
                            echo esc_html($terms[0]->name);
                        } else {
                            esc_html_e('Project', 'consultio-child');
                        }
                        ?>
                    </span>
                    <h1 id="projectTitle"><?= get_the_title(); ?></h1>
                    <div class="hero-meta">
                    <?php
                        $project_location = get_field('project_location');
                        if( !empty($project_location) ):
                    ?>
                            <div class="hero-meta-item">
                                <i class="fas fa-map-marker-alt"></i>
                                <span id="projectLocation"><?= $project_location ?></span>
                            </div>
                        <?php endif; ?>

                        <?php
                            $project_year = get_field('project_year');
                            if( !empty($project_year) ):
                        ?>
                            <div class="hero-meta-item">
                                <i class="fas fa-calendar-alt"></i>
                                <span id="projectYear"><?= $project_year ?></span>
                            </div>
                        <?php endif; ?>

                        <?php
                            $project_area = get_field('project_area');
                                if( !empty($project_area) ):
                        ?>
                        <div class="hero-meta-item">
                            <i class="fas fa-building"></i>
                            <span id="projectSize"><?= $project_area ?></span>
                        </div>
                        <?php endif; ?>

                    </div>
                </div>
            </div>
        </section>

        <!-- Project Details -->
         <section class="py-5">
             <div class="container">
                 <div class="row">
                    <!-- Main Content -->
                    <div class="col-lg-8">
                        <!-- Overview -->
                        <?php
                            $project_overview = get_field('project_overview');
                                if( !empty($project_overview) ):
                        ?>
                             <div class="content-section">
                                <h2 data-aos="fade-up" data-aos-duration="800">Project Overview</h2>
                                <div data-aos="fade-up" data-aos-duration="500" id="projectDescription"><?= $project_overview ?></div>
                            </div>
                        <?php endif; ?>

                        <!-- Challenge -->
                        <?php
                            $the_challenge = get_field('the_challenge');
                                if( !empty($the_challenge) ):
                        ?>
                             <div class="content-section">
                                <h2 data-aos="fade-up" data-aos-duration="800" >The Challenge</h2>
                                <div data-aos="fade-up" data-aos-duration="500" id="projectChallenge"><?= $the_challenge ?></div>
                            </div>
                        <?php endif; ?>

                        <!-- Solution -->
                        <?php
                            $our_solution = get_field('our_solution');
                                if( !empty($our_solution) ):
                        ?>
                             <div class="content-section">
                                <h2 data-aos="fade-up" data-aos-duration="800" >Our Solution</h2>
                                <div data-aos="fade-up" data-aos-duration="500" id="projectSolution"><?= $our_solution ?></div>
                            </div>
                        <?php endif; ?>

                        <!-- Services Provided -->
                        <?php
                            $services_provided = get_field('services_provided');
                                if( !empty($services_provided) ):
                        ?>
                         <div class="content-section" data-aos="fade-up" data-aos-duration="800">
                            <h2 data-aos="fade-up" data-aos-duration="800">Services Provided</h2>
                            <div id="servicesList" class="services-grid">
                                <?php foreach( $services_provided as $service ): ?>
                                    <div data-aos="fade-left" data-aos-duration="800" class="service-item">
                                        <i class="fas fa-check-circle"></i>
                                        <span><?= $service['service_name'] ?></span>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <?php endif; ?>

                        <!-- Outcomes -->
                        <?php
                            $project_outcomes = get_field('project_outcomes');
                                if( !empty($project_outcomes) ):
                        ?>
                         <div class="content-section" data-aos="fade-up" data-aos-duration="800">
                            <h2 data-aos="fade-up" data-aos-duration="800">Project Outcomes</h2>
                            <div id="outcomesList">
                                <?php foreach( $project_outcomes as $outcome ): ?>
                                    <div data-aos="fade-left" data-aos-duration="800" class="outcome-item">
                                        <i class="fas fa-check-circle"></i>
                                        <span><?= $outcome['project_outcome_item'] ?></span>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>

                    <!-- Sidebar -->
                     <div class="col-lg-4" data-aos="fade-left" data-aos-duration="800">
                         <div data-aos="fade-up" data-aos-duration="800" class="sidebar-info">

                            <?php
                                $project_information = get_field('project_information');
                                    if( !empty($project_information) ):
                            ?>
                            <h3>Project Information</h3>

                                <?php foreach ( $project_information as $information ): ?>
                                    <div class="info-item">
                                        <div class="info-label"><?= $information['project_info_item_title'] ?></div>
                                        <div class="info-value" id="projectClient"><?= $information['project_info_item_description'] ?></div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>


                            <div class="sidebar-cta" data-aos="flip-up" data-aos-duration="500">
                                <?php
                                    $side_cta_title = get_field('side_cta_title');
                                    if( !empty( $side_cta_title ) ):
                                ?>
                                    <h4><?= $side_cta_title ?></h4>
                                <?php endif; ?>

                                <?php
                                    $side_cta_description = get_field('side_cta_description');
                                    if( !empty( $side_cta_description ) ):
                                ?>
                                    <p><?= $side_cta_description ?></p>
                                <?php endif; ?>

                                <?php
                                    $side_cta_link = get_field('side_cta_link');
                                    if( !empty( $side_cta_link ) ):
                                ?>
                                    <a href="<?= $side_cta_link['url'] ?>" class="btn btn-red">
                                        <i class="fas fa-file-alt"></i>
                                        <?= $side_cta_link['title'] ?>
                                    </a>
                                <?php endif; ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
         <section class="cta-section">
             <div class="container">
                 <div class="row justify-content-center">
                     <div class="col-lg-8 text-center" data-aos="zoom-in" data-aos-duration="900">
                        <?php
                            $bottom_cta_title = get_field('bottom_cta_title');
                            if( !empty( $bottom_cta_title ) ):
                        ?>
                            <h2><?= $bottom_cta_title ?></h2>
                        <?php endif; ?>
                        <?php
                            $bottom_cta_description = get_field('bottom_cta_description');
                            if( !empty( $bottom_cta_description ) ):
                        ?>
                            <p><?= $bottom_cta_description ?></p>
                        <?php endif; ?>
                        <div class="d-flex flex-wrap gap-3 justify-content-center">
                            <?php
                                $bottom_cta_1_link = get_field('bottom_cta_1_link');
                                if( !empty($bottom_cta_1_link) ):
                            ?>
                                <a href="<?= $bottom_cta_1_link['url'] ?>" class="btn btn-white"><?= $bottom_cta_1_link['title'] ?></a>
                            <?php endif; ?>
                            <a href="<?= site_url() . '/projects' ?>" class="btn btn-outline-white"><?= __('View More Projects', 'consultio-child') ?></a>
                        </div>
                    </div>
                </div>
            </div>
        </section>


    </main>

<?php
get_footer();

