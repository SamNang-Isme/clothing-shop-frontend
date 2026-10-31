{{-- Usage: @include('shared.product-card', ['product' => $product]) --}}
{{-- $product comes from producttbl joined with categorytbl (needs proid, cateid, catetitle, proname, price, img1) --}}
<div class="product product-2">
    <figure class="product-media">
        <a href="{{ route('product.show', $product->proid) }}">
            {{-- img1 already holds the full image URL --}}
<img src="{{ $product->img1 }}" alt="{{ $product->proname }}" style="width:100%; aspect-ratio:3/4; object-fit:cover; object-position:top center;">        </a>

        <div class="product-action">
            <form action="{{ route('cart.add', $product->proid) }}" method="POST">
                @csrf
                <button type="submit" class="btn-product btn-cart" title="Add to cart"><span>add to cart</span></button>
            </form>
        </div>
    </figure>

    <div class="product-body">
        @if (!empty($product->catetitle))
            <div class="product-cat">
                <a href="{{ route('category.show', $product->cateid) }}">{{ $product->catetitle }}</a>
            </div>
        @endif
        <h3 class="product-title"><a href="{{ route('product.show', $product->proid) }}">{{ $product->proname }}</a></h3>
        <div class="product-price">${{ number_format($product->price, 2) }}</div>
    </div>
</div>