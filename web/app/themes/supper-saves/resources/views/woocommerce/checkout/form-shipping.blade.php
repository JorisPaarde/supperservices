@if (WC()->cart->needs_shipping_address())
    <div class="woocommerce-shipping-fields py-4 px-6 border-2 border-neutral-200 rounded mb-10">
        <ui-toggle> 
            <template v-slot="{ toggleContent, showContent }">
                <div class="pb-4 flex items-center border-b-2 border-neutral-200 mb-4">
                    <h3><?php echo __('Shipping details', 'woocommerce'); ?></h3>
                    <button 
                        @click="toggleContent"
                        class="button-outline ml-auto disabled:pointer-events-none disabled:opacity-30"
                        type="button"
                        :disabled="showContent"
                    >
                        <?php echo __('Edit address', 'woocommerce'); ?>
                    </button>
                </div>
                <p id="ship-to-different-address">
                    <label 
                        class="
                            woocommerce-form__label 
                            woocommerce-form__label-for-checkbox
                            checkbox
                            py-3
                            @if (get_option('woocommerce_ship_to_destination') === 'shipping')
                                hidden
                            @else
                                block
                            @endif
                        "
                    >
                        <input 
                            @input="toggleContent"
                            id="ship-to-different-address-checkbox" 
                            class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox" 
                            @php 
                                echo checked(
                                    apply_filters(
                                        'woocommerce_ship_to_different_address_checked', 
                                        'shipping' === get_option('woocommerce_ship_to_destination') ? 1 : 0
                                    ),
                                    1
                                ); 
                            @endphp
                            type="checkbox" 
                            name="ship_to_different_address" 
                            value="1" 
                        /> 
                        <span>
                            <?php echo __('Ship to shipping address?', 'woocommerce'); ?>
                        </span>
                    </label>
                </p>
                <div v-show="!showContent" class="grid grid-cols-2">
                    @if ($checkout->get_value('shipping_address') && $checkout->get_value('shipping_address_2'))
                        <div>
                            <h4 class="text-lg font-bold font-sans normal-case mb-3">
                                <?php echo __('Shipping address', 'supper'); ?>
                            </h4>
                            <p>
                                <strong class="block">{{ $checkout->get_value('shipping_company') }}</strong>
                                <span class="block">{{ $checkout->get_value('billing_first_name') }} {{ $checkout->get_value('shipping_last_name') }}</span>
                                <span class="block">{{ $checkout->get_value('shipping_address') }} {{ $checkout->get_value('shipping_address_2') }}</span>
                                <span class="block">{{ $checkout->get_value('shipping_postcode') }}  {{ $checkout->get_value('shipping_city') }} </span>
                                <span class="block">{{ $checkout->get_value('shipping_country') }}</span>
                            </p>
                        </div>
                    @endif
                    <div>
                        <h4 class="text-lg font-bold font-sans normal-case mb-3">
                            <?php echo __('Purchase info', 'supper'); ?>
                        </h4>
                        <p>
                            <span class="block">{{ get_user_meta(get_current_user_id(), 'purchase_name')[0] }}</span>
                            <span class="block">{{ get_user_meta(get_current_user_id(), 'purchase_phone')[0] }}</span>
                            <span class="block">{{ get_user_meta(get_current_user_id(), 'purchase_email')[0] }}</span>
                        </p>
                    </div>
                </div>
                @php 
                    do_action('woocommerce_before_checkout_shipping_form', $checkout); 
                @endphp
                <div 
                    :class="[
                        'woocommerce-shipping-fields__field-wrapper', 
                        { 'hidden': !showContent }
                    ]"
                >
                    @php
                        $fields = $checkout->get_checkout_fields('shipping');
                    @endphp
                    @foreach ($fields as $key => $field)
                        @php
                            woocommerce_form_field($key, $field, $checkout->get_value($key));
                        @endphp
                    @endforeach
                </div>
                @php 
                    do_action('woocommerce_after_checkout_shipping_form', $checkout); 
                @endphp
            </template>
        </ui-toggle>
    </div>
@endif

<div class="woocommerce-additional-fields ">
    @php 
        do_action('woocommerce_before_order_notes', $checkout); 
    @endphp

    @if (apply_filters('woocommerce_enable_order_notes_field', 'yes' === get_option('woocommerce_enable_order_comments', 'yes')))

        @if (!WC()->cart->needs_shipping() || wc_ship_to_billing_address_only())
            <h3>
                <?php echo __('Additional information', 'woocommerce'); ?>
            </h3>
        @endif

        <div class="woocommerce-additional-fields__field-wrapper mb-3">
            @foreach ($checkout->get_checkout_fields('order') as $key => $field)
                @php 
                    woocommerce_form_field($key, $field, $checkout->get_value($key)); 
                @endphp
            @endforeach
        </div>
    @endif

    @php 
        do_action('woocommerce_after_order_notes', $checkout); 
    @endphp
</div>
