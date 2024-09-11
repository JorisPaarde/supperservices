{{-- The Template for displaying product archives, including the main shop page which is a post type archive

This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.

HOWEVER, on occasion WooCommerce will need to update template files and you
(the theme developer) will need to copy the new files to your theme to
maintain compatibility. We try to do this as little as possible, but it does
happen. When this occurs the version of the template file will be bumped and
the readme will list any important changes.

@see https://docs.woocommerce.com/document/template-structure/
@package WooCommerce/Templates
@version 3.4.0
--}}

@extends('layouts.app')

@section('content')
    <div class="container mx-auto">
        @php
            do_action('get_header', 'shop');
        @endphp

        @php
            do_action('woocommerce_before_main_content');
            do_action('woocommerce_before_shop_loop');
        @endphp

        <div class="p-6 bg-carousel-pink mb-10">
            @php dynamic_sidebar('product-filters') @endphp
        </div>

        <div class="entry pt-6 pb-10 md:pb-20 lg:pb-40">
            @php
                $my_categories = get_terms([
                    'orderby' => 'name',
			        'order' => 'ASC',
                    'taxonomy' => 'product_cat'
                ]);
                $my_categories_count = count($my_categories);
            @endphp

            @if ($my_categories_count > 0 && is_array($my_categories))
                @php $index = 0; @endphp
                @php woocommerce_product_loop_start(); @endphp

                @foreach ($my_categories as $single_cat)
                    <div class="pb-20">
                        @php
                            $cat_posts_args = array(
                                'post_type' => 'product',
                                'order' => 'ASC',
                                'orderby' => 'date',
                                'post_status' => 'publish',
                                'posts_per_page' => -1,
                                'tax_query' => array(
                                    array(
                                        'taxonomy' => 'product_cat',
                                        'field' => 'id',
                                        'terms' => $single_cat->term_id,
                                        'include_children' => false
                                    )
                                )
                            );
                            $cat_posts = new WP_Query( $cat_posts_args );
                        @endphp

                        @if (!$cat_posts->have_posts()) @php continue; @endphp @endif

                        <h2 class="text-3xl text-center mb-10 border-b border-slate-200 pb-10">{{ $single_cat->name }}</h2>

                        <div
                            class="
                                gap-y-6
                                grid
                                lg:gap-y-10
                                lg:mb-6
                                mb-4
                                grid-cols-2
                                md:grid-cols-3
                                xl:grid-cols-4
                            "
                        >
                            @if ($cat_posts->have_posts())
                                @while ($cat_posts->have_posts())
                                    @php
                                        $cat_posts->the_post();
                                        $product = wc_get_product(get_the_ID());
                                    @endphp
                                    @include('partials.product', ['product' => $product])
                                    @php $index++; @endphp
                                @endwhile
                            @else
                                <p>@php do_action('woocommerce_no_products_found'); @endphp</p>
                            @endif
                        </div>

                        @php wp_reset_postdata(); @endphp
                    </div>
                @endforeach
                @php
                    woocommerce_product_loop_end();
                    do_action('woocommerce_after_shop_loop');
                @endphp
            @else
                @php do_action('woocommerce_no_products_found'); @endphp
            @endif
        </div>

        @php
            do_action('get_sidebar', 'shop');
            do_action('get_footer', 'shop');
        @endphp
    </div>
@endsection
