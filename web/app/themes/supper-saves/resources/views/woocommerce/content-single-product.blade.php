@php global $product; @endphp

@php
/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked woocommerce_output_all_notices - 10
 */
do_action('woocommerce_before_single_product');

@endphp

<div
    id="product-{{ the_ID() }}"
    class="mb-32"
>
    <div class="bg-primary flex items-center min-h-[280px]">
        <div class="ml-auto md:w-1/2 md:pb-14 pl-10 pr-14 pt-14 pb-[200px]">
            <h1 data-title-reveal class="w-full text-2xl lg:text-5xl text-white mb-3">
                {{ $product->get_name() }}
            </h1>
            <p class="text-secondary text-lg">SKU: {{ $product->get_sku() }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-10 max-w-7xl mx-auto">
        <div class="px-20 md:px-6 -mt-[160px] md:-mt-[210px]">
            @php
                /**
                 * Hook: woocommerce_before_single_product_summary.
                 *
                 * @hooked woocommerce_show_product_sale_flash - 10
                 * @hooked woocommerce_show_product_images - 20
                 */
                do_action('woocommerce_before_single_product_summary');
            @endphp
        </div>
        <div class="pb-6 lg:py-6 pl-5 entry-content">
            <div class="mb-6">
                @php 
                    $product_description = $product->get_short_description();
                    if (empty($product_description)) {
                        $product_description = $product->get_description();
                    }
                    $product_description = str_replace('&nbsp;',' ',$product_description);
                @endphp
                {!! wpautop($product_description) !!}
            </div>
            @php do_action('woocommerce_single_product_summary'); @endphp
        </div>
    </div>

    @if (is_user_logged_in())
        @php do_action('woocommerce_after_single_product_summary'); @endphp
    @else
        <div class="bg-carousel-pink text-heavy-metal max-w-[920px] mx-auto w-full mt-12 p-10 lg:p-24">
            <h2 class="text-xl lg:text-3xl mb-4">
                @if (get_fields('options')['not_logged_in']['title'] ?? false)
                    {{ get_fields('options')['not_logged_in']['title'] }}
                @else
                    <?php echo __('Hungry for more ?', 'supper') ?>
                @endif
            </h2>

            @if (get_fields('options')['not_logged_in']['content'] ?? false)
                <p class="mb-4 lg:text-xl">{{ get_fields('options')['not_logged_in']['content'] }}</p>
            @endif

            <div class="flex items-center mt-4">
                <a 
                    href="{{ wc_get_account_endpoint_url('dashboard') }}" 
                    class="button"
                >
                    <?php echo __('Log in', 'supper'); ?>
                </a>
                <span class="block px-2">
                    - <?php echo __('or', 'supper'); ?> - 
                </span>
                <a 
                    href="{{ wc_get_account_endpoint_url('dashboard') }}" 
                    class="button-outline button-outline-heavy-metal"
                >
                    <?php echo __('Register', 'supper'); ?>
                </a>
            </div>
        </div>
    @endif
</div>

@php do_action('woocommerce_after_single_product'); @endphp
