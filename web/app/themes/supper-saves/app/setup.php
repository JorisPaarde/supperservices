<?php

namespace App;

use Roots\Sage\Container;
use Roots\Sage\Assets\JsonManifest;
use Roots\Sage\Template\Blade;
use Roots\Sage\Template\BladeProvider;

/**
 * Theme assets
 */
add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style('supper-saves/app.css', asset_path('css/app.css'), false, null);
    
    if (is_single() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}, 100);

add_filter('woocommerce_enqueue_styles', '__return_empty_array');

/**
 * Theme setup
 */
add_action('after_setup_theme', function () {
    /**
     * Enable features from Soil when plugin is activated
     * @link https://roots.io/plugins/soil/
     */
    add_theme_support('soil-clean-up');
    add_theme_support('soil-jquery-cdn');
    add_theme_support('soil-nav-walker');
    add_theme_support('soil-nice-search');
    add_theme_support('soil-relative-urls');

    /**
     * Enable plugins to manage the document title
     * @link https://developer.wordpress.org/reference/functions/add_theme_support/#title-tag
     */
    add_theme_support('title-tag');

    /**
     * Register navigation menus
     * @link https://developer.wordpress.org/reference/functions/register_nav_menus/
     */
    register_nav_menus([
        'primary_navigation' => __('Primary Navigation', 'sage')
    ]);

    /**
     * Enable post thumbnails
     * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
     */
    add_theme_support('post-thumbnails');

    /**
     * Enable HTML5 markup support
     * @link https://developer.wordpress.org/reference/functions/add_theme_support/#html5
     */
    add_theme_support('html5', ['caption', 'comment-form', 'comment-list', 'gallery', 'search-form']);

    /**
     * Enable selective refresh for widgets in customizer
     * @link https://developer.wordpress.org/themes/advanced-topics/customizer-api/#theme-support-in-sidebars
     */
    add_theme_support('customize-selective-refresh-widgets');

    /**
     * Use main stylesheet for visual editor
     * @see resources/assets/styles/layouts/_tinymce.scss
     */
    add_editor_style(asset_path('styles/main.css'));

    add_theme_support('woocommerce');
}, 20);

/**
 * Register sidebars
 */
add_action('widgets_init', function () {
    $config = [
        'before_widget' => '<section class="widget %1$s %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h3>',
        'after_title' => '</h3>'
    ];
    register_sidebar([
        'name' => __('Primary', 'sage'),
        'id' => 'sidebar-primary'
    ] + $config);
    register_sidebar([
        'name' => __('Footer', 'sage'),
        'id' => 'sidebar-footer'
    ] + $config);

    register_sidebar([
        'name' => __('Product filters', 'sage'),
        'id' => 'product-filters',
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '',
        'after_title' => ''
    ]);
});

/**
 * Updates the `$post` variable on each iteration of the loop.
 * Note: updated value is only available for subsequently loaded views, such as partials
 */
add_action('the_post', function ($post) {
    sage('blade')->share('post', $post);
});

/**
 * Setup Sage options
 */
add_action('after_setup_theme', function () {
    /**
     * Add JsonManifest to Sage container
     */
    sage()->singleton('sage.assets', function () {
        return new JsonManifest(config('assets.manifest'), config('assets.uri'));
    });

    /**
     * Add Blade to Sage container
     */
    sage()->singleton('sage.blade', function (Container $app) {
        $cachePath = config('view.compiled');
        if (!file_exists($cachePath)) {
            wp_mkdir_p($cachePath);
        }
        (new BladeProvider($app))->register();
        return new Blade($app['view']);
    });

    /**
     * Create @asset() Blade directive
     */
    sage('blade')->compiler()->directive('asset', function ($asset) {
        return "<?= " . __NAMESPACE__ . "\\asset_path({$asset}); ?>";
    });

    /**
     * Create @icon() Blade directive
     */
    sage('blade')->compiler()->directive('icon', function ($icon) {
        return "<?= " . __NAMESPACE__ . "\\icon({$icon}); ?>";
    });
});

/**
 * Register ACF blocks
 */
add_action('acf/init', function() {
    if (function_exists('acf_register_block')) {
        // Look into views/blocks
        $dir = new \DirectoryIterator(\locate_template('views/blocks/'));

        // Loop through found blocks
        foreach ($dir as $fileinfo) {
            if (!$fileinfo->isDot() && !preg_match('/-admin\.blade\.php$/', $fileinfo->getFilename())) {
            $slug = str_replace('.blade.php', '', $fileinfo->getFilename());

            // Get infos from file
            $file_path = \locate_template('views/blocks/'.$slug.'.blade.php');
            $file_headers = get_file_data($file_path, [
                'title' => 'Title',
                'description' => 'Description',
                'category' => 'Category',
                'icon' => 'Icon',
                'keywords' => 'Keywords',
            ]);

            if (empty($file_headers['title'])) {
                die( _e('This block needs a title: ' . $file_path));
            }

            if (empty($file_headers['category'])) {
                die( _e('This block needs a category: ' . $file_path));
            }

            // Register a new block
            $datas = [
                'name' => $slug,
                'title' => $file_headers['title'],
                'description' => $file_headers['description'],
                'category' => $file_headers['category'],
                'icon' => $file_headers['icon'],
                'keywords' => explode(' ', $file_headers['keywords']),
                'render_callback'  => function( $block ) {
                    $slug             = str_replace( 'acf/', '', $block['name'] );
                    $block['slug']    = $slug;

                    if (is_admin() && $template = \locate_template('views/blocks/' . $slug . '-admin.blade.php')) {
                        echo \App\template( 'blocks/' . $slug . '-admin', [ 'block' => $block ] );
                    } else {
                        echo \App\template( 'blocks/' . $slug, [ 'block' => $block ] );
                    }
                },
            ];
            acf_register_block($datas);
            }
        }
    }
});
