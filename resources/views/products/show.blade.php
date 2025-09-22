@extends('app')

@section('title', $product->seo_title ?? $product->name)

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-5">
            @if($product->image)
                <img src="{{ asset('storage/products/' . $product->image) }}" class="img-fluid rounded shadow-sm" alt="{{ $product->name }}">
            @endif
        </div>
        <div class="col-md-7">
            <h1>{{ $product->name }}</h1>
            @if($product->price)
                <p class="h4 text-success">₹ {{ number_format($product->price, 2) }}</p>
            @endif
            <p>{!! $product->short_description !!}</p>
            <a href="{{ url('contact') }}" class="btn btn-primary btn-lg">Enquire Now</a>
        </div>
    </div>
    <div class="mt-5">
        <h3>Description</h3>
        <div>{!! $product->description !!}</div>
    </div>
</div>
@endsection
