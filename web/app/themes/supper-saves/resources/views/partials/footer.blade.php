<footer class="footer">
    <div class="container mx-auto">
        <div class="flex flex-col items-center">
            <img 
                src="@asset('/images/mark.svg')" 
                width="58"
                height="48"
                loading="lazy"
                class="mb-4"
                alt=""
            >
            <h2 class="text-center text-xl mb-20">
                <?php echo __('Hungry for more?'); ?>
            </h2>
        </div>
        <div class="grid grid-cols-1 lg:grid-cols-4 md:grid-cols-2 gap-10 md:gap-24">
            @php dynamic_sidebar('sidebar-footer') @endphp
            <div class="magazine widget">
                <h2><?php echo __('Supper magazine', 'supper');?></h2>
                @if (get_fields('options')['footer']['magazine'] ?? false)
                    <a href="{{ get_fields('options')['footer']['magazine'] }}">
                        <img 
                            src="@asset('/images/magazine.png')" 
                            width="232"
                            height="114"
                            loading="lazy"
                            class="mb-4"
                            alt=""
                        >
                    </a>
                @endif
            </div>
            <div class="social widget">
                <div class="h-full flex flex-col">
                    <h2><?php echo __('What we\'re up to?', 'supper');?></h2>
                    @if (get_fields('options')['footer']['newsletter'] ?? false)
                        <a 
                            href="{{ get_fields('options')['footer']['newsletter'] }}" 
                            class="button-outline button-outline-white !text-[9px] mr-auto w-auto"
                        >
                            <?php echo __('Subscribe to newsletter', 'supper'); ?>
                        </a>
                    @endif
                    <nav class="mt-auto flex items-center gap-4 pt-10">
                        @if (get_fields('options')['footer']['instagram'] ?? false)
                            <a 
                                href="{{ get_fields('options')['footer']['instagram'] }}" 
                                class="social-icon"
                                target="_blank"
                                rel="noopener nofollow noreferrer"
                            >
                                <icon icon="instagram"></icon>
                            </a>
                        @endif
                        @if (get_fields('options')['footer']['twitter'] ?? false)
                            <a 
                                href="{{ get_fields('options')['footer']['twitter'] }}" 
                                class="social-icon"
                                target="_blank"
                                rel="noopener nofollow noreferrer"
                            >
                                <icon icon="twitter"></icon>
                            </a>
                        @endif
                        @if (get_fields('options')['footer']['facebook'] ?? false)
                            <a 
                                href="{{ get_fields('options')['footer']['facebook'] }}" 
                                class="social-icon"
                                target="_blank"
                                rel="noopener nofollow noreferrer"
                            >
                                <icon icon="facebook"></icon>
                            </a>
                        @endif
                        @if (get_fields('options')['footer']['linkedin'] ?? false)
                            <a 
                                href="{{ get_fields('options')['footer']['linkedin'] }}" 
                                class="social-icon"
                                target="_blank"
                                rel="noopener nofollow noreferrer"
                            >
                                <icon icon="linkedin"></icon>
                            </a>
                        @endif
                        @if (get_fields('options')['footer']['youtube'] ?? false)
                            <a 
                                href="{{ get_fields('options')['footer']['youtube'] }}" 
                                class="social-icon"
                                target="_blank"
                                rel="noopener nofollow noreferrer"
                            >
                                <icon icon="youtube"></icon>
                            </a>
                        @endif
                    </nav>
                </div>
            </div>
        </div>
    </div>
</footer>
