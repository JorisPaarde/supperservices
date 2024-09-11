<div class="relative">
    <figure class="bg-gray-400 aspect-[16/8] relative">
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
    <div
        class="md:absolute bottom-0 w-full max-w-5xl mx-auto pt-10 px-8 md:pt-20 md:px-20 pb-10 left-0 right-0 bg-white"
    >    <a 
            href="{{ wc_get_account_endpoint_url('sop') }}" 
            class="button button-secondary bg-white mb-8"
        >
            <icon icon="chevron-left" class="mr-3"/></icon>
            <?php echo __('Back to overview'); ?>
        </a>
        <h1 data-title-reveal class="text-3xl md:text-5xl md:max-w-[75%]">{!! App::title() !!}</h1>
    </div> 
</div>
