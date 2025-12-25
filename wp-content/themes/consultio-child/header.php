<?php
/**
 * The header for our theme.
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @package Consultio
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="//gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>
    <div id="page" class="site">
        <?php 
        	consultio_page_loading();
        	consultio_header_layout();
            consultio_page_title_layout();
        ?>
        <div id="content" class="site-content">
            <?php
                $translate_this_page = get_field('translate_this_page');
                if( $translate_this_page ):
                    echo do_shortcode('[language-switcher]');
                endif;
            ?>
        	<div class="content-inner">
