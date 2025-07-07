/**
 * Art of Iran Theme JavaScript - Professional Edition
 * 
 * @package ArtOfIran
 * @version 2.0
 * @author Shamloo
 */

(function() {
    'use strict';

    // Theme configuration
    const ArtOfIranTheme = {
        config: {
            mobileBreakpoint: 768,
            tabletBreakpoint: 1024,
            scrollThreshold: 100,
            debounceDelay: 250,
            animationDuration: 300,
            lazyLoadOffset: 100,
        },
        
        utils: {
            // Debounce function for performance
            debounce(func, wait) {
                let timeout;
                return function executedFunction(...args) {
                    const later = () => {
                        clearTimeout(timeout);
                        func(...args);
                    };
                    clearTimeout(timeout);
                    timeout = setTimeout(later, wait);
                };
            },

            // Throttle function for scroll events
            throttle(func, limit) {
                let inThrottle;
                return function() {
                    const args = arguments;
                    const context = this;
                    if (!inThrottle) {
                        func.apply(context, args);
                        inThrottle = true;
                        setTimeout(() => inThrottle = false, limit);
                    }
                };
            },

            // Check if element is in viewport
            isInViewport(element, offset = 0) {
                const rect = element.getBoundingClientRect();
                return (
                    rect.top >= -offset &&
                    rect.left >= 0 &&
                    rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) + offset &&
                    rect.right <= (window.innerWidth || document.documentElement.clientWidth)
                );
            },

            // Smooth scroll to element
            scrollToElement(element, offset = 0) {
                const elementPosition = element.offsetTop - offset;
                window.scrollTo({
                    top: elementPosition,
                    behavior: 'smooth'
                });
            },

            // Get viewport dimensions
            getViewportDimensions() {
                return {
                    width: window.innerWidth || document.documentElement.clientWidth,
                    height: window.innerHeight || document.documentElement.clientHeight
                };
            },

            // Check if device is mobile
            isMobile() {
                return this.getViewportDimensions().width < ArtOfIranTheme.config.mobileBreakpoint;
            },

            // Generate unique ID
            generateId(prefix = 'element') {
                return `${prefix}-${Math.random().toString(36).substr(2, 9)}`;
            },

            // Sanitize HTML
            sanitizeHTML(str) {
                const temp = document.createElement('div');
                temp.textContent = str;
                return temp.innerHTML;
            }
        },

        // DOM manipulation helpers
        dom: {
            // Query selector with caching
            cache: new Map(),
            
            $(selector, context = document) {
                const key = `${selector}-${context.nodeName || 'document'}`;
                if (!this.cache.has(key)) {
                    this.cache.set(key, context.querySelector(selector));
                }
                return this.cache.get(key);
            },

            $$(selector, context = document) {
                return Array.from(context.querySelectorAll(selector));
            },

            // Add event listener with cleanup
            on(element, event, handler, options = {}) {
                if (element) {
                    element.addEventListener(event, handler, options);
                    return () => element.removeEventListener(event, handler, options);
                }
                return () => {};
            },

            // Add class with animation support
            addClass(element, className, animate = false) {
                if (!element) return;
                
                if (animate) {
                    element.style.transition = `all ${ArtOfIranTheme.config.animationDuration}ms ease`;
                }
                element.classList.add(className);
            },

            // Remove class with animation support
            removeClass(element, className, animate = false) {
                if (!element) return;
                
                if (animate) {
                    element.style.transition = `all ${ArtOfIranTheme.config.animationDuration}ms ease`;
                }
                element.classList.remove(className);
            },

            // Toggle class with animation support
            toggleClass(element, className, animate = false) {
                if (!element) return;
                
                if (animate) {
                    element.style.transition = `all ${ArtOfIranTheme.config.animationDuration}ms ease`;
                }
                element.classList.toggle(className);
            }
        },

        // Animation system
        animations: {
            // Fade in animation
            fadeIn(element, duration = 300) {
                if (!element) return Promise.resolve();
                
                return new Promise(resolve => {
                    element.style.opacity = '0';
                    element.style.display = 'block';
                    element.style.transition = `opacity ${duration}ms ease`;
                    
                    requestAnimationFrame(() => {
                        element.style.opacity = '1';
                        setTimeout(resolve, duration);
                    });
                });
            },

            // Fade out animation
            fadeOut(element, duration = 300) {
                if (!element) return Promise.resolve();
                
                return new Promise(resolve => {
                    element.style.transition = `opacity ${duration}ms ease`;
                    element.style.opacity = '0';
                    
                    setTimeout(() => {
                        element.style.display = 'none';
                        resolve();
                    }, duration);
                });
            },

            // Slide down animation
            slideDown(element, duration = 300) {
                if (!element) return Promise.resolve();
                
                return new Promise(resolve => {
                    element.style.height = '0';
                    element.style.overflow = 'hidden';
                    element.style.display = 'block';
                    
                    const height = element.scrollHeight;
                    element.style.transition = `height ${duration}ms ease`;
                    
                    requestAnimationFrame(() => {
                        element.style.height = height + 'px';
                        setTimeout(() => {
                            element.style.height = 'auto';
                            element.style.overflow = 'visible';
                            resolve();
                        }, duration);
                    });
                });
            },

            // Slide up animation
            slideUp(element, duration = 300) {
                if (!element) return Promise.resolve();
                
                return new Promise(resolve => {
                    element.style.height = element.scrollHeight + 'px';
                    element.style.overflow = 'hidden';
                    element.style.transition = `height ${duration}ms ease`;
                    
                    requestAnimationFrame(() => {
                        element.style.height = '0';
                        setTimeout(() => {
                            element.style.display = 'none';
                            resolve();
                        }, duration);
                    });
                });
            }
        },

        // Mobile menu functionality
        mobileMenu: {
            init() {
                this.menuToggle = ArtOfIranTheme.dom.$('.menu-toggle');
                this.navigation = ArtOfIranTheme.dom.$('#site-navigation');
                this.menu = ArtOfIranTheme.dom.$('.nav-menu');
                
                if (!this.menuToggle || !this.menu) return;

                this.bindEvents();
                this.setupAccessibility();
            },

            bindEvents() {
                // Toggle menu on button click
                ArtOfIranTheme.dom.on(this.menuToggle, 'click', (e) => {
                    e.preventDefault();
                    this.toggleMenu();
                });

                // Close menu on escape key
                ArtOfIranTheme.dom.on(document, 'keydown', (e) => {
                    if (e.key === 'Escape' && this.isMenuOpen()) {
                        this.closeMenu();
                    }
                });

                // Close menu when clicking outside
                ArtOfIranTheme.dom.on(document, 'click', (e) => {
                    if (this.isMenuOpen() && !this.navigation.contains(e.target)) {
                        this.closeMenu();
                    }
                });

                // Handle resize
                ArtOfIranTheme.dom.on(window, 'resize', ArtOfIranTheme.utils.debounce(() => {
                    if (!ArtOfIranTheme.utils.isMobile() && this.isMenuOpen()) {
                        this.closeMenu();
                    }
                }, ArtOfIranTheme.config.debounceDelay));
            },

            setupAccessibility() {
                // Add ARIA attributes
                this.menuToggle.setAttribute('aria-expanded', 'false');
                this.menuToggle.setAttribute('aria-controls', 'primary-menu');
                this.menu.setAttribute('aria-hidden', 'true');
            },

            toggleMenu() {
                if (this.isMenuOpen()) {
                    this.closeMenu();
                } else {
                    this.openMenu();
                }
            },

            openMenu() {
                ArtOfIranTheme.dom.addClass(this.menu, 'show', true);
                ArtOfIranTheme.dom.addClass(this.menuToggle, 'active');
                
                this.menuToggle.setAttribute('aria-expanded', 'true');
                this.menu.setAttribute('aria-hidden', 'false');
                
                // Focus first menu item
                const firstMenuItem = this.menu.querySelector('a');
                if (firstMenuItem) {
                    firstMenuItem.focus();
                }
            },

            closeMenu() {
                ArtOfIranTheme.dom.removeClass(this.menu, 'show', true);
                ArtOfIranTheme.dom.removeClass(this.menuToggle, 'active');
                
                this.menuToggle.setAttribute('aria-expanded', 'false');
                this.menu.setAttribute('aria-hidden', 'true');
                
                // Return focus to toggle button
                this.menuToggle.focus();
            },

            isMenuOpen() {
                return this.menu.classList.contains('show');
            }
        },

        // Scroll functionality
        scroll: {
            init() {
                this.scrollToTopBtn = this.createScrollToTopButton();
                this.bindEvents();
            },

            createScrollToTopButton() {
                let btn = ArtOfIranTheme.dom.$('#scroll-to-top');
                
                if (!btn) {
                    btn = document.createElement('button');
                    btn.id = 'scroll-to-top';
                    btn.className = 'scroll-to-top';
                    btn.innerHTML = `
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="18,15 12,9 6,15"></polyline>
                        </svg>
                    `;
                    btn.setAttribute('aria-label', 'Scroll to top');
                    document.body.appendChild(btn);
                }
                
                return btn;
            },

            bindEvents() {
                // Show/hide scroll to top button
                ArtOfIranTheme.dom.on(window, 'scroll', ArtOfIranTheme.utils.throttle(() => {
                    this.toggleScrollToTopButton();
                }, 100));

                // Scroll to top on button click
                ArtOfIranTheme.dom.on(this.scrollToTopBtn, 'click', (e) => {
                    e.preventDefault();
                    this.scrollToTop();
                });

                // Smooth scroll for anchor links
                ArtOfIranTheme.dom.$$('a[href^="#"]').forEach(anchor => {
                    ArtOfIranTheme.dom.on(anchor, 'click', (e) => {
                        const href = anchor.getAttribute('href');
                        if (href === '#') return;
                        
                        const target = ArtOfIranTheme.dom.$(href);
                        if (target) {
                            e.preventDefault();
                            ArtOfIranTheme.utils.scrollToElement(target, 100);
                        }
                    });
                });
            },

            toggleScrollToTopButton() {
                const scrolled = window.pageYOffset > ArtOfIranTheme.config.scrollThreshold;
                
                if (scrolled) {
                    ArtOfIranTheme.dom.addClass(this.scrollToTopBtn, 'show');
                } else {
                    ArtOfIranTheme.dom.removeClass(this.scrollToTopBtn, 'show');
                }
            },

            scrollToTop() {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            }
        },

        // Lazy loading functionality
        lazyLoad: {
            init() {
                this.images = ArtOfIranTheme.dom.$$('img[data-src]');
                this.observer = null;
                
                if ('IntersectionObserver' in window) {
                    this.setupIntersectionObserver();
                } else {
                    // Fallback for older browsers
                    this.loadAllImages();
                }
            },

            setupIntersectionObserver() {
                this.observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            this.loadImage(entry.target);
                            this.observer.unobserve(entry.target);
                        }
                    });
                }, {
                    rootMargin: `${ArtOfIranTheme.config.lazyLoadOffset}px`
                });

                this.images.forEach(img => {
                    this.observer.observe(img);
                });
            },

            loadImage(img) {
                const src = img.getAttribute('data-src');
                if (!src) return;

                img.onload = () => {
                    ArtOfIranTheme.dom.addClass(img, 'loaded');
                    img.removeAttribute('data-src');
                };

                img.src = src;
            },

            loadAllImages() {
                this.images.forEach(img => this.loadImage(img));
            }
        },

        // Search functionality
        search: {
            init() {
                this.searchForm = ArtOfIranTheme.dom.$('.search-form');
                this.searchField = ArtOfIranTheme.dom.$('.search-field');
                this.searchResults = null;
                
                if (!this.searchForm || !this.searchField) return;
                
                this.bindEvents();
                this.setupLiveSearch();
            },

            bindEvents() {
                // Enhanced search experience
                ArtOfIranTheme.dom.on(this.searchField, 'focus', () => {
                    ArtOfIranTheme.dom.addClass(this.searchForm, 'focused');
                });

                ArtOfIranTheme.dom.on(this.searchField, 'blur', () => {
                    setTimeout(() => {
                        ArtOfIranTheme.dom.removeClass(this.searchForm, 'focused');
                    }, 200);
                });
            },

            setupLiveSearch() {
                if (!window.artofiran_ajax) return;

                let searchTimeout;
                
                ArtOfIranTheme.dom.on(this.searchField, 'input', (e) => {
                    clearTimeout(searchTimeout);
                    const query = e.target.value.trim();
                    
                    if (query.length >= 3) {
                        searchTimeout = setTimeout(() => {
                            this.performLiveSearch(query);
                        }, 300);
                    } else {
                        this.hideSearchResults();
                    }
                });
            },

            async performLiveSearch(query) {
                try {
                    const response = await fetch(window.artofiran_ajax.ajax_url, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: new URLSearchParams({
                            action: 'artofiran_live_search',
                            query: query,
                            nonce: window.artofiran_ajax.nonce
                        })
                    });

                    const data = await response.json();
                    
                    if (data.success) {
                        this.showSearchResults(data.data.results);
                    }
                } catch (error) {
                    console.warn('Search request failed:', error);
                }
            },

            showSearchResults(results) {
                if (!this.searchResults) {
                    this.createSearchResultsContainer();
                }

                this.searchResults.innerHTML = results;
                ArtOfIranTheme.dom.addClass(this.searchResults, 'show');
            },

            hideSearchResults() {
                if (this.searchResults) {
                    ArtOfIranTheme.dom.removeClass(this.searchResults, 'show');
                }
            },

            createSearchResultsContainer() {
                this.searchResults = document.createElement('div');
                this.searchResults.className = 'search-results';
                this.searchForm.appendChild(this.searchResults);
            }
        },

        // Product functionality
        products: {
            init() {
                this.loadMoreBtn = ArtOfIranTheme.dom.$('.load-more-products');
                this.productGrid = ArtOfIranTheme.dom.$('.product-grid');
                this.currentPage = 1;
                
                this.bindEvents();
                this.setupProductAnimations();
            },

            bindEvents() {
                if (this.loadMoreBtn) {
                    ArtOfIranTheme.dom.on(this.loadMoreBtn, 'click', (e) => {
                        e.preventDefault();
                        this.loadMoreProducts();
                    });
                }

                // Quick view functionality
                ArtOfIranTheme.dom.$$('.product-card').forEach(card => {
                    this.setupQuickView(card);
                });
            },

            setupProductAnimations() {
                // Animate products on scroll
                const products = ArtOfIranTheme.dom.$$('.product-card');
                
                if ('IntersectionObserver' in window) {
                    const observer = new IntersectionObserver((entries) => {
                        entries.forEach(entry => {
                            if (entry.isIntersecting) {
                                ArtOfIranTheme.dom.addClass(entry.target, 'animate-fade-in-up');
                            }
                        });
                    });

                    products.forEach(product => {
                        observer.observe(product);
                    });
                }
            },

            setupQuickView(card) {
                const quickViewBtn = card.querySelector('.quick-view');
                if (!quickViewBtn) return;

                ArtOfIranTheme.dom.on(quickViewBtn, 'click', (e) => {
                    e.preventDefault();
                    const productId = quickViewBtn.getAttribute('data-product-id');
                    if (productId) {
                        this.openQuickView(productId);
                    }
                });
            },

            async loadMoreProducts() {
                if (!window.artofiran_ajax) return;

                const button = this.loadMoreBtn;
                const originalText = button.textContent;
                
                button.textContent = window.artofiran_ajax.strings.loading;
                button.disabled = true;

                try {
                    const response = await fetch(window.artofiran_ajax.ajax_url, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: new URLSearchParams({
                            action: 'artofiran_load_more_products',
                            page: this.currentPage + 1,
                            posts_per_page: 8,
                            nonce: window.artofiran_ajax.nonce
                        })
                    });

                    const data = await response.json();

                    if (data.success) {
                        this.currentPage++;
                        this.appendProducts(data.data.html);
                        
                        if (!data.data.has_more) {
                            button.textContent = window.artofiran_ajax.strings.no_more;
                            button.disabled = true;
                        } else {
                            button.textContent = originalText;
                            button.disabled = false;
                        }
                    } else {
                        throw new Error(data.data.message);
                    }
                } catch (error) {
                    console.error('Failed to load more products:', error);
                    button.textContent = window.artofiran_ajax.strings.error;
                    setTimeout(() => {
                        button.textContent = originalText;
                        button.disabled = false;
                    }, 3000);
                }
            },

            appendProducts(html) {
                const tempDiv = document.createElement('div');
                tempDiv.innerHTML = html;
                
                const newProducts = Array.from(tempDiv.children);
                newProducts.forEach((product, index) => {
                    setTimeout(() => {
                        this.productGrid.appendChild(product);
                        ArtOfIranTheme.dom.addClass(product, 'animate-fade-in-up');
                        this.setupQuickView(product);
                    }, index * 100);
                });
            }
        },

        // Cookie consent functionality
        cookies: {
            init() {
                this.banner = ArtOfIranTheme.dom.$('#cookie-banner');
                if (!this.banner) return;

                this.bindEvents();
            },

            bindEvents() {
                const acceptBtn = ArtOfIranTheme.dom.$('#accept-cookies');
                const rejectBtn = ArtOfIranTheme.dom.$('#reject-cookies');

                if (acceptBtn) {
                    ArtOfIranTheme.dom.on(acceptBtn, 'click', () => {
                        this.acceptCookies();
                    });
                }

                if (rejectBtn) {
                    ArtOfIranTheme.dom.on(rejectBtn, 'click', () => {
                        this.rejectCookies();
                    });
                }
            },

            acceptCookies() {
                this.setCookie('artofiran_cookies_accepted', '1', 365);
                this.hideBanner();
            },

            rejectCookies() {
                this.setCookie('artofiran_cookies_accepted', '0', 365);
                this.hideBanner();
            },

            hideBanner() {
                ArtOfIranTheme.animations.fadeOut(this.banner).then(() => {
                    this.banner.remove();
                });
            },

            setCookie(name, value, days) {
                const expires = new Date();
                expires.setTime(expires.getTime() + (days * 24 * 60 * 60 * 1000));
                document.cookie = `${name}=${value};expires=${expires.toUTCString()};path=/`;
            }
        },

        // Performance monitoring
        performance: {
            init() {
                this.measurePerformance();
                this.optimizeImages();
            },

            measurePerformance() {
                if ('performance' in window && 'measure' in window.performance) {
                    window.addEventListener('load', () => {
                        setTimeout(() => {
                            const loadTime = performance.timing.loadEventEnd - performance.timing.navigationStart;
                            console.log(`Page load time: ${loadTime}ms`);
                        }, 0);
                    });
                }
            },

            optimizeImages() {
                // Convert images to WebP if supported
                if (this.supportsWebP()) {
                    ArtOfIranTheme.dom.$$('img[data-webp]').forEach(img => {
                        const webpSrc = img.getAttribute('data-webp');
                        if (webpSrc) {
                            img.src = webpSrc;
                        }
                    });
                }
            },

            supportsWebP() {
                const canvas = document.createElement('canvas');
                canvas.width = 1;
                canvas.height = 1;
                return canvas.toDataURL('image/webp').indexOf('data:image/webp') === 0;
            }
        },

        // Main initialization
        init() {
            // Wait for DOM to be ready
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', () => this.initModules());
            } else {
                this.initModules();
            }
        },

        initModules() {
            try {
                this.mobileMenu.init();
                this.scroll.init();
                this.lazyLoad.init();
                this.search.init();
                this.products.init();
                this.cookies.init();
                this.performance.init();

                // Add loaded class to body
                document.body.classList.add('theme-loaded');
                
                console.log('Art of Iran Theme initialized successfully');
            } catch (error) {
                console.error('Theme initialization failed:', error);
            }
        }
    };

    // Initialize theme
    ArtOfIranTheme.init();

    // Expose theme object globally for debugging
    if (typeof window !== 'undefined') {
        window.ArtOfIranTheme = ArtOfIranTheme;
    }

})();