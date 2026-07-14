<?php
/**
 * Template part for displaying related posts from case results
 *
 * This file is intended to be called from a template using get_template_part().
 */

// Set the name of your custom post type here
$custom_post_type = 'case_result';

$num_post_show = 5;

$related_posts = getRelatedCPT($custom_post_type, $num_post_show );

// The Loop - modify the html, acf fields, or whatever is needed to fit the design
if ( $related_posts->have_posts() ) :?>


    <section class="widget csae-res">
         <h4 class="widget-title">Case Results</h4>
            <div class="case-sdbr-blk owl-carousel">          
            <?php while ( $related_posts->have_posts() ) : $related_posts->the_post(); ?>
                <div class="sdbr-case-item">
                    <div class="case-content">
                        <h4 class="case-title"><?php echo get_the_title(); ?></h4>
                        <p><?php echo wp_trim_words(get_the_content(), 30); ?></p>
                    </div>
                </div> 
            <?php endwhile; ?>
        </div>
    </section>





<?php
endif;

// Reset the post data to restore the main query
wp_reset_postdata();