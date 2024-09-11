<!doctype html>
<html {!! get_language_attributes() !!}>
@include('partials.head')
<body @php body_class() @endphp>
    @php do_action('get_header') @endphp
    <div id="app">
        @include('partials.header')
        <main class="main">
            @yield('content')
        </main>
        @if (App\display_sidebar())
            <aside class="sidebar">
                @include('partials.sidebar') 
            </aside>
        @endif
        @include('partials.footer')
    </div>
    @include('partials.scripts')
    @php do_action('get_footer') @endphp
    @php wp_footer() @endphp
</body>
</html>
