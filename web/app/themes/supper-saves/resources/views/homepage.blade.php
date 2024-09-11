{{--
  Template Name: Homepage
--}}

@extends('layouts.app')

@section('content')
    @while(have_posts())
        @php the_post() @endphp
        <div class="container mx-auto">
            {{-- Hero Slider --}}
            <ui-slider-hero>
                @foreach ($hero as $slide)
                    <swiper-slide>
                        <div class="relative aspect-[2/1] bg-gray-300 px-4 md:px-16 flex flex-col justify-center">
                            <img
                                src="{{ $slide->image->url }}"
                                width="1400"
                                height="700"
                                loading="lazy"
                                alt=""
                                class="absolute left-0 top-0 object-cover w-full h-full"
                            >
                            <div
                                class="
                                    relative
                                    aspect-[3/2]
                                    w-full
                                    xl:w-1/2
                                    lg:w-2/3
                                    bg-primary
                                    bg-opacity-90
                                    text-white
                                    p-14
                                    flex
                                    flex-col
                                    justify-center
                                "
                            >
                                <h2 data-title-reveal class="text-2xl lg:text-[44px] leading-tight mb-4">
                                    {{ $slide->title }}
                                </h2>
                                <p class="text-2xl mb-8">
                                    {{ $slide->content }}
                                </p>
                                <div class="flex flex-col lg:flex-row gap-4">
                                    @if ($slide->button_primary)
                                        <a
                                            href="{{ $slide->button_primary->url }}"
                                            class="button button-cta button-big"
                                            target="{{ $slide->button_primary->target }}"
                                            @if ($slide->button_primary->target === '_blank')
                                                rel="noopener noreferrer nofollow"
                                            @endif
                                        >
                                            {{ $slide->button_primary->title }}
                                        </a>
                                    @endif

                                    @if ($slide->button_secondary)
                                        <a
                                            href="{{ $slide->button_secondary->url }}"
                                            class="button-outline button-big button-outline-white"
                                            target="{{ $slide->button_secondary->target }}"
                                            @if ($slide->button_secondary->target === '_blank')
                                                rel="noopener noreferrer nofollow"
                                            @endif
                                        >
                                            {{ $slide->button_secondary->title }}
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </swiper-slide>
                @endforeach
            </ui-slider-hero>

            {{-- Quotes content --}}
            <div class="max-w-7xl mx-auto px-8 md:px-20 py-20 md:pt-[150px]">
                <div class="relative text-center z-10">
                    <h2 class="text-xl md:text-2xl lg:text-3xl mb-6">
                        <span data-title-reveal class="text-secondary block">
                            {{ $quotes->title_first_row }}
                        </span>
                        <span data-title-reveal>
                            {{ $quotes->title_second_row }}
                        </span>
                    </h2>
                </div>
                <div class="flex w-full relative">
                    <img
                        src="@asset('images/quotes.svg')"
                        width="203"
                        height="145"
                        loading="lazy"
                        alt=""
                        class="absolute -mt-20 left-0 z-0"
                    >
                    <div class="relative text-center mx-auto w-full md:max-w-4xl">
                        <ui-slider-thumbnail>
                            <template v-slot:main>
                                @foreach ($quotes->items as $quote)
                                    <swiper-slide class="relative mb-3 z-10">
                                        <p class="text-2xl mb-8">
                                            {{ $quote->quote }}
                                        </p>
                                        <p class="font-title uppercase text-xs text-secondary mb-2">
                                            {{ $quote->author_function }}
                                        </p>
                                        <p class="font-title uppercase text-xxs">
                                            {{ $quote->author }}
                                        </p>
                                    </swiper-slide>
                                @endforeach
                            </template>
                        </ui-slider-thumbnail>
                    </div>
                </div>
            </div>

            {{-- Intro content --}}
            <div class="max-w-7xl mx-auto pb-10 px-8 md:px-20 py-20 md:pb-[150px] md:pt-[100px]">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-10 md:gap-32">
                    <div class="flex flex-col justify-center h-full">
                        <h2 class="text-xl md:text-2xl lg:text-3xl mb-6">
                            <span data-title-reveal class="text-secondary block">
                                {{ $story->title_first_row }}
                            </span>
                            <span data-title-reveal>
                                {{ $story->title_second_row }}
                            </span>
                        </h2>
                        <p class="text-xl mb-12">
                            {{ $story->content }}
                        </p>
                        @if ($story->button)
                            <a
                                href="{{ $story->button->url }}"
                                class="button mr-auto"
                                target="{{ $story->button->target }}"
                                @if ($story->button->target === '_blank')
                                    rel="noopener noreferrer nofollow"
                                @endif
                            >
                                {{ $story->button->title }}
                            </a>
                        @endif
                    </div>
                    <ul data-list-fade-in>
                        @foreach ($story->ups as $usp)
                            <li class="flex items-center uppercase font-title text-xxs py-4">
                                <icon
                                    icon="check"
                                    class="text-secondary mr-5 text-xl"
                                ></icon>
                                <span class="block">
                                    {{ $usp->content }}
                                </span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        {{-- Video Block --}}
        @if ($show_video && $video || false)
            <div class="aspect-video">
                <iframe
                    src="{{ $video }}"
                    frameborder="0"
                    class="w-full h-full"
                    allow="autoplay muted"
                ></iframe>
            </div>
        @endif

        {{-- Why content --}}
        <div class="relative pb-[85px]">
            <figure class="lg:absolute left-0 top-0 object-cover aspect-[3/2] lg:aspect-[3/4] w-full lg:w-1/2 h-full overflow-hidden">
                <img
                    data-floating-block
                    src="{{ $why_block->image->url }}"
                    width="{{ $why_block->image->width }}"
                    height="{{ $why_block->image->height }}"
                    loading="lazy"
                    alt=""
                    class="w-full h-[140%] object-cover -translate-y-40 lg:scale-125"
                >
            </figure>
            <div class="bg-primary text-white">
                <div class="container mx-auto flex py-20 lg:py-[150px]">
                    <div class="lg:w-1/2 xl:px-32 px-8 ml-auto">
                        <h2 class="text-xl md:text-2xl lg:text-3xl mb-6">
                            <span data-title-reveal class="text-secondary block">
                                {{ $why_block->title_first_row }}
                            </span>
                            <span data-title-reveal>
                                {{ $why_block->title_second_row }}
                            </span>
                        </h2>
                        <p class="text-xl mb-12">
                            {{ $why_block->content }}
                        </p>
                        @if ($why_block->button)
                            <a
                                href="{{ $why_block->button->url }}"
                                class="button button-white mr-auto"
                                target="{{ $why_block->button->target }}"
                                @if ($why_block->button->target === '_blank')
                                    rel="noopener noreferrer nofollow"
                                @endif
                            >
                                {{ $why_block->button->title }}
                            </a>
                        @endif
                        @if ($why_block->button_secondary)
                            <a
                                href="{{ $why_block->button_secondary->url }}"
                                class="button-outline button-outline-white mt-3"
                                target="{{ $why_block->button_secondary->target }}"
                                @if ($why_block->button_secondary->target === '_blank')
                                    rel="noopener noreferrer nofollow"
                                @endif
                            >
                                {{ $why_block->button_secondary->title }}
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        {{-- Plate content --}}
        <div class="relative -top-[100px] lg:top-auto">
            <figure
                data-floating-block
                class="
                    relative
                    overflow-x-hidden
                    lg:overflow-visible
                    lg:absolute
                    ml-auto
                    lg:right-0
                    mx-auto
                    lg:-top-[100px]
                    lg:max-w-[50%]
                    lg:-bottom-[40px]
                    lg:h-[calc(100%+170px)]
                    -translate-y-20
                    z-10
                "
            >
                <img
                    src="{{ $plate_block->image->url }}"
                    width="{{ $plate_block->image->width }}"
                    height="{{ $plate_block->image->height }}"
                    loading="lazy"
                    alt=""
                    class="
                        relative
                        left-1/2
                        lg:left-auto
                        h-full
                        w-full
                        object-cover
                        object-left
                    "
                >
            </figure>
            <div class="container mx-auto flex pb-20 pt-4 lg:py-[150px]">
                <div class="lg:w-1/2 px-8 xl:px-32">
                    <h2 class="text-xl md:text-2xl lg:text-3xl mb-6">
                        <span data-title-reveal class="text-secondary block">
                            {{ $plate_block->title_first_row }}
                        </span>
                        <span data-title-reveal>
                            {{ $plate_block->title_second_row }}
                        </span>
                    </h2>
                    <p class="text-xl mb-12">
                        {{ $plate_block->content }}
                    </p>
                    @if ($plate_block->button)
                        <a
                            href="{{ $plate_block->button->url }}"
                            class="button button-cta mr-auto"
                            target="{{ $plate_block->button->target }}"
                            @if ($plate_block->button->target === '_blank')
                                rel="noopener noreferrer nofollow"
                            @endif
                        >
                            {{ $plate_block->button->title }}
                        </a>
                    @endif
                </div>
            </div>
        </div>

        {{-- Signature_block content --}}
        <div class="relative container mx-auto md:flex items-start z-40 mb-20 text-heavy-metal">
            <img
                src="{{ $signature_block->image->url }}"
                width="{{ $signature_block->image->width }}"
                height="{{ $signature_block->image->height }}"
                loading="lazy"
                alt=""
                class="object-cover aspect-[3/2] md:aspect-[5/6] md:max-w-[30%]"
            >
            <div class="relative z-10 p-14 md:py-24 md:pl-24 md:pr-32 bg-carousel-pink">
                <h2 data-title-reveal class="text-xl md:text-2xl lg:text-3xl mb-6">{{ $signature_block->title }}</h2>
                <p class="text-xl mb-12">
                    {{ $signature_block->content }}
                </p>
                @if ($signature_block->button)
                    <a
                        href="{{ $signature_block->button->url }}"
                        class="button-outline button-outline-heavy-metal mr-auto"
                        target="{{ $signature_block->button->target }}"
                        @if ($signature_block->button->target === '_blank')
                            rel="noopener noreferrer nofollow"
                        @endif
                    >
                        {{ $signature_block->button->title }}
                    </a>
                @endif
            </div>
        </div>

        {{-- Logos content --}}
        @if ($logos ?? false)
            <div class="max-w-7xl mx-auto px-8 md:px-20 py-20 md:py-[100px]">
                <swiper
                    autoplay
                    :breakpoints="{
                        0: {
                            slidesPerView: 1,
                        },
                        768: {
                            slidesPerView: 3,
                        },
                        1024: {
                            slidesPerView: 4,
                        }
                    }"
                    class="main"
                >
                    <template v-slot:main>
                        @foreach ($logos as $logo)
                            <swiper-slide class="relative mb-3 flex justify-center z-10 max-h-32 !h-auto">
                                <img
                                    src="{{ $logo->url }}"
                                    width="{{ $logo->width }}"
                                    height="{{ $logo->height }}"
                                    loading="lazy"
                                    alt="{{ $logo->alt }}"
                                    class="object-contain max-w-[160px]"
                                >
                            </swiper-slide>
                        @endforeach
                    </template>
                </swiper>
            </div>
        @endif
    @endwhile
@endsection
