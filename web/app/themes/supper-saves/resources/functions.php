<?php

/**
 * Do not edit anything in this file unless you know what you're doing
 */

use Roots\Sage\Config;
use Roots\Sage\Container;
use App\Includes\Woocommerce\AccountMenu;
use App\Includes\Woocommerce\FormValidation;
use Ddeboer\Vatin\Validator;

/**
 * Helper function for prettying up errors
 * @param string $message
 * @param string $subtitle
 * @param string $title
 */
$sage_error = function ($message, $subtitle = '', $title = '') {
    $title = $title ?: __('Sage &rsaquo; Error', 'sage');
    $footer = '<a href="https://roots.io/sage/docs/">roots.io/sage/docs/</a>';
    $message = "<h1>{$title}<br><small>{$subtitle}</small></h1><p>{$message}</p><p>{$footer}</p>";
    wp_die($message, $title);
};

/**
 * Ensure compatible version of PHP is used
 */
if (version_compare('7.1', phpversion(), '>=')) {
    $sage_error(__('You must be using PHP 7.1 or greater.', 'sage'), __('Invalid PHP version', 'sage'));
}

/**
 * Ensure compatible version of WordPress is used
 */
if (version_compare('4.7.0', get_bloginfo('version'), '>=')) {
    $sage_error(__('You must be using WordPress 4.7.0 or greater.', 'sage'), __('Invalid WordPress version', 'sage'));
}

/**
 * Ensure dependencies are loaded
 */
if (!class_exists('Roots\\Sage\\Container')) {
    if (!file_exists($composer = __DIR__.'/../vendor/autoload.php')) {
        $sage_error(
            __('You must run <code>composer install</code> from the Sage directory.', 'sage'),
            __('Autoloader not found.', 'sage')
);
    }
    require_once $composer;
}

/**
 * Sage required files
 *
 * The mapped array determines the code library included in your theme.
 * Add or remove files to the array as needed. Supports child theme overrides.
 */
array_map(function ($file) use ($sage_error) {
    $file = "../app/{$file}.php";
    if (!locate_template($file, true, true)) {
        $sage_error(sprintf(__('Error locating <code>%s</code> for inclusion.', 'sage'), $file), 'File not found');
    }
}, ['helpers', 'setup', 'filters', 'admin']);

/**
 * Here's what's happening with these hooks:
 * 1. WordPress initially detects theme in themes/sage/resources
 * 2. Upon activation, we tell WordPress that the theme is actually in themes/sage/resources/views
 * 3. When we call get_template_directory() or get_template_directory_uri(), we point it back to themes/sage/resources
 *
 * We do this so that the Template Hierarchy will look in themes/sage/resources/views for core WordPress themes
 * But functions.php, style.css, and index.php are all still located in themes/sage/resources
 *
 * This is not compatible with the WordPress Customizer theme preview prior to theme activation
 *
 * get_template_directory()   -> /srv/www/example.com/current/web/app/themes/sage/resources
 * get_stylesheet_directory() -> /srv/www/example.com/current/web/app/themes/sage/resources
 * locate_template()
 * ├── STYLESHEETPATH         -> /srv/www/example.com/current/web/app/themes/sage/resources/views
 * └── TEMPLATEPATH           -> /srv/www/example.com/current/web/app/themes/sage/resources
 */
array_map(
    'add_filter',
    ['theme_file_path', 'theme_file_uri', 'parent_theme_file_path', 'parent_theme_file_uri'],
    array_fill(0, 4, 'dirname')
);
Container::getInstance()
    ->bindIf('config', function () {
        return new Config([
            'assets' => require dirname(__DIR__).'/config/assets.php',
            'theme' => require dirname(__DIR__).'/config/theme.php',
            'view' => require dirname(__DIR__).'/config/view.php',
        ]);
    }, true);

require_once __DIR__ . '/../app/order_export.php';

function get_add_to_cart($product) {
    $attributes = [
        'aria-label' => $product->add_to_cart_description(),
        'data-quantity' => '1',
        'data-product_id' => $product->get_id(),
        'data-product_sku' => $product->get_sku(),
        'rel' => 'nofollow',
        'class' => 'wp-block-button__link add_to_cart_button button button-white product__button',
    ];

    if ($product->supports('ajax_add_to_cart')) {
        $attributes['class'] .= ' ajax_add_to_cart';
    }

    return sprintf(
        '<a href="%s" %s>%s</a>',
        esc_url($product->add_to_cart_url()),
        wc_implode_html_attributes($attributes),
        __('Add to cart', 'woocommerce')
);
}

remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);

remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);
remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);

remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50);

remove_action('woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15);
remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);

function is_customer() {
    if (current_user_can('customer')) {
        return true;
    }

    return false;
}

function woocom_validate_extra_register_fields($username, $email, $validationErrors) {
    $customerFields = [
        'billing_company' => $_POST['billing_company'],
        'billing_first_name' => $_POST['billing_first_name'],
        'billing_coc' => $_POST['billing_coc'],
        'billing_last_name' => $_POST['billing_last_name'],
        'billing_phone' => $_POST['billing_phone'],
    ];

    foreach ($customerFields as $metaKey => $value) {
        if (empty($value)) {
            $validationErrors->add(
                "{$metaKey}_error",
                __("{$metaKey} is required!", 'woocommerce')
            );
        }

        if ($metaKey === 'billing_coc' && strlen($value) !== 8) {
            $validationErrors->add(
                "{$metaKey}_error",
                __("{$value} is not valid COC number", 'woocommerce')
            );
        }
    }

    return $validationErrors;
}

add_action('woocommerce_register_post', 'woocom_validate_extra_register_fields', 10, 3);

function woocom_save_extra_register_fields($customer_id) {
    $customerFields = [
        'billing_company' => $_POST['billing_company'],
        'company' => $_POST['billing_company'],
        'billing_coc' => $_POST['billing_coc'],
        'billing_first_name' => $_POST['billing_first_name'],
        'first_name' => $_POST['billing_first_name'],
        'billing_last_name' => $_POST['billing_last_name'],
        'last_name' => $_POST['billing_last_name'],
        'display_name' => "{$_POST['billing_first_name']} {$_POST['billing_last_name']}",
        'billing_phone' => $_POST['billing_phone'],
        'accept_terms_conditions' => $_POST['accept_terms_conditions'],
    ];

    foreach ($customerFields as $metaKey => $value) {
        update_user_meta($customer_id, $metaKey, sanitize_text_field($value));
    };
}

add_action('woocommerce_created_customer', 'woocom_save_extra_register_fields');

add_filter('jwt_auth_whitelist', function ($endpoints) {
	$your_endpoints = [
		'/wp-json/wholesale/v1/*',
        '/wp-json/wc-analytics/*',
        '/wc-analytics/*',
        '/wp-json/jetpack/*',
    ];

	return array_unique(array_merge($endpoints, $your_endpoints));
});

new FormValidation();

// Setup new account pages
new AccountMenu(
    [
        [
            'title' => __('Company info', 'supper'),
            'key' => 'company-info',
            'template' => 'woocommerce/myaccount/company-info',
        ],
        [
            'title' => __('Shipping info', 'supper'),
            'key' => 'shipping-info',
            'template' => 'woocommerce/myaccount/shipping-info',
        ],
        [
            'title' => __('Hardware', 'supper'),
            'key' => 'hardware',
            'template' => 'woocommerce/myaccount/hardware',
            'conditional' => !is_customer(),
        ],
        [
            'title' => __('SOP\'s', 'supper'),
            'key' => 'sop',
            'template' => 'woocommerce/myaccount/sop',
            'conditional' => !is_customer(),
        ],
        [
            'title' => __('SUPPER Support', 'supper'),
            'key' => 'support',
            'template' => 'woocommerce/myaccount/support',
        ]
    ],
    ['downloads', 'customer-logout', 'edit-address']
);

function acf_form_short_code($atts) {
    if (!$atts['form-group'] || is_admin()) {
        return;
    }

    $class = $atts['class'] ?? '';

    return acf_form([
        'field_groups' => explode(', ', $atts['form-group']),
        'post_id' => 'user_'. get_current_user_id(),
        'form_attributes' => [
            'class' => $class
        ],
        'updated_message' => false,
    ]);
}
add_shortcode('acf-form', 'acf_form_short_code');

// Hide the ACF Admin when site is staging or production
add_filter('acf/settings/show_admin', function ($show) {
    return env('WP_ENV') === 'local' || env('WP_ENV') === 'development';
});

function my_pre_save_post($id) {
    // Company info fields
    $acfFields = $_POST['acf'];
    $company = 'field_620a67ba784db';
    $address = 'field_620a67d8784dc';
    $housenumber = 'field_621897bde7039';
    $zipcode = 'field_620a67f3784dd';
    $city = 'field_620a68bc784e4';
    $country = 'field_620a6898784e3';
    $phone = 'field_620a6801784de';
    $coc = 'field_620a6818784df';

    // Copy data to shipping address
    if (isset($acfFields['field_621752dd509d9']) && $acfFields['field_621752dd509d9']) {
        $_POST['acf']['field_620a65521508d'] = $acfFields[$company];
        $_POST['acf']['field_620a65d3d5a67'] = $acfFields[$address];
        $_POST['acf']['field_6218972da9e0f'] = $acfFields[$housenumber];
        $_POST['acf']['field_620a65f2c70c5'] = $acfFields[$zipcode];
        $_POST['acf']['field_620a6646c70c6'] = $acfFields[$city];
        $_POST['acf']['field_620a666dc70c7'] = $acfFields[$country];
        $_POST['acf']['field_620a66c5e8e13'] = $acfFields[$phone];
        $_POST['acf']['field_620a66f1855c8'] = $acfFields[$coc];
    }

    return $id;
}
add_filter('acf/pre_save_post', 'my_pre_save_post', 10, 1);

function sop_post_type() {
    register_post_type('sops',
        [
            'labels' => [
                'name' => __('Sop\'s'),
                'singular_name' => __('sop')
            ],
            'public' => true,
            'has_archive' => true,
            'rewrite' => ['slug' => 'sops'],
            'show_in_rest' => true,
        ]
);
}
add_action('init', 'sop_post_type');
add_post_type_support('sops', 'thumbnail');

function acf_theme_settings()
{
    if (function_exists('acf_add_options_page')) {
        acf_add_options_page([
            'page_title' => 'Theme settings',
            'menu_title' => 'Theme settings',
            'menu_slug' => 'theme-settings',
            'capability' => 'edit_posts',
            'redirect' => false,
        ]);
    }
}
add_action('acf/init', 'acf_theme_settings');

function custom_excerpt_length($length) {
	return 20;
}
add_filter('excerpt_length', 'custom_excerpt_length', 999);

if (!function_exists('allUserFieldsFilled')) {
    function allUserFieldsFilled (string $groupKey): bool
    {
        $fields = acf_get_fields($groupKey);

        foreach ($fields as $field) {
            if ($field['required']
            && empty(get_field($field['key'], 'user_'.get_current_user_id()))
            && $field['conditional_logic'] === 0) {
                return false;
            }
        }

        return true;
    }
}

// Don't login user in after registration
add_filter('woocommerce_registration_auth_new_customer', '__return_false');

remove_action('woocommerce_thankyou', 'woocommerce_order_details', 10);

add_filter('woocommerce_email_headers', 'addBccToEmailHeaders', 10, 4);
function addBccToEmailHeaders($header, $email_id, $email_for_obj, $email_class) {
    $email = env('BCC_EMAIL') ?? 'hello@supper.services';

    if ($email_id === 'customer_new_account') {
        $header .= 'Bcc: '. $email ."\r\n";
    }

	return $header;
}

function validateUsername($args) {
    if (isset($_POST['account_nickname'])
        && username_exists($_POST['account_nickname'])
        && $_POST['account_nickname'] !== wp_get_current_user()->user_login) {
        $args->add('error', __('This username is already chosen.', 'woocommerce'));
    }
}
add_action('woocommerce_save_account_details_errors', 'validateUsername', 10, 1);

function saveUsername($userId) {
    if (isset($_POST['account_nickname'])) {
        global $wpdb;

        $wpdb->update(
            "{$wpdb->prefix}users",
            ['user_login' => sanitize_text_field($_POST['account_nickname'])],
            ['ID' => $userId]
        );
    }
}
add_action('woocommerce_save_account_details', 'saveUsername', 10, 1);

/**
 * Validate the the delivery date
 *
 * @param string $fields
 * @param string $errors
 */
function validateDeliveryDate($fields, $errors)
{
    if (isset($_POST['coderockz_woo_delivery_date_field'])) {
        date_default_timezone_set(env('APP_TIMEZONE') ?? 'Europe/Amsterdam');

        $currentTime = (int) date('Hi');
        $tomorrow = date('Y-m-d', strtotime('+1 days'));
        $maximumOrderTime = (int) env('APP_MAXIMUM_ORDER_TIME') ?? 1400;

        $deliveryDate = $_POST['coderockz_woo_delivery_date_field'];
        $formattedDeliveryDate = date('Y-m-d', strtotime($deliveryDate));
        $nextDayDeliverySelected = $formattedDeliveryDate === $tomorrow;

        if (($currentTime > $maximumOrderTime) && $nextDayDeliverySelected) {
            $errors->add(
                'validation',
                __('Next day delivery isn\'t available anymore. Please select the next available delivery date', 'supper')
            );
        }
    }
}

add_action('woocommerce_after_checkout_validation', 'validateDeliveryDate', 10, 2);

/**
 * Validate the PO number
 *
 * @param string $fields
 * @param string $errors
 */
function validatePONumber($fields, $errors)
{

    $value = $fields['order_po'];
    $currentUser = wp_get_current_user();
    $isPoRequired = get_field('po_number_required', 'user_'. $currentUser->ID);

    if ($isPoRequired) {
        if (empty($value)) {
            $errors->add('validation', __('PO number is required', 'supper'));
        }
    }
}

add_action('woocommerce_after_checkout_validation', 'validatePONumber', 10, 2);

//  Create custom columns user table
function custom_columns_user_table( $column ) {
    $column['company_name'] =  __('Company name');
    $column['company_coc'] =  __('COC number');
    return $column;
}
add_filter('manage_users_columns', 'custom_columns_user_table');

//  Custom columns values
function custom_columns_user_table_values($val, $column_name, $user_id) {
    switch ($column_name) {
        case 'company_name' :
            return get_user_meta($user_id, 'billing_company', true);
        case 'company_coc' :
            return get_user_meta($user_id, 'billing_coc', true);
        default:
    }
    return $val;
}
add_filter('manage_users_custom_column', 'custom_columns_user_table_values', 10, 3);

// Custom placeholders WooCommerce emails
function filter_email_format_string($string, $email) {
    $user_id = $email->object->ID;

    $additional_placeholders = [
        '{billing_company}' => get_user_meta($user_id, 'billing_company', true),
        '{billing_coc}' => get_user_meta($user_id, 'billing_coc', true),
    ];

    return str_replace(array_keys($additional_placeholders), array_values($additional_placeholders), $string);
}
add_filter('woocommerce_email_format_string' , 'filter_email_format_string', 20, 2);

/**
 * Validate the billing VAT number.
 *
 * @param array $fields
 * @param \WP_Error $errors
 * @return void
 */
function validateBillingVatNumber($fields, $errors): void
{
    $value = $fields['billing_tax'];
    $validator = new Validator();

    if (!$validator->isValid($value, true)) {
        $errors->add('validation', __('VAT number is invalid', 'supper'));
    }
}
add_action('woocommerce_after_checkout_validation', 'validateBillingVatNumber', 10, 2);
