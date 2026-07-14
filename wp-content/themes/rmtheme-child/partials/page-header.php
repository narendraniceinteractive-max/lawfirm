<?php
/**
 * The template for displaying the page header.
 *
 * @package OceanWP WordPress theme
 */
// Exit if accessed directly.
?>
<section id="main-heading">
    <div class="page-container">
        <?php if (is_404()) { ?>
            <h1 class="page-title"><?php _e('Oops! That page can&rsquo;t be found.', 'rmtheme'); ?></h1>
        <?php } elseif (is_home() && !is_front_page()) { ?>
            <h1>Blog</h1> 
        <?php } else { ?>
            <h1><?php the_title(); ?></h1> 
        <?php } ?>
        <div class="inrpg-breadcrumbs" typeof="BreadcrumbList" vocab="https://schema.org/">
            <?php
            if (function_exists('bcn_display')) {
                bcn_display();
            }
            ?>
        </div>
    </div>
</section>

