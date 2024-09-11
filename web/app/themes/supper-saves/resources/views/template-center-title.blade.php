@php
// Template Name: Center Title
@endphp

@extends('layouts.app')

@section('content')
    @while (have_posts()) @php the_post() @endphp
        <div class="container mx-auto">
            <div class="relative mb-10 max-w-8xl mx-auto px-8 md:px-20">
                <h1 data-title-reveal class="text-2xl md:text-5xl md:max-w-[50%] text-center">{!! App::title() !!}</h1>
            </div>            
            @include('partials.content-woocommerce')
        </div>
    @endwhile
@endsection
