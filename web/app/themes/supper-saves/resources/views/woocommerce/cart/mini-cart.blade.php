@php do_action('woocommerce_before_mini_cart'); @endphp
@if (!WC()->cart->is_empty())
    <ul 
        class="
            woocommerce-mini-cart 
            cart_list 
            product_list_widget 
            {{ esc_attr($args['list_class']) }}
        "
    >
        @php do_action('woocommerce_before_mini_cart_contents'); @endphp
        @foreach (WC()->cart->get_cart() as $cartItemKey => $cartItem)
            @php
                // Woocommerce uses $_product because $product is already an global variable on product page
                $_product = apply_filters(
                    'woocommerce_cart_item_product', 
                    $cartItem['data'], 
                    $cartItem, 
                    $cartItemKey
                );

                $productId = apply_filters(
                    'woocommerce_cart_item_product_id', 
                    $cart_item['product_id'], 
                    $cart_item, 
                    $cart_item_key
                );

                $_productVisible = apply_filters(
                    'woocommerce_widget_cart_item_visible', 
                    true, 
                    $cartItem, 
                    $cartItemKey
                );
            @endphp

            @if ($_product && $_product->exists() && $cartItem['quantity'] > 0 && $_productVisible)
                @php
                    $thumbnail = apply_filters(
                        'woocommerce_cart_item_thumbnail', 
                        $_product->get_image(), 
                        $cartItem, 
                        $cartItemKey
                    );

                    $classes = apply_filters(
                        'woocommerce_mini_cart_item_class', 
                        'mini_cart_item', 
                        $cartItem, 
                        $cartItemKey
                    );
                @endphp
                <li
                    class="
                        woocommerce-mini-cart-item 
                        {{ $classes }} 
                        py-6 
                        border-b-2 
                        border-neutral-200
                    ">
                    <div class="flex gap-6">
                        <figure class="aspect-square max-w-[115px]">
                            <a href="{{ esc_url($_product->get_permalink($cartItem)) }}">
                                {!! $thumbnail !!}
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
                                    {{ $cartItem['quantity'] }} x
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
        @php do_action('woocommerce_mini_cart_contents'); @endphp
    </ul>

    <div class="woocommerce-mini-cart__total total py-7">
        <div class="flex items-center justify-between w-full">
            <p class="font-title uppercase text-xs leading-6">
                <?php echo __('Total', 'supper'); ?>
            </p>
            <p class="text-xl leading-6">
                {!! WC()->cart->get_cart_subtotal() !!}
            </p>
        </div>
    </div>
    @php do_action('woocommerce_widget_shopping_cart_before_buttons'); @endphp
@else
    <p class="woocommerce-mini-cart__empty-message">
        <?php echo __('No products in the cart.', 'woocommerce'); ?>
    </p>
@endif

@php do_action('woocommerce_after_mini_cart'); @endphp
