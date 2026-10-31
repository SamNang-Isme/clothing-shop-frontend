@extends('shared.layout-frontend')

@section('title', $page->title)

@section('content')
<div class="page-header text-center" @style(["background-image: url('" . asset('assets/images/page-header-bg.jpg') . "')"])>
    <div class="container">
        <h1 class="page-title">{{ $page->title }}<span>{{ $page->description }}</span></h1>
    </div>
</div>

<nav aria-label="breadcrumb" class="breadcrumb-nav">
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $page->title }}</li>
        </ol>
    </div>
</nav>

<div class="page-content pb-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="mx-auto" style="max-width:800px; line-height:1.8; text-align:left;">
                @foreach (preg_split('/\R{2,}/', trim($page->content)) as $block)
                    @if (in_array(trim($block), ['Our Story', 'What We Offer', 'Why Customers Choose Us']))
                        <h3 class="mt-4 mb-2">{{ trim($block) }}</h3>
                    @else
                        <p>{!! nl2br(e($block)) !!}</p>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection