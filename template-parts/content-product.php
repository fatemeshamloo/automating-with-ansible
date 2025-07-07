<?php
/**
 * Product Content Template - Professional Edition
 * 
 * Template part for displaying product content in loops.
 * 
 * @package ArtOfIran
 * @version 2.0
 */

if (!defined('ABSPATH')) {
    exit;
}

global $product;

// Ensure we have a valid product
if (!$product || !is_a($product, 'WC_Product')) {
    return;
}

$product_id = get_the_ID();
$product_url = get_permalink($product_id);
$product_title = get_the_title();
$product_image = get_the_post_thumbnail($product_id, 'product-thumb');
$product_gallery = $product->get_gallery_image_ids();
$on_sale = $product->is_on_sale();
$featured = $product->is_featured();
$in_stock = $product->is_in_stock();
$rating = $product->get_average_rating();
$review_count = $product->get_review_count();
?>

<article id="product-<?php echo esc_attr($product_id); ?>" 
         <?php wc_product_class('product-card animate-fade-in-up', $product); ?>
         data-product-id="<?php echo esc_attr($product_id); ?>">
    
    <!-- Product badges -->
    <div class="product-badges">
        <?php if ($on_sale) : ?>
            <span class="product-badge badge-sale">
                <?php
                $sale_percentage = '';
                if ($product->get_regular_price() && $product->get_sale_price()) {
                    $percentage = round((($product->get_regular_price() - $product->get_sale_price()) / $product->get_regular_price()) * 100);
                    $sale_percentage = '-' . $percentage . '%';
                }
                echo $sale_percentage ? esc_html($sale_percentage) : esc_html__('Sale', 'artofiran');
                ?>
            </span>
        <?php endif; ?>
        
        <?php if ($featured) : ?>
            <span class="product-badge badge-featured">
                <?php _e('Featured', 'artofiran'); ?>
            </span>
        <?php endif; ?>
        
        <?php if (!$in_stock) : ?>
            <span class="product-badge badge-out-of-stock">
                <?php _e('Out of Stock', 'artofiran'); ?>
            </span>
        <?php endif; ?>
        
        <?php if (function_exists('get_field') && get_field('is_handmade')) : ?>
            <span class="product-badge badge-handmade">
                <?php _e('Handmade', 'artofiran'); ?>
            </span>
        <?php endif; ?>
    </div>
    
    <!-- Product image -->
    <div class="product-image">
        <a href="<?php echo esc_url($product_url); ?>" 
           class="product-image-link" 
           aria-label="<?php printf(__('View %s', 'artofiran'), esc_attr($product_title)); ?>">
            
            <?php if ($product_image) : ?>
                <?php echo $product_image; ?>
            <?php else : ?>
                <img src="<?php echo esc_url(wc_placeholder_img_src()); ?>" 
                     alt="<?php echo esc_attr($product_title); ?>"
                     class="product-placeholder">
            <?php endif; ?>
            
            <!-- Secondary image on hover -->
            <?php if (!empty($product_gallery)) : ?>
                <img src="<?php echo esc_url(wp_get_attachment_image_url($product_gallery[0], 'product-thumb')); ?>" 
                     alt="<?php echo esc_attr($product_title); ?>"
                     class="product-image-secondary"
                     loading="lazy">
            <?php endif; ?>
        </a>
        
        <!-- Product actions overlay -->
        <div class="product-actions-overlay">
            
            <!-- Quick view button -->
            <button class="btn-quick-view" 
                    data-product-id="<?php echo esc_attr($product_id); ?>"
                    aria-label="<?php printf(__('Quick view %s', 'artofiran'), esc_attr($product_title)); ?>">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                    <circle cx="12" cy="12" r="3"></circle>
                </svg>
                <span class="sr-only"><?php _e('Quick View', 'artofiran'); ?></span>
            </button>
            
            <!-- Wishlist button -->
            <?php if (function_exists('YITH_WCWL')) : ?>
                <button class="btn-wishlist" 
                        data-product-id="<?php echo esc_attr($product_id); ?>"
                        aria-label="<?php printf(__('Add %s to wishlist', 'artofiran'), esc_attr($product_title)); ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                    </svg>
                    <span class="sr-only"><?php _e('Add to Wishlist', 'artofiran'); ?></span>
                </button>
            <?php endif; ?>
            
            <!-- Compare button -->
            <?php if (function_exists('woocommerce_output_related_products')) : ?>
                <button class="btn-compare" 
                        data-product-id="<?php echo esc_attr($product_id); ?>"
                        aria-label="<?php printf(__('Compare %s', 'artofiran'), esc_attr($product_title)); ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M18 6L6 18M6 6l12 12"></path>
                    </svg>
                    <span class="sr-only"><?php _e('Compare', 'artofiran'); ?></span>
                </button>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Product content -->
    <div class="product-content">
        
        <!-- Product categories -->
        <?php
        $categories = get_the_terms($product_id, 'product_cat');
        if (!empty($categories) && !is_wp_error($categories)) :
        ?>
            <div class="product-categories">
                <?php foreach ($categories as $category) : ?>
                    <a href="<?php echo esc_url(get_term_link($category)); ?>" 
                       class="product-category-link">
                        <?php echo esc_html($category->name); ?>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
        <!-- Product title -->
        <h3 class="product-title">
            <a href="<?php echo esc_url($product_url); ?>" class="product-title-link">
                <?php echo esc_html($product_title); ?>
            </a>
        </h3>
        
        <!-- Artist information -->
        <?php if (function_exists('get_field') && $artist_name = get_field('artist_name')) : ?>
            <div class="product-artist">
                <span class="artist-label"><?php _e('Artist:', 'artofiran'); ?></span>
                <span class="artist-name"><?php echo esc_html($artist_name); ?></span>
            </div>
        <?php endif; ?>
        
        <!-- Product rating -->
        <?php if ($rating > 0) : ?>
            <div class="product-rating">
                <div class="star-rating" title="<?php printf(__('Rated %s out of 5', 'artofiran'), esc_attr($rating)); ?>">
                    <?php for ($i = 1; $i <= 5; $i++) : ?>
                        <svg xmlns="http://www.w3.org/2000/svg" 
                             width="14" 
                             height="14" 
                             viewBox="0 0 24 24" 
                             fill="<?php echo $i <= $rating ? 'currentColor' : 'none'; ?>" 
                             stroke="currentColor" 
                             stroke-width="2" 
                             stroke-linecap="round" 
                             stroke-linejoin="round">
                            <polygon points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26"/>
                        </svg>
                    <?php endfor; ?>
                </div>
                <span class="rating-count">
                    <?php printf(_n('(%s review)', '(%s reviews)', $review_count, 'artofiran'), esc_html($review_count)); ?>
                </span>
            </div>
        <?php endif; ?>
        
        <!-- Product excerpt/description -->
        <?php if (has_excerpt()) : ?>
            <div class="product-excerpt">
                <?php echo wp_trim_words(get_the_excerpt(), 15, '...'); ?>
            </div>
        <?php endif; ?>
        
        <!-- Cultural description -->
        <?php if (function_exists('get_field') && $cultural_description = get_field('cultural_description')) : ?>
            <div class="product-cultural">
                <strong><?php _e('Cultural Background:', 'artofiran'); ?></strong>
                <?php echo wp_trim_words(esc_html($cultural_description), 10, '...'); ?>
            </div>
        <?php endif; ?>
        
        <!-- Product meta -->
        <div class="product-meta">
            
            <!-- Product price -->
            <div class="product-price">
                <?php echo $product->get_price_html(); ?>
            </div>
            
            <!-- Product availability -->
            <div class="product-availability">
                <?php if ($in_stock) : ?>
                    <span class="in-stock">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="20,6 9,17 4,12"></polyline>
                        </svg>
                        <?php _e('In Stock', 'artofiran'); ?>
                    </span>
                <?php else : ?>
                    <span class="out-of-stock">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="15" y1="9" x2="9" y2="15"></line>
                            <line x1="9" y1="9" x2="15" y2="15"></line>
                        </svg>
                        <?php _e('Out of Stock', 'artofiran'); ?>
                    </span>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Add to cart button -->
        <div class="product-add-to-cart">
            <?php
            if ($product->is_type('simple') && $in_stock) :
                woocommerce_template_loop_add_to_cart();
            elseif ($product->is_type('variable')) :
            ?>
                <a href="<?php echo esc_url($product_url); ?>" 
                   class="btn btn-primary product-btn">
                    <?php _e('Select Options', 'artofiran'); ?>
                </a>
            <?php
            elseif ($product->is_type('grouped')) :
            ?>
                <a href="<?php echo esc_url($product_url); ?>" 
                   class="btn btn-primary product-btn">
                    <?php _e('View Products', 'artofiran'); ?>
                </a>
            <?php
            else :
            ?>
                <a href="<?php echo esc_url($product_url); ?>" 
                   class="btn btn-primary product-btn">
                    <?php _e('Read More', 'artofiran'); ?>
                </a>
            <?php endif; ?>
        </div>
        
        <!-- Secondary image (for custom field) -->
        <?php if (function_exists('get_field') && $secondary_image = get_field('featured_image_2')) : ?>
            <div class="product-secondary-image">
                <img src="<?php echo esc_url($secondary_image['sizes']['medium'] ?? $secondary_image['url']); ?>" 
                     alt="<?php echo esc_attr($secondary_image['alt'] ?: $product_title); ?>"
                     class="secondary-image"
                     loading="lazy">
            </div>
        <?php endif; ?>
        
        <!-- Product tags -->
        <?php
        $tags = get_the_terms($product_id, 'product_tag');
        if (!empty($tags) && !is_wp_error($tags)) :
        ?>
            <div class="product-tags">
                <?php foreach (array_slice($tags, 0, 3) as $tag) : ?>
                    <span class="product-tag"><?php echo esc_html($tag->name); ?></span>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
    
    <!-- Product schema markup -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org/",
        "@type": "Product",
        "name": "<?php echo esc_js($product_title); ?>",
        "description": "<?php echo esc_js(wp_strip_all_tags(get_the_excerpt() ?: $product->get_short_description())); ?>",
        "url": "<?php echo esc_url($product_url); ?>",
        "image": "<?php echo esc_url(get_the_post_thumbnail_url($product_id, 'full')); ?>",
        "sku": "<?php echo esc_js($product->get_sku()); ?>",
        <?php if ($rating > 0) : ?>
        "aggregateRating": {
            "@type": "AggregateRating",
            "ratingValue": "<?php echo esc_js($rating); ?>",
            "reviewCount": "<?php echo esc_js($review_count); ?>"
        },
        <?php endif; ?>
        "offers": {
            "@type": "Offer",
            "price": "<?php echo esc_js($product->get_price()); ?>",
            "priceCurrency": "<?php echo esc_js(get_woocommerce_currency()); ?>",
            "availability": "<?php echo $in_stock ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock'; ?>",
            "url": "<?php echo esc_url($product_url); ?>"
        }
        <?php if (function_exists('get_field') && $artist_name) : ?>
        ,"brand": {
            "@type": "Brand",
            "name": "<?php echo esc_js($artist_name); ?>"
        }
        <?php endif; ?>
    }
    </script>
</article>