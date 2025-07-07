<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php wp_title('|', true, 'right'); ?><?php bloginfo('name'); ?></title>
    
    <!-- Vazir Font for Persian/Farsi support -->
    <link href="https://cdn.jsdelivr.net/gh/rastikerdar/vazir-font@v30.1.0/dist/font-face.css" rel="stylesheet" type="text/css" />
    
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php 
    if (function_exists('wp_body_open')) {
        wp_body_open(); 
    }
    ?>
    
    <header id="masthead" class="site-header">
        <div class="site-branding">
            <?php if (has_custom_logo()) : ?>
                <?php the_custom_logo(); ?>
            <?php else : ?>
                <h1 class="site-title">
                    <a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
                        <?php bloginfo('name'); ?>
                    </a>
                </h1>
                <?php 
                $description = get_bloginfo('description', 'display');
                if ($description || is_customize_preview()) : ?>
                    <p class="site-description"><?php echo $description; ?></p>
                <?php endif; ?>
            <?php endif; ?>
        </div>

        <!-- Currency Switcher (for WooCommerce multi-currency) -->
        <?php if (function_exists('woocommerce_currency_switcher')) : ?>
            <div class="currency-switcher">
                <?php echo do_shortcode('[woocommerce_currency_switcher]'); ?>
            </div>
        <?php endif; ?>

        <!-- Mobile Menu Toggle -->
        <button class="menu-toggle" onclick="toggleMobileMenu()">☰</button>
        
        <nav id="site-navigation" class="main-navigation">
            <?php
            if (has_nav_menu('main-menu')) {
                wp_nav_menu(array(
                    'theme_location' => 'main-menu',
                    'menu_id'        => 'primary-menu',
                    'fallback_cb'    => false,
                ));
            } else {
                wp_page_menu(array(
                    'menu_id'        => 'primary-menu',
                ));
            }
            ?>
        </nav>
    </header>

    <main id="primary" class="site-main">
        
        <!-- Welcome Message -->
        <?php if (is_home() || is_front_page()) : ?>
            <div class="welcome-message">
                <?php echo esc_html(get_theme_mod('welcome_message', 'به هنر ایران خوش آمدید - کیفیت و اصالت در هر اثر')); ?>
            </div>
        <?php endif; ?>

        <!-- Breadcrumbs -->
        <?php if (function_exists('woocommerce_breadcrumb') && !is_front_page()) : ?>
            <div class="breadcrumbs">
                <?php woocommerce_breadcrumb(); ?>
            </div>
        <?php endif; ?>

        <?php if (have_posts()) : ?>
            
            <?php 
            $is_shop = false;
            if (function_exists('is_shop') && function_exists('is_product_category') && function_exists('is_product_tag')) {
                $is_shop = is_shop() || is_product_category() || is_product_tag();
            }
            ?>
            
            <?php if ($is_shop) : ?>
                <!-- WooCommerce Product Grid -->
                <div class="product-grid">
                    <?php while (have_posts()) : the_post(); ?>
                        <?php 
                        if (function_exists('wc_get_template_part')) {
                            wc_get_template_part('content', 'product'); 
                        } else {
                            // Fallback for when WooCommerce is not active
                            get_template_part('content', 'product');
                        }
                        ?>
                    <?php endwhile; ?>
                </div>
                
                <?php
                // WooCommerce hooks
                if (function_exists('do_action')) {
                    do_action('woocommerce_after_shop_loop');
                }
                ?>
                
            <?php else : ?>
                <!-- Blog Posts -->
                <?php while (have_posts()) : the_post(); ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                        <header class="entry-header">
                            <?php if (is_singular()) : ?>
                                <?php the_title('<h1 class="entry-title">', '</h1>'); ?>
                            <?php else : ?>
                                <?php the_title('<h2 class="entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h2>'); ?>
                            <?php endif; ?>
                        </header>

                        <div class="entry-content">
                            <?php
                            if (is_singular()) {
                                the_content();
                            } else {
                                the_excerpt();
                            }
                            ?>
                        </div>

                        <footer class="entry-footer">
                            <div class="entry-meta">
                                <span class="posted-on"><?php echo get_the_date(); ?></span>
                                <span class="byline"><?php echo get_the_author(); ?></span>
                                <?php if (has_category()) : ?>
                                    <span class="cat-links"><?php the_category(', '); ?></span>
                                <?php endif; ?>
                            </div>
                        </footer>
                    </article>
                <?php endwhile; ?>
            <?php endif; ?>

            <!-- Pagination -->
            <div class="navigation pagination">
                <?php
                if (function_exists('woocommerce_pagination')) {
                    woocommerce_pagination();
                } elseif (function_exists('the_posts_pagination')) {
                    the_posts_pagination();
                } else {
                    posts_nav_link();
                }
                ?>
            </div>

        <?php else : ?>
            
            <section class="no-results not-found">
                <header class="page-header">
                    <h1 class="page-title"><?php esc_html_e('هیچ چیزی یافت نشد', 'artofiran'); ?></h1>
                </header>

                <div class="page-content">
                    <?php if (is_home() && current_user_can('publish_posts')) : ?>
                        <p><?php esc_html_e('آماده انتشار اولین پست خود هستید؟', 'artofiran'); ?></p>
                    <?php elseif (is_search()) : ?>
                        <p><?php esc_html_e('متأسفانه هیچ چیزی برای جستجوی شما یافت نشد. لطفا با کلمات کلیدی متفاوت تلاش کنید.', 'artofiran'); ?></p>
                    <?php else : ?>
                        <p><?php esc_html_e('به نظر می‌رسد ما نمی‌توانیم آنچه را که به دنبال آن هستید پیدا کنیم.', 'artofiran'); ?></p>
                    <?php endif; ?>
                </div>
            </section>

        <?php endif; ?>
    </main>

    <!-- Social Links -->
    <div class="social-links">
        <?php if (get_theme_mod('instagram_url')) : ?>
            <a href="<?php echo esc_url(get_theme_mod('instagram_url')); ?>" class="social-link" target="_blank">اینستاگرام</a>
        <?php endif; ?>
        <?php if (get_theme_mod('telegram_url')) : ?>
            <a href="<?php echo esc_url(get_theme_mod('telegram_url')); ?>" class="social-link" target="_blank">تلگرام</a>
        <?php endif; ?>
        <?php if (get_theme_mod('whatsapp_url')) : ?>
            <a href="<?php echo esc_url(get_theme_mod('whatsapp_url')); ?>" class="social-link" target="_blank">واتساپ</a>
        <?php endif; ?>
    </div>

    <footer id="colophon" class="site-footer">
        <div class="footer-widgets">
            <?php if (is_active_sidebar('footer-1')) : ?>
                <div class="footer-widget-area">
                    <?php dynamic_sidebar('footer-1'); ?>
                </div>
            <?php endif; ?>
        </div>
        
        <div class="site-info">
            <p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. <?php esc_html_e('تمامی حقوق محفوظ است.', 'artofiran'); ?></p>
            <?php if (get_theme_mod('footer_text')) : ?>
                <p><?php echo wp_kses_post(get_theme_mod('footer_text')); ?></p>
            <?php endif; ?>
        </div>
    </footer>

    <script>
        function toggleMobileMenu() {
            const menu = document.querySelector('#primary-menu');
            if (menu) {
                menu.classList.toggle('show');
            }
        }
    </script>

    <?php wp_footer(); ?>
</body>
</html>