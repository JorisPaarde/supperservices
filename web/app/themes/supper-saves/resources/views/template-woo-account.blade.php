@php
// Template Name: Woocommerce Account
@endphp

@extends('layouts.app')

@section('content')
    @while (have_posts()) @php the_post() @endphp
        <div class="container mx-auto">
            <div class="max-w-8xl mx-auto pt-10 pb-10 px-8 md:px-20 md:pb-20">
                <div class="grid grid-cols-7 gap-4 md:gap-12 lg:gap-24">
                    @if (is_user_logged_in() ?? false)
                        <aside
                            class="
                                col-span-7
                                lg:col-span-2
                                @if (!allUserFieldsFilled('group_620a653be68c3') || !allUserFieldsFilled('group_620a67b2e3ae4'))}
                                    opacity-30
                                @endif
                            "
                        >
                            @php
                                do_action( 'woocommerce_account_navigation');
                                acf_form_head();
                            @endphp
                        </aside>
                    @endif
                    <div class="woocommerce-MyAccount-content col-span-7  @if (is_user_logged_in() ?? false) lg:col-span-5 @endif ">
                        <h1 class="text-2xl md:text-3xl mb-8">{!! App::title() !!}</h1>
                        @php the_content() @endphp
                        {!! wp_link_pages(['echo' => 0, 'before' => '<nav class="page-nav"><p>' . __('Pages:', 'sage'), 'after' => '</p></nav>']) !!}
                    </div>
                </div>
            </div>
        </div>
    @endwhile
@endsection
