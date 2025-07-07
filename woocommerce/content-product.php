<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * @package ArtOfIran
 */

defined('ABSPATH') || exit;

global $product;

// Ensure visibility
if (empty($product) || !$product->is_visible()) {
    return;
}
?>

<div <?php wc_product_class('product-card', $product); ?>>
    
    <?php
    /**
     * Hook: woocommerce_before_shop_loop_item.
     */
    do_action('woocommerce_before_shop_loop_item');
    ?>

    <div class="product-image-wrapper">
        <?php
        /**
         * Hook: woocommerce_before_shop_loop_item_title.
         */
        do_action('woocommerce_before_shop_loop_item_title');
        ?>
        
        <?php
        // Product main image
        if (has_post_thumbnail()) {
            echo '<a href="' . esc_url(get_permalink()) . '">';
            the_post_thumbnail('woocommerce_thumbnail', array('alt' => get_the_title()));
            echo '</a>';
        } else {
            echo '<a href="' . esc_url(get_permalink()) . '">';
            echo wc_placeholder_img('woocommerce_thumbnail');
            echo '</a>';
        }
        ?>
        
        <?php
        // Secondary image (for Iranian art cultural context)
        $attachment_ids = $product->get_gallery_image_ids();
        if (!empty($attachment_ids)) {
            $secondary_image_id = $attachment_ids[0];
            echo '<a href="' . esc_url(get_permalink()) . '">';
            echo wp_get_attachment_image($secondary_image_id, 'thumbnail', false, array('class' => 'secondary-image', 'alt' => get_the_title()));
            echo '</a>';
        }
        ?>
    </div>

    <div class="product-details">
        <?php
        /**
         * Hook: woocommerce_shop_loop_item_title.
         */
        do_action('woocommerce_shop_loop_item_title');
        ?>

        <h3 class="product-title">
            <a href="<?php echo esc_url(get_permalink()); ?>" title="<?php echo esc_attr(get_the_title()); ?>">
                <?php the_title(); ?>
            </a>
        </h3>

        <?php
        /**
         * Hook: woocommerce_after_shop_loop_item_title.
         */
        do_action('woocommerce_after_shop_loop_item_title');
        ?>

        <div class="price">
            <?php echo $product->get_price_html(); ?>
        </div>

        <?php
        // Display artist name (custom field)
        $artist_name = get_post_meta(get_the_ID(), '_artist_name', true);
        if ($artist_name) {
            echo '<div class="artist">هنرمند: ' . esc_html($artist_name) . '</div>';
        }
        ?>

        <?php
        // Display cultural context (custom field)
        $cultural_context = get_post_meta(get_the_ID(), '_cultural_context', true);
        if ($cultural_context) {
            echo '<div class="cultural">' . esc_html($cultural_context) . '</div>';
        }
        ?>

        <?php
        // Display product categories
        $terms = get_the_terms(get_the_ID(), 'product_cat');
        if ($terms && !is_wp_error($terms)) {
            $category_list = array();
            foreach ($terms as $term) {
                $category_list[] = $term->name;
            }
            echo '<div class="categories">دسته: ' . implode(', ', $category_list) . '</div>';
        }
        ?>

        <?php
        // Display product attributes (for Iranian art specifics)
        $attributes = $product->get_attributes();
        if (!empty($attributes)) {
            echo '<div class="product-attributes">';
            foreach ($attributes as $attribute) {
                if ($attribute->get_visible()) {
                    echo '<span class="attribute">';
                    echo wc_attribute_label($attribute->get_name()) . ': ';
                    
                    if ($attribute->is_taxonomy()) {
                        $values = wc_get_product_terms($product->get_id(), $attribute->get_name(), array('fields' => 'names'));
                        echo implode(', ', $values);
                    } else {
                        echo $attribute->get_options()[0];
                    }
                    echo '</span>';
                }
            }
            echo '</div>';
        }
        ?>

        <div class="product-actions">
            <?php
            /**
             * Hook: woocommerce_after_shop_loop_item.
             */
            do_action('woocommerce_after_shop_loop_item');
            ?>
        </div>
    </div>

    <?php
    // Add sale badge
    if ($product->is_on_sale()) {
        echo '<span class="sale-badge">تخفیف</span>';
    }
    
    // Add new product badge (if product is less than 30 days old)
    $created_date = strtotime($product->get_date_created());
    if ($created_date > strtotime('-30 days')) {
        echo '<span class="new-badge">جدید</span>';
    }
    ?>

</div><?php