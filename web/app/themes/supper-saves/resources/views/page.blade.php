@extends('layouts.app')

@section('content')
    @while(have_posts()) @php the_post() @endphp
        <div class="container mx-auto">
            @include('partials.page-header')
            @include('partials.content-page')
        </div> 
        @if (have_rows('content'))
            @while (have_rows('content')) @php the_row() @endphp
                <div class="pb-10 md:pb-[100px]">
                    @include('components.'. get_row_layout())
                </div>
            @endwhile
        @endif
    @endwhile
@endsection
