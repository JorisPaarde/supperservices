

@php 
    $paged = (get_query_var('page')) ? get_query_var('page') : 1;
    $args = [
        'paged' => $paged, 
        'post_type' => 'sops',
        'order' => 'asc'
    ];
    $wp_query = new WP_Query($args);
@endphp
@if (!$wp_query->have_posts())
    <div class="alert alert-warning">
    {{ __('Sorry, no SOP\'s were found.', 'sage') }}
    </div>
@endif

@while ($wp_query->have_posts()) @php $wp_query->the_post() @endphp
    @include('partials.sop-list-item')
@endwhile 
