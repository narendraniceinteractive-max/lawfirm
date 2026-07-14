<?php
/* Template Name: Area Served Page Template */
get_header();
?>
<?php include( get_stylesheet_directory() . '/partials/page-header.php' ); ?>
<main id="page-content" class="content-area">
    <div class="page-container">
        <section id="areaserved-main">

            <?php if (have_rows('area_served_list')) { ?>

                <?php while (have_rows('area_served_list')) : the_row(); ?>
                    <div class="areaserved-item-list">
                        <h2><?php echo get_sub_field('single_area_served_city_name'); ?></h2>
                        <div class="areaserved-list">
                            <?php while (have_rows('single_area_served_list')) : the_row(); ?>
                                <div class="areaserved-item">
                                    <a href="<?php echo get_sub_field('single_practice_area_link'); ?>"><?php echo get_sub_field('single_practice_area_name'); ?></a>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    </div>
                <?php endwhile; ?>

            <?php } ?>

        </section>

    </div>
</main>

<?php
get_footer();
