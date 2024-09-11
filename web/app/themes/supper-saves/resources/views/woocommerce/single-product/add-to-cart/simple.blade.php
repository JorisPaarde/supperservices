<?php
defined('ABSPATH') || exit();

global $product;

if (!$product->is_purchasable()) {
    return;
}

echo wc_get_stock_html($product); // WPCS: XSS ok.
?>

@if ($product->is_in_stock() && (is_user_logged_in() && !is_customer()))

    @php do_action('woocommerce_before_add_to_cart_form'); @endphp

    <form
        class="cart"
        action="<?php echo esc_url(apply_filters('woocommerce_add_to_cart_form_action', $product->get_permalink())); ?>"
        method="post"
        enctype='multipart/form-data'
    >
        @php do_action('woocommerce_before_add_to_cart_button'); @endphp

        <div class="flex items-center gap-4">
            @php do_action('woocommerce_before_add_to_cart_quantity'); @endphp

            @php
                woocommerce_quantity_input([
                    'min_value' => apply_filters('woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product),
                    'max_value' => apply_filters('woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product),
                    'input_value' => isset($_POST['quantity']) ? wc_stock_amount(wp_unslash($_POST['quantity'])) : $product->get_min_purchase_quantity(), // WPCS: CSRF ok, input var ok.
                ]);
            @endphp

            @php do_action('woocommerce_after_add_to_cart_quantity');@endphp

            <button
                type="submit"
                name="add-to-cart"
                value="<?php echo esc_attr($product->get_id()); ?>"
                class="button button-secondary"
            >
                {{ $product->single_add_to_cart_text() }}
            </button>
        </div>
        @php do_action('woocommerce_after_add_to_cart_button'); @endphp
    </form>

    @php do_action('woocommerce_after_add_to_cart_form'); @endphp

@endif
