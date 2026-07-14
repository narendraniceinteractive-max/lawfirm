<?php
/* Template Name: Reviews Page Template */
get_header();
?>
<?php include( get_stylesheet_directory() . '/partials/page-header.php' ); ?>
<main id="page-content">
    <div class="page-container">
        <div class="page-col-full">
           <div id="page-column" class="full-width">
            <section id="reviews-main">
                <?php
                $page_reviews = get_posts([
                    'post_type' => 'reviews',
                    'posts_per_page' => -1,
                    'orderby' => 'date',
                    'order' => 'DESC',
                ]);

                if ($page_reviews) : foreach ($page_reviews as $post) : setup_postdata($post);
                        ?>
                        <div class="review-item">
                            <div class="star-rat"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/sdbr-start-img.webp" alt="testimonial star rating image"></div>
                            <p><?php the_content(); ?></p>
                              <div class="wherefromtesti-blk">
                                <div class="wherefromtesti">
                                    <?php $wherefromtesti = get_field('where_from_reviews'); ?>
                                    <?php if ($wherefromtesti == 'Avvo') { ?>
                                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/wherefortesti-avvo-icon.webp" alt="Avvo Icon">
                                    <?php } elseif ($wherefromtesti == 'Facebook') { ?>
                                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/wherefortesti-facebook-icon.webp" alt="Facebook Icon">
                                    <?php } else { ?>
                                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/wherefortesti-google-icon.webp" alt="Google Icon">
                                    <?php } ?>
                                </div>
                                <h5><?php the_title(); ?></h5>
                            </div>
                        </div>
                        <?php
                    endforeach;
                    wp_reset_postdata();
                endif;
                ?>
            </section>
            </div>
        </div>
    </div>
</main>

<?php
get_footer();
