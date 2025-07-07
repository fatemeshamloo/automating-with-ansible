<?php
/**
 * Header Template - Professional Edition
 * 
 * @package ArtOfIran
 * @version 2.0
 */

if (!defined('ABSPATH')) {
    exit;
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    <!-- Preconnect to external domains for performance -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    
    <!-- DNS prefetch for performance -->
    <link rel="dns-prefetch" href="//fonts.googleapis.com">
    <link rel="dns-prefetch" href="//www.google-analytics.com">
    
    <!-- Theme color for mobile browsers -->
    <meta name="theme-color" content="#0f7b0f">
    <meta name="msapplication-TileColor" content="#0f7b0f">
    
    <!-- Prevent automatic detection of telephone numbers -->
    <meta name="format-detection" content="telephone=no">
    
    <!-- Security headers -->
    <meta name="referrer" content="no-referrer-when-downgrade">
    
    <?php wp_head(); ?>
    
    <!-- Remove no-js class and add js class -->
    <script>
        document.documentElement.className = document.documentElement.className.replace('no-js', 'js');
    </script>
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>
    
    <!-- Skip link for accessibility -->
    <a class="sr-only" href="#main"><?php _e('Skip to main content', 'artofiran'); ?></a>
    
    <!-- Scroll to top button -->
    <button id="scroll-to-top" class="scroll-to-top" aria-label="<?php _e('Scroll to top', 'artofiran'); ?>">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="18,15 12,9 6,15"></polyline>
        </svg>
    </button>
    
    <!-- Site wrapper -->
    <div id="page" class="site">
        
        <!-- Header top bar -->
        <?php if (get_theme_mod('show_top_bar', true)) : ?>
            <div class="header-top">
                <div class="container">
                    <div class="header-top-content">
                        <div class="header-top-left">
                            <!-- Dynamic welcome message -->
                            <span class="welcome-text">
                                <?php echo esc_html(artofiran_dynamic_welcome_message()); ?>
                            </span>
                        </div>
                        
                        <div class="header-top-right">
                            <!-- Language switcher (if WPML is active) -->
                            <?php if (function_exists('icl_get_languages')) : ?>
                                <div class="language-switcher">
                                    <?php
                                    $languages = icl_get_languages('skip_missing=0&orderby=code');
                                    if (!empty($languages)) :
                                        foreach ($languages as $lang) :
                                            if (!$lang['active']) :
                                                echo '<a href="' . esc_url($lang['url']) . '" class="lang-link">' . esc_html($lang['code']) . '</a>';
                                            else :
                                                echo '<span class="lang-current">' . esc_html($lang['code']) . '</span>';
                                            endif;
                                        endforeach;
                                    endif;
                                    ?>
                                </div>
                            <?php endif; ?>
                            
                            <!-- Currency switcher -->
                            <?php if (function_exists('woo_multi_currency')) : ?>
                                <div class="currency-switcher">
                                    <?php echo do_shortcode('[woo_multi_currency]'); ?>
                                </div>
                            <?php endif; ?>
                            
                            <!-- User account link -->
                            <?php if (class_exists('WooCommerce')) : ?>
                                <div class="account-link">
                                    <a href="<?php echo esc_url(get_permalink(get_option('woocommerce_myaccount_page_id'))); ?>" 
                                       class="btn-account" 
                                       aria-label="<?php _e('My Account', 'artofiran'); ?>">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                            <circle cx="12" cy="7" r="4"></circle>
                                        </svg>
                                        <span><?php _e('Account', 'artofiran'); ?></span>
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        
        <!-- Main header -->
        <header id="masthead" class="site-header" role="banner">
            <div class="container">
                <div class="header-main">
                    <div class="header-content">
                        
                        <!-- Site branding -->
                        <div class="site-branding">
                            <?php if (has_custom_logo()) : ?>
                                <?php the_custom_logo(); ?>
                            <?php else : ?>
                                <div class="site-title-wrapper">
                                    <?php if (is_front_page() && is_home()) : ?>
                                        <h1 class="site-title">
                                            <a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
                                                <?php bloginfo('name'); ?>
                                            </a>
                                        </h1>
                                    <?php else : ?>
                                        <p class="site-title">
                                            <a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
                                                <?php bloginfo('name'); ?>
                                            </a>
                                        </p>
                                    <?php endif; ?>
                                    
                                    <?php
                                    $description = get_bloginfo('description', 'display');
                                    if ($description || is_customize_preview()) :
                                    ?>
                                        <p class="site-description"><?php echo $description; ?></p>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Search form -->
                        <div class="header-search">
                            <form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
                                <label class="sr-only" for="search-field"><?php _e('Search', 'artofiran'); ?></label>
                                <input type="search" 
                                       id="search-field" 
                                       class="search-field" 
                                       placeholder="<?php _e('Search products...', 'artofiran'); ?>" 
                                       value="<?php echo get_search_query(); ?>" 
                                       name="s">
                                <?php if (class_exists('WooCommerce')) : ?>
                                    <input type="hidden" name="post_type" value="product">
                                <?php endif; ?>
                                <button type="submit" class="search-submit" aria-label="<?php _e('Search', 'artofiran'); ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="11" cy="11" r="8"></circle>
                                        <path d="M21 21l-4.35-4.35"></path>
                                    </svg>
                                </button>
                            </form>
                        </div>
                        
                        <!-- Header actions -->
                        <div class="header-actions">
                            
                            <!-- Wishlist (if plugin is active) -->
                            <?php if (function_exists('YITH_WCWL')) : ?>
                                <div class="header-wishlist">
                                    <a href="<?php echo esc_url(YITH_WCWL()->get_wishlist_url()); ?>" 
                                       class="btn-wishlist" 
                                       aria-label="<?php _e('Wishlist', 'artofiran'); ?>">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                                        </svg>
                                        <span class="wishlist-count"><?php echo yith_wcwl_count_products(); ?></span>
                                    </a>
                                </div>
                            <?php endif; ?>
                            
                            <!-- Shopping cart -->
                            <?php if (class_exists('WooCommerce')) : ?>
                                <div class="header-cart">
                                    <a href="<?php echo esc_url(wc_get_cart_url()); ?>" 
                                       class="btn-cart" 
                                       aria-label="<?php _e('Shopping Cart', 'artofiran'); ?>">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <circle cx="9" cy="21" r="1"></circle>
                                            <circle cx="20" cy="21" r="1"></circle>
                                            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                                        </svg>
                                        <span class="cart-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
                                        <span class="cart-total"><?php echo WC()->cart->get_cart_subtotal(); ?></span>
                                    </a>
                                    
                                    <!-- Mini cart dropdown -->
                                    <div class="mini-cart-dropdown">
                                        <?php woocommerce_mini_cart(); ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                            
                            <!-- Mobile menu toggle -->
                            <button class="menu-toggle" 
                                    aria-controls="primary-menu" 
                                    aria-expanded="false"
                                    aria-label="<?php _e('Toggle navigation', 'artofiran'); ?>">
                                <span class="hamburger">
                                    <span class="hamburger-line"></span>
                                    <span class="hamburger-line"></span>
                                    <span class="hamburger-line"></span>
                                </span>
                                <span class="menu-text"><?php _e('Menu', 'artofiran'); ?></span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Primary navigation -->
            <nav id="site-navigation" class="main-navigation" role="navigation" aria-label="<?php _e('Primary Navigation', 'artofiran'); ?>">
                <div class="container">
                    <?php
                    wp_nav_menu([
                        'theme_location' => 'primary',
                        'menu_id'        => 'primary-menu',
                        'menu_class'     => 'nav-menu',
                        'container'      => false,
                        'depth'          => 3,
                        'fallback_cb'    => 'artofiran_default_menu',
                        'walker'         => new WP_Bootstrap_Navwalker(),
                    ]);
                    ?>
                </div>
            </nav>
        </header>
        
        <!-- Breadcrumbs -->
        <?php do_action('artofiran_before_content'); ?>
        
        <!-- Main content wrapper -->
        <div id="content" class="site-content">
            <div class="container">
                <main id="main" class="site-main" role="main"><?php
/**
 * Default menu fallback
 */
function artofiran_default_menu() {
    echo '<ul id="primary-menu" class="nav-menu">';
    echo '<li><a href="' . esc_url(home_url('/')) . '">' . __('Home', 'artofiran') . '</a></li>';
    
    if (class_exists('WooCommerce')) {
        echo '<li><a href="' . esc_url(get_permalink(wc_get_page_id('shop'))) . '">' . __('Shop', 'artofiran') . '</a></li>';
    }
    
    wp_list_pages([
        'title_li' => '',
        'depth'    => 1,
        'number'   => 5,
    ]);
    
    echo '</ul>';
}

/**
 * Custom Navigation Walker
 */
class WP_Bootstrap_Navwalker extends Walker_Nav_Menu {
    
    public function start_lvl(&$output, $depth = 0, $args = null) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<ul class=\"dropdown-menu\" role=\"menu\">\n";
    }
    
    public function end_lvl(&$output, $depth = 0, $args = null) {
        $indent = str_repeat("\t", $depth);
        $output .= "$indent</ul>\n";
    }
    
    public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $indent = ($depth) ? str_repeat("\t", $depth) : '';
        
        $classes = empty($item->classes) ? [] : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;
        
        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';
        
        $id = apply_filters('nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args);
        $id = $id ? ' id="' . esc_attr($id) . '"' : '';
        
        $output .= $indent . '<li' . $id . $class_names .'>';
        
        $attributes = ! empty($item->attr_title) ? ' title="'  . esc_attr($item->attr_title) .'"' : '';
        $attributes .= ! empty($item->target)     ? ' target="' . esc_attr($item->target     ) .'"' : '';
        $attributes .= ! empty($item->xfn)        ? ' rel="'    . esc_attr($item->xfn        ) .'"' : '';
        $attributes .= ! empty($item->url)        ? ' href="'   . esc_attr($item->url        ) .'"' : '';
        
        $item_output = isset($args->before) ? $args->before : '';
        $item_output .= '<a' . $attributes .'>';
        $item_output .= (isset($args->link_before) ? $args->link_before : '') . apply_filters('the_title', $item->title, $item->ID) . (isset($args->link_after) ? $args->link_after : '');
        $item_output .= '</a>';
        $item_output .= isset($args->after) ? $args->after : '';
        
        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }
    
    public function end_el(&$output, $item, $depth = 0, $args = null) {
        $output .= "</li>\n";
    }
}