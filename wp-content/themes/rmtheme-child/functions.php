<?php
/**
 * RizeUp Child Theme Functions
 */

/** Enqueue Parent and Child Theme Styles */
function rmtheme_enqueue_styles() {
    // Load parent theme CSS
    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');

    // Load child theme CSS
    wp_enqueue_style('rmtheme-style', get_stylesheet_directory_uri() . '/style.css', array('parent-style'), wp_get_theme()->get('Version'));
}

add_action('wp_enqueue_scripts', 'rmtheme_enqueue_styles');

/** Load Custom Fonts */
function load_custom_fonts() {
    wp_enqueue_style('custom-fonts', get_stylesheet_directory_uri() . '/css/fonts.css', array(), null);
}
add_action('wp_enqueue_scripts', 'load_custom_fonts', 1);

/** Add Custom Image Sizes */
add_image_size('hm_blog_img', 355, 200, true);
add_image_size('blog_img', 388, 217, true);
add_image_size('full_blog_img', 950, 550, true);
add_image_size('rsntblog_img', 952, 413, true);

/** Site Logo Function */
function get_site_logo() {
    $logo_filename = 'logo.webp';
    $logo_path = get_stylesheet_directory() . '/images/' . $logo_filename;
    $logo_url = get_stylesheet_directory_uri() . '/images/' . $logo_filename;

    if (file_exists($logo_path)) {
        list($width, $height) = getimagesize($logo_path);
    } else {
        $width = $height = '';
    }

    $site_logo = '<a href="' . esc_url(home_url('/')) . '" rel="home">';
    $site_logo .= '<img src="' . esc_url($logo_url) . '" alt="' . esc_attr(get_bloginfo('name')) . '" width="' . esc_attr($width) . '" height="' . esc_attr($height) . '" />';
    $site_logo .= '</a>';

    return $site_logo;
}

/** Include Custom Files */
include_once get_stylesheet_directory() . '/functions-inc/breadcrumb-override.php';
include_once get_stylesheet_directory() . '/functions-inc/acf-nav-menu-select-field/init.php';
include_once get_stylesheet_directory() . '/functions-inc/eeat-tag-cat-cpt-team.php';
include_once get_stylesheet_directory() . '/functions-inc/eeat-get-releated-cpt.php';
include_once get_stylesheet_directory() . '/functions-inc/widget-cta-shortcodes.php';


/** ACF Global Settings Page */
if (function_exists('acf_add_options_page')) {
    acf_add_options_page(array(
        'page_title' => 'Global Settings',
        'menu_title' => 'Global Settings',
        'menu_slug' => 'global-settings',
        'capability' => 'edit_posts',
        'redirect' => false
    ));
}

/** Register Menus */
register_nav_menus(array(
    'header-nav' => esc_html__('Header Menu', 'rmtheme'),
    'footer-nav' => esc_html__('Footer Menu', 'rmtheme'),
));

add_action('init', function () {
    register_post_type('reviews', [
        'labels' => [
            'name' => 'Reviews',
            'singular_name' => 'review',
            'add_new' => 'Add New',
            'add_new_item' => 'Add New Review',
            'edit_item' => 'Edit Review',
            'new_item' => 'New Review',
            'view_item' => 'View Review',
            'search_items' => 'Search Reviews',
            'not_found' => 'No Reviews found',
            'not_found_in_trash' => 'No Reviews found in Trash',
            'parent_item_colon' => ''
        ],
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'query_var' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'rewrite' => ['slug' => 'reviews'],
        'supports' => ['title', 'editor'],
        'taxonomies' => array('category', 'post_tag'),
    ]);
});

add_action('add_meta_boxes', function () {
    add_meta_box('review_details', 'Review Details', function ($post) {
        echo '<p>This is the Review Details meta box content.</p>';
    }, 'review', 'normal', 'default');
});
add_action('init', 'case_results_init');
function case_results_init() {
    $labels = array(
        'name' => 'Case Results',
        'singular_name' => 'Case Result',
        'add_new' => 'Add New',
        'add_new_item' => 'Add New Case Result',
        'edit_item' => 'Edit Case Result',
        'new_item' => 'New Case Result',
        'view_item' => 'View Case Result',
        'search_items' => 'Search Case Results',
        'not_found' => 'No Case Results found',
        'not_found_in_trash' => 'No Case Results found in Trash',
        'parent_item_colon' => ''
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'has_archive' => true,
        'publicly_queryable' => false,
        'show_ui' => true,
        'query_var' => false,
        'capability_type' => 'post',
        'hierarchical' => true,
        'rewrite' => false,
        'menu_position' => null,
        'taxonomies' => array('category', 'post_tag'),
        'supports' => array(
            'title',
            'editor',
        // 'thumbnail'
        ),
    );

    register_post_type('case_result', $args);
    flush_rewrite_rules();
}



/** Gravity Forms - Disable Default CSS */
add_filter('gform_disable_css', '__return_true');

/** Memory Limit & Execution Time */
@ini_set('upload_max_size', '64M');
@ini_set('post_max_size', '64M');
@ini_set('max_execution_time', '300');

/** Deregister Example Script (optional cleanup) */
function deregister_isotope() {
    wp_deregister_script('rmtheme-touch-navigation');
}

add_action('wp_print_scripts', 'deregister_isotope');

/** Remove Version Query Strings */
function remove_cssjs_ver($src) {
    if (strpos($src, '?ver='))
        $src = remove_query_arg('ver', $src);
    return $src;
}

add_filter('style_loader_src', 'remove_cssjs_ver', 10, 2);
add_filter('script_loader_src', 'remove_cssjs_ver', 10, 2);

/** Shortcodes in Widgets */
add_filter('widget_text', 'shortcode_unautop');

/** Remove Unused Theme Features */
add_action('after_setup_theme', function () {
    remove_theme_support('custom-header');
    remove_theme_support('custom-background');
});

/** Disable WP Emojis */
function disable_wp_emojis() {
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_styles', 'print_emoji_styles');
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');

    add_filter('tiny_mce_plugins', 'disable_emojis_tinymce');
}

add_action('init', 'disable_wp_emojis');

function disable_emojis_tinymce($plugins) {
    if (is_array($plugins)) {
        return array_diff($plugins, array('wpemoji'));
    }
    return array();
}

/** CTA Shortcode */

function page_cta_box($atts) {
    $atts = shortcode_atts(array(
        'title' => 'Lorem Ipsum is simply dummy text of the printing',
        'title_part' => 'Ut enim ad minim veniam',
        'sub_title' => 'Lorem ipsum dolor sit amet,.',
        'button_text' => 'Contact Us',
        'button_link' => 'https://rizemedia.net/demo-theme/contact/',
        'phone_title' => '',
        'phone_number' => 'Call US: 412-341-8477',
        'phone_text' => '',
        'background' => '#001833',
        'title_color' => '#ffffff',
        'title_part_color' => '#ffcc00',
        'sub_title_color' => '#cccccc',
        'button_color' => '#001833',
        'button_text_color' => '#ffffff',
        'phone_color' => '#ffffff',
    ), $atts, 'cta_block');

    // Clean the phone number for tel: link
    $clean_phone = preg_replace('/[^0-9]/', '', $atts['phone_number']);

    ob_start();
    ?>
    <div class="cmn-box" style="background-color: <?php echo esc_attr($atts['background']); ?>;">
        <h2 style="color: <?php echo esc_attr($atts['title_color']); ?>;">
            <?php echo esc_html($atts['title']); ?>  
            <strong style="color: <?php echo esc_attr($atts['title_part_color']); ?>;">
                <?php echo esc_html($atts['title_part']); ?>
            </strong>
        </h2>
        <p style="color: <?php echo esc_attr($atts['sub_title_color']); ?>;"><?php echo esc_html($atts['sub_title']); ?></p>
        <div class="cmn-box-cnslt-btn">
            <div class="cnslt-btn">
                <a href="<?php echo esc_url($atts['button_link']); ?>" class="cmn-btn" style="background-color: <?php echo esc_attr($atts['button_color']); ?>; color: <?php echo esc_attr($atts['button_text_color']); ?>;">
                    <?php echo esc_html($atts['button_text']); ?>
                </a>
            </div>
            <div class="cnslt-call">
                <a href="tel:<?php echo esc_attr($clean_phone); ?>" class="cmn-btn" style="color: <?php echo esc_attr($atts['phone_color']); ?>;">
                    <?php echo esc_html($atts['phone_number']); ?>
                </a>
            </div>
        </div>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('cta_block', 'page_cta_box');

/**
 * CTA Shortcode Meta Box
 */
function add_cta_shortcode_meta_box() {
    add_meta_box('cta_shortcode_box', 'CTA Shortcode', 'display_cta_shortcode_meta_box', 'page', 'side', 'high');
}
add_action('add_meta_boxes', 'add_cta_shortcode_meta_box');

function display_cta_shortcode_meta_box($post) {
    $shortcode = '[cta_block title="Dedication And Compassion in" title_part="Difficult Times" sub_title="Comprehensive legal assistance in Pittsburgh, Pennsylvania." button_text="Contact Us" button_link="https://rizemedia.net/demo-theme/contact/" phone_number="Call US: 412-341-8477" background="#001833" title_color="#ffffff" title_part_color="#ff0000" sub_title_color="#cccccc" button_color="#ffcc00" button_text_color="#001833" phone_color="#00ff00"]';
    
    echo '<textarea readonly style="width:100%; height:150px;" onclick="this.select();">' . esc_textarea($shortcode) . '</textarea>';
    echo '<p style="font-size: 12px;">Copy this shortcode and paste it where you want the CTA block to appear. You can also modify the colors directly in the shortcode.</p>';
}
