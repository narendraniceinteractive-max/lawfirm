<?php

/** Testimonials CTA Shortcode */
function testimonial_cta_box($atts) {
    $atts = shortcode_atts(array(
        'title' => '',
        'posts' => 3,
        'background' => '', // keep parameter for compatibility, but unused
        'button_text' => 'Read More Reviews',
        'button_link' => '#',
        'taxonomy' => 'post_tag',
        'tag_slug' => '',
        'text_color' => '',
        'heading_color' => '',
        'background_color' => '',
            ), $atts, 'testimonial_block');

    ob_start();

    $args = array(
        'post_type' => 'reviews',
        'posts_per_page' => intval($atts['posts']),
        'post_status' => 'publish'
    );

    if (!empty($atts['tag_slug'])) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => $atts['taxonomy'],
                'field' => 'slug',
                'terms' => $atts['tag_slug'],
            ),
        );
    }

    $testimonial_query = new WP_Query($args);

    if ($testimonial_query->have_posts()) :
        ?>
        <section class="testimonial-cta-block">
            <div class="overlay"></div>
            <div class="container">
                <div class="testi-cta-title"><?php echo esc_html($atts['title']); ?></div>
                <div class="testi-slider owl-carousel" style="<?php echo!empty($atts['background_color']) ? 'background-color:' . esc_attr($atts['background_color']) . ';' : ''; ?>">
                    <?php while ($testimonial_query->have_posts()) : $testimonial_query->the_post(); ?>
                        <div class="testi-item">
                            <div class="testi-content">
                                <h6 class="testi-name" style="<?php echo!empty($atts['heading_color']) ? 'color:' . esc_attr($atts['heading_color']) . ';' : ''; ?>">
                                    <?php echo esc_html(get_the_title()); ?>
                                </h6>
                                <div class="star-rating-list">
                                    <?php if (get_field('where_from_review_logo')) { ?>
                                        <div class="where-from-review-logo">
                                            <a <?php if (get_field('where_from_review_link')) { ?> href="<?php echo get_field('where_from_review_link'); ?>" target="_blank" <?php } ?>>
                                                <img src="<?php echo get_field('where_from_review_logo'); ?>" alt="where from review image">
                                            </a>
                                        </div>
                                    <?php } ?>
                                    <div class="star-rating">
                                        <img src="<?php echo home_url(); ?>/wp-content/themes/rmtheme-child/images/sdbr-start-img.webp" alt="">
                                    </div>
                                </div>
                                <p style="<?php echo!empty($atts['text_color']) ? 'color:' . esc_attr($atts['text_color']) . ';' : ''; ?>">
                                    <?php echo wp_trim_words(get_the_content(), 30); ?>
                                </p>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
                <?php if (!empty($atts['button_text'])) : ?>
                    <div class="cta-btn">
                        <a href="<?php echo esc_url($atts['button_link']); ?>" class="btn-primary cmn-btn">
                            <?php echo esc_html($atts['button_text']); ?>
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </section>
        <?php
    endif;

    wp_reset_postdata();
    return ob_get_clean();
}

add_shortcode('testimonial_block', 'testimonial_cta_box');

function add_testimonial_cta_meta_box() {
    add_meta_box('testimonial_cta_shortcode_box', 'Testimonial CTA Shortcode', 'display_testimonial_cta_meta_box', 'page', 'side', 'high');
}

add_action('add_meta_boxes', 'add_testimonial_cta_meta_box');

function display_testimonial_cta_meta_box($post) {
    $shortcode = '[testimonial_block title="What Our Clients Say" posts="3" button_text="Read More Reviews" button_link="#" taxonomy="post_tag" tag_slug="happy-clients" text_color="#000" heading_color="#000" background_color="#f9f9f9"]';
    echo '<textarea readonly style="width:100%; height:120px;" onclick="this.select();">' . esc_textarea($shortcode) . '</textarea>';
    echo '<p>Copy this shortcode and paste it where you want the testimonial CTA block to appear.<br><strong>Optional:</strong> Use <code>text_color</code> and <code>heading_color</code> to change text colors.<br>Example:<br><code>text_color="#000" heading_color="#ff6600"</code></p>';
}

/** Case Results CTA Shortcode */
function related_case_results_shortcode($atts, $content = '') {
    $atts = shortcode_atts(array(
        'title' => '',
        'posts' => 4,
        'columns' => 3,
        'background' => home_url('/wp-content/uploads/2025/07/rizeup_sample.png'),
        'button_text' => 'View All Case Results',
        'button_link' => '#',
        'taxonomy' => 'post_tag',
        'tag_slug' => '',
        'item_bg_color' => '',
        'title_color' => '',
        'excerpt_color' => '',
            ), $atts, 'related_case_results');

    $args = array(
        'post_type' => 'case_result',
        'posts_per_page' => intval($atts['posts']),
        'post_status' => 'publish',
    );

    if (!empty($atts['tag_slug'])) {
        $args['tax_query'] = array(array(
                'taxonomy' => $atts['taxonomy'],
                'field' => 'slug',
                'terms' => $atts['tag_slug'],
        ));
    }

    $caseresult = new WP_Query($args);
    ob_start();

    if ($caseresult->have_posts()) :
        $columns = max(1, intval($atts['columns']));
        $unique_id = uniqid('case_results_');
        ?>
        <section class="case-results-cta" 
                 id="<?php echo esc_attr($unique_id); ?>" 
                 style="background-image:url('<?php echo esc_url($atts['background']); ?>'); background-size:cover; background-position:center;">

            <div class="container">
                <?php if (!empty($atts['title'])) : ?>
                    <div class="caseresult-cta-title"><?php echo esc_html($atts['title']); ?></div>
                <?php endif; ?>

                <div class="case-slider case-grid">
                    <?php while ($caseresult->have_posts()) : $caseresult->the_post(); ?>
                        <div class="case-item">
                            <h4 class="case-title"><?php the_title(); ?></h4>
                            <p class="case-excerpt"><?php echo esc_html(wp_trim_words(get_the_content(), 30)); ?></p>
                        </div>
                    <?php endwhile; ?>
                </div>
                <?php if (!empty($atts['button_text'])) : ?>
                    <div class="cta-btn">
                        <a href="<?php echo esc_url($atts['button_link']); ?>" class="btn-primary cmn-btn">
                            <?php echo esc_html($atts['button_text']); ?>
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </section>

        <style>
            /* Responsive grid */
            #<?php echo esc_attr($unique_id); ?> .case-grid {
                display: grid;
                gap: 20px;
                grid-template-columns: repeat(<?php echo $columns; ?>, 1fr);
            }

            @media (max-width: 992px) {
                #<?php echo esc_attr($unique_id); ?> .case-grid {
                    grid-template-columns: repeat(2, 1fr);
                }
            }
            @media (max-width: 480px) {
                #<?php echo esc_attr($unique_id); ?> .case-grid {
                    grid-template-columns: repeat(1, 1fr);
                }
            }

            /* Default styles */
            #<?php echo esc_attr($unique_id); ?> .case-item {
                background: rgba(255, 255, 255, 0.9);
                padding: 20px;
                border-radius: 10px;
                transition: background 0.3s ease;
            }
            #<?php echo esc_attr($unique_id); ?> .case-title {
                color: #000;
                margin-bottom: 10px;
            }
            #<?php echo esc_attr($unique_id); ?> .case-excerpt {
                color: #333;
            }

            /* ✅ Override if shortcode specifies custom values */
            <?php if (!empty($atts['item_bg_color'])) : ?>
                #<?php echo esc_attr($unique_id); ?> .case-item {
                    background: <?php echo esc_attr($atts['item_bg_color']); ?> !important;
                }
            <?php endif; ?>

            <?php if (!empty($atts['title_color'])) : ?>
                #<?php echo esc_attr($unique_id); ?> .case-title {
                    color: <?php echo esc_attr($atts['title_color']); ?> !important;
                }
            <?php endif; ?>

            <?php if (!empty($atts['excerpt_color'])) : ?>
                #<?php echo esc_attr($unique_id); ?> .case-excerpt {
                    color: <?php echo esc_attr($atts['excerpt_color']); ?> !important;
                }
            <?php endif; ?>

            #<?php echo esc_attr($unique_id); ?> .cta-button {
                display: inline-block;
                padding: 10px 25px;
                background: #0073aa;
                color: #fff;
                text-decoration: none;
                border-radius: 5px;
                transition: background 0.3s ease;
            }

            #<?php echo esc_attr($unique_id); ?> .cta-button:hover {
                background: #005f8c;
            }
        </style>
        <?php
    endif;

    wp_reset_postdata();
    return ob_get_clean();
}

add_shortcode('related_case_results', 'related_case_results_shortcode');

/* Case Results CTA Meta Box */

function add_case_results_cta_meta_box() {
    add_meta_box(
            'case_results_cta_shortcode_box',
            'Case Results CTA Shortcode',
            'display_case_results_cta_meta_box',
            'page',
            'side',
            'high'
    );
}

add_action('add_meta_boxes', 'add_case_results_cta_meta_box');

function display_case_results_cta_meta_box($post) {
    $shortcode = '[related_case_results title="Recent Case Results" posts="3" columns="3" background="/wp-content/uploads/2025/07/rizeup_sample.png" button_text="View All Case Results" button_link="#" taxonomy="post_tag" tag_slug="your-tag-slug" item_bg_color="#f7f7f7" title_color="#fff" excerpt_color="#555"]';

    echo '<textarea readonly style="width:100%; height:180px;" onclick="this.select();">'
    . esc_textarea($shortcode)
    . '</textarea>';

    echo '<p>Copy this shortcode and paste it where you want the Case Results CTA block to appear.</p>
    <p><strong>Options:</strong></p>
    <ul style="margin-left:15px; list-style:disc;">
        <li><code>tag_slug="your-tag-slug"</code> — Filter posts by tag.</li>
        <li><code>columns="3"</code> — Set number of columns on desktop (auto 2 on tablet, 1 on mobile).</li>
        <li><code>item_bg_color="#f7f7f7"</code> — Override each item’s background color.</li>
        <li><code>title_color="#fff"</code> — Override case title color.</li>
        <li><code>excerpt_color="#555555"</code> — Override excerpt text color.</li>
        <li>Leave colors empty to use the default styling.</li>
    </ul>';
}

/* Related Insights Shortcode with Meta Box */

function related_insights_shortcode($atts) {
    $atts = shortcode_atts(array(
        'posts' => 5,
        'columns' => 3, // Number of columns on desktop
        'post_type' => 'post',
        'title' => '',
        'taxonomy' => 'post_tag',
        'tag_slug' => '',
        'post_ids' => '', // ✅ New: specific post IDs (comma-separated)
        'heading_color' => '', // color for h3
        'text_color' => '', // color for p
        'hover_color' => '', // background hover color
        'bg_color' => '', // default background color
        'padding' => '', // default padding
            ), $atts, 'related_insights');

    $num_post_show = intval($atts['posts']);
    $num_columns = max(1, intval($atts['columns']));
    $custom_post_type = sanitize_text_field($atts['post_type']);
    $heading_color = sanitize_hex_color($atts['heading_color']);
    $text_color = sanitize_hex_color($atts['text_color']);
    $hover_color = sanitize_hex_color($atts['hover_color']);
    $bg_color = sanitize_hex_color($atts['bg_color']) ?: '#f9f9f9'; // default
    $padding = !empty($atts['padding']) ? esc_attr($atts['padding']) : '20px';
    $post_ids = !empty($atts['post_ids']) ? array_map('intval', explode(',', $atts['post_ids'])) : [];

    // Base query args
    $args = array(
        'post_type' => $custom_post_type,
        'posts_per_page' => $num_post_show,
        'post_status' => 'publish',
        'orderby' => 'date',
        'order' => 'DESC',
        'post__not_in' => array(get_the_ID()),
    );

    // ✅ Combine: specific post IDs + tag filter
    $meta_query_relation = 'OR';
    $tax_query = array();

    // Add tag filter if provided
    if (!empty($atts['tag_slug'])) {
        $tax_query[] = array(
            'taxonomy' => $atts['taxonomy'],
            'field' => 'slug',
            'terms' => explode(',', $atts['tag_slug']),
        );
    }

    // Add specific post IDs if provided
    if (!empty($post_ids)) {
        $args['post__in'] = $post_ids;
        $args['orderby'] = 'post__in';
    }

    // Apply tax_query only if tags exist
    if (!empty($tax_query)) {
        $args['tax_query'] = $tax_query;
    }

    $related_posts = new WP_Query($args);
    ob_start();

    if ($related_posts->have_posts()) :
        ?>
        <section class="widget widget_related_insights">
            <?php if (!empty($atts['title'])) : ?>
                <div class="posts-cta-title"><?php echo esc_html($atts['title']); ?></div>
            <?php endif; ?>

            <div class="related-insights-posts related-insights-columns-<?php echo $num_columns; ?>">
                <?php while ($related_posts->have_posts()) : $related_posts->the_post(); ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class('posts-list'); ?>>
                        <div class="posts-thumbnail">
                            <a href="<?php the_permalink(); ?>">
                                <?php if (has_post_thumbnail()) : ?>
                                    <?php the_post_thumbnail('medium', array('alt' => get_the_title())); ?>
                                <?php else : ?>
                                    <img src="<?php echo esc_url(get_stylesheet_directory_uri() . '/images/default-post.webp'); ?>" alt="<?php the_title_attribute(); ?>" width="398" height="241">
                                <?php endif; ?>
                            </a>
                        </div>
                        <div class="posts-block">
                            <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                            <p><?php echo wp_kses_post(wp_trim_words(get_the_excerpt(), 20, '...')); ?></p>
                        </div>
                    </article>
                <?php endwhile; ?>
            </div>
        </section>

        <style>
            @media (max-width: 991px) {
                .related-insights-posts {
                    grid-template-columns: repeat(2, 1fr) !important;
                }
            }

            @media (max-width: 600px) {
                .related-insights-posts {
                    grid-template-columns: repeat(1, 1fr) !important;
                }
            }
            .related-insights-posts {
                display: grid;
                grid-template-columns: repeat(<?php echo $num_columns; ?>, 1fr);
                gap: 20px;
            }
            .related-insights-posts .posts-list {
                background-color: <?php echo $bg_color; ?>;
                padding: <?php echo $padding; ?>;
                transition: all 0.3s ease;
            }
            <?php if ($hover_color) : ?>
                .related-insights-posts .posts-list:hover {
                    background-color: <?php echo $hover_color; ?> !important;
                }
            <?php endif; ?>
            <?php if ($heading_color) : ?>
                .related-insights-posts .posts-block h3 a {
                    color: <?php echo $heading_color; ?> !important;
                }
            <?php endif; ?>
            <?php if ($text_color) : ?>
                .related-insights-posts .posts-block p {
                    color: <?php echo $text_color; ?> !important;
                }
            <?php endif; ?>

        </style>
        <?php
    endif;

    wp_reset_postdata();
    return ob_get_clean();
}

add_shortcode('related_insights', 'related_insights_shortcode');

function add_related_insights_cta_meta_box() {
    add_meta_box(
            'related_insights_cta_shortcode_box',
            'Related Insights Shortcode',
            'display_related_insights_cta_meta_box',
            'page',
            'side',
            'high'
    );
}

add_action('add_meta_boxes', 'add_related_insights_cta_meta_box');

function display_related_insights_cta_meta_box($post) {
    $shortcode = '[related_insights posts="5" columns="3" post_type="post" title="Related Insights" taxonomy="post_tag" tag_slug="your-tag-slug" post_ids="12,34,56" heading_color="#000000" text_color="#333333" hover_color="#f0f0f0" bg_color="#f9f9f9" padding="10px"]';

    echo '<textarea readonly style="width:100%; height:160px;" onclick="this.select();">'
    . esc_textarea($shortcode)
    . '</textarea>';
    echo '<p style="font-size: 12px; margin-top: 5px;">
        Use this shortcode anywhere to display Related Insights.<br><br>
        <b>Options:</b><br>
        • <code>posts="5"</code> → Number of posts to show.<br>
        • <code>columns="3"</code> → Number of columns.<br>
        • <code>tag_slug="your-tag"</code> → Filter by tag(s).<br>
        • <code>post_ids="12,34,56"</code> → Show specific posts.<br>
        • You can use both <code>tag_slug</code> and <code>post_ids</code> together.<br>
        • <code>heading_color</code>, <code>text_color</code>, <code>hover_color</code>, <code>bg_color</code>, and <code>padding</code> customize styles.
    </p>';
}

/*
  Team Member Shortcode
 */

function team_member_shortcode($atts) {
    $atts = shortcode_atts(array(
        'posts' => 3,
        'columns' => 3,
        'taxonomy' => 'post_tag',
        'tag_slug' => '',
        'post_ids' => '',
        'button_text' => 'See More Attorneys',
        'button_link' => '#',
        'title' => '',
        'border_color' => '#cccccc',
        'hover_color' => '#ff0000',
        'name_color' => '#000000',
        'summary_color' => '#333333',
            ), $atts, 'team_member');

    ob_start();

    $custom_post_type = 'team_member';

    $args = array(
        'post_type' => $custom_post_type,
        'posts_per_page' => intval($atts['posts']),
        'post_status' => 'publish',
    );
    if (!empty($atts['post_ids'])) {
        $post_ids = array_map('intval', explode(',', $atts['post_ids']));
        $args['post__in'] = $post_ids;
        $args['orderby'] = 'post__in'; // preserve order of IDs
    } elseif (!empty($atts['tag_slug'])) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => $atts['taxonomy'],
                'field' => 'slug',
                'terms' => $atts['tag_slug'],
            ),
        );
    }
    $team_query = new WP_Query($args);
    if ($team_query->have_posts()) :
        $unique_id = uniqid('team_member_');
        $columns = max(1, min(6, intval($atts['columns'])));
        ?>
        <style>
            #<?php echo esc_attr($unique_id); ?> .team-inner-list {
                display: grid;
                grid-template-columns: repeat(<?php echo esc_attr($columns); ?>, 1fr);
                gap: 20px;
            }
            #<?php echo esc_attr($unique_id); ?> .team_member_item {
                text-align: center;
                transition: transform 0.3s ease, box-shadow 0.3s ease;
            }
            #<?php echo esc_attr($unique_id); ?> .team_member_name a {
                color: <?php echo esc_attr($atts['name_color']); ?>;
                text-decoration: none;
                font-weight: 600;
                transition: color 0.3s ease;
            }
            #<?php echo esc_attr($unique_id); ?> .team_member_name a:hover {
                color: <?php echo esc_attr($atts['hover_color']); ?>;
            }
            #<?php echo esc_attr($unique_id); ?> .team_member_summary p {
                color: <?php echo esc_attr($atts['summary_color']); ?>;
            }
            @media (max-width: 768px) {
                #<?php echo esc_attr($unique_id); ?> .team-inner-list {
                    grid-template-columns: repeat(2, 1fr);
                }
            }
            @media (max-width: 480px) {
                #<?php echo esc_attr($unique_id); ?> .team-inner-list {
                    grid-template-columns: repeat(1, 1fr);
                }
            }
        </style>
        <section id="<?php echo esc_attr($unique_id); ?>" class="widget widget_team_member">
            <?php if (!empty($atts['title'])) : ?>
                <div class="team-cta-title"><?php echo esc_html($atts['title']); ?></div>
            <?php endif; ?>

            <div class="team-inner-list">
                <?php while ($team_query->have_posts()) : $team_query->the_post(); ?>
                    <div class="team_member_item">
                        <div class="team_member_pic">
                            <?php if (get_field('single_profile_page_image')) { ?>
                                <a href="<?php the_permalink(); ?>">
                                    <img src="<?php echo esc_url(get_field('single_profile_page_image')); ?>" alt="<?php the_title(); ?> Image">
                                </a>
                            <?php } else { ?>
                                <a href="<?php the_permalink(); ?>">
                                    <img src="<?php echo esc_url(get_stylesheet_directory_uri() . '/images/team-member1.webp'); ?>" alt="<?php the_title(); ?> Image">
                                </a>
                            <?php } ?>
                        </div>
                        <div class="team_member_name">
                            <p><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></p>
                        </div>
                        <?php if (get_field('single_profile_designation')) { ?>
                            <div class="team_member_summary">
                                <p><?php echo esc_html(get_field('single_profile_designation')); ?></p>
                            </div>
                        <?php } ?>
                    </div>
                <?php endwhile; ?>
            </div>
            <?php if (!empty($atts['button_text'])) : ?>
                <div class="cta-btn">
                    <a href="<?php echo esc_url($atts['button_link']); ?>" class="btn-primary cmn-btn">
                        <?php echo esc_html($atts['button_text']); ?>
                    </a>
                </div>
            <?php endif; ?>
        </section>
        <?php
        wp_reset_postdata();
    endif;
    return ob_get_clean();
}

add_shortcode('team_member', 'team_member_shortcode');

/**
 * Team Member CTA Meta Box (unchanged)
 */
function add_team_member_cta_meta_box() {
    add_meta_box(
            'team_member_cta_shortcode_box',
            'Team Member Shortcode',
            'display_team_member_cta_meta_box',
            'page',
            'side',
            'high'
    );
}

add_action('add_meta_boxes', 'add_team_member_cta_meta_box');

function display_team_member_cta_meta_box($post) {
    $shortcode = '[team_member posts="5" columns="3" taxonomy="post_tag" tag_slug="senior-attorneys" title="Attorneys" button_text="See More Attorneys" button_link="#" border_color="#ddd" hover_color="#f00" name_color="#000" summary_color="#333" post_ids="123,456,789"]';
    echo '<textarea readonly style="width:100%; height:100px;" onclick="this.select();">'
    . esc_textarea($shortcode)
    . '</textarea>';
    echo '<p>Copy this shortcode and paste it where you want the Team Member section to appear.<br>
    <strong>Customizable attributes:</strong><br>
    <code>posts</code> – number of team members<br>
    <code>columns</code> – number of columns<br>
    <code>border_color</code> – item border color<br>
    <code>hover_color</code> – title hover color<br>
    <code>name_color</code> – team member name color<br>
    <code>summary_color</code> – summary/excerpt color<br>
    <code>tag_slug</code> – filter by tag<br>
    </p>';
}

/**
 * Custom Block CTA Meta Box
 */
function add_custom_block_cta_meta_box() {
    add_meta_box(
            'custom_block_cta_shortcode_box',
            'Custom Block Shortcode',
            'display_custom_block_cta_meta_box',
            ['page', 'post'], // Show on both pages and posts
            'side',
            'high'
    );
}

add_action('add_meta_boxes', 'add_custom_block_cta_meta_box');

/**
 * Display the Custom Block Shortcode Meta Box
 */
function display_custom_block_cta_meta_box($post) {
    $shortcode = '[custom_block]';
    echo '<textarea readonly style="width:100%; height:60px;" onclick="this.select();">'
    . esc_textarea($shortcode)
    . '</textarea>';
    echo '<p>Copy and paste this shortcode where you want the <strong>Custom Block</strong> to appear.</p>';
}

/**
 * Custom Block Shortcode Function
 */
function custom_block_shortcode() {
    ob_start();
    ?>
    <div class="custom-block-list">
        <?php echo get_field('custom_block_content'); ?>
    </div>
    <?php
    return ob_get_clean();
}

add_shortcode('custom_block', 'custom_block_shortcode');



