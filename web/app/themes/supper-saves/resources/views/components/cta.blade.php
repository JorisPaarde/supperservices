<div class="relative">
    <img
        data-floating-block
        src="{{ get_sub_field('image')['url'] }}"
        width="{{ get_sub_field('image')['width'] }}"
        height="{{ get_sub_field('image')['height'] }}"
        loading="lazy"
        alt=""
        class="
            lg:absolute
            ml-auto
            right-0
            -top-[50px]
            object-cover
            object-left
            max-w-[50%]
            lg:-bottom-[50px]
            lg:h-[calc(100%+100px)]
            lg:-translate-y-20
            lg:-translate-x-5
            z-10
        "
    >
    <div class="max-w-7xl mx-auto flex pb-20 pt-4 lg:py-[150px]">
        <div class="p-20 bg-secondary">
            <div class="lg:w-1/2 pr-20">
                <h2 class="text-xl md:text-2xl lg:text-3xl text-white mb-6">
                    <span  data-title-reveal class="block">
                        {{ get_sub_field('title_first_row') }}
                    </span>
                    <span data-title-reveal>
                        {{ get_sub_field('title_second_row') }}
                    </span>
                </h2>
                <p class="text-xl mb-12 text-white">
                    {{ get_sub_field('content') }}
                </p>
                @if (get_sub_field('button'))
                    <a
                        href="{{ get_sub_field('button')['url'] }}"
                        class="button button-cta mr-auto"
                        target="{{ get_sub_field('button')['target'] }}"
                        @if (get_sub_field('button')['target'] === '_blank')
                            rel="noopener noreferrer nofollow"
                        @endif
                    >
                        {{ get_sub_field('button')['title'] }}
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>
