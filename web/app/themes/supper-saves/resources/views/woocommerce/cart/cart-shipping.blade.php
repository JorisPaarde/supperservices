@php
    $formatted_destination = isset($formatted_destination) ? $formatted_destination : WC()->countries->get_formatted_address($package['destination'], ', ');
    $has_calculated_shipping = !empty($has_calculated_shipping);
    $show_shipping_calculator = !empty($show_shipping_calculator);
    $calculator_text = '';
@endphp
<div class="woocommerce-shipping-totals shipping flex items-center justify-between w-full py-2">
    <p class="font-title uppercase text-xxs leading-6">{{ wp_kses_post($package_name) }}</p>
    <div data-title="{{ esc_attr($package_name) }}" class="text-lg leading-6">
        @if ($available_methods)
            <ul id="shipping_method" class="woocommerce-shipping-methods text-lg">
                @foreach ($available_methods as $method)
                    <li class="flex items-center">
                        <input 
                            type="{{ 1 < count($available_methods) ? 'radio' : 'hidden' }}" 
                            name="shipping_method[{{ $index }}]" 
                            data-index="{{ $index }}"
                            id="shipping_method_{{ $index }}_{{ esc_attr(sanitize_title($method->id)) }}" 
                            value="{{ esc_attr($method->id) }}" 
                            class="shipping_method" 
                            @if (1 < count($available_methods))
                                @php echo checked($method->id, $chosen_method, false) @endphp
                            @endif
                        />
                        <label 
                            for="shipping_method_{{ $index }}_{{ esc_attr(sanitize_title($method->id)) }}"
                            class="ml-2"
                        >
                            {!! wc_cart_totals_shipping_method_label($method) !!}
                        </label>
                        @php
                            do_action('woocommerce_after_shipping_rate', $method, $index);
                        @endphp
                    </li>
                @endforeach
            </ul>
        @elseif (!$has_calculated_shipping || !$formatted_destination)
            @php
                if (is_cart() && 'no' === get_option('woocommerce_enable_shipping_calc')) {
                    echo wp_kses_post(
                        apply_filters(
                            'woocommerce_shipping_not_enabled_on_cart_html', 
                            __('Shipping costs are calculated during checkout.', 'woocommerce')
                        )
                    );
                } else {
                    echo wp_kses_post(
                        apply_filters(
                            'woocommerce_shipping_may_be_available_html',
                            __('Enter your address to view shipping options.', 'woocommerce')
                        )
                    );
                }
            @endphp
        @elseif (!is_cart())
            @php
                echo wp_kses_post(
                    apply_filters(
                        'woocommerce_no_shipping_available_html',
                         __('There are no shipping options available.', 'woocommerce')
                    )
                );
            @endphp
        @else
            @php
                echo wp_kses_post(
                    apply_filters(
                        'woocommerce_cart_no_shipping_available_html', 
                        l__('No shipping options were found', 'woocommerce')
                    )
                );
                $calculator_text = esc_html__('Enter a different address', 'woocommerce');
            @endphp
        @endif

        @if ($show_package_details)
            <p class="woocommerce-shipping-contents">
                <small>
                    @php 
                        esc_html($package_details) 
                    @endphp
                </small>
            </p>
        @endif

        @if ($show_shipping_calculator)
            @php woocommerce_shipping_calculator($calculator_text); @endphp
        @endif
    </div>
</div>
