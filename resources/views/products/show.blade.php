@extends('app')

@section('title', $product->seo_title ?? $product->name)
<?php //dd($product); ?>
@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-5">

            @php
                $thumbnail = $product->images->where('is_thumbnail', 1)->first() 
                            ?? $product->images->first();
            @endphp

            {{-- Main Image --}}
            @if($thumbnail)
                <img id="mainImage" 
                     src="{{ asset('storage/'.$thumbnail->image_path) }}" 
                     class="img-fluid rounded border mb-3 w-100" 
                     style="max-height:400px; object-fit:contain;">
            @endif

            {{-- Other Images Thumbnails --}}
            @if($product->images && $product->images->count() > 1)
                <div class="d-flex flex-wrap gap-2" id="thumbnails">
                    @foreach($product->images as $image)
                        <img src="{{ asset('storage/'.$image->image_path) }}" 
                             class="img-thumbnail thumb-img {{ $image->is_thumbnail ? 'border border-3 border-success' : '' }}" 
                             style="width:100px; height:100px; object-fit:cover; cursor:pointer;">
                    @endforeach
                </div>
            @endif

        </div>

        <div class="col-md-7">
            <h1>{{ $product->name }}</h1>

            @if($product->price)
                <p class="h4 text-success">₹ {{ number_format($product->price, 2) }}</p>
            @endif

            {{-- Short Description before Enquiry --}}
            <p>{!! $product->title !!}</p>

            {{-- Enquiry Button --}}
            <a href="{{ url('contact') }}" class="btn btn-primary btn-lg mt-5">Enquire Now</a>
        </div>
    </div>

    <div class="mt-5">
        <h3>Description</h3>
        <div>{!! $product->description !!}</div>
    </div>
</div>

{{-- JS CDN + Script --}}
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    $(document).ready(function(){
        $('#thumbnails').on('click', '.thumb-img', function(){
            let newSrc = $(this).attr('src');

            // fade effect for main image
            $('#mainImage').fadeOut(200, function(){
                $(this).attr('src', newSrc).fadeIn(200);
            });

            // remove active border from all
            $('.thumb-img').removeClass('border border-3 border-success');

            // add active border to clicked one
            $(this).addClass('border border-3 border-success');
        });
    });
</script>
@endsection
