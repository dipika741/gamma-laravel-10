@extends('app')

@section('title', $subSubCategory->name ?? $subcategory->name ?? $category->name)

@section('content')
<div class="container py-4">
    <div class="row">

       {{-- Sidebar --}}
<div class="col-lg-3 mb-4">
    {{-- Categories --}}
    <div class="list-group shadow-sm">
        <h5 class="list-group-item active">Categories</h5>
        @foreach(\App\Models\Category::withCount('products')->get() as $cat)
            <a href="{{ route('products.listing', $cat->slug) }}" 
               class="list-group-item d-flex justify-content-between align-items-center {{ $category->id === $cat->id ? 'active' : '' }}">
                {{ $cat->name }}
                <span class="badge bg-secondary rounded-pill">{{ $cat->products_count }}</span>
            </a>
        @endforeach
    </div>

    {{-- Subcategories --}}
    @if($category->subcategories->count())
        <div class="list-group shadow-sm mt-4">
            <h6 class="list-group-item bg-light">Subcategories</h6>
            <a href="{{ route('products.listing', $category->slug) }}" 
               class="list-group-item {{ !$subcategory ? 'active' : '' }}">
                All ({{ $category->products()->count() }})
            </a>
            @foreach($category->subcategories()->withCount('products')->get() as $sub)
                <a href="{{ route('products.subcategory', [$category->slug, $sub->slug]) }}" 
                   class="list-group-item d-flex justify-content-between align-items-center {{ $subcategory && $subcategory->id === $sub->id ? 'active' : '' }}">
                    {{ $sub->name }}
                    <span class="badge bg-secondary rounded-pill">{{ $sub->products_count }}</span>
                </a>
            @endforeach
        </div>
    @endif

    {{-- Sub-Subcategories --}}
    @if($subcategory && $subcategory->subSubCategories->count())
        <div class="list-group shadow-sm mt-4">
            <h6 class="list-group-item bg-light">Sub-Subcategories</h6>
            <a href="{{ route('products.subcategory', [$category->slug, $subcategory->slug]) }}" 
               class="list-group-item {{ !$subSubCategory ? 'active' : '' }}">
                All ({{ $subcategory->products()->count() }})
            </a>
            @foreach($subcategory->subSubCategories()->withCount('products')->get() as $subsub)
                <a href="{{ route('products.subsubcategory', [$category->slug, $subcategory->slug, $subsub->slug]) }}" 
                   class="list-group-item d-flex justify-content-between align-items-center {{ $subSubCategory && $subSubCategory->id === $subsub->id ? 'active' : '' }}">
                    {{ $subsub->name }}
                    <span class="badge bg-secondary rounded-pill">{{ $subsub->products_count }}</span>
                </a>
            @endforeach
        </div>
    @endif
</div>


        {{-- Products --}}
        <div class="col-lg-9">
            {{-- Breadcrumb --}}
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('products.listing', $category->slug) }}">{{ $category->name }}</a></li>
                    @if($subcategory)
                        <li class="breadcrumb-item"><a href="{{ route('products.listing', [$category->slug, $subcategory->slug]) }}">{{ $subcategory->name }}</a></li>
                    @endif
                    @if($subSubCategory)
                        <li class="breadcrumb-item active">{{ $subSubCategory->name }}</li>
                    @endif
                </ol>
            </nav>

            <h1 class="mb-4">
                {{ $subSubCategory->name ?? $subcategory->name ?? $category->name }}
            </h1>

            @if($products->count())
                <div class="row">
                    @foreach($products as $product)
                        <div class="col-md-4 mb-4">
                            <div class="card h-100 shadow-sm">
                                @if($product->image)
                                    <img src="{{ asset('storage/products/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                                @endif
                                <div class="card-body">
                                    <h5 class="card-title">{{ $product->name }}</h5>
                                    <p class="card-text text-muted">{{ Str::limit($product->short_description, 80) }}</p>
                                    <!-- <a href="{{ route('products.showallslug', ['categorySlug' => $category->slug,'slug1' => $subcategory->slug ?? 'product','slug2' => $subSubCategory->slug ?? 'item','productSlug' => $product->slug]) }}" class="btn btn-primary btn-sm">show all slug</a> -->
                                    <a href="{{ route('product.showcategoryslugonly', [$product->category->slug, $product->slug]) }}" class="btn btn-primary">View </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="d-flex justify-content-center">
                    {{ $products->links() }}
                </div>
            @else
                <p>No products found in this section.</p>
            @endif
        </div>
    </div>
</div>
@endsection
