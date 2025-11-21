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
        <section class="hero-image-section" data-aos="fade-up" data-aos-duration="900">
            <?php
                $project_main_image = get_field('project_main_image');
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
                                <span id="projectYear"><?= date('Y', strtotime($project_year)) ?></span>
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
                         <div class="content-section" data-aos="fade-up" data-aos-duration="800">
                            <h2>Project Overview</h2>
                            <p id="projectDescription">A landmark 45-story mixed-use development in the heart of Dubai's
                                business district, requiring comprehensive fire protection engineering and life safety
                                systems design.</p>
                        </div>

                        <!-- Challenge -->
                         <div class="content-section" data-aos="fade-up" data-aos-duration="800" data-aos-delay="100">
                            <h2>The Challenge</h2>
                            <p id="projectChallenge">The project presented unique challenges due to its mixed-use
                                nature, combining retail, office, and residential spaces across 45 floors. The
                                building's innovative architectural design required creative solutions to meet both
                                local and international fire safety standards while maintaining the architectural
                                vision.</p>
                        </div>

                        <!-- Solution -->
                         <div class="content-section" data-aos="fade-up" data-aos-duration="800" data-aos-delay="200">
                            <h2>Our Solution</h2>
                            <p id="projectSolution">Our team developed an integrated fire protection strategy
                                incorporating advanced smoke control systems, multiple fire suppression technologies,
                                and a comprehensive life safety plan. We utilized performance-based design approaches to
                                optimize the fire protection systems while ensuring full compliance with UAE Fire and
                                Life Safety Code.</p>
                        </div>

                        <!-- Services Provided -->
                         <div class="content-section" data-aos="fade-up" data-aos-duration="800" data-aos-delay="300">
                            <h2>Services Provided</h2>
                            <div id="servicesList" class="services-grid">
                                <div class="service-item">
                                    <i class="fas fa-check-circle"></i>
                                    <span>Fire Protection Engineering</span>
                                </div>
                                <div class="service-item">
                                    <i class="fas fa-check-circle"></i>
                                    <span>Smoke Control System Design</span>
                                </div>
                                <div class="service-item">
                                    <i class="fas fa-check-circle"></i>
                                    <span>Sprinkler System Design</span>
                                </div>
                                <div class="service-item">
                                    <i class="fas fa-check-circle"></i>
                                    <span>Fire Alarm System Design</span>
                                </div>
                            </div>
                        </div>

                        <!-- Outcomes -->
                         <div class="content-section" data-aos="fade-up" data-aos-duration="800" data-aos-delay="400">
                            <h2>Project Outcomes</h2>
                            <div id="outcomesList">
                                <div class="outcome-item">
                                    <i class="fas fa-check-circle"></i>
                                    <span>Achieved full compliance with UAE Fire and Life Safety Code</span>
                                </div>
                                <div class="outcome-item">
                                    <i class="fas fa-check-circle"></i>
                                    <span>Reduced overall fire protection system costs by 15% through optimization</span>
                                </div>
                                <div class="outcome-item">
                                    <i class="fas fa-check-circle"></i>
                                    <span>Obtained timely approvals from Civil Defense authorities</span>
                                </div>
                                <div class="outcome-item">
                                    <i class="fas fa-check-circle"></i>
                                    <span>Successfully integrated systems with building automation</span>
                                </div>
                                <div class="outcome-item">
                                    <i class="bi bi-check-circle-fill"></i>
                                    <span>Delivered comprehensive as-built documentation</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sidebar -->
                     <div class="col-lg-4" data-aos="fade-left" data-aos-duration="800" data-aos-delay="200">
                         <div class="sidebar-info">
                            <h3>Project Information</h3>

                            <div class="info-item">
                                <div class="info-label">Client</div>
                                <div class="info-value" id="projectClient">Premier Development Group</div>
                            </div>

                            <div class="info-item">
                                <div class="info-label">Location</div>
                                <div class="info-value" id="sidebarLocation">Dubai, UAE</div>
                            </div>

                            <div class="info-item">
                                <div class="info-label">Project Size</div>
                                <div class="info-value" id="sidebarSize">450,000 sq ft</div>
                            </div>

                            <div class="info-item">
                                <div class="info-label">Duration</div>
                                <div class="info-value" id="projectDuration">18 months</div>
                            </div>

                            <div class="info-item">
                                <div class="info-label">Year Completed</div>
                                <div class="info-value" id="sidebarYear">2024</div>
                            </div>

                            <div class="sidebar-cta">
                                <h4>Interested in Similar Work?</h4>
                                <p>Let's discuss how we can help with your fire protection needs.</p>
                                <button class="btn btn-red">
                                    <i class="fas fa-file-alt"></i>
                                    Request Consultation
                                </button>
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
                        <h2>Ready to Start Your Fire Protection Project?</h2>
                        <p>
                            Our team of experts is ready to provide strategic, innovative fire protection solutions for
                            your next project.
                        </p>
                        <div class="d-flex flex-wrap gap-3 justify-content-center">
                            <a href="#" class="btn btn-white"><?= __('Contact Us Today', 'consultio-child') ?></a>
                            <a href="<?= site_url() . '/projects' ?>" class="btn btn-outline-white"><?= __('View More Projects', 'consultio-child') ?></a>
                        </div>
                    </div>
                </div>
            </div>
        </section>


    </main>

<?php
get_footer();

