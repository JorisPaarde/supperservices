@php $productTabs = App\Controllers\Product::productTabs(); @endphp

<div class="woocommerce-tabs mt-10">
    <ul class="tabs" role="tablist">
        @foreach ($productTabs as $tab) 
            <li 
                class="tabs-item" 
                id="tab-title-{{ $tab->key }}" 
                role="tab" 
                aria-controls="tab-{{ $tab->key }}"
            >
                <a class="tabs-item-link" href="#tab-{{ $tab->key }}">
                    {{ $tab->label }}
                </a>
            </li>
        @endforeach
    </ul>
    @foreach ($productTabs as $tab) 
        <div 
            class="panel" 
            id="tab-{{ $tab->key }}" 
            role="tabpanel" 
            aria-labelledby="tab-title-{{ $tab->key }}"
        >
            @include("woocommerce.single-product.tabs.{$tab->view}", ['tabData' => $tab->data])
        </div>
    @endforeach

    @php do_action('woocommerce_product_after_tabs'); @endphp
</div>
