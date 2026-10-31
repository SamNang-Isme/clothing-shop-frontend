@extends('shared.layout-frontend')

@section('title', 'Shopping Cart')

@section('content')
<div class="page-header text-center" @style(["background-image: url('" . asset('assets/images/page-header-bg.jpg') . "')"])>
    <div class="container">
        <h1 class="page-title">Shopping Cart<span>Shop</span></h1>
    </div>
</div>

<nav aria-label="breadcrumb" class="breadcrumb-nav">
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Shopping Cart</li>
        </ol>
    </div>
</nav>

<div class="page-content">
    <div class="cart">
        <div class="container">
            @if (count($cart) === 0)
                <div class="text-center py-5">
                    <p>Your cart is empty.</p>
                    <a href="{{ route('product.index') }}" class="btn btn-outline-primary-2"><span>CONTINUE SHOPPING</span><i class="icon-long-arrow-right"></i></a>
                </div>
            @else
                <div class="row">
                    <div class="col-lg-9">
                        <table class="table table-cart table-mobile">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cart as $id => $item)
                                    <tr>
                                        <td class="product-col">
                                            <div class="product">
                                                <figure class="product-media">
                                                    <a href="{{ route('product.show', $id) }}">
                                                        <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}">
                                                    </a>
                                                </figure>
                                                <h3 class="product-title">
                                                    <a href="{{ route('product.show', $id) }}">{{ $item['name'] }}</a>
                                                </h3>
                                            </div>
                                        </td>
                                        <td class="price-col">${{ number_format($item['price'], 2) }}</td>
                                        <td class="quantity-col">
                                            <form action="{{ route('cart.update', $id) }}" method="POST" class="d-flex">
                                                @csrf
                                                @method('PATCH')
                                                <input type="number" name="qty" class="form-control" value="{{ $item['qty'] }}" min="1" max="10" style="width: 80px;">
                                                <button type="submit" class="btn btn-link p-0 ml-2" title="Update"><i class="icon-refresh"></i></button>
                                            </form>
                                        </td>
                                        <td class="total-col">${{ number_format($item['price'] * $item['qty'], 2) }}</td>
                                        <td class="remove-col">
                                            <form action="{{ route('cart.remove', $id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-remove" title="Remove"><i class="icon-close"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <aside class="col-lg-3">
                        <div class="summary summary-cart">
                            <h3 class="summary-title">Cart Total</h3>
                            <table class="table table-summary">
                                <tbody>
                                    <tr class="summary-total">
                                        <td>Total:</td>
                                        <td>${{ number_format($total, 2) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <a href="{{ route('checkout.index') }}" class="btn btn-outline-primary-2 btn-order btn-block mb-3">PROCEED TO CHECKOUT</a>
                            <a href="{{ route('product.index') }}" class="btn btn-outline-dark-2 btn-block mb-3"><span>CONTINUE SHOPPING</span><i class="icon-refresh"></i></a>
                        </div>
                    </aside>
                </div>
            @endif
        </div>
    </div>
</div>
<script>
window.addEventListener('load', function () {
    if (!window.jQuery) return;
    var timer;
    jQuery('.table-cart input[name="qty"]').on('change', function () {
        var form = this.form;
        clearTimeout(timer);
        timer = setTimeout(function () { form.submit(); }, 600);
    });
});
</script>
@endsection