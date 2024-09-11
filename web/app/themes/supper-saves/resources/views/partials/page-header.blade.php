<div class="relative">
    <figure class="bg-gray-400 aspect-[14/5] relative">
        @if (has_post_thumbnail())
            <img 
                src="{{ the_post_thumbnail_url() }}" 
                width="1400"
                height="500"
                lazy="loading"
                alt="" 
                class="absolute w-full h-full object-cover" 
            />
        @endif 
    </figure>
    <div
        class="lg:absolute bottom-0 w-full max-w-5xl mx-auto pt-10 px-8 lg:pt-20 lg:px-20 pb-10 left-0 right-0 bg-white"
    >
        <h1 data-title-reveal class="text-3xl lg:text-5xl lg:max-w-[75%]">{!! App::title() !!}</h1>
    </div> 
</div>
