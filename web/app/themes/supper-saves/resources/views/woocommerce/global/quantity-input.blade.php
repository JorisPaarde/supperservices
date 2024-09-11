@if ($max_value && $min_value === $max_value)
    <div class="quantity hidden">
        <input
            type="hidden"
            id="{{ esc_attr($input_id) }}"
            class="qty"
            name="{{ esc_attr($input_name) }}"
            value="{{ esc_attr($min_value) }}"
        />
    </div>
@else
    <div class="quantity">
        @php do_action( 'woocommerce_before_quantity_input_field' ); @endphp
        <label
            class="screen-reader-text visually-hidden"
            for="{{ esc_attr($input_id) }}"
        >
            <?php echo __('Quantity', 'woocommerce'); ?>
        </label>
        <ui-quantity-input
            :value="{{ esc_attr($input_value ?? 1) }}"
            name="{{ esc_attr($input_name) }}"
            title="{{ esc_attr_x('Qty', 'Product quantity input tooltip', 'woocommerce') }}"
            id="{{ esc_attr($input_id) }}"
            :step="{{ esc_attr($step) }}"
            :min="{{ esc_attr($min_value) }}"
            :max="{{ esc_attr($max_value && $max_value > 0 ? $max_value : 999) }}"
        ></ui-quantity-input>
        @php do_action('woocommerce_after_quantity_input_field'); @endphp
    </div>
@endif
