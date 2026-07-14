<?php
/**
 * Template part for displaying page content in page.php
 * @package themedemo
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class('posts-list'); ?>>
    <?php
    $fallback_image = get_stylesheet_directory() . '/images/default-post.webp';
    $fallback_url = get_stylesheet_directory_uri() . '/images/default-post.webp';
    if (has_post_thumbnail()) {
        $thumb_id = get_post_thumbnail_id(get_the_ID());
        $thumb_data = wp_get_attachment_image_src($thumb_id, 'blog_img');
        $blogUrl = $thumb_data[0];
        $width = $thumb_data[1];
        $height = $thumb_data[2];
    } else {
        $blogUrl = $fallback_url;
        if (file_exists($fallback_image)) {
            $size = getimagesize($fallback_image);
            $width = $size[0];
            $height = $size[1];
        } else {
            $width = $height = '';
        }
    }
    ?>
    <div class="posts-thumbnail">
        <a href="<?php the_permalink(); ?>">
            <img src="<?php echo esc_url($blogUrl); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" width="<?php echo esc_attr($width); ?>" height="<?php echo esc_attr($height); ?>" />
        </a>
    </div>
    <div class="posts-block">
        <div class="author-info">
            <?php
            $author_id = get_the_author_meta('ID');
            $avatar = get_field('author_avatar', 'user_' . $author_id);
            if ($avatar):
                ?>
                <div class="author-avatar">
                    <a href="<?php echo esc_url(get_author_posts_url($author_id)); ?>" target="_blank">
                        <img src="<?php echo esc_url($avatar['url']); ?>" alt="<?php echo esc_attr($avatar['alt']); ?>" width="40px" height="40px" style=" border-radius:100%; border: 1px solid black;">
                    </a>
                </div>
            <?php endif; ?>
            <div class="author-meta">
                <span>By </span>
                <a class="author-link" href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>" rel="author">
                    <?php printf(__(' %s', 'rmtheme'), get_the_author()); ?>
                </a>
            </div>
            <span class="post-dmy"><?php echo get_the_date('M d, Y'); ?></span> | <span class="post-categories"><?php the_category(' , '); ?></span>
        </div>
         <h3><a href="<?php the_permalink(); ?>"><?php echo esc_html(wp_trim_words(get_the_title(), 7, '...')); ?></a></h3>
        <p><?php echo esc_html(wp_trim_words(get_the_content(), 18)); ?></p>
        <div class="posts-readmore"><a href="<?php the_permalink(); ?>">Read More</a></div>
    </div>
</article>