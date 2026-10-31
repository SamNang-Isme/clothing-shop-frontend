@extends('shared.layout-frontend')

@section('title', 'Checkout')

@section('content')
<div class="page-header text-center" @style(["background-image: url('" . asset('assets/images/page-header-bg.jpg') . "')"])>
    <div class="container">
        <h1 class="page-title">Checkout<span>Shop</span></h1>
    </div>
</div>

<nav aria-label="breadcrumb" class="breadcrumb-nav">
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('cart.index') }}">Shopping Cart</a></li>
            <li class="breadcrumb-item active" aria-current="page">Checkout</li>
        </ol>
    </div>
</nav>

<div class="page-content">
    <div class="checkout">
        <div class="container">
            <form action="{{ route('checkout.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-lg-9">
                        <h2 class="checkout-title">Billing Details</h2>

                        <label>Full name *</label>
                        <input type="text" name="customer_name" class="form-control @error('customer_name') is-invalid @enderror" value="{{ old('customer_name') }}" required>
                        @error('customer_name') <div class="text-danger small mb-2">{{ $message }}</div> @enderror

                        <div class="row">
                            <div class="col-sm-6">
                                <label>Phone *</label>
                                <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}" required>
                                @error('phone') <div class="text-danger small mb-2">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-sm-6">
                                <label>Email (optional)</label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
                                @error('email') <div class="text-danger small mb-2">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <label>Delivery address *</label>
                        <textarea name="address" rows="3" class="form-control @error('address') is-invalid @enderror" required>{{ old('address') }}</textarea>
                        @error('address') <div class="text-danger small mb-2">{{ $message }}</div> @enderror

                        <label>Order notes (optional)</label>
                        <textarea name="note" rows="3" class="form-control" placeholder="Notes about your order, e.g. size or delivery time">{{ old('note') }}</textarea>
                    </div>

                    <aside class="col-lg-3">
                        <div class="summary">
                            <h3 class="summary-title">Your Order</h3>
                            <table class="table table-summary">
                                <thead>
                                    <tr><th>Product</th><th>Total</th></tr>
                                </thead>
                                <tbody>
                                    @foreach ($lines as $l)
                                        <tr>
                                            <td>{{ $l['proname'] }} &times; {{ $l['qty'] }}</td>
                                            <td>${{ number_format($l['subtotal'], 2) }}</td>
                                        </tr>
                                    @endforeach
                                    <tr class="summary-total">
                                        <td>Total:</td>
                                        <td>${{ number_format($total, 2) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <p class="small text-muted">Payment: cash on delivery.</p>
                            <button type="submit" class="btn btn-outline-primary-2 btn-order btn-block">
                                <span class="btn-text">Place Order</span>
                            </button>
                        </div>
                    </aside>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
