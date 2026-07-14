<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package rmtheme
 */
get_header();
?>
<?php include(get_stylesheet_directory() . '/partials/page-header.php'); ?>

<?php
$factCheckedDescription = get_field('select_team_member_description');
$toggleFactChecked = get_field('fact_checked_cpt');
if ($toggleFactChecked) {
    ?>
    <div class="fact-checked-sec">
        <div class="page-container">
            <section class="widget widget_fact_checked">
                <div class="fact_checked_inner">
                    <div class="checked_by">
                        <div class="checked-right">
                            <div class="checked-left"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/factcheckedimage.webp" alt="fact checked image" width="35" height="35" ><p class="widget-names">Fact-Checked</p></div>
                            <div class="widget-description"><?php echo $factCheckedDescription; ?></div>
                        </div>
                    </div>
                    <p class="mod_date">Last modified: <span> <?php the_modified_date(); ?></span></p>
                </div>
            </section>
        </div>
    </div>
<?php } ?>
<main id="page-content">
    <div class="page-container">
        <div class="page-col-full">
            <section id="page-column">
                <?php while (have_posts()) : the_post(); ?>

                    <?php if (has_post_thumbnail()) : ?>
                        <?php
                        $thumb_id = get_post_thumbnail_id(get_the_ID());
                        $thumb_data = wp_get_attachment_image_src($thumb_id, 'innerpg_banner_full');

                        $pageimg = $thumb_data[0];
                        $width = $thumb_data[1];
                        $height = $thumb_data[2];
                        ?>
                        <div class="page-feature-img">
                            <img src="<?php echo esc_url($pageimg); ?>" alt="<?php echo esc_attr(get_the_title()); ?>-image" width="<?php echo esc_attr($width); ?>" height="<?php echo esc_attr($height); ?>">
                        </div>
                    <?php endif; ?>

                    <?php the_content(); ?>
                <?php endwhile; ?>
            </section>
            <?php get_sidebar('page'); ?>
        </div>
    </div>
</main>
<?php
get_footer();
