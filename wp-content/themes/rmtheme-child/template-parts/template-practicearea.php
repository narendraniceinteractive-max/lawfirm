<?php
/* Template Name: Practice Area Page Template */
get_header(); ?>
<?php include( get_stylesheet_directory() . '/partials/page-header.php' ); ?>
<main id="page-content">
    <div class="page-container">
        <div class="page-col-full">
        <div id="page-column" class="full-width">
            <section id="practicearea-main">
                <?php if (have_rows('practice_areas_list')): ?>
                    <div class="practice-list">
                        <?php while (have_rows('practice_areas_list')): the_row(); ?>
                            <div class="practice-item">

                                <?php if (get_sub_field('practice_area_icon')) { ?>
                                    <div class="practice-icon">
                                        <img src="<?php echo get_sub_field('practice_area_icon'); ?>" alt="<?php echo get_sub_field('practice_area_icon_alt_tag_name'); ?> Image" width="" height="">
                                    </div>
                                <?php } ?>
                                
                                <?php if (get_sub_field('practice_area_hover_icon')) { ?>
                                    <div class="practice-icon icon-hover">
                                        <img src="<?php echo get_sub_field('practice_area_hover_icon'); ?>" alt="<?php echo get_sub_field('practice_area_hover_icon_alt_tag_name'); ?> Hover Image" width="" height="">
                                    </div>
                                <?php } ?>
                                 <?php if (get_sub_field('practice_area_image')) { ?>
                                    <div class="practice-itm-img">
                                        <img src="<?php echo get_sub_field('practice_area_image'); ?>" alt="<?php echo get_sub_field('practice_area_image_alt_tag_name'); ?> Image" width="" height="">
                                    </div>
                                <?php } ?>
                                
                                <?php if (get_sub_field('practice_area_name')) { ?>
                                    <div class="practice-name">
                                        <h4><?php echo get_sub_field('practice_area_name'); ?></h4>
                                    </div>
                                <?php } ?>
                                
                                <div class="practice-button">
                                    <a href="<?php echo get_sub_field('practice_area_link'); ?>">Read More</a>
                                </div>

                                <?php if (get_sub_field('practice_area_link')) { ?>
                                    <div class="practice-name item-hover">
                                        <a href="<?php echo get_sub_field('practice_area_link'); ?>"><?php echo get_sub_field('practice_area_name'); ?></a>
                                    </div>
                                <?php } ?>
                                
                            </div>
                        <?php endwhile; ?>
                    </div>
                <?php endif; ?>

            </section>
        </div>

        </div>
    </div>
</main>

<?php get_footer();