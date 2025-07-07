<?php
/**
 * Art of Iran Theme Functions - Professional Edition
 * 
 * @package ArtOfIran
 * @version 2.0
 * @author Shamloo
 * @link https://artofiran.com
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Define theme constants
define('ARTOFIRAN_VERSION', '2.0.0');
define('ARTOFIRAN_THEME_DIR', get_template_directory());
define('ARTOFIRAN_THEME_URI', get_template_directory_uri());
define('ARTOFIRAN_ASSETS_URI', ARTOFIRAN_THEME_URI . '/assets');

/**
 * Theme Setup and Support
 */
function artofiran_setup() {
    // Make theme available for translation
    load_theme_textdomain('artofiran', ARTOFIRAN_THEME_DIR . '/languages');

    // Add theme support for various features
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', [
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script'
    ]);
    
    // Add RSS feed links to head
    add_theme_support('automatic-feed-links');
    
    // Add support for responsive embeds
    add_theme_support('responsive-embeds');
    
    // Add support for editor styles
    add_theme_support('editor-styles');
    add_editor_style('assets/css/editor-style.css');
    
    // Add support for wide and full alignment
    add_theme_support('align-wide');
    
    // Add custom logo support
    add_theme_support('custom-logo', [
        'height'      => 120,
        'width'       => 400,
        'flex-height' => true,
        'flex-width'  => true,
        'header-text' => ['site-title', 'site-description'],
    ]);

    // WooCommerce support
    add_theme_support('woocommerce', [
        'thumbnail_image_width' => 300,
        'single_image_width'    => 600,
        'product_grid'          => [
            'default_rows'    => 3,
            'min_rows'        => 2,
            'max_rows'        => 8,
            'default_columns' => 4,
            'min_columns'     => 2,
            'max_columns'     => 5,
        ],
    ]);
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');

    // Custom header support
    add_theme_support('custom-header', [
        'default-image'          => '',
        'width'                  => 1920,
        'height'                 => 500,
        'flex-height'            => true,
        'flex-width'             => true,
        'uploads'                => true,
        'random-default'         => false,
        'header-text'            => true,
        'default-text-color'     => '000000',
        'wp-head-callback'       => 'artofiran_header_style',
    ]);

    // Custom background support
    add_theme_support('custom-background', [
        'default-color'      => 'fafafa',
        'default-image'      => '',
        'default-repeat'     => 'repeat',
        'default-position-x' => 'left',
        'default-attachment' => 'scroll',
    ]);

    // Register navigation menus
    register_nav_menus([
        'primary'   => __('Primary Menu', 'artofiran'),
        'footer'    => __('Footer Menu', 'artofiran'),
        'mobile'    => __('Mobile Menu', 'artofiran'),
        'top'       => __('Top Bar Menu', 'artofiran'),
    ]);

    // Add image sizes
    add_image_size('product-thumb', 300, 300, true);
    add_image_size('product-large', 600, 600, true);
    add_image_size('hero-image', 1920, 800, true);
    add_image_size('card-image', 400, 250, true);
    add_image_size('gallery-thumb', 150, 150, true);

    // Set content width
    global $content_width;
    if (!isset($content_width)) {
        $content_width = 1200;
    }
}
add_action('after_setup_theme', 'artofiran_setup');

/**
 * Enqueue scripts and styles
 */
function artofiran_enqueue_scripts() {
    // Google Fonts - Vazir
    wp_enqueue_style(
        'artofiran-fonts',
        'https://fonts.googleapis.com/css2?family=Vazir:wght@300;400;500;600;700;800&display=swap',
        [],
        null
    );

    // Main stylesheet
    wp_enqueue_style(
        'artofiran-style',
        get_stylesheet_uri(),
        [],
        ARTOFIRAN_VERSION
    );

    // RTL stylesheet
    if (is_rtl()) {
        wp_enqueue_style(
            'artofiran-rtl',
            ARTOFIRAN_ASSETS_URI . '/css/rtl.css',
            ['artofiran-style'],
            ARTOFIRAN_VERSION
        );
    }

    // Main JavaScript
    wp_enqueue_script(
        'artofiran-main',
        ARTOFIRAN_ASSETS_URI . '/js/main.js',
        ['jquery'],
        ARTOFIRAN_VERSION,
        true
    );

    // Intersection Observer for animations
    wp_enqueue_script(
        'artofiran-animations',
        ARTOFIRAN_ASSETS_URI . '/js/animations.js',
        ['artofiran-main'],
        ARTOFIRAN_VERSION,
        true
    );

    // Localize script for Ajax
    wp_localize_script('artofiran-main', 'artofiran_ajax', [
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce'    => wp_create_nonce('artofiran_nonce'),
        'strings'  => [
            'loading'    => __('Loading...', 'artofiran'),
            'load_more'  => __('Load More', 'artofiran'),
            'no_more'    => __('No more items', 'artofiran'),
            'error'      => __('Something went wrong', 'artofiran'),
        ]
    ]);

    // Comment reply script
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }

    // Conditional scripts
    if (is_woocommerce() || is_cart() || is_checkout() || is_account_page()) {
        wp_enqueue_script(
            'artofiran-woocommerce',
            ARTOFIRAN_ASSETS_URI . '/js/woocommerce.js',
            ['jquery', 'artofiran-main'],
            ARTOFIRAN_VERSION,
            true
        );
    }
}
add_action('wp_enqueue_scripts', 'artofiran_enqueue_scripts');

/**
 * Register widget areas
 */
function artofiran_widgets_init() {
    // Primary sidebar
    register_sidebar([
        'name'          => __('Primary Sidebar', 'artofiran'),
        'id'            => 'sidebar-1',
        'description'   => __('Add widgets here to appear in your sidebar.', 'artofiran'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ]);

    // Footer widgets (4 columns)
    for ($i = 1; $i <= 4; $i++) {
        register_sidebar([
            'name'          => sprintf(__('Footer Widget %d', 'artofiran'), $i),
            'id'            => 'footer-' . $i,
            'description'   => sprintf(__('Add widgets here to appear in footer column %d.', 'artofiran'), $i),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h4 class="widget-title">',
            'after_title'   => '</h4>',
        ]);
    }

    // Shop sidebar
    register_sidebar([
        'name'          => __('Shop Sidebar', 'artofiran'),
        'id'            => 'shop-sidebar',
        'description'   => __('Widgets for shop pages.', 'artofiran'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title">',
        'after_title'   => '</h4>',
    ]);

    // Header widget area
    register_sidebar([
        'name'          => __('Header Widget Area', 'artofiran'),
        'id'            => 'header-widgets',
        'description'   => __('Widgets for header area.', 'artofiran'),
        'before_widget' => '<div id="%1$s" class="header-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h5 class="header-widget-title">',
        'after_title'   => '</h5>',
    ]);
}
add_action('widgets_init', 'artofiran_widgets_init');

/**
 * Customize the excerpt
 */
function artofiran_excerpt_length($length) {
    return is_admin() ? $length : 25;
}
add_filter('excerpt_length', 'artofiran_excerpt_length', 999);

function artofiran_excerpt_more($more) {
    return is_admin() ? $more : ' <a href="' . get_permalink() . '" class="read-more">' . __('Read More', 'artofiran') . '</a>';
}
add_filter('excerpt_more', 'artofiran_excerpt_more');

/**
 * WooCommerce customizations
 */
function artofiran_woocommerce_setup() {
    // Remove default WooCommerce styles
    add_filter('woocommerce_enqueue_styles', '__return_empty_array');
    
    // Remove WooCommerce breadcrumbs (we'll use Yoast)
    remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
    
    // Remove WooCommerce sidebar
    remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar', 10);
    
    // Modify loop products per page
    add_filter('loop_shop_per_page', function() {
        return 12;
    }, 20);
    
    // Change number of related products
    add_filter('woocommerce_output_related_products_args', function($args) {
        $args['posts_per_page'] = 4;
        $args['columns'] = 4;
        return $args;
    });
}
add_action('init', 'artofiran_woocommerce_setup');

/**
 * Add Yoast breadcrumbs
 */
function artofiran_yoast_breadcrumbs() {
    if (function_exists('yoast_breadcrumb') && !is_front_page()) {
        yoast_breadcrumb('<div class="breadcrumbs container">', '</div>');
    }
}
add_action('artofiran_before_content', 'artofiran_yoast_breadcrumbs');

/**
 * Dokan compatibility
 */
function artofiran_dokan_compatibility() {
    if (class_exists('WeDevs_Dokan')) {
        add_filter('dokan_locate_template', function($template, $template_name, $args) {
            $theme_template = ARTOFIRAN_THEME_DIR . '/dokan/' . $template_name;
            return file_exists($theme_template) ? $theme_template : $template;
        }, 10, 3);
    }
}
add_action('init', 'artofiran_dokan_compatibility');

/**
 * Custom post types and taxonomies
 */
function artofiran_register_post_types() {
    // Artist post type
    register_post_type('artist', [
        'labels' => [
            'name'               => __('Artists', 'artofiran'),
            'singular_name'      => __('Artist', 'artofiran'),
            'menu_name'          => __('Artists', 'artofiran'),
            'add_new'            => __('Add New Artist', 'artofiran'),
            'add_new_item'       => __('Add New Artist', 'artofiran'),
            'edit_item'          => __('Edit Artist', 'artofiran'),
            'new_item'           => __('New Artist', 'artofiran'),
            'view_item'          => __('View Artist', 'artofiran'),
            'search_items'       => __('Search Artists', 'artofiran'),
            'not_found'          => __('No artists found', 'artofiran'),
            'not_found_in_trash' => __('No artists found in trash', 'artofiran'),
        ],
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => ['slug' => 'artist'],
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 5,
        'menu_icon'          => 'dashicons-art',
        'supports'           => ['title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'],
        'show_in_rest'       => true,
    ]);

    // Portfolio post type
    register_post_type('portfolio', [
        'labels' => [
            'name'               => __('Portfolio', 'artofiran'),
            'singular_name'      => __('Portfolio Item', 'artofiran'),
            'menu_name'          => __('Portfolio', 'artofiran'),
            'add_new'            => __('Add New Item', 'artofiran'),
            'add_new_item'       => __('Add New Portfolio Item', 'artofiran'),
            'edit_item'          => __('Edit Portfolio Item', 'artofiran'),
            'new_item'           => __('New Portfolio Item', 'artofiran'),
            'view_item'          => __('View Portfolio Item', 'artofiran'),
            'search_items'       => __('Search Portfolio', 'artofiran'),
            'not_found'          => __('No portfolio items found', 'artofiran'),
            'not_found_in_trash' => __('No portfolio items found in trash', 'artofiran'),
        ],
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => ['slug' => 'portfolio'],
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 6,
        'menu_icon'          => 'dashicons-portfolio',
        'supports'           => ['title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'],
        'show_in_rest'       => true,
    ]);
}
add_action('init', 'artofiran_register_post_types');

/**
 * Customizer settings
 */
function artofiran_customize_register($wp_customize) {
    // Theme Options Panel
    $wp_customize->add_panel('artofiran_theme_options', [
        'title'    => __('Art of Iran Options', 'artofiran'),
        'priority' => 30,
    ]);

    // Header Section
    $wp_customize->add_section('artofiran_header', [
        'title'    => __('Header Settings', 'artofiran'),
        'panel'    => 'artofiran_theme_options',
        'priority' => 10,
    ]);

    // Header Layout
    $wp_customize->add_setting('header_layout', [
        'default'           => 'default',
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('header_layout', [
        'label'   => __('Header Layout', 'artofiran'),
        'section' => 'artofiran_header',
        'type'    => 'select',
        'choices' => [
            'default' => __('Default', 'artofiran'),
            'center'  => __('Centered', 'artofiran'),
            'minimal' => __('Minimal', 'artofiran'),
        ],
    ]);

    // Social Media Section
    $wp_customize->add_section('artofiran_social', [
        'title'    => __('Social Media', 'artofiran'),
        'panel'    => 'artofiran_theme_options',
        'priority' => 20,
    ]);

    $social_networks = [
        'instagram' => __('Instagram', 'artofiran'),
        'telegram'  => __('Telegram', 'artofiran'),
        'whatsapp'  => __('WhatsApp', 'artofiran'),
        'facebook'  => __('Facebook', 'artofiran'),
        'twitter'   => __('Twitter', 'artofiran'),
        'youtube'   => __('YouTube', 'artofiran'),
        'linkedin'  => __('LinkedIn', 'artofiran'),
    ];

    foreach ($social_networks as $network => $label) {
        $wp_customize->add_setting($network . '_url', [
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ]);
        $wp_customize->add_control($network . '_url', [
            'label'   => $label . ' ' . __('URL', 'artofiran'),
            'section' => 'artofiran_social',
            'type'    => 'url',
        ]);
    }

    // Typography Section
    $wp_customize->add_section('artofiran_typography', [
        'title'    => __('Typography', 'artofiran'),
        'panel'    => 'artofiran_theme_options',
        'priority' => 30,
    ]);

    // Body Font Size
    $wp_customize->add_setting('body_font_size', [
        'default'           => '16',
        'sanitize_callback' => 'absint',
    ]);
    $wp_customize->add_control('body_font_size', [
        'label'   => __('Body Font Size (px)', 'artofiran'),
        'section' => 'artofiran_typography',
        'type'    => 'number',
        'input_attrs' => [
            'min'  => 12,
            'max'  => 24,
            'step' => 1,
        ],
    ]);

    // Performance Section
    $wp_customize->add_section('artofiran_performance', [
        'title'    => __('Performance', 'artofiran'),
        'panel'    => 'artofiran_theme_options',
        'priority' => 40,
    ]);

    // Lazy Loading
    $wp_customize->add_setting('enable_lazy_loading', [
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ]);
    $wp_customize->add_control('enable_lazy_loading', [
        'label'   => __('Enable Lazy Loading', 'artofiran'),
        'section' => 'artofiran_performance',
        'type'    => 'checkbox',
    ]);

    // Minify CSS
    $wp_customize->add_setting('minify_css', [
        'default'           => false,
        'sanitize_callback' => 'wp_validate_boolean',
    ]);
    $wp_customize->add_control('minify_css', [
        'label'   => __('Minify CSS', 'artofiran'),
        'section' => 'artofiran_performance',
        'type'    => 'checkbox',
    ]);
}
add_action('customize_register', 'artofiran_customize_register');

/**
 * Performance optimizations
 */
function artofiran_performance_optimizations() {
    // Remove WordPress version
    remove_action('wp_head', 'wp_generator');
    
    // Remove RSD link
    remove_action('wp_head', 'rsd_link');
    
    // Remove wlwmanifest link
    remove_action('wp_head', 'wlwmanifest_link');
    
    // Remove shortlink
    remove_action('wp_head', 'wp_shortlink_wp_head');
    
    // Remove feed links
    remove_action('wp_head', 'feed_links_extra', 3);
    
    // Disable emoji scripts
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('admin_print_styles', 'print_emoji_styles');
    
    // Remove jQuery migrate
    add_action('wp_default_scripts', function($scripts) {
        if (!is_admin() && isset($scripts->registered['jquery'])) {
            $script = $scripts->registered['jquery'];
            if ($script->deps) {
                $script->deps = array_diff($script->deps, ['jquery-migrate']);
            }
        }
    });
}
add_action('init', 'artofiran_performance_optimizations');

/**
 * Security enhancements
 */
function artofiran_security_enhancements() {
    // Remove WordPress version from scripts and styles
    add_filter('style_loader_src', 'artofiran_remove_version_from_assets', 15, 1);
    add_filter('script_loader_src', 'artofiran_remove_version_from_assets', 15, 1);
    
    // Hide login errors
    add_filter('login_errors', function() {
        return __('Invalid credentials.', 'artofiran');
    });
    
    // Remove WordPress version from RSS feeds
    add_filter('the_generator', '__return_empty_string');
}
add_action('init', 'artofiran_security_enhancements');

function artofiran_remove_version_from_assets($src) {
    if (strpos($src, 'ver=')) {
        $src = remove_query_arg('ver', $src);
    }
    return $src;
}

/**
 * Custom functions for theme features
 */

// Get social media links
function artofiran_get_social_links() {
    $social_networks = ['instagram', 'telegram', 'whatsapp', 'facebook', 'twitter', 'youtube', 'linkedin'];
    $links = [];
    
    foreach ($social_networks as $network) {
        $url = get_theme_mod($network . '_url');
        if (!empty($url)) {
            $links[$network] = $url;
        }
    }
    
    return $links;
}

// Dynamic welcome message based on geolocation
function artofiran_dynamic_welcome_message() {
    if (function_exists('geoip_detect2_get_info_from_current_ip')) {
        $record = geoip_detect2_get_info_from_current_ip();
        $country = $record->country->isoCode;
        
        if ($country === 'IR') {
            return __('خوش آمدید به فروشگاه هنر ایران!', 'artofiran');
        } else {
            return __('Welcome to Art of Iran Store!', 'artofiran');
        }
    }
    
    return __('Welcome to Art of Iran Store!', 'artofiran');
}

// Get featured products
function artofiran_get_featured_products($limit = 8) {
    if (!class_exists('WooCommerce')) {
        return [];
    }
    
    $args = [
        'post_type'      => 'product',
        'posts_per_page' => $limit,
        'meta_query'     => [
            [
                'key'   => '_featured',
                'value' => 'yes',
            ],
        ],
        'orderby' => 'menu_order title',
        'order'   => 'ASC',
    ];
    
    return new WP_Query($args);
}

// Lazy loading images
function artofiran_add_lazy_loading($attr, $attachment, $size) {
    if (get_theme_mod('enable_lazy_loading', true)) {
        $attr['loading'] = 'lazy';
    }
    return $attr;
}
add_filter('wp_get_attachment_image_attributes', 'artofiran_add_lazy_loading', 10, 3);

// Custom header style
function artofiran_header_style() {
    $header_text_color = get_header_textcolor();
    
    if (!empty($header_text_color) && $header_text_color !== '000000') {
        echo '<style type="text/css">';
        echo '.site-title a, .site-description { color: #' . esc_attr($header_text_color) . '; }';
        echo '</style>';
    }
}

// Ajax load more products
function artofiran_load_more_products() {
    check_ajax_referer('artofiran_nonce', 'nonce');
    
    $page = intval($_POST['page'] ?? 1);
    $posts_per_page = intval($_POST['posts_per_page'] ?? 8);
    
    $args = [
        'post_type'      => 'product',
        'posts_per_page' => $posts_per_page,
        'paged'          => $page,
        'post_status'    => 'publish',
    ];
    
    $query = new WP_Query($args);
    
    if ($query->have_posts()) {
        ob_start();
        while ($query->have_posts()) {
            $query->the_post();
            get_template_part('template-parts/content', 'product');
        }
        wp_reset_postdata();
        $html = ob_get_clean();
        
        wp_send_json_success([
            'html'     => $html,
            'has_more' => $page < $query->max_num_pages,
        ]);
    } else {
        wp_send_json_error(['message' => __('No more products found.', 'artofiran')]);
    }
}
add_action('wp_ajax_artofiran_load_more_products', 'artofiran_load_more_products');
add_action('wp_ajax_nopriv_artofiran_load_more_products', 'artofiran_load_more_products');

// Schema markup for products
function artofiran_product_schema_markup() {
    if (is_product()) {
        global $product;
        
        $schema = [
            '@context'    => 'https://schema.org/',
            '@type'       => 'Product',
            'name'        => get_the_title(),
            'description' => wp_strip_all_tags(get_the_excerpt()),
            'sku'         => $product->get_sku(),
            'offers'      => [
                '@type'         => 'Offer',
                'price'         => $product->get_price(),
                'priceCurrency' => get_woocommerce_currency(),
                'availability'  => $product->is_in_stock() ? 'InStock' : 'OutOfStock',
            ],
        ];
        
        if (has_post_thumbnail()) {
            $schema['image'] = get_the_post_thumbnail_url(get_the_ID(), 'full');
        }
        
        echo '<script type="application/ld+json">' . wp_json_encode($schema) . '</script>';
    }
}
add_action('wp_head', 'artofiran_product_schema_markup');

// Custom admin styles
function artofiran_admin_styles() {
    wp_enqueue_style(
        'artofiran-admin',
        ARTOFIRAN_ASSETS_URI . '/css/admin.css',
        [],
        ARTOFIRAN_VERSION
    );
}
add_action('admin_enqueue_scripts', 'artofiran_admin_styles');

// Flush rewrite rules on theme activation
function artofiran_flush_rewrite_rules() {
    artofiran_register_post_types();
    flush_rewrite_rules();
}
add_action('after_switch_theme', 'artofiran_flush_rewrite_rules');

// Clean up on theme deactivation
function artofiran_theme_deactivation() {
    flush_rewrite_rules();
}
add_action('switch_theme', 'artofiran_theme_deactivation');

// Include additional theme files
require_once ARTOFIRAN_THEME_DIR . '/inc/customizer.php';
require_once ARTOFIRAN_THEME_DIR . '/inc/template-tags.php';
require_once ARTOFIRAN_THEME_DIR . '/inc/woocommerce.php';

// Load Dokan compatibility if Dokan is active
if (class_exists('WeDevs_Dokan')) {
    require_once ARTOFIRAN_THEME_DIR . '/inc/dokan.php';
}

// Load WPML compatibility if WPML is active
if (defined('ICL_SITEPRESS_VERSION')) {
    require_once ARTOFIRAN_THEME_DIR . '/inc/wpml.php';
}
?>