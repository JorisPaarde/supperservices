<?php
/**
 * Cart totals
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart-totals.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 2.3.6
 */

defined('ABSPATH') || exit;

?>
<div class="cart_totals <?php echo (WC()->customer->has_calculated_shipping()) ? 'calculated_shipping' : ''; ?>">
    @php do_action('woocommerce_before_cart_totals'); @endphp
    <div cellspacing="0" class="p-8 bg-neutral-200 mb-4 shop_table shop_table_responsive">
        <h2 class="mb-6">
            <?php esc_html_e('Cart totals', 'woocommerce'); ?>
        </h2>
        <div class="cart-subtotal flex items-center justify-between w-full">
            <p class="font-title uppercase text-xxs leading-6">
                <?php echo __('Subtotal', 'woocommerce'); ?>
            </p>
            <p class="text-lg leading-6">
                {!! wc_cart_totals_subtotal_html(); !!}
            </p>
        </div>

        @foreach (WC()->cart->get_coupons() as $code => $coupon)
            <hr class="h-0.5 bg-white w-full my-3 border-none">
            <div class="cart-coupons flex items-center justify-between w-full">
                <p class="font-title uppercase text-xxs leading-6">
                    {!! wc_cart_totals_coupon_label($coupon); !!}
                </p>
                <p class="text-lg leading-6">
                    {!! wc_cart_totals_coupon_html($coupon); !!}
                </p>
            </div>
        @endforeach

        @if (WC()->cart->needs_shipping() && WC()->cart->show_shipping())
            @php do_action('woocommerce_cart_totals_before_shipping'); @endphp
            @php wc_cart_totals_shipping_html(); @endphp
            @php do_action('woocommerce_cart_totals_after_shipping'); @endphp
        @elseif (WC()->cart->needs_shipping() && get_option('woocommerce_enable_shipping_calc') === 'yes')
            <div class="Shipping flex items-center justify-between w-full">
                <p class="font-title uppercase text-xxs leading-6">
                    <?php echo __('Shipping', 'woocommerce');?>
                </p>
                <p class="text-lg leading-6">
                    {!! woocommerce_shipping_calculator() !!}
                </p>
            </div>
        @endif

        @foreach (WC()->cart->get_fees() as $fee)
            <hr class="h-0.5 bg-white w-full my-3 border-none">
            <div class="fee flex items-center justify-between w-full">
                <p class="font-title uppercase text-xxs leading-6">
                    {{ esc_html($fee->name) }}
                </p>
                <p class="text-lg leading-6">
                    {!!  wc_cart_totals_fee_html($fee); !!}
                </p>
            </div>
        @endforeach

        @if (wc_tax_enabled() && ! WC()->cart->display_prices_including_tax())
            @php 
                $taxable_address = WC()->customer->get_taxable_address();
                $estimated_text  = '';
            @endphp

            @if (WC()->customer->is_customer_outside_base() && ! WC()->customer->has_calculated_shipping()) {
                @php 
                    $estimated_text = 
                    sprintf(
                        '<small>' . esc_html__('(estimated for %s)', 'woocommerce') . '</small>', 
                        WC()->countries->estimated_for_prefix($taxable_address[0]) . WC()->countries->countries[$taxable_address[0]] 
                    );
                @endphp
            @endif
            @if (get_option('woocommerce_tax_total_display') === 'itemized')
                @foreach (WC()->cart->get_tax_totals() as $code => $tax)
                    <hr class="h-0.5 bg-white w-full my-3 border-none">
                    <div class="tax-rate flex items-center justify-between w-full">
                        <p class="font-title uppercase text-xxs leading-6">
                            {{ esc_html($tax->label) . $estimated_text }}
                        </p>
                        <p class="text-lg leading-6">
                            {{ wp_kses_post($tax->formatted_amount) }}
                        </p>
                    </div>
                @endforeach
            @else
                <div class="tax-total flex items-center justify-between w-full">
                    <p class="font-title uppercase text-xxs leading-6">
                        {{ esc_html(WC()->countries->tax_or_vat()) . $estimated_text }}
                    </p>
                    <p class="text-lg leading-6">
                        {{ wp_kses_post(wc_cart_totals_taxes_total_html()) }}
                    </p>
                </div>
            @endif
        @endif
        @php do_action('woocommerce_cart_totals_before_order_total'); @endphp
        <hr class="h-0.5 bg-white w-full my-3 border-none">
        <div class="order-total flex items-center justify-between mt-4 w-full">
            <p class="font-title uppercase text-xs leading-6">
                <?php echo __('Total', 'woocommerce'); ?>
            </p>
            <p class="text-xl leading-6">
                {!! wc_cart_totals_order_total_html(); !!}
            </p>
        </div>
        @php do_action('woocommerce_cart_totals_after_order_total'); @endphp
        <div class="wc-proceed-to-checkout mt-10">
            @php do_action('woocommerce_proceed_to_checkout'); @endphp
        </div>
    </div>
    @php do_action('woocommerce_after_cart_totals'); @endphp
</div>
