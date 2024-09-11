<?php
/**
 * Plugin Name: Supper Admin PO number field at order
 * Description: Show po number field in backend order
 * Version: v1.0.0
 * Author: Jim van Eijk (23G)
 * Author URI: https://www.23G.nl
 */

add_action('add_meta_boxes', 'supper_add_meta_boxes');

if (!function_exists('supper_add_meta_boxes')) {
    function supper_add_meta_boxes(): void
    {
        add_meta_box(
            'supper_other_fields', 
            __('PO number', 'woocommerce'), 
            'supper_add_other_fields_for_packaging', 
            'shop_order', 
            'side', 
            'core'
        );
    }
}

if (!function_exists('supper_add_other_fields_for_packaging')) {
    function supper_add_other_fields_for_packaging()
    {
        global $post;

        $metaFieldData = get_post_meta($post->ID, '_my_field_slug', true) ?: '';

        echo '
            <input type="hidden" name="supper_other_meta_field_nonce" value="' . wp_create_nonce() . '">
            <p style="border-bottom:solid 1px #eee;padding-bottom:13px;">
                <input 
                    type="text" 
                    style="width:250px;" 
                    name="order_po" 
                    placeholder="' . $metaFieldData . '" 
                    value="' . $metaFieldData . '"
                >
            </p>
        ';

    }
}

add_action('save_post', 'supper_save_wc_order_other_fields', 10, 1);

if (!function_exists('supper_save_wc_order_other_fields')) {
    function supper_save_wc_order_other_fields($postId) 
    {
        if (!isset($_POST['supper_other_meta_field_nonce'])) {
            return $postId;
        }

        $nonce = $_POST['supper_other_meta_field_nonce'];

        if (!wp_verify_nonce($nonce)) {
            return $postId;
        }

        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return $postId;
        }

        if ('page' == $_POST['post_type']) {
            if (!current_user_can('edit_page', $postId)) {
                return $postId;
            }
        } else {
            if (!current_user_can('edit_post', $postId)) {
                return $postId;
            }
        }
    
        update_post_meta($postId, '_order_po', $_POST['order_po']);
    }
}

add_action('woocommerce_before_add_to_cart_button', 'my_custom_product_field');

function my_custom_product_field() 
{
    echo '
        <div id="my_custom_field">
            <label>' . __('PO number') . ' </label>
            <input type="text" name="order_po" value="">
        </div><br>
    ';
}

add_filter('woocommerce_add_cartItem_data', 'save_my_custom_product_field', 10, 2);
function save_my_custom_product_field($cartItemData, $productId) 
{
    if (isset($_REQUEST['order_po'])) {
        $cartItemData['order_po'] = $_REQUEST['order_po'];
    
        $cartItemData['unique_key'] = md5(microtime().rand());
        WC()->session->set('my_order_data', $_REQUEST['order_po']);
    }
    return $cartItemData;
}

add_action('woocommerce_checkout_update_order_meta', 'my_custom_checkout_field_update_order_meta');
function my_custom_checkout_field_update_order_meta($order_id) 
{
    if (!empty($_POST['order_po'])) {
        update_post_meta($order_id, '_order_po', $_POST['order_po']);
    }
}

add_action('woocommerce_admin_order_data_after_billing_address', 'my_custom_checkout_field_display_admin_order_meta', 10, 1);
function my_custom_checkout_field_display_admin_order_meta($order)
{
    $poField = get_post_meta($order->id, '_order_po', true);

    if (!empty($poField)) {
        echo '<p><strong>'. __('PO number', 'woocommerce').':</strong> ' . get_post_meta($order->id, '_order_po', true) . '</p>';
    }
}

add_filter('woocommerce_get_item_data', 'render_meta_on_cart_and_checkout', 10, 2);
function render_meta_on_cart_and_checkout($cartData, $cartItem = null) 
{
    $customItems = [];

    if (!empty($cartData)) {
        $customItems = $cartData;
    }

    if (isset($cartItem['order_po'])) {
        $customItems[] = [
            'name' => __('PO number', 'woocommerce'),
            'value' => $cartItem['order_po']
        ];
    }

    return $customItems;
}

add_action('woocommerce_add_order_item_meta','add_values_to_order_item_meta', 10, 3);
function add_values_to_order_item_meta($itemId, $cartItem, $cartItemKey) 
{
    if (!empty($cartItem['order_po'])) {
        wc_add_order_item_meta(
            $itemId, 
            __('PO number label name'), 
            $cartItem['order_po'], 
            true
        );
    }
}
