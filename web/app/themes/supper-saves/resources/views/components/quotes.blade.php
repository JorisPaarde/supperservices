<div class="max-w-7xl mx-auto px-8 md:px-20 py-20 md:pb-[130px]">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-10 md:gap-32">
        <div>
            <h2 class="text-xl md:text-2xl lg:text-3xl mb-6">
                <span  data-title-reveal class="text-secondary block">
                    {{ get_sub_field('title_first_row') }}
                </span>
                <span data-title-reveal>
                    {{ get_sub_field('title_second_row') }}
                </span>
            </h2>
            <p class="text-2xl">
                {{ get_sub_field('content') }}
            </p>
        </div>
        <div class="relative">
            <img
                src="@asset('images/quotes.svg')"
                width="203"
                height="145"
                loading="lazy"
                alt=""
                class="absolute -mt-[70px] left-0 z-0"
            >
            <ui-slider-thumbnail>
                <template v-slot:main>
                    @foreach (get_sub_field('items') as $quote)
                        <swiper-slide class="relative mb-3 z-10">
                            <p class="text-2xl mb-8">
                                {{ $quote['quote'] }}
                            </p>
                            <p class="font-title uppercase text-xxs text-secondary mb-3">
                                {{ $quote['author_function'] }}
                            </p>
                            <p class="font-title uppercase text-xxs">
                                {{ $quote['author'] }}
                            </p>
                        </swiper-slide>
                    @endforeach
                </template>
                <template v-slot:thumbs>
                    @foreach (get_sub_field('items') as $item)
                        <swiper-slide
                            class="relative mb-3 z-10"
                        >
                            <img
                                src="{{ $item['logo']['url'] }}"
                                width="{{ $item['logo']['width'] }}"
                                height="{{ $item['logo']['height'] }}"
                                loading="lazy"
                                alt=""
                            >
                        </swiper-slide>
                    @endforeach
                </template>
            </ui-slider-thumbnail>
        </div>
    </div>
</div>
