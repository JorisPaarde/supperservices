<div class="relative">
    <figure class="lg:absolute left-0 top-0 object-cover aspect-[3/2] w-full lg:w-1/2 h-full overflow-hidden">
        <img
            data-floating-block
            src="{{ get_sub_field('image')['url'] }}"
            width="{{ get_sub_field('image')['width'] }}"
            height="{{ get_sub_field('image')['height'] }}"
            loading="lazy"
            alt=""
            class="w-full h-[140%] object-cover -translate-y-40 lg:scale-125"
        >
    </figure>
    <div class="bg-primary text-white">
        <div class="container mx-auto flex py-20 lg:py-[150px]">
            <div class="lg:w-1/2 lg:px-32 px-16 ml-auto">
                <h2 class="text-xl md:text-2xl lg:text-3xl mb-6">
                    <span data-title-reveal class="text-secondary block">
                        {{ get_sub_field('title_first_row') }}
                    </span>
                    <span data-title-reveal>
                        {{ get_sub_field('title_second_row') }}
                    </span>
                </h2>
                <p class="text-xl mb-12">
                    {{ get_sub_field('content') }}
                </p>
                <div class="flex gap-4 flex-wrap">
                    @if (get_sub_field('button') ?? false)
                        <a
                            href="{{ get_sub_field('button')['url'] }}"
                            class="button button-white mr-auto"
                            target="{{ get_sub_field('button')['target'] }}"
                            @if (get_sub_field('button')['target'] === '_blank')
                                rel="noopener noreferrer nofollow"
                            @endif
                        >
                            {{ get_sub_field('button')['title'] }}
                        </a>
                    @endif
                    @if (get_sub_field('button_secondary') ?? false)
                        <a
                            href="{{ get_sub_field('button_secondary')['url'] }}"
                            class="button-outline button-outline-white mt-3"
                            target="{{ get_sub_field('button_secondary')['target'] }}"
                            @if (get_sub_field('button_secondary')['target'] === '_blank')
                                rel="noopener noreferrer nofollow"
                            @endif
                        >
                            {{ get_sub_field('button_secondary')['title'] }}
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
