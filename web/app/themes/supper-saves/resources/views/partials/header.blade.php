<header class="relative container mx-auto flex-col lg:flex-row flex items-center py-6 md:py-10 px-10 md:px-0">
    <div class="md:hidden absolute left-10 text-[25px] top-0 pt-5 flex items-center">
        <menu-button></menu-button>
    </div>

    <a href="{{ home_url('/') }}">
        <img
            src="@asset('/images/supper-logo.svg')"
            width="180"
            height="117"
            loading="lazy"
            class="hidden md:block"
            alt=""
        >
        <img
            src="@asset('/images/mark-green.svg')"
            width="40"
            height="40"
            loading="lazy"
            class="md:hidden"
            alt=""
        >
    </a>

    <div class="lg:ml-auto">
        <div
            class="absolute lg:relative right-10 text-2xl md:text-base md:right-0 top-0 pt-6 lg:pt-0 flex items-center gap-7 justify-end"
        >
            @if (!is_checkout() || is_order_received_page())
                @include('partials.header.account')
                @include('partials.header.mini-cart')
            @endif
        </div>

        @if (!is_checkout() || is_order_received_page())
            <navigation>
                <div class="h-full flex flex-col justify-center items-center">
                    @if (has_nav_menu('primary_navigation'))
                        @php
                            echo wp_nav_menu([
                                'theme_location' => 'primary_navigation',
                                'menu_class' => 'main-navigation',
                            ]);
                        @endphp
                    @endif
                </div>
            </navigation>
        @endif
    </div>
</header>
