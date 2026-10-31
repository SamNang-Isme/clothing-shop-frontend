@extends('shared.layout-frontend')

@section('title', $category->catetitle)

@section('content')
<div class="page-header text-center" @style(["background-image: url('" . asset('assets/images/page-header-bg.jpg') . "')"])>
    <div class="container">
        <h1 class="page-title">{{ $category->catetitle }}<span>Category</span></h1>
    </div>
</div>

<nav aria-label="breadcrumb" class="breadcrumb-nav mb-3">
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('category.index') }}">Categories</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $category->catetitle }}</li>
        </ol>
    </div>
</nav>

<div class="page-content">
    <div class="container">
        <div class="products">
            <div class="row">
                @forelse ($products as $product)
                    <div class="col-6 col-md-4 col-lg-4 col-xl-3">
                        @include('shared.product-card', ['product' => $product])
                    </div>
                @empty
                    <p class="text-center w-100">No products in this category yet.</p>
                @endforelse
            </div>

            <div class="d-flex justify-content-center">
                {{ $products->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
</div>
@endsection