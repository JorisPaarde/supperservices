<div class="woocommerce-order">
    @if ($order)
        @php
            do_action('woocommerce_before_thankyou', $order->get_id());
        @endphp
        @if ($order->has_status('failed'))
            <div class="bg-carousel-pink text-heavy-metal p-14 text-center mb-10">
                <p class="text-xl mb-4">
                    <?php echo __(
                        'Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction. Please attempt your purchase again.', 
                        'woocommerce'
                    ); ?>
                </p>
                <p class="flex items-center gap-4">
                    <a 
                        href="<?php echo esc_url($order->get_checkout_payment_url()); ?>" 
                        class="button pay"
                    >
                        <?php esc_html_e('Pay', 'woocommerce'); ?>
                    </a>
                    @if (is_user_logged_in())
                        <a 
                            href="<?php echo esc_url(wc_get_page_permalink('myaccount')); ?>" 
                            class="button-outline pay"
                        >
                            <?php esc_html_e('My account', 'woocommerce'); ?>
                        </a>
                    @endif
                </p>
            </div>
        @else
            <div class="bg-carousel-pink text-heavy-metal p-14 text-center mb-10">
                <h2 class="text-xl lg:text-3xl mb-4">
                    <?php echo sprintf(__('Order %s', 'supper'), "#{$order->get_order_number()}") ?>
                </h2>

                <p class="text-xl mb-4">
                    <?php echo __('Thank you. Your order has been received.', 'woocommerce'); ?>
                </p>

                <ul>
                    <li>
                        <?php esc_html_e('Order number:', 'woocommerce'); ?>
                        <strong>
                            {{ $order->get_order_number() }}
                        </strong>
                    </li>

                    <li>
                        <?php esc_html_e('Date:', 'woocommerce'); ?>
                        <strong>
                            {{ wc_format_datetime($order->get_date_created()) }}
                        </strong>
                    </li>

                    @if (
                        is_user_logged_in() 
                        && $order->get_user_id() === get_current_user_id() 
                        && $order->get_billing_email()
                    )
                        <li>
                            <?php esc_html_e('Email:', 'woocommerce'); ?>
                            <strong>
                                {{ $order->get_billing_email() }}
                            </strong>
                        </li>
                    @endif

                    <li>
                        <?php esc_html_e('Total:', 'woocommerce'); ?>
                        <strong>
                            {!! $order->get_formatted_order_total() !!}
                        </strong>
                    </li>
                </ul>
                <div class="mt-4">
                    @php 
                        do_action('woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id()); 
                    @endphp
                </div>
            </div>
            <div 
                class="
                    grid 
                    grid-cols-1 
                    lg:grid-cols-2 
                    gap-10 p-10 
                    border-2 
                    border-neutral-200 
                    rounded 
                    mb-10
                "
            >
                @php 
                    do_action('woocommerce_thankyou', $order->get_id()); 
                @endphp
            </div>
        @endif
    @else
        <p lass="text-xl mb-4">
            <?php echo __('Thank you. Your order has been received.', 'woocommerce'); ?>
        </p>
    @endif
</div>
