@php
$product_data = $product->get_data();
$product_image = wp_get_attachment_image_src($product->get_image_id(), 'woocommerce_thumbnail');
$product_meta = get_post_meta($product_data['id']);
@endphp

<article 
    :ref="
        (el) => {
            productItems[{{ $index }}] = el;
        }
    "
    class="
        relative 
        product-item 
        group 
        opacity-0
        translate-y-5 
        hover:z-30
    "
>
    <a href="{{ get_permalink($product_data['id']) }}" class="relative z-20 block p-5">
        <figure class="relative mb-4 aspect-square group-hover:scale-90 group-hover:rotate-12 transition duration-500">
            @if ($product_image ?? false)
                <img 
                    src="{{ $product_image[0] }}" 
                    width="{{ $product_image[1] }}" 
                    height="{{ $product_image[2] }}"
                    class="
                        absolute
                        top-0
                        left-0
                        w-full
                        h-full
                        lazyload
                        lazyload-animate
                        object-contain
                    "
                    alt="{{ $product_data['name'] }}" 
                    loading="lazy"
                >
            @endif
        </figure>

        <h3 data-title-reveal class="text-xxs text-secondary font-normal text-center mb-4 lg:group-hover:text-white">
            {{ $product->get_name() }}
        </h3>

        @if (is_user_logged_in() && !is_customer() ?? false)
            <p class="flex items-center justify-center price text-lg text-primary font-light text-center group-hover:text-secondary">
                {!! $product->get_price_html() !!}
            </p>
            <p class="text-base text-secondary font-light text-center">
                {{ get_field('box_amount', $product->get_id()) }}
            </p>
        @endif
    </a>
    <div
        class="
            z-10
            flex
            lg:invisible
            lg:group-hover:visible
            lg:flex
            lg:group-hover:bg-primary
            lg:absolute
            left-0
            top-0
            @if (!is_user_logged_in() || is_customer() ?? false)
                lg:pt-full
            @else
                lg:pt-[calc(100%+100px)]
            @endif
            w-full
            lg:min-h-full
            justify-center
            transition 
            duration-300
        "
    >
        @if (is_user_logged_in() && !is_customer() && $product->is_in_stock() ?? false)
            <div 
                class="
                    lg:opacity-0
                    lg:-translate-y-2
                    lg:group-hover:opacity-100
                    lg:group-hover:translate-y-0
                    ease-in-out
                    transition 
                    duration-300
                    pt-2
                    pb-6
                    px-6
                    lg:px-16
                "
            >
                <archive-add-to-cart
                    add-to-cart-link="{{ $product->add_to_cart_url() }}"
                    add-to-cart-message="<?php echo sprintf(__('%s is added to the cart'), $product->get_name()); ?>"
                    @if($product->supports('ajax_add_to_cart'))
                        ajax-add-to-cart
                    @endif
                    :min="{{ $product->get_min_purchase_quantity() }}"
                    :max="{{ $product->get_max_purchase_quantity() }}"
                    product-description="{{ $product->add_to_cart_description() }}"
                    :product-id="{{ $product->get_id() }}"
                    product-sku="{{ $product->get_sku() }}"
                >
                    <span class="hidden lg:block">
                        <?php echo __('Add to cart'); ?>
                    </span>
                    <span class="lg:hidden text-base py-1">
                        <icon icon="cart"></icon>
                    </span>
                </archive-add-to-cart>
            </div>
        @endif
        @if (!$product->is_in_stock())
            <div
                class="p-6"
            >
                <p class="lg:text-white mb-2 text-center">
                    <?php echo __('this product is currently out of stock', 'supper'); ?>
                </p>
                <a href="{{ $product->get_permalink() }}" class="button button-white w-full justify-center">
                    <?php echo __('View product', 'supper'); ?>
                </a>
            </div>
        @endif
    </div>
</article>
