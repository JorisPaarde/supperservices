<div class="relative container mx-auto md:flex items-start z-40 text-heavy-metal">
    <img
        src="{{ get_sub_field('image')['url'] }}"
        width="{{ get_sub_field('image')['width'] }}"
        height="{{ get_sub_field('image')['height'] }}"
        loading="lazy"
        alt=""
        class="object-cover aspect-[3/2] md:aspect-[5/6] md:max-w-[30%]"
    >
    <div class="p-14 md:py-24 md:pl-24 md:pr-32 bg-carousel-pink">
        <h2 data-title-reveal class="text-xl md:text-2xl lg:text-3xl mb-6">{{ get_sub_field('title') }}</h2>
        <p class="text-xl mb-12">
            {{ get_sub_field('content') }}
        </p>
        @if (get_sub_field('button'))
            <a
                href="{{ get_sub_field('button')['url'] }}"
                class="button-outline button-outline-heavy-metal mr-auto"
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
