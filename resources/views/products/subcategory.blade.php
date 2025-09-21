@extends('app')

@section('title', $subcategory->name)

@section('content')

@include('includes.breadcrumbs', [
    'category' => $subcategory->category ?? null,
    'subcategory' => $subcategory ?? null,
    'pageTitle' => $subcategory->name
])

<section class="section-box mt-50 mb-50">
    <div class="container">
        <div class="row">
            {{-- Sidebar --}}
            <div class="col-lg-3">
                <h5 class="mb-20">Subcategories</h5>
                <ul class="list-unstyled">
                    @foreach($subcategory->subSubCategories as $subsub)
                        <li>
                            <a href="{{ route('products.subsubcategory', [$subcategory->category->slug, $subcategory->slug, $subsub->slug]) }}">
                                {{ $subsub->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
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
                                    {{-- ✅ category + subcategory --}}
                                    <a href="{{ route('products.show', [
                                        'category'    => $subcategory->category->slug,
                                        'subcategory' => $subcategory->slug,
                                        'product'     => $product->slug
                                    ]) }}" class="btn btn-primary btn-sm">View</a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p>No products available in this subcategory.</p>
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
