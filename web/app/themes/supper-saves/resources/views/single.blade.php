@extends('layouts.app')

@section('content')
    @while(have_posts()) @php the_post() @endphp
        <div class="container mx-auto">
            @include('partials.page-header')
            @include('partials.content-page')
        </div> 
    @endwhile
@endsection
