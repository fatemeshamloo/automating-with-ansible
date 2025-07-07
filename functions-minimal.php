<?php
/**
 * Art of Iran Theme Functions - Minimal Version
 * 
 * @package ArtOfIran
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Theme Setup
 */
function artofiran_theme_setup() {
    // Add theme support for post thumbnails
    add_theme_support('post-thumbnails');
    
    // Add theme support for custom logo
    add_theme_support('custom-logo');
    
    // Add theme support for title tag
    add_theme_support('title-tag');
    
    // Register navigation menus
    register_nav_menus(array(
        'main-menu' => 'منوی اصلی',
    ));
    
    // Add WooCommerce support if WooCommerce is active
    if (class_exists('WooCommerce')) {
        add_theme_support('woocommerce');
    }
}
add_action('after_setup_theme', 'artofiran_theme_setup');

/**
 * Enqueue Scripts and Styles
 */
function artofiran_scripts() {
    // Enqueue main stylesheet
    wp_enqueue_style('artofiran-style', get_stylesheet_uri());
    
    // Enqueue RTL stylesheet if needed
    if (is_rtl()) {
        wp_enqueue_style('artofiran-rtl', get_template_directory_uri() . '/rtl.css');
    }
}
add_action('wp_enqueue_scripts', 'artofiran_scripts');

/**
 * Register Widget Areas
 */
function artofiran_widgets_init() {
    register_sidebar(array(
        'name'          => 'Footer Widget Area',
        'id'            => 'footer-1',
        'before_widget' => '<div class="widget">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3>',
        'after_title'   => '</h3>',
    ));
}
add_action('widgets_init', 'artofiran_widgets_init');

/**
 * Theme Customizer
 */
function artofiran_customize_register($wp_customize) {
    // Welcome Message
    $wp_customize->add_section('artofiran_settings', array(
        'title' => 'تنظیمات قالب',
    ));
    
    $wp_customize->add_setting('welcome_message', array(
        'default' => 'به هنر ایران خوش آمدید',
    ));
    
    $wp_customize->add_control('welcome_message', array(
        'label'   => 'پیام خوش‌آمدگویی',
        'section' => 'artofiran_settings',
        'type'    => 'text',
    ));
}
add_action('customize_register', 'artofiran_customize_register');