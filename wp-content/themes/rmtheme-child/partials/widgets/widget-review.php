<?php
/**
 * Template part for displaying related posts from reviews
 *
 * This file is intended to be called from a template using get_template_part().
 */


//do we make this a function in the function.php file for all to call to? DO WE???????????????????????????????????

// Set the name of your custom post type here
$custom_post_type = 'reviews';

$num_post_show = 5;

$related_posts = getRelatedCPT($custom_post_type, $num_post_show);

// The Loop - modify the html to fit the design
if ( $related_posts->have_posts() ) :?>

    <section class="widget testi">
        <h4 class="widget-title">Testimonials</h4>
        <div class="testi-sdbr-blk owl-carousel">        
            <?php while ( $related_posts->have_posts() ) : $related_posts->the_post(); ?>
                <div class="testi-item">
                    <div class="testi-content">                
                        <?php if ($testi_info = get_field('testi_info')): ?>
                            <h5><?php echo $testi_info; ?></h5>
                        <?php endif; ?>
                        <div class="star-rat"></div>
                        <p><?php echo wp_trim_words(get_the_content(), 50); ?></p>                        
                        <h6 class="testi-name">- <?php echo get_the_title(); ?></h6>
                    </div>
                </div>
             <?php endwhile; ?>
        </div>
    </section>


<?php
endif;

// Reset the post data to restore the main query
wp_reset_postdata();