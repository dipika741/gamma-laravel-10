@extends('app')

@section('title', $category->name)

@section('content')

@include('includes.breadcrumbs', [
    'category' => $category ?? null,
    'pageTitle' => $category->name
])

<section class="section-box mt-50 mb-50">
    <div class="container">
        <div class="row">
            {{-- Sidebar --}}
            <div class="col-lg-3">
                <div class="box-sidebar">
                    <h5 class="mb-20">Product Categories</h5>
                    <ul class="list-unstyled">
                        @foreach($category->subcategories as $sub)
                            <li>
                                <a href="{{ route('products.subcategory', [$category->slug, $sub->slug]) }}">
                                    {{ $sub->name }}
                                    <span class="badge bg-light text-dark">
                                        {{ $sub->products()->count() }}
                                    </span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            {{-- Product listing --}}
            <div class="col-lg-9">
                <div class="row">
                    @forelse($products as $product)
                        <div class="col-md-4 mb-4">
                            <div class="card h-100 shadow-sm">
                                <img src="{{ asset('images/products/'.$product->slug.'.jpg') }}" class="card-img-top" alt="{{ $product->name }}">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $product->name }}</h5>
                                    <p class="card-text">{{ Str::limit($product->description, 80) }}</p>
                                    {{-- ✅ category only --}}
                                    <a href="{{ route('products.show', [
                                        'category' => $category->slug,
                                        'product'  => $product->slug
                                    ]) }}" class="btn btn-primary btn-sm">View</a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p>No products available in this category.</p>
                    @endforelse
                </div>

                <div class="mt-4">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
