<div class="max-w-7xl mx-auto pb-10 px-8 md:px-20">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-10 md:gap-32">
        <div class="flex flex-col justify-center h-full">
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
            @if (get_sub_field('button'))
                <a
                    href="{{ get_sub_field('button')['url'] }}"
                    class="button mr-auto"
                    target="{{ get_sub_field('button')['target'] }}"
                    @if (get_sub_field('button')['target'] === '_blank')
                        rel="noopener noreferrer nofollow"
                    @endif
                >
                    {{ get_sub_field('button')['title'] }}
                </a>
            @endif
        </div>
        <ul data-list-fade-in>
            @foreach (get_sub_field('items') as $usp)
                <li class="flex items-center uppercase font-title text-xxs py-4">
                    <icon
                        icon="check"
                        class="text-secondary mr-5 text-xl"
                    ></icon>
                    <span class="block">
                        {{ $usp['content'] }}
                    </span>
                </li>
            @endforeach
        </ul>
    </div>
</div>
