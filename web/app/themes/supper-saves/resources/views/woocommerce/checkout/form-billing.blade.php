<div class="woocommerce-billing-fields py-4 px-6 border-2 border-neutral-200 rounded mb-10">
    <ui-toggle> 
        <template v-slot="{ toggleContent, showContent }">
            <div class="pb-4 flex items-center border-b-2 border-neutral-200 mb-4">
                @if (wc_ship_to_billing_address_only() && WC()->cart->needs_shipping())
                    <h3><?php echo __('Billing &amp; Shipping', 'woocommerce'); ?></h3>
                @else
                    <h3><?php echo __('Billing details', 'woocommerce'); ?></h3>
                @endif
                @if (get_option('woocommerce_ship_to_destination') !== 'shipping')
                    <button 
                        @click="toggleContent"
                        class="button-outline ml-auto disabled:pointer-events-none disabled:opacity-30"
                        type="button"
                        :disabled="showContent"
                    >
                        <?php echo __('Edit address', 'woocommerce'); ?>
                    </button>
                @endif
            </div>
            <div v-show="!showContent" class="grid grid-cols-2">
                <div>
                    <h4 class="text-lg font-bold font-sans normal-case mb-3">
                        <?php echo __('Billing address', 'supper'); ?>
                    </h4>
                    <p>
                        <strong class="block">{{ $checkout->get_value('billing_company') }}</strong>
                        <span class="block">{{ $checkout->get_value('billing_address_1') }} {{ $checkout->get_value('billing_address_2') }}</span>
                        <span class="block">{{ $checkout->get_value('billing_postcode') }}  {{ $checkout->get_value('billing_city') }} </span>
                        <span class="block">{{ $checkout->get_value('billing_country') }}</span>
                    </p>
                </div>
                <div>
                    <h4 class="text-lg font-bold font-sans normal-case mb-3">
                        <?php echo __('Contact info', 'supper'); ?>
                    </h4>
                    <p>
                        <span class="block">{{ $checkout->get_value('billing_phone') }}</span>
                        <span class="block">{{ $checkout->get_value('billing_email') }}</span>
                        <span class="block">
                            <strong><?php echo __('Invoice email:', 'supper') ?></strong> 
                            {{ $checkout->get_value('admin_invoice_email') }}
                        </span>
                    </p>
                </div>
            </div>
            @php 
                do_action('woocommerce_before_checkout_billing_form', $checkout); 
            @endphp
            <div 
                :class="[
                    'woocommerce-billing-fields__field-wrapper', 
                    { 'hidden': !showContent }
                ]"
            >
                @php
                    $fields = $checkout->get_checkout_fields('billing');
                @endphp
                
                @foreach ($fields as $key => $field)
                    @php 
                        woocommerce_form_field($key, $field, $checkout->get_value($key));
                    @endphp 
                @endforeach 
            </div>
            @php 
                do_action('woocommerce_after_checkout_billing_form', $checkout); 
            @endphp
        </template>
    </ui-toggle>
</div>

