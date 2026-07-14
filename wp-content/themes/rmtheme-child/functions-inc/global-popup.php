<?php
$args = array(
    'post_type' => 'global_popup',
    'meta_key' => 'popup_active',
    'meta_value' => '1',
);

$popups = new WP_Query($args);

if ($popups->have_posts()) :
    while ($popups->have_posts()) : $popups->the_post();
        $popup_id = get_the_ID();
        $content = get_field('popup_content');
        $trigger_type = get_field('popup_trigger_type');
        $scroll_percent = get_field('popup_scroll_percent');
        $manual_class = get_field('popup_manual_trigger_class');
        $delay = get_field('popup_delay');
        ?>
        <div class="global-popup popup<?php echo $popup_id; ?>" 
            id="popup-<?php echo $popup_id; ?>" 
            data-trigger="<?php echo esc_attr($trigger_type); ?>" 
            data-scroll="<?php echo esc_attr($scroll_percent); ?>"
            data-delay="<?php echo esc_attr($delay); ?>" 
            data-manual-class="<?php echo esc_attr($manual_class); ?>"
            style="display:none;">
            <div class="popup-inner">
                <span class="close-popup">&times;</span>
                <?php echo $content; ?>
            </div>
        </div>
        <?php
    endwhile;
    wp_reset_postdata();
endif;
?>

<script>
jQuery(document).ready(function ($) {
    function showPopup($popup) {
        setTimeout(function () {
            $popup.fadeIn();
        }, parseInt($popup.data('delay')));
    }
    $('.global-popup').each(function () {
        let $popup = $(this);
        let trigger = $popup.data('trigger');
        let scrollPercent = parseInt($popup.data('scroll')) || 50;
        let manualClass = $popup.data('manual-class');
        if (trigger === 'on_page_load') {
            showPopup($popup);
        } else if (trigger === 'scroll') {
            $(window).on('scroll', function () {
                let scrolled = ($(window).scrollTop() / ($(document).height() - $(window).height())) * 100;
                if (scrolled >= scrollPercent) {
                    showPopup($popup);
                }
            });
        } else if (trigger === 'exit_intent') {
            $(document).on('mouseleave', function (e) {
                if (e.clientY < 0) {
                    showPopup($popup);
                }
            });
        } else if (trigger === 'manual' && manualClass) {
            $(document).on('click', manualClass, function () {
                showPopup($popup);
            });
        }
    });
    $(document).on('click', '.close-popup', function () {
        $(this).closest('.global-popup').fadeOut();
    });
});
</script>
<style>
.global-popup{position:fixed;top:0;left:0;right:0;bottom:0;background:rgba(0,0,0,0.6);z-index:9999;display:none}
.popup-inner{position:relative;background:#fff;padding:2rem;max-width:500px;margin:10% auto;border-radius:10px;animation:fadeIn 0.3s ease-in-out}
.close-popup{position:absolute;top:10px;right:15px;font-size:24px;cursor:pointer}
@keyframes fadeIn{from{opacity:0;transform:translateY(-30px)}to{opacity:1;transform:translateY(0)}}
</style>