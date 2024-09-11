{{--
Title: Highlight
Description: Highlight block with image and text content
Category: common
Icon: format-image
Keywords: highlight title text image block
--}}

<div class="flex flex-col lg:flex-row 2xl:-ml-[336px] 2xl:-mr-[336px] mb-5 lg:mb-10 py-5 lg:py-16">
    @if (get_fields()['highlight_image'] ?? false)
        <figure class="relative h-[200px] lg:h-auto lg:w-[386px] lg:basis-[386px] lg:shrink-0 overflow-hidden">
            <img 
                src="{{ get_fields()['highlight_image']['sizes']['medium_large'] }}"
                class="absolute w-full h-full object-cover"
                loading="lazy"
            >
        </figure>
    @endif

    <div class="2xl:pb-20">
        <div class="h-full p-5 lg:p-10 xl:p-24 bg-carousel-pink">
            @if (get_fields()['highlight_title'] ?? false)
                <h2 class="lg:text-3xl mb-5 lg:mb-10">
                    {{ get_fields()['highlight_title'] }}
                </h2>
            @endif

            @if (get_fields()['highlight_text'] ?? false)
                <p class="!mb-5 lg:!mb-10">{{ get_fields()['highlight_text'] }}</p>
            @endif

            @if (get_fields()['highlight_button'] ?? false)
                <a
                    href="{{ get_fields()['highlight_button']['url'] }}"
                    class="button-outline"
                    target="{{ get_fields()['highlight_button']['target'] }}"
                    @if (get_fields()['highlight_button']['target'] === '_blank')
                        rel="noopener nofollow noreferrer"
                    @endif
                >
                    {{ get_fields()['highlight_button']['title'] }}
                </a>
            @endif
        </div>
    </div>
</div>
