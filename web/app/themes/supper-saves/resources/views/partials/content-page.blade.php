<div class="entry-content max-w-5xl mx-auto pb-10 px-8 md:px-20 md:pb-20">
    @php echo App::filterScriptTags(do_shortcode(get_the_content())) @endphp
    {!! wp_link_pages(['echo' => 0, 'before' => '<nav class="page-nav"><p>' . __('Pages:', 'sage'), 'after' => '</p></nav>']) !!}
</div>
