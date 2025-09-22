@extends('app')

@section('title', $subsubcategory->name)

@section('content')

@include('includes.breadcrumbs', [
    'category' => $subsubcategory->subcategory->category ?? null,
    'subcategory' => $subsubcategory->subcategory ?? null,
    'subsubcategory' => $subsubcategory ?? null,
    'pageTitle' => $subsubcategory->name
])

<section class="section-box mt-50 mb-50">
    <div class="container">
        <div class="row">
            {{-- Product listing --}}
            <div class="col-lg-12">
                <div class="row">
                    @forelse($products as $product)
                        <div class="col-md-4 mb-4">
                            <div class="card h-100 shadow-sm">
                                <img src="{{ asset('images/products/'.$product->slug.'.jpg') }}" class="card-img-top" alt="{{ $product->name }}">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $product->name }}</h5>
                                    <p class="card-text">{{ Str::limit($product->description, 80) }}</p>
                                    {{-- ✅ category + subcategory + subsubcategory --}}
                                    <a href="{{ route('products.show', [
                                        'category'      => $subsubcategory->subcategory->category->slug,
                                        'subcategory'   => $subsubcategory->subcategory->slug,
                                        'subsubcategory'=> $subsubcategory->slug,
                                        'product'       => $product->slug
                                    ]) }}" class="btn btn-primary btn-sm">View</a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p>No products available in this sub-subcategory.</p>
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
