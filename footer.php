                </main>
            </div>
        </div>
        
        <!-- Footer -->
        <footer id="colophon" class="site-footer" role="contentinfo">
            
            <!-- Footer widgets section -->
            <?php if (is_active_sidebar('footer-1') || is_active_sidebar('footer-2') || is_active_sidebar('footer-3') || is_active_sidebar('footer-4')) : ?>
                <div class="footer-widgets">
                    <div class="container">
                        <div class="footer-widgets-grid">
                            <?php for ($i = 1; $i <= 4; $i++) : ?>
                                <?php if (is_active_sidebar('footer-' . $i)) : ?>
                                    <div class="footer-widget-column">
                                        <?php dynamic_sidebar('footer-' . $i); ?>
                                    </div>
                                <?php endif; ?>
                            <?php endfor; ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            
            <!-- Newsletter signup section -->
            <?php if (get_theme_mod('show_newsletter', true)) : ?>
                <div class="newsletter-section">
                    <div class="container">
                        <div class="newsletter-content">
                            <div class="newsletter-text">
                                <h3><?php echo esc_html(get_theme_mod('newsletter_title', __('Stay Updated', 'artofiran'))); ?></h3>
                                <p><?php echo esc_html(get_theme_mod('newsletter_description', __('Subscribe to our newsletter for the latest updates and exclusive offers.', 'artofiran'))); ?></p>
                            </div>
                            <div class="newsletter-form">
                                <?php if (function_exists('mc4wp_show_form')) : ?>
                                    <?php mc4wp_show_form(); ?>
                                <?php else : ?>
                                    <form class="newsletter-signup" method="post" action="#" aria-label="<?php _e('Newsletter Signup', 'artofiran'); ?>">
                                        <div class="form-group">
                                            <label class="sr-only" for="newsletter-email"><?php _e('Email Address', 'artofiran'); ?></label>
                                            <input type="email" 
                                                   id="newsletter-email" 
                                                   name="email" 
                                                   placeholder="<?php _e('Enter your email address', 'artofiran'); ?>" 
                                                   required 
                                                   aria-describedby="newsletter-privacy">
                                            <button type="submit" class="btn btn-primary">
                                                <?php _e('Subscribe', 'artofiran'); ?>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <line x1="22" y1="2" x2="11" y2="13"></line>
                                                    <polygon points="22,2 15,22 11,13 2,9"></polygon>
                                                </svg>
                                            </button>
                                        </div>
                                        <p id="newsletter-privacy" class="privacy-notice">
                                            <?php printf(
                                                __('By subscribing, you agree to our %s.', 'artofiran'),
                                                '<a href="' . esc_url(get_privacy_policy_url()) . '">' . __('Privacy Policy', 'artofiran') . '</a>'
                                            ); ?>
                                        </p>
                                    </form>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            
            <!-- Social links and company info -->
            <div class="footer-main">
                <div class="container">
                    <div class="footer-main-content">
                        
                        <!-- Company info -->
                        <div class="company-info">
                            <div class="company-logo">
                                <?php if (has_custom_logo()) : ?>
                                    <?php the_custom_logo(); ?>
                                <?php else : ?>
                                    <h3 class="company-name">
                                        <a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
                                            <?php bloginfo('name'); ?>
                                        </a>
                                    </h3>
                                <?php endif; ?>
                            </div>
                            
                            <div class="company-description">
                                <?php
                                $footer_description = get_theme_mod('footer_description', get_bloginfo('description'));
                                if (!empty($footer_description)) :
                                ?>
                                    <p><?php echo esc_html($footer_description); ?></p>
                                <?php endif; ?>
                            </div>
                            
                            <!-- Contact info -->
                            <div class="contact-info">
                                <?php if (get_theme_mod('contact_phone')) : ?>
                                    <div class="contact-item">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                                        </svg>
                                        <a href="tel:<?php echo esc_attr(get_theme_mod('contact_phone')); ?>">
                                            <?php echo esc_html(get_theme_mod('contact_phone')); ?>
                                        </a>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if (get_theme_mod('contact_email')) : ?>
                                    <div class="contact-item">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                            <polyline points="22,6 12,13 2,6"></polyline>
                                        </svg>
                                        <a href="mailto:<?php echo esc_attr(get_theme_mod('contact_email')); ?>">
                                            <?php echo esc_html(get_theme_mod('contact_email')); ?>
                                        </a>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if (get_theme_mod('contact_address')) : ?>
                                    <div class="contact-item">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                            <circle cx="12" cy="10" r="3"></circle>
                                        </svg>
                                        <span><?php echo esc_html(get_theme_mod('contact_address')); ?></span>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <!-- Quick links -->
                        <div class="quick-links">
                            <h4><?php _e('Quick Links', 'artofiran'); ?></h4>
                            <?php
                            wp_nav_menu([
                                'theme_location' => 'footer',
                                'menu_class'     => 'footer-menu',
                                'container'      => false,
                                'depth'          => 1,
                                'fallback_cb'    => 'artofiran_footer_menu_fallback',
                            ]);
                            ?>
                        </div>
                        
                        <!-- Customer service -->
                        <?php if (class_exists('WooCommerce')) : ?>
                            <div class="customer-service">
                                <h4><?php _e('Customer Service', 'artofiran'); ?></h4>
                                <ul class="service-menu">
                                    <li><a href="<?php echo esc_url(get_permalink(get_option('woocommerce_myaccount_page_id'))); ?>"><?php _e('My Account', 'artofiran'); ?></a></li>
                                    <li><a href="<?php echo esc_url(wc_get_cart_url()); ?>"><?php _e('Shopping Cart', 'artofiran'); ?></a></li>
                                    <li><a href="<?php echo esc_url(get_permalink(get_option('woocommerce_shop_page_id'))); ?>"><?php _e('Shop', 'artofiran'); ?></a></li>
                                    <?php if (function_exists('YITH_WCWL')) : ?>
                                        <li><a href="<?php echo esc_url(YITH_WCWL()->get_wishlist_url()); ?>"><?php _e('Wishlist', 'artofiran'); ?></a></li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                        
                        <!-- Social media links -->
                        <?php
                        $social_links = artofiran_get_social_links();
                        if (!empty($social_links)) :
                        ?>
                            <div class="social-media">
                                <h4><?php _e('Follow Us', 'artofiran'); ?></h4>
                                <div class="social-links">
                                    <?php foreach ($social_links as $network => $url) : ?>
                                        <a href="<?php echo esc_url($url); ?>" 
                                           class="social-link social-<?php echo esc_attr($network); ?>" 
                                           target="_blank" 
                                           rel="noopener noreferrer"
                                           aria-label="<?php printf(__('Follow us on %s', 'artofiran'), ucfirst($network)); ?>">
                                            <?php echo artofiran_get_social_icon($network); ?>
                                        </a>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <!-- Footer bottom -->
            <div class="footer-bottom">
                <div class="container">
                    <div class="footer-bottom-content">
                        <div class="copyright">
                            <p>
                                &copy; <?php echo date('Y'); ?> 
                                <a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
                                    <?php bloginfo('name'); ?>
                                </a>. 
                                <?php _e('All rights reserved.', 'artofiran'); ?>
                            </p>
                        </div>
                        
                        <div class="footer-policies">
                            <ul class="policy-links">
                                <?php if (get_privacy_policy_url()) : ?>
                                    <li><a href="<?php echo esc_url(get_privacy_policy_url()); ?>"><?php _e('Privacy Policy', 'artofiran'); ?></a></li>
                                <?php endif; ?>
                                
                                <?php if (get_theme_mod('terms_page_url')) : ?>
                                    <li><a href="<?php echo esc_url(get_theme_mod('terms_page_url')); ?>"><?php _e('Terms of Service', 'artofiran'); ?></a></li>
                                <?php endif; ?>
                                
                                <?php if (get_theme_mod('cookie_policy_url')) : ?>
                                    <li><a href="<?php echo esc_url(get_theme_mod('cookie_policy_url')); ?>"><?php _e('Cookie Policy', 'artofiran'); ?></a></li>
                                <?php endif; ?>
                            </ul>
                        </div>
                        
                        <!-- Payment methods (if WooCommerce is active) -->
                        <?php if (class_exists('WooCommerce') && get_theme_mod('show_payment_methods', true)) : ?>
                            <div class="payment-methods">
                                <span class="payment-label"><?php _e('We Accept:', 'artofiran'); ?></span>
                                <div class="payment-icons">
                                    <?php
                                    $payment_methods = get_theme_mod('payment_method_icons', ['visa', 'mastercard', 'paypal']);
                                    foreach ($payment_methods as $method) :
                                    ?>
                                        <span class="payment-icon payment-<?php echo esc_attr($method); ?>" aria-label="<?php echo esc_attr(ucfirst($method)); ?>">
                                            <?php echo artofiran_get_payment_icon($method); ?>
                                        </span>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                        
                        <!-- Back to top indicator -->
                        <div class="back-to-top-indicator">
                            <span><?php _e('Made with', 'artofiran'); ?> ❤️ <?php _e('in Iran', 'artofiran'); ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    
    <!-- Cookie consent banner (GDPR compliance) -->
    <?php if (get_theme_mod('show_cookie_banner', true) && !isset($_COOKIE['artofiran_cookies_accepted'])) : ?>
        <div id="cookie-banner" class="cookie-banner" role="banner" aria-label="<?php _e('Cookie Consent', 'artofiran'); ?>">
            <div class="cookie-content">
                <div class="cookie-message">
                    <p>
                        <?php echo wp_kses_post(get_theme_mod('cookie_message', __('We use cookies to enhance your browsing experience and analyze our traffic. By continuing to use our site, you consent to our use of cookies.', 'artofiran'))); ?>
                        <?php if (get_theme_mod('cookie_policy_url')) : ?>
                            <a href="<?php echo esc_url(get_theme_mod('cookie_policy_url')); ?>" class="cookie-policy-link">
                                <?php _e('Learn more', 'artofiran'); ?>
                            </a>
                        <?php endif; ?>
                    </p>
                </div>
                <div class="cookie-actions">
                    <button id="accept-cookies" class="btn btn-primary">
                        <?php _e('Accept All', 'artofiran'); ?>
                    </button>
                    <button id="reject-cookies" class="btn btn-secondary">
                        <?php _e('Reject', 'artofiran'); ?>
                    </button>
                </div>
            </div>
        </div>
    <?php endif; ?>
    
    <!-- Loading overlay -->
    <div id="loading-overlay" class="loading-overlay" aria-hidden="true">
        <div class="loading-spinner">
            <div class="spinner"></div>
            <p><?php _e('Loading...', 'artofiran'); ?></p>
        </div>
    </div>
    
    <?php wp_footer(); ?>
    
    <!-- Schema.org structured data for organization -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Organization",
        "name": "<?php bloginfo('name'); ?>",
        "url": "<?php echo esc_url(home_url('/')); ?>",
        <?php if (has_custom_logo()) : ?>
        "logo": "<?php echo esc_url(wp_get_attachment_image_url(get_theme_mod('custom_logo'), 'full')); ?>",
        <?php endif; ?>
        <?php if (get_theme_mod('contact_phone')) : ?>
        "telephone": "<?php echo esc_attr(get_theme_mod('contact_phone')); ?>",
        <?php endif; ?>
        <?php if (get_theme_mod('contact_email')) : ?>
        "email": "<?php echo esc_attr(get_theme_mod('contact_email')); ?>",
        <?php endif; ?>
        <?php if (get_theme_mod('contact_address')) : ?>
        "address": "<?php echo esc_attr(get_theme_mod('contact_address')); ?>",
        <?php endif; ?>
        "sameAs": [
            <?php
            $social_links = artofiran_get_social_links();
            $social_urls = array_values($social_links);
            echo '"' . implode('","', array_map('esc_url', $social_urls)) . '"';
            ?>
        ]
    }
    </script>
</body>
</html>

<?php
/**
 * Footer menu fallback
 */
function artofiran_footer_menu_fallback() {
    echo '<ul class="footer-menu">';
    echo '<li><a href="' . esc_url(home_url('/')) . '">' . __('Home', 'artofiran') . '</a></li>';
    
    if (get_privacy_policy_url()) {
        echo '<li><a href="' . esc_url(get_privacy_policy_url()) . '">' . __('Privacy Policy', 'artofiran') . '</a></li>';
    }
    
    wp_list_pages([
        'title_li' => '',
        'depth'    => 1,
        'number'   => 3,
    ]);
    
    echo '</ul>';
}

/**
 * Get social media icon SVG
 */
function artofiran_get_social_icon($network) {
    $icons = [
        'instagram' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg>',
        'telegram' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22,2 15,22 11,13 2,9"></polygon></svg>',
        'whatsapp' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>',
        'facebook' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path></svg>',
        'twitter' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"></path></svg>',
        'youtube' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22.54 6.42a2.78 2.78 0 0 0-1.94-2C18.88 4 12 4 12 4s-6.88 0-8.6.46a2.78 2.78 0 0 0-1.94 2A29 29 0 0 0 1 11.75a29 29 0 0 0 .46 5.33A2.78 2.78 0 0 0 3.4 19c1.72.46 8.6.46 8.6.46s6.88 0 8.6-.46a2.78 2.78 0 0 0 1.94-2 29 29 0 0 0 .46-5.25 29 29 0 0 0-.46-5.33z"></path><polygon points="9.75,15.02 15.5,11.75 9.75,8.48"></polygon></svg>',
        'linkedin' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"></path><rect x="2" y="9" width="4" height="12"></rect><circle cx="4" cy="4" r="2"></circle></svg>',
    ];
    
    return isset($icons[$network]) ? $icons[$network] : '';
}

/**
 * Get payment method icon
 */
function artofiran_get_payment_icon($method) {
    $icons = [
        'visa' => '<svg width="40" height="24" viewBox="0 0 40 24" fill="none"><rect width="40" height="24" rx="4" fill="#1A1F71"/><text x="20" y="15" text-anchor="middle" fill="white" font-size="8" font-weight="bold">VISA</text></svg>',
        'mastercard' => '<svg width="40" height="24" viewBox="0 0 40 24" fill="none"><rect width="40" height="24" rx="4" fill="#FF5F00"/><circle cx="15" cy="12" r="6" fill="#EB001B"/><circle cx="25" cy="12" r="6" fill="#F79E1B"/></svg>',
        'paypal' => '<svg width="40" height="24" viewBox="0 0 40 24" fill="none"><rect width="40" height="24" rx="4" fill="#003087"/><text x="20" y="15" text-anchor="middle" fill="white" font-size="6" font-weight="bold">PayPal</text></svg>',
    ];
    
    return isset($icons[$method]) ? $icons[$method] : '';
}
?>