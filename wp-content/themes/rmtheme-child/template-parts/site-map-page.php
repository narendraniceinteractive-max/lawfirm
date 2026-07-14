<?php
/*
 * Template Name: Site Map 
 */

get_header();
?>

<section id="main-heading">
    <div class="page-container">
        <h1><?php echo '<span>' . get_the_title() . '</span>'; ?></h1>
        <div class="inrpg-breadcrumbs" typeof="BreadcrumbList" vocab="https://schema.org/">
            <?php if (function_exists('bcn_display')) bcn_display(); ?>
        </div>
    </div>
</section>

<main id="page-content">
    <div class="page-container">
        <div class="page-col-full">
            <section id="page-column">
                <h2><span>Pages</span></h2>
                <ul class="list sitemap">
                    <?php wp_list_pages('title_li='); ?>
                </ul>
            </section>
            <?php get_sidebar('page'); ?>

        </div>
    </div>
</main>



<?php
get_footer();
