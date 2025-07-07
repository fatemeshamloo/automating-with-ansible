<?php
/**
 * Main Template - Professional Edition
 * 
 * This is the most generic template file in a WordPress theme and one
 * of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * 
 * @package ArtOfIran
 * @version 2.0
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<div class="main-content-wrapper">
    
    <!-- Hero Section -->
    <?php if (is_front_page() && get_theme_mod('show_hero_section', true)) : ?>
        <section class="hero-section">
            <div class="hero-background">
                <?php if (get_theme_mod('hero_background_image')) : ?>
                    <img src="<?php echo esc_url(get_theme_mod('hero_background_image')); ?>" 
                         alt="<?php _e('Hero Background', 'artofiran'); ?>" 
                         class="hero-bg-image"
                         loading="eager">
                <?php endif; ?>
                <div class="hero-overlay"></div>
            </div>
            
            <div class="container">
                <div class="hero-content">
                    <div class="hero-text">
                        <h1 class="hero-title animate-fade-in-up">
                            <?php echo esc_html(get_theme_mod('hero_title', __('Discover the Art of Iran', 'artofiran'))); ?>
                        </h1>
                        <p class="hero-subtitle animate-fade-in-up">
                            <?php echo esc_html(get_theme_mod('hero_subtitle', __('Explore authentic Iranian art and crafts from talented local artists', 'artofiran'))); ?>
                        </p>
                        <div class="hero-actions animate-fade-in-up">
                            <?php if (class_exists('WooCommerce')) : ?>
                                <a href="<?php echo esc_url(get_permalink(wc_get_page_id('shop'))); ?>" 
                                   class="btn btn-primary">
                                    <?php _e('Shop Now', 'artofiran'); ?>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M9 18l6-6-6-6"/>
                                    </svg>
                                </a>
                            <?php endif; ?>
                            <a href="#featured-products" class="btn btn-secondary">
                                <?php _e('Explore Art', 'artofiran'); ?>
                            </a>
                        </div>
                    </div>
                    
                    <?php if (get_theme_mod('hero_featured_image')) : ?>
                        <div class="hero-image animate-fade-in-left">
                            <img src="<?php echo esc_url(get_theme_mod('hero_featured_image')); ?>" 
                                 alt="<?php _e('Featured Art', 'artofiran'); ?>"
                                 loading="eager">
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>
    
    <!-- Featured Categories -->
    <?php if (is_front_page() && class_exists('WooCommerce') && get_theme_mod('show_featured_categories', true)) : ?>
        <section class="featured-categories section">
            <div class="container">
                <div class="section-header">
                    <h2 class="section-title">
                        <?php echo esc_html(get_theme_mod('categories_title', __('Shop by Category', 'artofiran'))); ?>
                    </h2>
                    <p class="section-subtitle">
                        <?php echo esc_html(get_theme_mod('categories_subtitle', __('Discover our diverse collection of Iranian art and crafts', 'artofiran'))); ?>
                    </p>
                </div>
                
                <div class="categories-grid">
                    <?php
                    $featured_categories = get_theme_mod('featured_categories', []);
                    if (empty($featured_categories)) {
                        // Default categories if none selected
                        $featured_categories = get_terms([
                            'taxonomy' => 'product_cat',
                            'hide_empty' => true,
                            'number' => 6,
                            'orderby' => 'count',
                            'order' => 'DESC'
                        ]);
                    }
                    
                    if (!empty($featured_categories)) :
                        foreach ($featured_categories as $category) :
                            $category_link = get_term_link($category);
                            $category_image = get_term_meta($category->term_id, 'thumbnail_id', true);
                            $image_url = $category_image ? wp_get_attachment_image_url($category_image, 'medium') : '';
                    ?>
                        <div class="category-card animate-fade-in-up">
                            <a href="<?php echo esc_url($category_link); ?>" class="category-link">
                                <?php if ($image_url) : ?>
                                    <div class="category-image">
                                        <img src="<?php echo esc_url($image_url); ?>" 
                                             alt="<?php echo esc_attr($category->name); ?>"
                                             loading="lazy">
                                    </div>
                                <?php endif; ?>
                                <div class="category-content">
                                    <h3 class="category-name"><?php echo esc_html($category->name); ?></h3>
                                    <p class="category-count">
                                        <?php printf(_n('%d Product', '%d Products', $category->count, 'artofiran'), $category->count); ?>
                                    </p>
                                </div>
                            </a>
                        </div>
                    <?php
                        endforeach;
                    endif;
                    ?>
                </div>
            </div>
        </section>
    <?php endif; ?>
    
    <!-- Featured Products -->
    <?php if (class_exists('WooCommerce')) : ?>
        <section id="featured-products" class="featured-products section">
            <div class="container">
                <div class="section-header">
                    <h2 class="section-title">
                        <?php echo esc_html(get_theme_mod('featured_products_title', __('Featured Products', 'artofiran'))); ?>
                    </h2>
                    <p class="section-subtitle">
                        <?php echo esc_html(get_theme_mod('featured_products_subtitle', __('Handpicked art pieces from our most talented artists', 'artofiran'))); ?>
                    </p>
                </div>
                
                <div class="product-grid" id="featured-products-grid">
                    <?php
                    $featured_query = artofiran_get_featured_products(8);
                    if ($featured_query && $featured_query->have_posts()) :
                        while ($featured_query->have_posts()) : $featured_query->the_post();
                            get_template_part('template-parts/content', 'product');
                        endwhile;
                        wp_reset_postdata();
                    else :
                    ?>
                        <div class="no-products-message">
                            <h3><?php _e('No featured products found', 'artofiran'); ?></h3>
                            <p><?php _e('Check back soon for new featured items!', 'artofiran'); ?></p>
                        </div>
                    <?php endif; ?>
                </div>
                
                <?php if ($featured_query && $featured_query->have_posts()) : ?>
                    <div class="section-footer">
                        <a href="<?php echo esc_url(get_permalink(wc_get_page_id('shop'))); ?>" 
                           class="btn btn-primary">
                            <?php _e('View All Products', 'artofiran'); ?>
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M9 18l6-6-6-6"/>
                            </svg>
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </section>
    <?php endif; ?>
    
    <!-- Latest Products / Blog Posts -->
    <section class="latest-content section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">
                    <?php 
                    if (class_exists('WooCommerce') && !is_home()) {
                        echo esc_html(get_theme_mod('latest_products_title', __('Latest Products', 'artofiran')));
                    } else {
                        echo esc_html(get_theme_mod('latest_posts_title', __('Latest Stories', 'artofiran')));
                    }
                    ?>
                </h2>
                <p class="section-subtitle">
                    <?php 
                    if (class_exists('WooCommerce') && !is_home()) {
                        echo esc_html(get_theme_mod('latest_products_subtitle', __('Discover our newest art pieces and creations', 'artofiran')));
                    } else {
                        echo esc_html(get_theme_mod('latest_posts_subtitle', __('Read about Iranian art, culture, and artist stories', 'artofiran')));
                    }
                    ?>
                </p>
            </div>
            
            <div class="content-grid" id="latest-content-grid">
                <?php
                if (class_exists('WooCommerce') && !is_home()) :
                    // Show latest products
                    $latest_products = new WP_Query([
                        'post_type' => 'product',
                        'posts_per_page' => 8,
                        'orderby' => 'date',
                        'order' => 'DESC',
                        'post_status' => 'publish'
                    ]);
                    
                    if ($latest_products->have_posts()) :
                        while ($latest_products->have_posts()) : $latest_products->the_post();
                            get_template_part('template-parts/content', 'product');
                        endwhile;
                        wp_reset_postdata();
                    endif;
                else :
                    // Show blog posts
                    if (have_posts()) :
                        while (have_posts()) : the_post();
                            get_template_part('template-parts/content', get_post_type());
                        endwhile;
                        
                        // Pagination
                        the_posts_pagination([
                            'mid_size' => 2,
                            'prev_text' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 18l-6-6 6-6"/></svg>' . __('Previous', 'artofiran'),
                            'next_text' => __('Next', 'artofiran') . '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 18l6-6-6-6"/></svg>',
                        ]);
                    else :
                        get_template_part('template-parts/content', 'none');
                    endif;
                endif;
                ?>
            </div>
            
            <?php if (class_exists('WooCommerce') && !is_home() && isset($latest_products) && $latest_products->have_posts()) : ?>
                <!-- Load More Button -->
                <div class="section-footer">
                    <button class="btn btn-secondary load-more-products" 
                            data-page="1" 
                            data-post-type="product">
                        <?php _e('Load More Products', 'artofiran'); ?>
                        <div class="loading-spinner" style="display: none;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="animate-spin">
                                <path d="M21 12a9 9 0 11-6.219-8.56"/>
                            </svg>
                        </div>
                    </button>
                </div>
            <?php endif; ?>
        </div>
    </section>
    
    <!-- Testimonials Section -->
    <?php if (is_front_page() && get_theme_mod('show_testimonials', true)) : ?>
        <section class="testimonials section">
            <div class="container">
                <div class="section-header">
                    <h2 class="section-title">
                        <?php echo esc_html(get_theme_mod('testimonials_title', __('What Our Customers Say', 'artofiran'))); ?>
                    </h2>
                    <p class="section-subtitle">
                        <?php echo esc_html(get_theme_mod('testimonials_subtitle', __('Hear from our satisfied customers about their experience', 'artofiran'))); ?>
                    </p>
                </div>
                
                <div class="testimonials-slider">
                    <?php
                    $testimonials = get_theme_mod('testimonials_list', []);
                    if (!empty($testimonials)) :
                        foreach ($testimonials as $testimonial) :
                    ?>
                        <div class="testimonial-card">
                            <div class="testimonial-content">
                                <div class="testimonial-stars">
                                    <?php for ($i = 1; $i <= 5; $i++) : ?>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor" stroke="none">
                                            <polygon points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26"/>
                                        </svg>
                                    <?php endfor; ?>
                                </div>
                                <blockquote class="testimonial-text">
                                    "<?php echo esc_html($testimonial['text']); ?>"
                                </blockquote>
                                <cite class="testimonial-author">
                                    <strong><?php echo esc_html($testimonial['author']); ?></strong>
                                    <?php if (!empty($testimonial['location'])) : ?>
                                        <span class="author-location"><?php echo esc_html($testimonial['location']); ?></span>
                                    <?php endif; ?>
                                </cite>
                            </div>
                        </div>
                    <?php
                        endforeach;
                    endif;
                    ?>
                </div>
            </div>
        </section>
    <?php endif; ?>
    
    <!-- Call to Action Section -->
    <?php if (is_front_page() && get_theme_mod('show_cta_section', true)) : ?>
        <section class="cta-section">
            <div class="container">
                <div class="cta-content">
                    <h2 class="cta-title">
                        <?php echo esc_html(get_theme_mod('cta_title', __('Ready to Discover Iranian Art?', 'artofiran'))); ?>
                    </h2>
                    <p class="cta-text">
                        <?php echo esc_html(get_theme_mod('cta_text', __('Join thousands of art lovers who have found their perfect piece with us.', 'artofiran'))); ?>
                    </p>
                    <div class="cta-actions">
                        <?php if (class_exists('WooCommerce')) : ?>
                            <a href="<?php echo esc_url(get_permalink(wc_get_page_id('shop'))); ?>" 
                               class="btn btn-primary">
                                <?php _e('Start Shopping', 'artofiran'); ?>
                            </a>
                        <?php endif; ?>
                        
                        <?php if (get_theme_mod('contact_page_url')) : ?>
                            <a href="<?php echo esc_url(get_theme_mod('contact_page_url')); ?>" 
                               class="btn btn-secondary">
                                <?php _e('Get in Touch', 'artofiran'); ?>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?>
    
</div>

<?php get_footer(); ?>