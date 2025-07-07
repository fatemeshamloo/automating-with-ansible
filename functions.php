<?php
/**
 * Art of Iran Theme Functions
 * 
 * @package ArtOfIran
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Theme version
define('ARTOFIRAN_VERSION', '1.0.0');

/**
 * Theme Setup
 */
function artofiran_theme_setup() {
    // Add theme support for post thumbnails
    add_theme_support('post-thumbnails');
    
    // Add theme support for custom logo
    add_theme_support('custom-logo', array(
        'height'      => 100,
        'width'       => 300,
        'flex-height' => true,
        'flex-width'  => true,
    ));
    
    // Add theme support for title tag
    add_theme_support('title-tag');
    
    // Add theme support for HTML5
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));
    
    // Add theme support for responsive embeds
    add_theme_support('responsive-embeds');
    
    // Add theme support for editor styles
    add_theme_support('editor-styles');
    
    // Load text domain for translations
    load_theme_textdomain('artofiran', get_template_directory() . '/languages');
    
    // Register navigation menus
    register_nav_menus(array(
        'main-menu' => esc_html__('منوی اصلی', 'artofiran'),
        'footer-menu' => esc_html__('منوی پاورقی', 'artofiran'),
    ));
}
add_action('after_setup_theme', 'artofiran_theme_setup');

/**
 * Enqueue Scripts and Styles
 */
function artofiran_scripts() {
    // Enqueue main stylesheet
    wp_enqueue_style('artofiran-style', get_stylesheet_uri(), array(), ARTOFIRAN_VERSION);
    
    // Enqueue RTL stylesheet if needed
    if (is_rtl()) {
        wp_enqueue_style('artofiran-rtl', get_template_directory_uri() . '/rtl.css', array('artofiran-style'), ARTOFIRAN_VERSION);
    }
    
    // Check if theme.js file exists before enqueuing
    $theme_js_path = get_template_directory() . '/js/theme.js';
    if (file_exists($theme_js_path)) {
        wp_enqueue_script('artofiran-script', get_template_directory_uri() . '/js/theme.js', array(), ARTOFIRAN_VERSION, true);
    }
    
    // Enqueue comment reply script
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'artofiran_scripts');

/**
 * Add WooCommerce Support (only if WooCommerce is active)
 */
function artofiran_add_woocommerce_support() {
    if (class_exists('WooCommerce')) {
        add_theme_support('woocommerce');
        add_theme_support('wc-product-gallery-zoom');
        add_theme_support('wc-product-gallery-lightbox');
        add_theme_support('wc-product-gallery-slider');
    }
}
add_action('after_setup_theme', 'artofiran_add_woocommerce_support');

/**
 * Disable WooCommerce default styles (only if WooCommerce is active)
 */
function artofiran_disable_woocommerce_styles() {
    if (class_exists('WooCommerce')) {
        add_filter('woocommerce_enqueue_styles', '__return_empty_array');
    }
}
add_action('init', 'artofiran_disable_woocommerce_styles');

/**
 * Custom WooCommerce product card template
 */
function artofiran_woocommerce_product_loop_start() {
    echo '<div class="product-grid">';
}
add_action('woocommerce_output_content_wrapper', 'artofiran_woocommerce_product_loop_start');

function artofiran_woocommerce_product_loop_end() {
    echo '</div>';
}
add_action('woocommerce_output_content_wrapper_end', 'artofiran_woocommerce_product_loop_end');

/**
 * Register Widget Areas
 */
function artofiran_widgets_init() {
    register_sidebar(array(
        'name'          => esc_html__('Footer Widget Area', 'artofiran'),
        'id'            => 'footer-1',
        'description'   => esc_html__('Widgets در این ناحیه در پاورقی سایت نمایش داده می‌شوند.', 'artofiran'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
    
    register_sidebar(array(
        'name'          => esc_html__('Shop Sidebar', 'artofiran'),
        'id'            => 'shop-sidebar',
        'description'   => esc_html__('Widgets در این ناحیه در صفحات فروشگاه نمایش داده می‌شوند.', 'artofiran'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
}
add_action('widgets_init', 'artofiran_widgets_init');

/**
 * Customizer Settings
 */
function artofiran_customize_register($wp_customize) {
    // Add Art of Iran Settings Section
    $wp_customize->add_section('artofiran_settings', array(
        'title'    => esc_html__('تنظیمات هنر ایران', 'artofiran'),
        'priority' => 30,
    ));
    
    // Welcome Message Setting
    $wp_customize->add_setting('welcome_message', array(
        'default'           => 'به هنر ایران خوش آمدید - کیفیت و اصالت در هر اثر',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('welcome_message', array(
        'label'    => esc_html__('پیام خوش‌آمدگویی', 'artofiran'),
        'section'  => 'artofiran_settings',
        'type'     => 'text',
    ));
    
    // Social Media Links
    $social_networks = array(
        'instagram' => 'اینستاگرام',
        'telegram'  => 'تلگرام',
        'whatsapp'  => 'واتساپ',
        'twitter'   => 'توییتر',
        'facebook'  => 'فیسبوک',
    );
    
    foreach ($social_networks as $network => $label) {
        $wp_customize->add_setting($network . '_url', array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ));
        
        $wp_customize->add_control($network . '_url', array(
            'label'    => sprintf(esc_html__('لینک %s', 'artofiran'), $label),
            'section'  => 'artofiran_settings',
            'type'     => 'url',
        ));
    }
    
    // Footer Text Setting
    $wp_customize->add_setting('footer_text', array(
        'default'           => '',
        'sanitize_callback' => 'wp_kses_post',
    ));
    
    $wp_customize->add_control('footer_text', array(
        'label'    => esc_html__('متن اضافی پاورقی', 'artofiran'),
        'section'  => 'artofiran_settings',
        'type'     => 'textarea',
    ));
}
add_action('customize_register', 'artofiran_customize_register');

/**
 * Add Dokan Support (only if Dokan is active)
 */
function artofiran_dokan_support() {
    if (class_exists('WeDevs_Dokan')) {
        add_action('dokan_dashboard_wrap_before', function() {
            echo '<div class="dokan-theme-wrapper">';
        });
        
        add_action('dokan_dashboard_wrap_after', function() {
            echo '</div>';
        });
    }
}
add_action('init', 'artofiran_dokan_support');

/**
 * Custom excerpt length
 */
function artofiran_excerpt_length($length) {
    return 20;
}
add_filter('excerpt_length', 'artofiran_excerpt_length');

/**
 * Custom excerpt more text
 */
function artofiran_excerpt_more($more) {
    return '...';
}
add_filter('excerpt_more', 'artofiran_excerpt_more');

/**
 * Add custom body classes
 */
function artofiran_body_classes($classes) {
    // Add class for RTL support
    if (is_rtl()) {
        $classes[] = 'rtl';
    }
    
    // Add class for WooCommerce pages
    if (class_exists('WooCommerce') && function_exists('is_woocommerce') && is_woocommerce()) {
        $classes[] = 'woocommerce-page';
    }
    
    // Add class for Dokan pages
    if (class_exists('WeDevs_Dokan') && function_exists('dokan_is_store_page') && dokan_is_store_page()) {
        $classes[] = 'dokan-store-page';
    }
    
    return $classes;
}
add_filter('body_class', 'artofiran_body_classes');

/**
 * Modify WooCommerce currency symbol (only if WooCommerce is active)
 */
function artofiran_custom_currency_symbol($currency_symbol, $currency) {
    if (class_exists('WooCommerce')) {
        switch ($currency) {
            case 'IRR':
                $currency_symbol = 'ریال';
                break;
            case 'IRT':
                $currency_symbol = 'تومان';
                break;
        }
    }
    return $currency_symbol;
}
add_filter('woocommerce_currency_symbol', 'artofiran_custom_currency_symbol', 10, 2);

/**
 * Add Persian/Farsi number support
 */
function artofiran_persian_numbers($input) {
    $persian_digits = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');
    $english_digits = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
    
    return str_replace($english_digits, $persian_digits, $input);
}

/**
 * Security: Remove WordPress version from head
 */
remove_action('wp_head', 'wp_generator');

/**
 * Optimize WordPress for Persian/Farsi content
 */
function artofiran_persian_optimization() {
    // Set default timezone to Tehran
    if (get_option('timezone_string') == '') {
        update_option('timezone_string', 'Asia/Tehran');
    }
    
    // Set default date format to Persian
    if (get_option('date_format') == 'F j, Y') {
        update_option('date_format', 'j F Y');
    }
}
add_action('init', 'artofiran_persian_optimization');

/**
 * Add theme customizer for colors
 */
function artofiran_color_customizer($wp_customize) {
    // Colors Section
    $wp_customize->add_section('artofiran_colors', array(
        'title'    => esc_html__('رنگ‌های تم', 'artofiran'),
        'priority' => 40,
    ));
    
    // Primary Color
    $wp_customize->add_setting('primary_color', array(
        'default'           => '#a8d5ba',
        'sanitize_callback' => 'sanitize_hex_color',
    ));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'primary_color', array(
        'label'    => esc_html__('رنگ اصلی', 'artofiran'),
        'section'  => 'artofiran_colors',
    )));
    
    // Accent Color
    $wp_customize->add_setting('accent_color', array(
        'default'           => '#f4c7c3',
        'sanitize_callback' => 'sanitize_hex_color',
    ));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'accent_color', array(
        'label'    => esc_html__('رنگ تأکیدی', 'artofiran'),
        'section'  => 'artofiran_colors',
    )));
}
add_action('customize_register', 'artofiran_color_customizer');

/**
 * Output custom colors to header
 */
function artofiran_custom_colors() {
    $primary_color = get_theme_mod('primary_color', '#a8d5ba');
    $accent_color = get_theme_mod('accent_color', '#f4c7c3');
    
    if ($primary_color !== '#a8d5ba' || $accent_color !== '#f4c7c3') {
        echo '<style type="text/css">';
        echo ':root {';
        echo '--pastel-green: ' . esc_attr($primary_color) . ';';
        echo '--pastel-red: ' . esc_attr($accent_color) . ';';
        echo '}';
        echo '</style>';
    }
}
add_action('wp_head', 'artofiran_custom_colors');

/**
 * Add support for WooCommerce product attributes in Persian
 */
function artofiran_woocommerce_product_attributes() {
    // Add support for Persian product attributes
    add_filter('woocommerce_attribute_label', function($label, $name) {
        $persian_attributes = array(
            'pa_color' => 'رنگ',
            'pa_size'  => 'اندازه',
            'pa_artist' => 'هنرمند',
            'pa_material' => 'جنس',
            'pa_origin' => 'منطقه',
        );
        
        return isset($persian_attributes[$name]) ? $persian_attributes[$name] : $label;
    }, 10, 2);
}
add_action('init', 'artofiran_woocommerce_product_attributes');

/**
 * Enable upload of additional file types for Iranian art
 */
function artofiran_custom_upload_mimes($mimes) {
    // Add support for additional image formats
    $mimes['webp'] = 'image/webp';
    $mimes['avif'] = 'image/avif';
    
    return $mimes;
}
add_filter('upload_mimes', 'artofiran_custom_upload_mimes');