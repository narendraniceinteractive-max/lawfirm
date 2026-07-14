<?php
/* Template Name: Single Profile Page Template */
get_header();
?>
<?php include( get_stylesheet_directory() . '/partials/page-header.php' ); ?>
<main id="page-content">
    <div class="page-container">
        <div class="page-col-full">
            <section id="page-column">
                <div class="single-profile-block">
                    <?php
                    $profile_image = get_field('single_profile_page_image');
                    if ($profile_image) {
                        ?>
                        <div class="single-profile-image">
                            <img src="<?php echo $profile_image; ?>" alt="<?php echo esc_attr(get_the_title()); ?>" width="" height="">
                        </div>
                    <?php } ?>
                    <div class="sp-block">
                        <?php if (get_field('single_profile_name')) { ?>
                            <h2><?php echo get_field('single_profile_name'); ?></h2>
                        <?php } ?>

                        <?php if (get_field('single_profile_designation')) { ?>
                            <h5><?php echo get_field('single_profile_designation'); ?></h5>
                        <?php } ?>

                        <?php if (get_field('single_profile_phone_number')) { ?>
                            <div class="profile-tel">
                                <a href="tel:<?php echo get_field('single_profile_phone_number'); ?>"><?php echo get_field('single_profile_phone_number'); ?></a>
                            </div>
                        <?php } ?>

                        <?php if (get_field('single_profile_email_address')) { ?>
                            <div class="profile-email">
                                <a href="mailto:<?php echo get_field('single_profile_email_address'); ?>"><?php echo get_field('single_profile_email_address'); ?></a>
                            </div>
                        <?php } ?>

                        <?php if (get_field('single_profile_physical_address')) { ?>
                            <div class="profile-address">
                                <p><?php echo get_field('single_profile_physical_address'); ?></p>
                            </div>
                        <?php } ?>

                        <?php if (have_rows('single_profile_social_media')) { ?>
                            <div class="profile-socials">
                                <?php while (have_rows('single_profile_social_media')) : the_row(); ?>
                                    <a href="<?php echo esc_url(get_sub_field('single_profile_social_media_link')); ?>" target="_blank">
                                        <img src="<?php echo esc_url(get_sub_field('single_profile_social_media_image')); ?>" alt="<?php echo esc_attr(get_sub_field('single_profile_social_media_name')); ?>" width="45" height="45">
                                        <span><?php echo esc_html(get_sub_field('single_profile_social_media_name')); ?></span>
                                    </a>
                                <?php endwhile; ?>
                            </div>
                        <?php } ?>

                    </div>
                </div>
                <div class="single-profile-content">
                    <?php while (have_posts()) : the_post(); ?>
                        <?php the_content(); ?>
                        <div class="single-accordion">
                            <div class="accordion-profile active">
                                <h3>Section 1</h3>
                            <div class="accordion-profile-content">
                                <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.</p></div>
                            </div>

                            <div class="accordion-profile">
                                <h3>Section 2</h3>
                                <div class="accordion-profile-content">
                                    <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.</p></div>
                            </div>
                        </div>

                    <?php endwhile; ?>
                </div>

            </section>

            <?php get_sidebar('page'); ?>
        </div>
    </div>
</main>

<?php
get_footer();
