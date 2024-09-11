<div class="entry-content max-w-5xl mx-auto pb-10 px-8 md:px-20 md:pb-20">
    <div class="flex items-center gap-4 pb-8">
        <figure class="w-10 h-10 rounded-full overflow-hidden">
            @php echo get_avatar(get_the_author_meta('ID'), 40); @endphp
        </figure>
        <p class="font-bold !text-base">
            {{ get_the_author_meta('display_name') }}
        </p>
    </div>
    @php echo App::filterScriptTags(do_shortcode(get_the_content())) @endphp
</div>
