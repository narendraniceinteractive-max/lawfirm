<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package rmtheme
 */

get_header();
?>

<section id="main-heading">
    <div class="page-container">
        <h1>Testimonials</h1>
        <div class="breadcrumbs" typeof="BreadcrumbList" vocab="https://schema.org/">
            <?php if (function_exists('bcn_display')) bcn_display(); ?>
        </div>
    </div>
</section>

<main id="page-content" class="content-area">
    <div class="page-container">
        <div class="page-col-full">
            <section id="reviews-main">
                <?php
                    $page_reviews = get_posts([
                        'post_type'      => 'reviews',
                        'posts_per_page' => -1,
                        'orderby'        => 'date',
                        'order'          => 'DESC',
                    ]);

                    if ($page_reviews) : foreach ($page_reviews as $post) : setup_postdata($post);?>
                    <div class="review-item">
                        <div class="star-rat"><!-- Don't Use Empty div's, put something like Rating --></div>
                        <p><?php the_content(); ?></p>
                        <h5><?php the_title(); ?></h5>
                    </div>
                <?php endforeach; wp_reset_postdata(); endif; ?>
            </section>
        </div>
    </div>
</main>
<?php
get_footer();
