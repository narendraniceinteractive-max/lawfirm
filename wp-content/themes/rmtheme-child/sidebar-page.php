<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package rmtheme
 */
$menuFieldID = get_field("nav_menu_for_sidebar");
if (empty($menuFieldID)) {
    $menuFieldID = acf_get_field('nav_menu_for_sidebar')['nav_menu_sidebar'];
}
$menuObj = wp_get_nav_menu_object($menuFieldID);
$menuNameHeader = is_object($menuObj) ? $menuObj->name : '';
?>
<div class="sidebar-page">
    <section class="sidebar-item sidebar-practice-menu">
        <h2><?php echo $menuNameHeader; ?></h2>
        <div class="sidebar-menu-pa">
            <?php wp_nav_menu(array('menu' => $menuFieldID, 'container' => false, 'menu_class' => 'sidebar-menu')); ?>
        </div>
    </section>
    <?php get_template_part('partials/widgets/widget', 'review'); ?>

    <?php /* get_template_part('partials/widgets/widget', 'case-result'); ?>

    <?php get_template_part('partials/widgets/widget', 'related-post'); ?>

    <?php get_template_part('partials/widgets/widget', 'team-member');*/ ?>

</div>