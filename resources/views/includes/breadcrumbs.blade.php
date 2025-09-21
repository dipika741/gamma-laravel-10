@props([
    'category' => null,
    'subcategory' => null,
    'subsubcategory' => null,
    'product' => null,
    'pageTitle' => null,
])

<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
        {{-- Home --}}
        <li class="breadcrumb-item">
            <a href="{{ url('/') }}">Home</a>
        </li>

        {{-- Category --}}
        @if($category)
            <li class="breadcrumb-item">
                <a href="{{ route('products.category', $category->slug) }}">
                    {{ $category->name }}
                </a>
            </li>
        @endif

        {{-- Subcategory --}}
        @if($subcategory)
            <li class="breadcrumb-item">
                <a href="{{ route('products.subcategory', [$category->slug, $subcategory->slug]) }}">
                    {{ $subcategory->name }}
                </a>
            </li>
        @endif

        {{-- Sub-subcategory --}}
        @if($subsubcategory)
            <li class="breadcrumb-item">
                <a href="{{ route('products.subsubcategory', [
                    $category->slug,
                    $subcategory->slug,
                    $subsubcategory->slug
                ]) }}">
                    {{ $subsubcategory->name }}
                </a>
            </li>
        @endif

        {{-- Product (detail page) --}}
        @if($product)
            <li class="breadcrumb-item active" aria-current="page">
                {{ $product->name }}
            </li>
        @elseif($pageTitle)
            <li class="breadcrumb-item active" aria-current="page">
                {{ $pageTitle }}
            </li>
        @endif
    </ol>
</nav>
