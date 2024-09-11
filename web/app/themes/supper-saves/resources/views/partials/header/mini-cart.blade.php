<button
    class="relative"
    @click="toggleMiniCart"
>
    <icon icon="cart"></icon>
    @if (WC()->cart->get_cart_contents_count() > 0)
        <span
            class="header-cart-count absolute block -right-1 top-1 rounded-full w-2.5 h-2.5 bg-secondary"
        ></span>
    @endif
</button>
<dropdown-mini-cart>
    <div class="flex flex-col h-full" v-cloak>
        <header>
            <p class="font-title text-3xl uppercase mb-11">
                <?php echo __('Cart', 'woocommerce'); ?>
            </p>
        </header>
        <div class="grow overflow-auto">
            <div v-show="notification" class="woocommerce-notices-wrapper">
                <div class="woocommerce-message" role="alert">
                    @{{ notification }}
                </div>
            </div>
            <div class="widget_shopping_cart_content"></div>
        </div>
        <footer class="flex items-center -mx-[50px] -mb-[50px] px-[50px] py-8 border-t-2 border-neutral-200">
            <button 
                @click="toggleMiniCart"
                class="inline-flex text-base lg:text-xl items-center"
            >
                <icon icon="chevron-left" class="mr-3 text-secondary text-sm mt-0.5"></icon> <?php echo __('Continue shopping', 'supper');?>
            </button>
            @if (is_user_logged_in() && !is_customer())
                <a href="{{ wc_get_page_permalink('cart') }}" class="button button-secondary ml-auto">
                    <?php echo __('Proceed to cart', 'supper'); ?>
                </a>
            @endif
        </footer>
    </div>
</dropdown-mini-cart>
