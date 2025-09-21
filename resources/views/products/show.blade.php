@extends('app')

@section('title', $product->name)

@section('content')
@include('includes.breadcrumbs', [
    'category'      => $product->category,
    'subcategory'   => $product->subcategory,
    'subsubcategory'=> $product->subSubCategory,
    'product'       => $product,
    'pageTitle'     => $product->name
])

<section class="section-box mt-50 mb-50">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <img src="{{ asset('images/products/'.$product->slug.'.jpg') }}" alt="{{ $product->name }}" class="img-fluid rounded">
            </div>
            <div class="col-md-6">
                <h2>{{ $product->name }}</h2>
                <p>{{ $product->description }}</p>
                <h4 class="text-success">${{ number_format($product->discounted_price, 2) }}</h4>
                @if($product->discount_percentage > 0)
                    <p><del>${{ number_format($product->original_price, 2) }}</del> ({{ $product->discount_percentage }}% off)</p>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
