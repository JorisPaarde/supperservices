@php
// Template Name: Woocommerce
@endphp

@extends('layouts.app')

@section('content')
    @while (have_posts()) @php the_post() @endphp
        <div class="container mx-auto">
            @include('partials.page-header-woocommerce')
            @include('partials.content-woocommerce')
        </div>
    @endwhile
@endsection
