<?php
/**
 * Single view template for member.
 *
 * @package team-free
 * @subpackage team-free\Frontend\templates
 * @since 2.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

?>
<?php
if ( function_exists( 'wp_is_block_theme' ) && wp_is_block_theme() ) {
    ?>
    <?php wp_head(); ?>
    <div class="wp-site-blocks">
    <header class="wp-block-template-part site-header">
        <?php block_header_area(); ?>
    </header>
    <?php
} else {
    get_header();
}
// Start the loop.
while ( have_posts() ) :
    the_post();
    $member_info   = get_post_meta( get_the_ID(), '_sptp_add_member', true );
    $sptp_settings = get_option( '_sptp_settings' );

    $show_name            = true;
    $show_img             = true;
    $show_desc            = true;
    $show_position        = true;
    $show_social_profiles = true;
    if ( isset( $sptp_settings['detail_page_fields'] ) ) {
        $detail_fields        = $sptp_settings['detail_page_fields'];
        $show_name            = isset( $detail_fields['name_switch'] ) ? $detail_fields['name_switch'] : true;
        $show_img             = isset( $detail_fields['image_switch'] ) ? $detail_fields['image_switch'] : true;
        $show_desc            = isset( $detail_fields['bio_switch'] ) ? $detail_fields['bio_switch'] : true;
        $show_position        = isset( $detail_fields['job_position_switch'] ) ? $detail_fields['job_position_switch'] : true;
        $show_social_profiles = isset( $detail_fields['social_switch'] ) ? $detail_fields['social_switch'] : true;
    }
    ?>

    <div class="single-team-data">
        <div class="heading-name-wrapper">
            <div class="heading-name container">
                <?= get_the_title() ?>
            </div>
        </div>

        <div class="container">
            <h2 class="heading-bio">
                We are a team of problem-solvers and innovators, committed to transforming your challenges into successes through our expertise and dedication
            </h2>

            <div class="ct-team-details team-card">
                <?php
                    $featured_img_url = get_the_post_thumbnail_url(get_the_ID(),'full');
                    $member_job_title = isset( $member_info['sptp_job_title'] ) ? $member_info['sptp_job_title'] : '';
                    $member_short_bio = isset( $member_info['sptp_short_bio'] ) ? $member_info['sptp_short_bio'] : '';
                ?>
                <div class="ct-team-image bg-image" style="background-image: url(<?= $featured_img_url ?>);" ></div>
                <div class="ct-team-content bg-image" >
                    <div class="ct-team-holder" >
                        <div class="ct-team-icon" ><i class="fac fac-user-cog"></i></div>
                        <div class="ct-team-meta" >
                            <h3 class="ct-team-title"> <?= get_the_title() ?> </h3>
                            <div class="ct-team-position" > <?= $member_job_title ?> </div>
                        </div>
                    </div>
                    <ul class="ct-team-contact">
                        <li class="contact-address"><i class="fac fac-map-marker-alt"></i>
                            <?= $member_short_bio ?>
                        </li>
                    </ul>
                    <div class="ct-team-social">
                        <?php
                        if ( $show_social_profiles ) {
                            $member_socials = isset( $member_info['sptp_member_social'] ) ? $member_info['sptp_member_social'] : 0;
                            if ( $member_socials ) {
                                ?>
                                <div class="sptp-member-social rounded">
                                    <ul>
                                        <?php
                                        foreach ( $member_socials as $social ) :
                                            if ( $social['social_group'] ) :
                                                $social_link = $social['social_link'];
                                                if ( preg_match( '#^https?://#i', $social_link ) ) {
                                                    $social_link = $social_link;
                                                } elseif ( preg_match( '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', $social_link ) ) {
                                                    $social_link = 'mailto:' . $social_link;
                                                } else {
                                                    $social_link = 'http://' . $social_link;
                                                }
                                                ?>
                                                <li>
                                                    <a class="<?php echo 'sptp-' . esc_html( $social['social_group'] ); ?>" href="<?php echo esc_html( $social_link ); ?>" target="_blank">
                                                        <?php if ( preg_match( '/icon/', $social['social_group'] ) ) { ?>
                                                            <i class="spteam-icon <?php echo esc_attr( $social['social_group'] ); ?>"></i>
                                                        <?php } else { ?>
                                                            <i class="<?php echo 'fa fa-' . esc_attr( $social['social_group'] ); ?>"></i>
                                                        <?php } ?>
                                                    </a>
                                                </li>
                                            <?php
                                            endif;
                                        endforeach;
                                        ?>
                                    </ul>
                                </div>
                                <?php
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>

        </div>
    </div>


    <?php if ( $show_desc ) { ?>
        <div class="sptp-content container">
        <?php the_content(); ?>
    </div>
    <?php } ?>
    </div>

<?php
endwhile;

if ( function_exists( 'wp_is_block_theme' ) && wp_is_block_theme() ) {
    ?>
    <footer class="wp-block-template-part site-footer">
        <?php block_footer_area(); ?>
    </footer>
    </div>
    <?php
    wp_footer();
} else {
    get_footer();
}
