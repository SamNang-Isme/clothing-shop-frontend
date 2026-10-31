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
        <div class="row">
            <div class="col-md-4 mb-4">
                <h3>Contact Information</h3>
                <p>{!! nl2br(e($page->content)) !!}</p>
                @if ($phone)
                    <p><i class="icon-phone"></i> {{ $phone }}</p>
                @endif
                @if ($email)
                    <p><i class="icon-envelope"></i> {{ $email }}</p>
                @endif
            </div>

            <div class="col-md-8">
                <h3>Got Any Questions?</h3>
                <form action="#" method="post" class="contact-form mb-2">
                    @csrf
                    <div class="row">
                        <div class="col-sm-6">
                            <label for="cname" class="sr-only">Name</label>
                            <input type="text" class="form-control" id="cname" name="name" placeholder="Name *" required>
                        </div>
                        <div class="col-sm-6">
                            <label for="cemail" class="sr-only">Email</label>
                            <input type="email" class="form-control" id="cemail" name="email" placeholder="Email *" required>
                        </div>
                    </div>

                    <label for="cmessage" class="sr-only">Message</label>
                    <textarea class="form-control" cols="30" rows="4" id="cmessage" name="message" required placeholder="Message *"></textarea>

                    <button type="submit" class="btn btn-outline-primary-2 btn-minwidth-sm">
                        <span>SUBMIT</span><i class="icon-long-arrow-right"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection