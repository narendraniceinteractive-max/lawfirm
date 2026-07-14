<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package rmtheme
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo('charset'); ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="profile" href="https://gmpg.org/xfn/11">
        <?php wp_head(); ?>
        <?php $theme_uri = get_stylesheet_directory_uri(); ?>
        <link rel="stylesheet" href="<?php echo esc_url($theme_uri); ?>/css/widget-cta-shortcodes.css" media="all">
        <link rel="stylesheet" href="<?php echo esc_url($theme_uri); ?>/css/owl.carousel.min.css" media="all">
    </head>
    <body <?php body_class(); ?>>
        <?php wp_body_open(); ?>
        <div id="floatingMenu">
            <div class="floatingMenu-list">
                <button type="button" onclick="closeFloatingMenu();" id="cloaseFloatingMenu">&times;</button>
                <div class="sticky-mobinav mobinav">
                    <div class="container">
                        <?php
                        wp_nav_menu(array(
                            'menu_class' => "main-menu-mobile",
                            'menu_id' => "main-menu-mobile",
                            'menu' => 'Main Menu',
                            'container' => "",
                            'container_class' => "",
                            'container_id' => "",
                            'theme_location' => "main_menu",
                        ));
                        ?>
                    </div>
                </div>
            </div>
            <button type="button" onclick="closeFloatingMenu();" id="cloaseFloatingMenu2">×</button>
        </div>
        <header class="site-header"> 
            <div class="container">
                <div class="logo-section">
                    <div class="site-branding"><?php echo get_site_logo(); ?></div>
                    <nav id="main-navigation">
                        <?php
                        wp_nav_menu(array(
                            'theme_location' => 'menu-1'
                        ));
                        ?>
                    </nav>
                    <div class="header-number"><strong>Schedule a Call</strong><a href="tel:9876543213">9876543213</a></div>
                </div>
            </div>
            <div class="mobile_src_nav">
                <div class="container">
                    <button type="button" onclick="floatingMenu();" class="showhide">
                        <b class="txtr">&equiv;</b>
                        <b class="txtl">Menu</b>
                    </button>
                </div>
            </div>
            <div class="header-sticky">
                <div class="container">
                    <div class="sticky-cnt mobile_src_nav"><button type="button" onclick="floatingMenu();"
                                                                   class="stickyshowhide"><b class="txt">Menu</b></button></div>
                    <div class="sicky-cnt sticky-mobile-logo"><a href="<?php echo home_url(); ?>"><img
                                src="<?php echo get_stylesheet_directory_uri(); ?>/images/logo.webp" alt="Mobile Sticky Logo"
                                width="" height=""></a></div>
                    <div class="sticky-cnt sticky-call-wrap"><a href="tel:0000000000">Call</a></div>
                </div>
            </div>
        </header>