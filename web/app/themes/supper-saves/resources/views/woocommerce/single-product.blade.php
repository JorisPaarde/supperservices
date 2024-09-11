@extends('layouts.app')

@section('content')
    @while (have_posts())
        @php the_post(); @endphp
        <div class="container mx-auto">
            @php wc_get_template_part('content', 'single-product'); @endphp
        </div>
    @endwhile
@endsection
