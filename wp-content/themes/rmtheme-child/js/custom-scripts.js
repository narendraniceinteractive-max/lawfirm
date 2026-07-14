// Function to open the floating menu
const floatingMenu = () => {
    document.getElementById('floatingMenu').classList.add('openMenu');
};
document.addEventListener('DOMContentLoaded', function () {
    const closeButtons = document.querySelectorAll('#cloaseFloatingMenu, #cloaseFloatingMenu2');
    closeButtons.forEach(button => {
        button.addEventListener('click', () => {
            document.getElementById('floatingMenu').classList.remove('openMenu');
        });
    });
    const menuTriggers = document.querySelectorAll('.stickyshowhide, .showhide');
    menuTriggers.forEach(trigger => {
        trigger.addEventListener('click', function (e) {
            e.preventDefault();
            floatingMenu();
        });
    });
    const menuItemsWithChildren = document.querySelectorAll('.sticky-mobinav .menu-item-has-children');
    menuItemsWithChildren.forEach(item => {
        const dropLink = document.createElement('a');
        dropLink.className = 'drop close';
        dropLink.href = 'javascript:void(0)';
        item.appendChild(dropLink);
    });
    const subMenus = document.querySelectorAll('.sticky-mobinav .menu-item-has-children ul.sub-menu');
    subMenus.forEach(subMenu => {
        subMenu.style.display = 'none';
    });
});
document.addEventListener('click', function (event) {
    if (event.target.matches('.sticky-mobinav .menu-item-has-children a.drop')) {
        event.preventDefault();
        const clickedLink = event.target;
        const menuItem = clickedLink.closest('.menu-item');
        const submenu = menuItem.querySelector('.sub-menu');
        if (submenu) {
            if (submenu.style.display === 'block') {
                submenu.style.display = 'none';
            } else {
                submenu.style.display = 'block';
            }
        }
        const siblingItems = menuItem.parentElement.querySelectorAll('.menu-item');
        siblingItems.forEach(item => {
            if (item !== menuItem) {
                const siblingSubmenu = item.querySelector('.sub-menu');
                const siblingLink = item.querySelector('a.drop');
                if (siblingSubmenu) {
                    siblingSubmenu.style.display = 'none';
                }
                if (siblingLink) {
                    siblingLink.classList.remove('open');
                    siblingLink.classList.add('close');
                }
            }
        });
        if (clickedLink.classList.contains('close')) {
            clickedLink.classList.remove('close');
            clickedLink.classList.add('open');
        } else {
            clickedLink.classList.remove('open');
            clickedLink.classList.add('close');
        }
    }
});
document.addEventListener("DOMContentLoaded", function () {
    const header = document.querySelector(".header-sticky");
    if (window.innerWidth > 0) {
        window.addEventListener("scroll", function () {
            if (window.scrollY > 250) {
                header.classList.add("fixed-header");
            } else {
                header.classList.remove("fixed-header");
            }
        });
    }
});
const header = document.querySelector(".site-header");
const toggleClass = "is-sticky";
const fadingOutClass = "is-fading-out";
let lastScroll = window.pageYOffset;
function shouldApplySticky() {
    return window.innerWidth > 991;
}
window.addEventListener("scroll", () => {
    if (!shouldApplySticky())
        return;

    const currentScroll = window.pageYOffset;

    if (currentScroll > lastScroll && currentScroll > 250) {
        header.classList.remove(fadingOutClass);
        header.classList.add(toggleClass);
    } else if (
            currentScroll < lastScroll &&
            currentScroll < 600 &&
            header.classList.contains(toggleClass)
            ) {
        header.classList.add(fadingOutClass);
        setTimeout(() => {
            header.classList.remove(toggleClass);
            header.classList.remove(fadingOutClass);
        }, 300);
    }
    lastScroll = currentScroll;
});
window.addEventListener("resize", () => {
    if (!shouldApplySticky()) {
        header.classList.remove(toggleClass, fadingOutClass);
    }
});
document.addEventListener('DOMContentLoaded', function () {
    const trigger = document.querySelector(".disclaimer-trigger");
    const popup = document.getElementById("disclaimer-container");
    if (trigger && popup) {
        trigger.addEventListener("click", function (e) {
            e.preventDefault();
            popup.classList.toggle("show");
        });
        document.addEventListener("click", function (e) {
            if (!popup.contains(e.target) && e.target !== trigger) {
                popup.classList.remove("show");
            }
        });
    }
    jQuery(".hm-form a.popup").click(function () {
        jQuery(".hm-form span.popuptext").toggleClass("show");
    });
    jQuery('input[type="email"]').bind("cut copy paste", function (e) {
        e.preventDefault();
    });
    jQuery('#input_2_3').bind("cut copy paste", function (e) {
        e.preventDefault();
    });
});
document.addEventListener("DOMContentLoaded", function () {
    const widgets = document.querySelectorAll(".checked_by");

    widgets.forEach(widget => {
        const name = widget.querySelector(".widget-names");
        const description = widget.querySelector(".widget-description");
        name.addEventListener("click", function () {
            name.classList.toggle("nameactive");
            description.classList.toggle("active");
        });
    });
});
jQuery('.testi-sdbr-blk, .case-sdbr-blk, .team-sdbar-list').owlCarousel({
    loop: true,
    touchDrag: true,
    mouseDrag: true,
    nav: true,
    dots: false,
    items: 1,
    margin: 0,
    autoplay: true
});
jQuery('.testi-slider').owlCarousel({
    loop: true,
    touchDrag: true,
    mouseDrag: true,
    nav: false,
    dots: false,
    items: 1,
    margin: 0,
    autoplay: true
});
document.addEventListener('DOMContentLoaded', () => {
    const menuItems = document.querySelectorAll('.sidebar-menu-pa .menu-item-has-children');

    menuItems.forEach(item => {
        const dropToggle = document.createElement('div');
        dropToggle.className = 'drop close';
        dropToggle.setAttribute('role', 'button');
        dropToggle.setAttribute('tabindex', '0');
        item.appendChild(dropToggle);
        const submenu = item.querySelector('ul.sub-menu');
        if (submenu) {
            submenu.style.maxHeight = '0';
            submenu.style.overflow = 'hidden';
            submenu.style.transition = 'max-height 0.3s ease';
            dropToggle.addEventListener('click', () => {
                const isOpen = submenu.classList.contains('open');
                if (isOpen) {
                    submenu.style.maxHeight = submenu.scrollHeight + 'px';
                    submenu.offsetHeight; // force reflow
                    submenu.style.maxHeight = '0';
                    submenu.classList.remove('open');
                    dropToggle.classList.remove('open');
                    dropToggle.classList.add('close');
                } else {
                    submenu.style.maxHeight = submenu.scrollHeight + 'px';
                    submenu.classList.add('open');
                    dropToggle.classList.remove('close');
                    dropToggle.classList.add('open');
                }
            });
            submenu.addEventListener('transitionend', () => {
                if (submenu.classList.contains('open')) {
                    submenu.style.maxHeight = 'none';
                }
            });
        }
    });


    const mountIfExists = (selector, options = {}, extensions = null) => {
        const el = document.querySelector(selector);
        if (el && typeof Splide !== 'undefined') {
            try {
                const splide = new Splide(el, options);
                splide.mount(extensions || {});
            } catch (e) {
                console.error(`Failed to mount Splide on ${selector}:`, e);
            }
    }
    };
    const splideExtensions = typeof Splide !== 'undefined' && Splide.Extensions ? Splide.Extensions : undefined;
    mountIfExists('#sidebar-reviews', {
        type: 'loop',
        perPage: 1,
        perMove: 1,
        autoplay: true,
        interval: 3000,
        speed: 3500,
        autoHeight: true
    });

});
jQuery('.hm-testi-list').owlCarousel({
    loop: true,
    touchDrag: true,
    mouseDrag: true,
    nav: true,
    dots: false,
    items: 2,
    margin: 38,
    autoplay: true
});
jQuery('.hm-insights').owlCarousel({
    loop: true,
    touchDrag: true,
    mouseDrag: true,
    nav: true,
    dots: false,
    items: 2,
    margin: 20,
    autoplay: true
});

jQuery(document).ready(function () {
    jQuery('.checked-left').on('click', function () {
        console.log('test');
        jQuery(this).siblings('.widget-description').toggleClass('fact-active');
    });
});
const headers = document.querySelectorAll('.accordion-profile');
const contents = document.querySelectorAll('.accordion-profile-content');

if (headers.length > 0) {
    const firstHeader = headers[0];
    const firstContent = firstHeader.nextElementSibling;
    firstHeader.classList.add('active');
    firstContent.style.maxHeight = firstContent.scrollHeight + 'px';

    headers.forEach(header => {
        header.addEventListener('click', () => handleAccordion(header));
    });
    contents.forEach(content => {
        content.addEventListener('click', () => {
            const header = content.previousElementSibling;
            handleAccordion(header);
        });
    });
}

function handleAccordion(header) {
    const content = header.nextElementSibling;
    const isOpen = header.classList.contains('active');
    document.querySelectorAll('.accordion-profile').forEach(h => h.classList.remove('active'));
    document.querySelectorAll('.accordion-profile-content').forEach(c => c.style.maxHeight = null);

    if (!isOpen) {
        header.classList.add('active');
        content.style.maxHeight = content.scrollHeight + 'px';
        const headerHeight = jQuery(".site-header, header").outerHeight() || 0;
        jQuery('html, body').animate({
            scrollTop: jQuery(header).offset().top - headerHeight - 250
        }, 400);
    }
}

/* Mobile Slider */
jQuery(document).ready(function () {
    mobilesliders();
    jQuery(window).resize(function () {
        mobilesliders();
    });
    function mobilesliders() {
        if (jQuery(window).width() <= 991) {
            jQuery('.hm-our-serv-blk, .team-blk').addClass('owl-carousel').owlCarousel({
                loop: true,
                autoplay: false,
                autoplayTimeout: 5000,
                autoplayHoverPause: true,
                touchDrag: true,
                mouseDrag: true,
                nav: false,
                dots: true,
                items: 1
            });
        } else {
            jQuery('.hm-our-serv-blk, .team-blk').trigger('destroy.owl.carousel').removeClass('owl-carousel');
        }
    }
});
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.tab-btn').forEach(button => {
        button.addEventListener('click', () => {
            const tabId = button.getAttribute('data-tab');
            document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
            document.querySelectorAll('.tab-content').forEach(tab => tab.classList.remove('active'));
            button.classList.add('active');
            const tabContent = document.getElementById(tabId);
            if (tabContent)
                tabContent.classList.add('active');
        });
    });
});