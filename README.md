# automating-with-ansible

Code samples for videos in youtube.com === >  https://www.youtube.com/playlist?list=PLpWlJSEceWjV1gYrQ3EXHU7zOpCCwHAiF

Code samples for videos in aparat.com === > https://www.aparat.com/imandarabi/

slides: https://www.slideshare.net/imand/automating-with-ansible-part-a

If you encounter any problems with these samples, please submit a GitHub issue or a pull request against this repository.

# Art of Iran WordPress Theme

A custom minimal WordPress theme designed specifically for Art of Iran eCommerce website with multi-vendor support and Persian/Farsi language optimization.

## Features

### 🎨 Design & Aesthetics
- **Iran-inspired color palette**: Pastel colors inspired by the Iranian flag
- **Minimal and clean design**: Focus on artwork and products
- **Persian/Farsi typography**: Optimized for Vazir font family
- **RTL (Right-to-Left) support**: Full Persian/Farsi language support
- **Responsive design**: Mobile-first approach with tablet and desktop optimization

### 🛒 eCommerce Features
- **WooCommerce integration**: Full support for WordPress eCommerce
- **Dokan multi-vendor support**: Enable multiple artists/vendors to sell
- **Custom product cards**: Designed for art products with cultural context
- **Currency switcher support**: Multi-currency support for international sales
- **Persian currency symbols**: Support for Rial (ریال) and Toman (تومان)

### 🌐 Localization
- **Persian/Farsi optimization**: Complete RTL language support
- **Persian number support**: Automatic conversion to Persian numerals
- **Cultural attributes**: Custom fields for artist information and cultural context
- **Iran timezone**: Default timezone set to Asia/Tehran

### 📱 Technical Features
- **Sticky header**: Improved navigation experience
- **Mobile menu**: Responsive navigation for mobile devices
- **Lazy loading**: Optimized image loading for better performance
- **Accessibility**: WCAG compliant with screen reader support
- **SEO optimized**: Clean markup and semantic HTML5

## Installation

### Requirements
- WordPress 5.0 or higher
- PHP 7.4 or higher
- WooCommerce plugin (for eCommerce functionality)
- Dokan plugin (for multi-vendor support)

### Installation Steps

1. **Download the theme** to your WordPress themes directory:
   ```
   /wp-content/themes/artofiran/
   ```

2. **Activate the theme** in WordPress Admin:
   - Go to Appearance > Themes
   - Find "Art of Iran" theme
   - Click "Activate"

3. **Install required plugins**:
   - WooCommerce (for eCommerce)
   - Dokan (for multi-vendor marketplace)

4. **Configure the theme**:
   - Go to Appearance > Customize
   - Configure theme settings under "تنظیمات هنر ایران" (Art of Iran Settings)

## Theme Structure

```
artofiran/
├── style.css           # Main stylesheet with theme information
├── index.php           # Main template file
├── functions.php       # Theme functions and features
├── rtl.css            # RTL stylesheet for Persian/Farsi
├── README.md          # This documentation file
├── js/
│   └── theme.js       # Theme JavaScript functionality
└── woocommerce/
    └── content-product.php  # Custom product template
```

## Customization

### Theme Customizer Options

Access through **Appearance > Customize**:

#### تنظیمات هنر ایران (Art of Iran Settings)
- **Welcome Message**: Customize the homepage welcome message
- **Social Media Links**: Instagram, Telegram, WhatsApp, Twitter, Facebook
- **Footer Text**: Additional footer content

#### رنگ‌های تم (Theme Colors)
- **Primary Color**: Main theme color (default: pastel green)
- **Accent Color**: Accent color for highlights (default: pastel red)

### Custom Fields for Products

The theme supports these custom fields for art products:

- `_artist_name`: Artist name (displayed in product cards)
- `_cultural_context`: Cultural context or historical information

### Product Attributes

Pre-configured Persian attribute labels:
- `pa_color` → "رنگ" (Color)
- `pa_size` → "اندازه" (Size)
- `pa_artist` → "هنرمند" (Artist)
- `pa_material` → "جنس" (Material)
- `pa_origin` → "منطقه" (Region)

## Supported Languages

- **Persian/Farsi** (primary)
- **English** (secondary)

The theme automatically detects the site language and applies appropriate styling.

## Browser Support

- Chrome 70+
- Firefox 65+
- Safari 12+
- Edge 79+
- Mobile browsers (iOS Safari, Chrome Mobile)

## Performance Optimization

- **Lazy loading** for images
- **Optimized CSS** with minimal unused styles
- **Compressed JavaScript** for better loading times
- **Semantic HTML5** markup
- **Responsive images** support

## WooCommerce Integration

### Supported WooCommerce Features
- Product galleries with zoom, lightbox, and slider
- Product variations and attributes
- Shopping cart and checkout
- Product categories and tags
- Product reviews and ratings
- Wishlist support (with compatible plugins)

### Dokan Multi-Vendor Features
- Vendor store pages
- Vendor dashboard integration
- Custom vendor styling
- Multi-vendor marketplace support

## Development

### Local Development Setup

1. Clone the theme to your WordPress installation
2. Ensure WordPress is configured with Persian language
3. Install WooCommerce and Dokan plugins
4. Import sample art products for testing

### CSS Variables

The theme uses CSS custom properties for easy customization:

```css
:root {
    --pastel-green: #a8d5ba;  /* Primary color */
    --pastel-white: #f9f7f4;  /* Background */
    --pastel-red: #f4c7c3;    /* Accent color */
    --pastel-blue: #c3d7e6;   /* Secondary */
    --accent-dark: #4a4a4a;   /* Text color */
}
```

### JavaScript API

The theme exposes a global JavaScript object:

```javascript
window.ArtOfIranTheme = {
    toggleMobileMenu: function() { ... },
    productCardEffects: function() { ... }
};
```

## Troubleshooting

### Common Issues

1. **Persian fonts not loading**:
   - Ensure internet connection for Google Fonts
   - Check if Vazir font CDN is accessible

2. **RTL layout issues**:
   - Verify WordPress language is set to Persian
   - Check if `rtl.css` is being loaded

3. **WooCommerce styling conflicts**:
   - The theme disables default WooCommerce styles
   - Custom styling is applied through theme CSS

### Support

For theme support and customization:
- Check WordPress.org support forums
- Review WooCommerce documentation
- Consult Dokan plugin documentation

## Contributing

To contribute to the theme development:

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Test thoroughly with Persian content
5. Submit a pull request

## License

This theme is licensed under GPL v2 or later.

## Credits

- **Vazir Font**: Persian/Farsi font family by Saber Rastikerdar
- **Color Inspiration**: Iranian flag colors adapted to pastel palette
- **Cultural Design**: Inspired by traditional Iranian art and calligraphy

## Changelog

### Version 1.0
- Initial release
- WooCommerce integration
- Dokan multi-vendor support
- Persian/Farsi RTL optimization
- Responsive design
- Accessibility features

---

**Theme Name**: Art of Iran  
**Author**: Shamloo  
**Version**: 1.0  
**Text Domain**: artofiran  
**Website**: https://artofiran.com
