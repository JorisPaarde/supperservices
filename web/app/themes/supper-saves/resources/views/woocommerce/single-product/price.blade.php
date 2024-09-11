@php global $product; @endphp
@if (is_user_logged_in() && !is_customer())
    <p
        class="
            flex 
            items-center
            text-4xl 
            text-secondary 
            {{ esc_attr(apply_filters('woocommerce_product_price_class', 'price')) }}
        "
    >
        {!! $product->get_price_html() !!}
        <span class="text-xl inline-block ml-4">
            {{ get_field('box_amount', $product->get_id()) }}
        </span>
    </p>
@endif
