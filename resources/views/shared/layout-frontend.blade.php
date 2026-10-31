@php
    // Tip: move these into a View Composer / AppServiceProvider later.
    $navCategories = \Illuminate\Support\Facades\DB::table('categorytbl')->where('status', 'Active')->get();

    // Site settings (settingtbl)
    $settings = \Illuminate\Support\Facades\DB::table('settingtbl')->where('status', 'Active')->get();
    $logo     = $settings->firstWhere('type', 'Logo');
    $sitePhone = optional($settings->where('type', 'Contact')->firstWhere('title', 'Phone'))->description ?? '+0123 456 789';
    $cart          = session('cart', []);
    $cartCount     = collect($cart)->sum('qty');
    $cartTotal     = collect($cart)->sum(fn ($item) => $item['price'] * $item['qty']);
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Clothing Shop')</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/images/icons/favicon-32x32.png') }}">
    <link rel="shortcut icon" href="{{ asset('assets/images/icons/favicon.ico') }}">

    <!-- Plugins CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/line-awesome/line-awesome/line-awesome/css/line-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/owl-carousel/owl.carousel.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/magnific-popup/magnific-popup.css') }}">
    <!-- Main CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/skins/skin-demo-4.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/demos/demo-4.css') }}">
    @stack('styles')

    <style>
    /* ---------- Product cards ---------- */
    .product .product-media {
        aspect-ratio: 3 / 4;
        overflow: hidden;
    }
    .product .product-media img,
    .product .product-media .product-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: top center;
    }
    .product .product-title {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* ---------- Slider ---------- */
    .intro-slide {
        position: relative;
        background-size: cover;
        background-position: center;
    }

    /* dark overlay so text is readable on any photo */
    .intro-slide::before {
        content: "";
        position: absolute;
        inset: 0;
        background: linear-gradient(90deg, rgba(0,0,0,.55) 0%, rgba(0,0,0,.25) 60%, rgba(0,0,0,0) 100%);
        z-index: 1;
    }

    /* let the text block use the full row */
    .intro-slide .container {
        position: relative;
        z-index: 2;
        max-width: 100%;
        padding-left: 5rem;
        padding-right: 5rem;
    }
    .intro-slide .intro-content,
    .intro-slide .intro-content[class*="col-"] {
        position: relative;
        z-index: 2;
        max-width: 100%;
        flex: 0 0 100%;
        width: 100%;
        margin: 0;
        padding: 0;
        text-align: left;
    }

    /* white text, size scales with the screen */
    .intro-slide .intro-subtitle,
    .intro-slide .intro-title {
        color: #fff !important;
        text-shadow: 0 2px 8px rgba(0,0,0,.5);
        white-space: nowrap;
    }
    .intro-slide .intro-title {
        font-size: clamp(2.4rem, 5vw, 5rem);
        line-height: 1.1;
    }
    .intro-slide .intro-subtitle {
        font-size: clamp(1.6rem, 2vw, 2.2rem);
    }

    /* small screens: less side padding, allow wrapping */
    @media (max-width: 575px) {
        .intro-slide .container {
            padding-left: 2rem;
            padding-right: 2rem;
        }
        .intro-slide .intro-title,
        .intro-slide .intro-subtitle {
            white-space: normal;
        }
    }
    /* put the slide text on the left */
.intro-slide {
    display: flex;
    align-items: center;          /* vertically centered */
    justify-content: flex-start;  /* pushes content to the left */
}
.intro-slide .container {
    margin: 0;                    /* stop the container centering itself */
    display: flex;
    justify-content: flex-start;
    padding-left: 8rem;           /* distance from the left edge; adjust to taste */
}
.intro-slide .intro-content,
.intro-slide .intro-content[class*="col-"] {
    flex: 0 1 auto;
    width: auto;
    max-width: 700px;             /* keeps the text from stretching across the photo */
    margin: 0;
    margin-right: auto;           /* anchors the block to the left */
    text-align: left;
}
</style>
</head>

<body>
<div class="page-wrapper">
    <header class="header header-intro-clearance header-4">
        <div class="header-top">
            <div class="container">
                <div class="header-left">
                    <a href="tel:{{ $sitePhone }}"><i class="icon-phone"></i>Call: {{ $sitePhone }}</a>
                </div>
            </div>
        </div>

        <div class="header-middle">
            <div class="container">
                <div class="header-left">
                    <button class="mobile-menu-toggler">
                        <span class="sr-only">Toggle mobile menu</span>
                        <i class="icon-bars"></i>
                    </button>

                    <a href="{{ route('home') }}" class="logo">
                        <img src="{{ $logo->img1 ?? asset('assets/images/demos/demo-4/logo.png') }}" alt="Logo" width="105" height="25">
                    </a>
                </div>

                <div class="header-center">
                    <div class="header-search header-search-extended header-search-visible d-none d-lg-block">
                        <a href="#" class="search-toggle" role="button"><i class="icon-search"></i></a>
                        <form action="{{ route('product.index') }}" method="get">
                            <div class="header-search-wrapper search-wrapper-wide">
                                <label for="q" class="sr-only">Search</label>
                                <button class="btn btn-primary" type="submit"><i class="icon-search"></i></button>
                                <input type="search" class="form-control" name="q" id="q" value="{{ request('q') }}" placeholder="Search product ..." required>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="header-right">
                    <div class="dropdown cart-dropdown">
                        <a href="#" class="dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">
                            <div class="icon">
                                <i class="icon-shopping-cart"></i>
                                <span class="cart-count">{{ $cartCount }}</span>
                            </div>
                            <p>Cart</p>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right">
                            <div class="dropdown-cart-products">
                                @forelse ($cart as $id => $item)
                                    <div class="product">
                                        <div class="product-cart-details">
                                            <h4 class="product-title">
                                                <a href="{{ route('product.show', $id) }}">{{ $item['name'] }}</a>
                                            </h4>
                                            <span class="cart-product-info">
                                                <span class="cart-product-qty">{{ $item['qty'] }}</span>
                                                x ${{ number_format($item['price'], 2) }}
                                            </span>
                                        </div>
                                        <figure class="product-image-container">
                                            <a href="{{ route('product.show', $id) }}" class="product-image">
                                                <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}">
                                            </a>
                                        </figure>
                                    </div>
                                @empty
                                    <p class="text-center my-3">Your cart is empty</p>
                                @endforelse
                            </div>

                            <div class="dropdown-cart-total">
                                <span>Total</span>
                                <span class="cart-total-price">${{ number_format($cartTotal, 2) }}</span>
                            </div>

                            <div class="dropdown-cart-action">
                                <a href="{{ route('cart.index') }}" class="btn btn-primary">View Cart</a>
                                @if ($cartCount > 0)
                                    <a href="{{ route('checkout.index') }}" class="btn btn-outline-primary-2"><span>Checkout</span><i class="icon-long-arrow-right"></i></a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="header-bottom sticky-header">
            <div class="container">
                <div class="header-left">
                    <div class="dropdown category-dropdown">
                        <a href="#" class="dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static" title="Browse Categories">
                            Browse Categories <i class="icon-angle-down"></i>
                        </a>
                        <div class="dropdown-menu">
                            <nav class="side-nav">
                                <ul class="menu-vertical sf-arrows">
                                    @foreach ($navCategories as $navCat)
                                        <li><a href="{{ route('category.show', $navCat->cateid) }}">{{ $navCat->catetitle }}</a></li>
                                    @endforeach
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>

                <div class="header-center">
                    <nav class="main-nav">
                        <ul class="menu sf-arrows">
                            <li class="{{ request()->routeIs('home') ? 'active' : '' }}"><a href="{{ route('home') }}">Home</a></li>
                            <li class="{{ request()->routeIs('category.*') ? 'active' : '' }}"><a href="{{ route('category.index') }}">Category</a></li>
                            <li class="{{ request()->routeIs('product.*') ? 'active' : '' }}"><a href="{{ route('product.index') }}">Product</a></li>
                            <li class="{{ request()->routeIs('about') ? 'active' : '' }}"><a href="{{ route('about') }}">About Us</a></li>
                            <li class="{{ request()->routeIs('contact') ? 'active' : '' }}"><a href="{{ route('contact') }}">Contact Us</a></li>
                        </ul>
                    </nav>
                </div>

                <div class="header-right">
                    <i class="la la-lightbulb-o"></i><p>Clearance<span class="highlight">&nbsp;Up to 30% Off</span></p>
                </div>
            </div>
        </div>
    </header>

    @if (session('success'))
        <div class="alert alert-success text-center mb-0 rounded-0">{{ session('success') }}</div>
    @endif

    <main class="main">
        @yield('content')
    </main>

    <footer class="footer">
    <div class="footer-middle">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-lg-4">
                    <div class="widget widget-about">
                        <img src="{{ $logo->img1 ?? asset('assets/images/demos/demo-4/logo-footer.png') }}" class="footer-logo" alt="Défier" style="height:40px; width:auto;">
                        <p>Défier brings you modern, affordable fashion for men, women and kids. New styles arrive every week.</p>
                        <div class="widget-call">
                            <i class="icon-phone"></i>
                            Got Question? Call us 24/7
                            <a href="tel:{{ $sitePhone }}">{{ $sitePhone }}</a>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-4">
                    <div class="widget">
                        <h4 class="widget-title">Useful Links</h4>
                        <ul class="widget-list">
                            <li><a href="{{ route('home') }}">Home</a></li>
                            <li><a href="{{ route('category.index') }}">Category</a></li>
                            <li><a href="{{ route('product.index') }}">Product</a></li>
                            <li><a href="{{ route('about') }}">About Us</a></li>
                            <li><a href="{{ route('contact') }}">Contact Us</a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-4">
                    <div class="widget">
                        <h4 class="widget-title">Customer Service</h4>
                        <ul class="widget-list">
                            <li><a href="#">Payment Methods</a></li>
                            <li><a href="#">Returns</a></li>
                            <li><a href="#">Shipping</a></li>
                            <li><a href="#">Privacy Policy</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <div class="container">
            <p class="footer-copyright">Copyright © {{ date('Y') }} Défier. All Rights Reserved.</p>
            <figure class="footer-payments">
                <img src="{{ asset('assets/images/payments.png') }}" alt="Payment methods" width="272" height="20">
            </figure>
        </div>
    </div>
</footer>
</div>

<button id="scroll-top" title="Back to Top"><i class="icon-arrow-up"></i></button>

<!-- Mobile Menu -->
<div class="mobile-menu-overlay"></div>
<div class="mobile-menu-container mobile-menu-light">
    <div class="mobile-menu-wrapper">
        <span class="mobile-menu-close"><i class="icon-close"></i></span>

        <form action="{{ route('product.index') }}" method="get" class="mobile-search">
            <label for="mobile-search" class="sr-only">Search</label>
            <input type="search" class="form-control" name="q" id="mobile-search" placeholder="Search in..." required>
            <button class="btn btn-primary" type="submit"><i class="icon-search"></i></button>
        </form>

        <nav class="mobile-nav">
            <ul class="mobile-menu">
                <li class="{{ request()->routeIs('home') ? 'active' : '' }}"><a href="{{ route('home') }}">Home</a></li>
                <li><a href="{{ route('category.index') }}">Category</a></li>
                <li><a href="{{ route('product.index') }}">Product</a></li>
                <li><a href="{{ route('about') }}">About Us</a></li>
                <li><a href="{{ route('contact') }}">Contact Us</a></li>
            </ul>
        </nav>

        <div class="social-icons">
            <a href="#" class="social-icon" target="_blank" title="Facebook"><i class="icon-facebook-f"></i></a>
            <a href="#" class="social-icon" target="_blank" title="Twitter"><i class="icon-twitter"></i></a>
            <a href="#" class="social-icon" target="_blank" title="Instagram"><i class="icon-instagram"></i></a>
        </div>
    </div>
</div>

<!-- Plugins JS -->
<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.hoverIntent.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.waypoints.min.js') }}"></script>
<script src="{{ asset('assets/js/superfish.min.js') }}"></script>
<script src="{{ asset('assets/js/owl.carousel.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap-input-spinner.js') }}"></script>
<script src="{{ asset('assets/js/jquery.plugin.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.magnific-popup.min.js') }}"></script>
<!-- Main JS -->
<script src="{{ asset('assets/js/main.js') }}"></script>
@stack('scripts')
</body>
</html>