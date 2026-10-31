@extends('shared.layout-frontend')

@section('title', 'Home')

@section('content')
{{-- Intro slider --}}
<div class="intro-slider-container mb-5">
    <div class="intro-slider owl-carousel owl-theme owl-nav-inside owl-light" data-toggle="owl"
         data-owl-options='{"dots": true, "nav": false, "responsive": {"1200": {"nav": true, "dots": false}}}'>
        @foreach ($slides as $slide)
            <div class="intro-slide" @style(["background-image: url('" . $slide->img1 . "')"])>
                <div class="container intro-content">
                    <div class="row justify-content-end">
                        <div class="col-auto col-sm-7 col-md-6 col-lg-5">
                            <h3 class="intro-subtitle text-primary">{{ $slide->description }}</h3>
                            <h1 class="intro-title">{{ $slide->title }}</h1>
                            <a href="{{ route('product.index') }}" class="btn btn-primary btn-round">
                                <span>Shop More</span><i class="icon-long-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <span class="slider-loader"></span>
</div>

{{-- Popular categories --}}
<div class="container">
    <h2 class="title text-center mb-4">Explore Popular Categories</h2>
    <div class="cat-blocks-container">
        <div class="row">
            @foreach ($categories->take(6) as $category)
                <div class="col-6 col-sm-4 col-lg-2">
                    <a href="{{ route('category.show', $category->cateid) }}" class="cat-block">
                        <figure>
                            <span>
                                <img src="{{ asset($category->img ?? 'storage/test1.jpg') }}" alt="{{ $category->catetitle }}" style="width:100%; height:100px; object-fit:cover;">                                                 </span>
                        </figure>
                        <h3 class="cat-block-title">{{ $category->catetitle }}</h3>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</div>

<div class="mb-4"></div>

{{-- Promo banners --}}

<div class="mb-3"></div>

{{-- New arrivals --}}
<div class="container new-arrivals">
    <div class="heading heading-flex mb-3">
        <div class="heading-left"><h2 class="title">New Arrivals</h2></div>
        <div class="heading-right">
            <a href="{{ route('product.index') }}" class="title-link">View All <i class="icon-long-arrow-right"></i></a>
        </div>
    </div>

    <div class="tab-content tab-content-carousel just-action-icons-sm">
        <div class="owl-carousel owl-full carousel-equal-height carousel-with-shadow" data-toggle="owl"
             data-owl-options='{"nav": true, "dots": true, "margin": 20, "loop": false,
                "responsive": {"0": {"items":2}, "480": {"items":2}, "768": {"items":3}, "992": {"items":4}, "1200": {"items":5}}}'>
            @foreach ($newProducts as $product)
                @include('shared.product-card', ['product' => $product])
            @endforeach
        </div>
    </div>
</div>

<div class="mb-5"></div>

{{-- Recommendation grid --}}
<div class="container for-you">
    <div class="heading heading-flex mb-3">
        <div class="heading-left"><h2 class="title">Recommendation For You</h2></div>
        <div class="heading-right">
            <a href="{{ route('product.index') }}" class="title-link">View All <i class="icon-long-arrow-right"></i></a>
        </div>
    </div>

    <div class="products">
        <div class="row justify-content-center">
            @foreach ($recommended as $product)
                <div class="col-6 col-md-4 col-lg-3">
                    @include('shared.product-card', ['product' => $product])
                </div>
            @endforeach
        </div>
    </div>
</div>

<div class="mb-4"></div>
<div class="container"><hr class="mb-0"></div>

{{-- Icon boxes --}}
<div class="icon-boxes-container bg-transparent">
    <div class="container">
        <div class="row">
            @foreach ([
                ['icon-rocket', 'Free Shipping', 'Orders $50 or more'],
                ['icon-rotate-left', 'Free Returns', 'Within 30 days'],
                ['icon-info-circle', 'Get 20% Off 1 Item', 'when you sign up'],
                ['icon-life-ring', 'We Support', '24/7 amazing services'],
            ] as [$icon, $title, $text])
                <div class="col-sm-6 col-lg-3">
                    <div class="icon-box icon-box-side">
                        <span class="icon-box-icon text-dark"><i class="{{ $icon }}"></i></span>
                        <div class="icon-box-content">
                            <h3 class="icon-box-title">{{ $title }}</h3>
                            <p>{{ $text }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection