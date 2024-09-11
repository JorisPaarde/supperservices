@php do_action('woocommerce_before_account_navigation'); @endphp

<nav class="woocommerce-MyAccount-navigation col-span-2">
    <ul>
        @foreach (wc_get_account_menu_items() as $endpoint => $label)
            <li class="{{ wc_get_account_menu_item_classes($endpoint) }}">
                <a
                    href="{{ wc_get_account_endpoint_url($endpoint) }}"
                    class="block pb-3 mb-3 text-lg transition hover:text-secondary hover:border-secondary border-b-2 border-neutral-200"
                >
                    {{ $label }}
                </a>
            </li>
        @endforeach
    </ul>
</nav>

@php do_action('woocommerce_after_account_navigation'); @endphp
