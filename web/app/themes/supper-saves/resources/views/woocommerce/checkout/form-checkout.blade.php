@php
if (!defined('ABSPATH')) {
    exit();
}
// If checkout registration is disabled and not logged in, the user cannot checkout.
if (!$checkout->is_registration_enabled() && $checkout->is_registration_required() && !is_user_logged_in()) {
    echo esc_html(apply_filters('woocommerce_checkout_must_be_logged_in_message', __('You must be logged in to checkout.', 'woocommerce')));
    return;
}
@endphp

@php 
    do_action('woocommerce_before_checkout_form'); 
@endphp

<form
    name="checkout"
    method="post"
    class="checkout woocommerce-checkout"
    action="{!! esc_url(wc_get_checkout_url()) !!}"
    enctype="multipart/form-data"
>
    @php do_action('woocommerce_checkout_before_customer_details'); @endphp

    <div
        class="grid grid-cols-1 lg:grid-cols-5 gap-20"
        id="customer_details"
    >
        <div class="lg:col-span-3">
            @if ($checkout->get_checkout_fields())
                @php 
                    do_action('woocommerce_checkout_billing'); 
                @endphp
                @php 
                    do_action('woocommerce_checkout_shipping'); 
                @endphp 
            @endif
        </div>

        <div class="lg:col-span-2">
            @php 
                do_action('woocommerce_checkout_before_order_review_heading');
            @endphp
            @php do_action('woocommerce_checkout_before_order_review'); @endphp
            <div
                id="order_review"
                class="woocommerce-checkout-review-order"
            >
                @php do_action('woocommerce_checkout_order_review'); @endphp
            </div>
            @php do_action('woocommerce_checkout_after_order_review'); @endphp
        </div>
    </div>
    @php 
        do_action('woocommerce_checkout_after_customer_details'); 
    @endphp
</form>

@php do_action('woocommerce_after_checkout_form', $checkout); @endphp
