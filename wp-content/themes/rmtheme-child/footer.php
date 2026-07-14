<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package rmtheme
 */
?>
<div class="ftr-form-sctn">
    <div class="container"> 
        <?php $footer_form_content = do_shortcode(get_field('footer_form_content', 'option')); ?>
        <div class="custom-header-content">
            <?php echo $footer_form_content; ?>
			<?php echo do_shortcode(get_field('footer_gravity_form_shortcode', 'option')); ?>
        </div>
    </div>
</div>
<div class="ftr-block-sec">
    <div class="container">  

        <div class="ftr-menu">
                <nav id="footer-navigation"> <?php wp_nav_menu( array( 'menu' => 6, ) ); 
                ?>
            </nav>
    </div>

        <?php $footer_block_content = get_field('footer_blocks_content', 'option'); ?>
        <div class="ftr-block-list">
            <?php echo $footer_block_content; ?>
        </div>
    </div>
</div>
<div class="ftr-copyrights-sec">
    <div class="container">
        <div class="cpy-inr">
            <p class="copy-para">&copy; <?php echo date("Y"); ?> <?php echo get_option('blogname') ?>• All Rights Reserved. <a href="<?php echo esc_url(home_url('/disclaimer/')); ?>" role="link" data-uw-styling-context="true">Disclaimer</a> | <a href="<?php echo esc_url(home_url('/site-map/')); ?>" role="link" data-uw-styling-context="true">Site Map</a> | <a href="<?php echo esc_url(home_url('/privacy-policy/')); ?>" role="link" data-uw-styling-context="true">Privacy Policy.</a> Digital Marketing By: <a href="https://www.rizeupmedia.com/" rel="nofollow noopener"target="_blank"><img src="https://www.rizeupmedia.com/static/RizeUp-Logo-Footer-W.png" rel="nofollow noopener" alt="rizeup media logo" width="85" height="30" /></a></p>
        </div>
    </div>
</div>

<?php wp_footer(); ?>
<?php $theme_uri = get_stylesheet_directory_uri(); ?>
<script src="<?php echo esc_url($theme_uri); ?>/js/owl.carousel.min.js"></script>
<script src="<?php echo esc_url($theme_uri); ?>/js/custom-scripts.js"></script>
</body>
</html>
