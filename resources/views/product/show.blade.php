@extends('shared.layout-frontend')

@section('title', $product->proname)

@section('content')
<nav aria-label="breadcrumb" class="breadcrumb-nav border-0 mb-0">
    <div class="container d-flex align-items-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('product.index') }}">Products</a></li>
            @if (!empty($product->catetitle))
                <li class="breadcrumb-item"><a href="{{ route('category.show', $product->cateid) }}">{{ $product->catetitle }}</a></li>
            @endif
            <li class="breadcrumb-item active" aria-current="page">{{ $product->proname }}</li>
        </ol>
    </div>
</nav>

<div class="page-content">
    <div class="container">
        <div class="product-details-top mb-5">
            <div class="row">
                <div class="col-md-6">
                    <img src="{{ $product->img1 }}" alt="{{ $product->proname }}" class="img-fluid">
                </div>

                <div class="col-md-6">
                    <div class="product-details">
                        <h1 class="product-title">{{ $product->proname }}</h1>
                        <div class="product-price">${{ number_format($product->price, 2) }}</div>

                        <div class="product-content">
                            <p>{{ $product->qty > 0 ? 'In stock: ' . $product->qty : 'Out of stock' }}</p>
                        </div>

                        @if ($product->qty > 0)
                            <form action="{{ route('cart.add', $product->proid) }}" method="POST">
                                @csrf
                                <div class="details-filter-row details-row-size">
                                    <label for="qty">Qty:</label>
                                    <div class="product-details-quantity">
                                        <input type="number" id="qty" name="qty" class="form-control" value="1" min="1" max="{{ $product->qty }}" step="1" required>
                                    </div>
                                </div>

                                <div class="product-details-action">
                                    <button type="submit" class="btn-product btn-cart"><span>add to cart</span></button>
                                </div>
                            </form>
                        @endif

                        @if (!empty($product->catetitle))
                            <div class="product-details-footer">
                                <div class="product-cat">
                                    <span>Category:</span>
                                    <a href="{{ route('category.show', $product->cateid) }}">{{ $product->catetitle }}</a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        @if ($related->isNotEmpty())
            <h2 class="title text-center mb-4">You May Also Like</h2>
            <div class="row">
                @foreach ($related as $item)
                    <div class="col-6 col-md-4 col-lg-3">
                        @include('shared.product-card', ['product' => $item])
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection