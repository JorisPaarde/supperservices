<article class="relative flex pb-20">
    <figure class="bg-gray-400 aspect-[16/6] absolute top-0 left-0 w-full">
        @if (has_post_thumbnail())
            <img
                src="{{ the_post_thumbnail_url() }}"
                width="1400"
                height="500"
                lazy="loading"
                alt=""
                class="absolute w-full h-full object-cover object-center"
            />
        @endif
    </figure>
    <div class="relative pt-32 z-10 px-3 md:pl-32 md:pr-8 w-full md:w-auto">
        <div class="bg-carousel-pink w-full text-heavy-metal p-8">
            <h2 class="text-2xl mb-4 max-w-[80%]">
                {!! App::title() !!}
            </h2>
            <div class="flex items-center gap-4 pb-4">
                <figure class="w-8 h-8 rounded-full overflow-hidden">
                    @php echo get_avatar(get_the_author_meta('ID'), 32); @endphp
                </figure>
                <p class="font-bold !text-base">
                    {{ get_the_author_meta('display_name') }}
                </p>
            </div>
            <div class="text-xl">
                {{ the_excerpt() }}
            </div>
            <a
                href="{{ get_permalink() }}"
                class="button-outline button-outline-heavy-metal mt-8"
            >
                <?php echo __('Read article', 'supper'); ?>
            </a>
        </div>
    </div>
</article>

