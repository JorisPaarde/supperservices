@php 
    do_action('woocommerce_before_cart')
@endphp

<div class="grid grid-cols-1 lg:grid-cols-12 gap-24">
    <div class="lg:col-span-7">
        <form action="<?php echo esc_url(wc_get_cart_url()); ?>" method="post">
            @php 
                do_action('woocommerce_before_cart_table'); 
            @endphp
            <div class="cart woocommerce-cart-form__contents">
                @php 
                    do_action('woocommerce_before_cart_contents'); 
                @endphp
                <ul class="woocommerce-cart m-0 pl-0 cart_list product_list_widget mb-10">
                    @foreach (WC()->cart->get_cart() as $cartItemKey => $cartItem)
                        @php
                            $_product = 
                                apply_filters(
                                    'woocommerce_cart_item_product',
                                    $cartItem['data'],
                                    $cartItem,
                                    $cartItemKey
                            );
                            $product_id = $_product->get_id();
                        @endphp

                        @if ($_product && $_product->exists() && $cartItem['quantity'] > 0 && apply_filters('woocommerce_widget_cart_item_visible', true, $cartItem, $cartItemKey))
                            @php
                                $classes = apply_filters(
                                    'woocommerce_mini_cart_item_class', 
                                    'mini_item', 
                                    $cartItem, 
                                    $cartItemKey
                                );
                            @endphp
                            <li
                                class="
                                    woocommerce-cart-item 
                                    {{ $classes }} 
                                    py-6 
                                    border-b-2 
                                    border-neutral-200
                                "
                            >
                                <div class="flex gap-6">
                                    <figure class="aspect-square max-w-[115px]">
                                        <a href="{{ esc_url($_product->get_permalink($cartItem)) }}">
                                            <img 
                                                src="{{ get_the_post_thumbnail_url($_product->get_id(), 'post-thumbnail') }}" 
                                                alt="{{ $product_name }}"
                                                width="115"
                                                height="115"
                                                loading="lazy"
                                            >
                                        </a>
                                    </figure>
                                    <div class="content flex flex-col grow">
                                        <p 
                                            class="
                                                title 
                                                font-title 
                                                text-xxs 
                                                uppercase 
                                                text-secondary
                                                w-3/4 
                                                leading-4 
                                                mb-0.5
                                            "
                                        >
                                            {{ $_product->get_name() }}
                                        </p>
                                        <p class="title text-secondary mb-2">
                                            {{ get_field('box_amount', $_product->get_id()) }}
                                        </p>
                                        <div class="flex mt-auto gap-3">
                                            <div class="text-xl leading-10">
                                                <?php
                                                    if ($_product->is_sold_individually()) {
                                                        $product_quantity = sprintf('1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cartItemKey);
                                                    } else {
                                                        $product_quantity = woocommerce_quantity_input(
                                                            array(
                                                                'input_name' => "cart[{$cartItemKey}][qty]",
                                                                'input_value' => $cartItem['quantity'],
                                                                'max_value' => $_product->get_max_purchase_quantity(),
                                                                'min_value' => 0,
                                                                'product_name' => $_product->get_name(),
                                                            ),
                                                            $_product,
                                                            false
                                                        );
                                                    }
                                                    echo apply_filters('woocommerce_cart_item_quantity', $product_quantity, $cartItemKey, $cartItem); // PHPCS: XSS ok.
                                                ?>
                                            </div>
                                            <a 
                                                href="{!! wc_get_cart_remove_url($cartItemKey) !!}"
                                                data-product_id="{{ esc_attr($productId) }}"
                                                data-cartItemKey="{{ esc_attr($cartItemKey) }}"
                                                data-product_sku="{{ esc_attr($_product->get_sku()) }}"
                                                class="
                                                    remove
                                                    remove_from_cart_button
                                                    w-10
                                                    h-10
                                                    flex
                                                    items-center
                                                    justify-center
                                                    border-2
                                                    border-neutral-400
                                                    text-neutral-400
                                                    rounded-full
                                                "
                                            >
                                                @icon('trash-2')
                                            </a>
                                        </div>
                                    </div>
                                    <div class="flex items-end">
                                        {!! WC()->cart->get_product_price($_product) !!}
                                    </div>
                                </div>
                            </li>
                        @endif
                    @endforeach
                </ul>
                <section class="cart-essentials">
                    <button
                        type="submit"
                        class="button-outline ml-auto w-auto disabled:opacity-40 disabled:grayscale-100"
                        name="update_cart"
                        value="<?php esc_attr_e('Update cart', 'woocommerce'); ?>"
                    >
                        <?php esc_html_e('Update cart', 'woocommerce'); ?>
                    </button>

                    @php 
                        do_action('woocommerce_cart_actions');
                    @endphp

                    <?php wp_nonce_field('woocommerce-cart', 'woocommerce-cart-nonce'); ?>
                </section>
                @php 
                    do_action('woocommerce_after_cart_contents');
                @endphp
            </div>
            @php 
                do_action('woocommerce_after_cart_table');
            @endphp
        </form>
    </div>
    <aside class="lg:col-span-5">
        @php 
            do_action('woocommerce_before_cart_collaterals'); 
        @endphp

        <div class="cart-collaterals">
            @php
                /**
                 * Cart collaterals hook.
                 *
                 * @hooked woocommerce_cross_sell_display
                 * @hooked woocommerce_cart_totals - 10
                 */
                do_action('woocommerce_cart_collaterals');
            @endphp
        </div>
    </aside>
</div>

@php 
    do_action('woocommerce_after_cart');
@endphp
