<div class="text-xl">
    <p class="mb-8">
        <?php
            printf(
                __( 'Hello %1$s', 'woocommerce' ),
                '<strong>' . esc_html( $current_user->display_name ) . '</strong>',
            );
        ?>
    </p>
    <div class="grid grid-cols-2 gap-10">
        <div
            class="
                col-span-2
                md:col-span-1
                bg-carousel-pink
                border-2
                border-transparent
                p-6
                @if (!allUserFieldsFilled('group_620a67b2e3ae4'))
                    border-cinnabar
                @endif
                rounded
            "
        >
            <p class="font-title text-sm uppercase mb-5">
                <?php echo __('Company address') ?>
            </p>
            @if (allUserFieldsFilled('group_620a67b2e3ae4') ?? false)
                <p>{{ get_user_meta($current_user->ID, 'billing_company')[0] }}</p>
                <p>{{ get_user_meta($current_user->ID, 'billing_address_1')[0] }} {{ get_user_meta($current_user->ID, 'billing_address_2')[0] }}</p>
                <p>{{ get_user_meta($current_user->ID, 'billing_postcode')[0] }} {{ get_user_meta($current_user->ID, 'billing_city')[0] }}</p>
                <p>{{ get_user_meta($current_user->ID, 'billing_country')[0] }}</p>
            @else
                <div class="flex gap-4">
                    <span
                        class="
                            flex-shrink-0
                            flex
                            items-center
                            justify-center
                            w-10
                            h-10
                            font-bold
                            rounded-full
                            bg-cinnabar
                            text-white
                        "
                    >
                        !
                    </span>
                    <p class="text-cinnabar"><?php echo __('Not all fileds are filled, please add the missing information');?> </p>
                </div>
            @endif
            <a
                href="{{ wc_get_account_endpoint_url('company-info') }}"
                class="button-outline mt-8"
            >
                <?php echo __('Edit address'); ?>
            </a>
        </div>
        <div
            class="
                col-span-2
                md:col-span-1
                bg-carousel-pink
                border-2
                border-transparent
                p-6
                @if (!allUserFieldsFilled('group_620a653be68c3'))
                    border-cinnabar
                @endif
                rounded
            "
        >
            <p class="font-title text-sm mb-5 uppercase">
                <?php echo __('Shipping address') ?>
            </p>
            @if (allUserFieldsFilled('group_620a653be68c3') ?? false)
                <p>{{ get_user_meta($current_user->ID, 'shipping_company')[0] }}</p>
                <p>{{ get_user_meta($current_user->ID, 'shipping_address_1')[0] }} {{ get_user_meta($current_user->ID, 'shipping_address_2')[0] }}</p>
                <p>{{ get_user_meta($current_user->ID, 'shipping_postcode')[0] }} {{ get_user_meta($current_user->ID, 'shipping_city')[0] }}</p>
                <p>{{ get_user_meta($current_user->ID, 'shipping_country')[0] }}</p>
            @else
                <div class="flex gap-4">
                    <span
                        class="
                            flex-shrink-0
                            flex
                            items-center
                            justify-center
                            w-10
                            h-10
                            font-bold
                            rounded-full
                            bg-cinnabar
                            text-white
                        "
                    >
                        !
                    </span>
                    <p class="text-cinnabar"><?php echo __('Not all fileds are filled, please add the missing information');?> </p>
                </div>
            @endif
            <a
                href="{{ wc_get_account_endpoint_url('shipping-info') }}"
                class="button-outline mt-8"
            >
                <?php echo __('Edit address'); ?>
            </a>
        </div>
    </div>
    @php
        do_action('woocommerce_account_dashboard');
    @endphp
</div>
