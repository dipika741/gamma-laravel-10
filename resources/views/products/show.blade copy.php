@extends('app')

@section('title', $product->seo_title ?? $product->name)

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-5">
<?php //echo $product->images[0]->image_path;
//dd($product->images[0]->image_path); ?>
            @if($product)
            <img src="{{ asset('storage/'.$product->images[0]->image_path) }}" class="img-thumbnail {{ $product->images[0]->is_thumbnail ? 'border border-3 border-success' : '' }}" style="height:100px; object-fit:cover;">
            @endif

            <!-- @foreach($product->images as $image)
                    <div class="position-relative" style="width:120px;">
                        <img src="{{ asset('storage/'.$image->image_path) }}" class="img-thumbnail {{ $image->is_thumbnail ? 'border border-3 border-success' : '' }}" style="height:100px; object-fit:cover;">
                    </div>
                @endforeach -->

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
