@extends('shared.layout-frontend')

@section('title', 'Categories')

@section('content')
<div class="page-header text-center" @style(["background-image: url('" . asset('assets/images/page-header-bg.jpg') . "')"])>
    <div class="container">
        <h1 class="page-title">Categories<span>Browse by category</span></h1>
    </div>
</div>

<nav aria-label="breadcrumb" class="breadcrumb-nav mb-3">
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Categories</li>
        </ol>
    </div>
</nav>

<div class="page-content">
    <div class="container">
        <div class="cat-blocks-container">
            <div class="row">
                @forelse ($categories as $category)
                    <div class="col-6 col-sm-4 col-lg-3">
                        <a href="{{ route('category.show', $category->cateid) }}" class="cat-block">
                            <figure>
                                <span>
<img src="{{ asset($category->img ?? 'storage/test1.jpg') }}" alt="{{ $category->catetitle }}" style="width:100%; height:180px; object-fit:cover;">                                </span>
                            </figure>
                            <h3 class="cat-block-title">{{ $category->catetitle }}</h3>
                            <p class="text-center text-muted">{{ $category->products_count }} products</p>
                        </a>
                    </div>
                @empty
                    <p class="text-center w-100">No categories yet.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection