<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package rmtheme
 */
get_header();
?>
<?php include( get_stylesheet_directory() . '/partials/page-header.php' ); ?>

<main id="page-content">
    <div class="page-container">
        <div class="page-col-full">
            <section id="page-column">
                <p><?php _e('It looks like nothing was found at this location.', 'rmtheme'); ?></p>                    
                <p><?php _e('The following are other pages you may find helpful:', 'rmtheme'); ?></p>                    
                <ul>
                    <li><a role="link" href="<?php echo esc_url(home_url('')); ?>">Home</a></li>
                    <li><a role="link" href="<?php echo esc_url(home_url('/about/')); ?>">About</a></li>
                    <li><a role="link" href="<?php echo esc_url(home_url('/contact/')); ?>">Contact</a></li>
                </ul>
            </section>			
        <?php get_sidebar('page'); ?>
        </div>
    </div>
</main>

<?php
get_footer();
