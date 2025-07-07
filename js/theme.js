/**
 * Art of Iran Theme JavaScript
 * 
 * @package ArtOfIran
 */

(function() {
    'use strict';

    // DOM ready function
    function domReady(callback) {
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', callback);
        } else {
            callback();
        }
    }

    // Mobile Menu Toggle
    function toggleMobileMenu() {
        const menu = document.querySelector('#primary-menu');
        const menuToggle = document.querySelector('.menu-toggle');
        
        if (menu && menuToggle) {
            menuToggle.addEventListener('click', function() {
                menu.classList.toggle('show');
                
                // Update aria-expanded for accessibility
                const isExpanded = menu.classList.contains('show');
                menuToggle.setAttribute('aria-expanded', isExpanded);
            });
        }
    }

    // Smooth scroll for anchor links
    function smoothScrollLinks() {
        const anchorLinks = document.querySelectorAll('a[href^="#"]');
        
        anchorLinks.forEach(function(link) {
            link.addEventListener('click', function(e) {
                const href = this.getAttribute('href');
                const target = document.querySelector(href);
                
                if (target && href !== '#') {
                    e.preventDefault();
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    }

    // Product card hover effects
    function productCardEffects() {
        const productCards = document.querySelectorAll('.product-card');
        
        productCards.forEach(function(card) {
            // Add hover class for enhanced styling
            card.addEventListener('mouseenter', function() {
                this.classList.add('hovered');
            });
            
            card.addEventListener('mouseleave', function() {
                this.classList.remove('hovered');
            });
        });
    }

    // Lazy loading for images
    function lazyLoadImages() {
        if ('IntersectionObserver' in window) {
            const imageObserver = new IntersectionObserver(function(entries, observer) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        img.src = img.dataset.src;
                        img.classList.remove('lazy');
                        imageObserver.unobserve(img);
                    }
                });
            });

            const lazyImages = document.querySelectorAll('img[data-src]');
            lazyImages.forEach(function(img) {
                imageObserver.observe(img);
            });
        }
    }

    // Currency switcher enhancement
    function enhanceCurrencySwitcher() {
        const currencySelect = document.querySelector('.currency-switcher select');
        
        if (currencySelect) {
            currencySelect.addEventListener('change', function() {
                // Add loading state
                this.disabled = true;
                this.style.opacity = '0.6';
                
                // Re-enable after currency change (WooCommerce handles the actual switching)
                setTimeout(function() {
                    currencySelect.disabled = false;
                    currencySelect.style.opacity = '1';
                }, 1000);
            });
        }
    }

    // Search form enhancement
    function enhanceSearchForm() {
        const searchForms = document.querySelectorAll('.search-form');
        
        searchForms.forEach(function(form) {
            const input = form.querySelector('input[type="search"]');
            
            if (input) {
                // Add placeholder for RTL
                if (document.documentElement.dir === 'rtl') {
                    input.placeholder = 'جستجو...';
                }
                
                // Clear button functionality
                const clearButton = document.createElement('button');
                clearButton.type = 'button';
                clearButton.innerHTML = '×';
                clearButton.className = 'search-clear';
                clearButton.style.display = 'none';
                
                input.parentNode.appendChild(clearButton);
                
                input.addEventListener('input', function() {
                    clearButton.style.display = this.value ? 'block' : 'none';
                });
                
                clearButton.addEventListener('click', function() {
                    input.value = '';
                    this.style.display = 'none';
                    input.focus();
                });
            }
        });
    }

    // Accessibility improvements
    function improveAccessibility() {
        // Add skip to content link
        const skipLink = document.createElement('a');
        skipLink.href = '#primary';
        skipLink.className = 'screen-reader-text';
        skipLink.textContent = 'پرش به محتوا';
        document.body.insertBefore(skipLink, document.body.firstChild);
        
        // Improve form labels
        const formFields = document.querySelectorAll('input, textarea, select');
        formFields.forEach(function(field) {
            if (!field.getAttribute('aria-label') && !field.labels.length) {
                const placeholder = field.getAttribute('placeholder');
                if (placeholder) {
                    field.setAttribute('aria-label', placeholder);
                }
            }
        });
    }

    // Handle WooCommerce add to cart buttons
    function enhanceAddToCartButtons() {
        const addToCartButtons = document.querySelectorAll('.add_to_cart_button');
        
        addToCartButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                // Add loading state
                this.classList.add('loading');
                this.textContent = 'در حال افزودن...';
                
                // Remove loading state after a delay (WooCommerce Ajax will handle the actual process)
                setTimeout(function() {
                    button.classList.remove('loading');
                    button.textContent = 'افزودن به سبد خرید';
                }, 2000);
            });
        });
    }

    // Sticky header on scroll
    function stickyHeader() {
        const header = document.querySelector('header');
        let lastScrollTop = 0;
        
        if (header) {
            window.addEventListener('scroll', function() {
                const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
                
                if (scrollTop > lastScrollTop && scrollTop > 100) {
                    // Scrolling down
                    header.style.transform = 'translateY(-100%)';
                } else {
                    // Scrolling up
                    header.style.transform = 'translateY(0)';
                }
                
                lastScrollTop = scrollTop;
            });
        }
    }

    // Initialize all functions when DOM is ready
    domReady(function() {
        toggleMobileMenu();
        smoothScrollLinks();
        productCardEffects();
        lazyLoadImages();
        enhanceCurrencySwitcher();
        enhanceSearchForm();
        improveAccessibility();
        enhanceAddToCartButtons();
        stickyHeader();
        
        console.log('Art of Iran Theme loaded successfully');
    });

    // Export functions for global access if needed
    window.ArtOfIranTheme = {
        toggleMobileMenu: toggleMobileMenu,
        productCardEffects: productCardEffects
    };

})();