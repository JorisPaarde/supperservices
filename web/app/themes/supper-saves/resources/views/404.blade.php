@extends('layouts.app')

@section('content')
    <div class="bg-secondary text-white">
        <div class="container mx-auto">
            <div class="entry-content max-w-8xl mx-auto px-8 md:px-20 py-32">
                <h1 class="text-3xl md:text-5xl mb-8 text-center">{!! App::title() !!}</h1>
                @if (!have_posts())
                    <p class="text-center alert alert-warning">
                        {{ __('Sorry, but the page you were trying to view does not exist.', 'sage') }}
                    </p>
                @endif
            </div>
        </div>
    </div>
@endsection
