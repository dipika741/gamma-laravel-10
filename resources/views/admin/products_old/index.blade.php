{{-- resources/views/admin/products/index.blade.php --}}
@extends('admin.layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between mb-3">
        <h2>Products</h2>
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary">+ Add Product</a>
    </div>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Thumbnail</th>
                <th>Name</th>
                <th>Category</th>
                <th>Price</th>
                <th>Discount %</th>
                <th>Discounted Price</th>
                <th>Rating</th>
                <th width="180">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $product)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>
                    @if($product->images->count() > 0)
                        <img src="{{ asset('storage/'.$product->images->first()->image_path) }}" width="50" class="rounded">
                    @else
                        <span class="text-muted">No Image</span>
                    @endif
                </td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->category->name ?? '-' }}</td>
                <td>${{ $product->original_price }}</td>
                <td>{{ $product->discount_percentage }}%</td>
                <td>${{ $product->discounted_price }}</td>
                <td>{{ $product->rating }}</td>
                <td>
                    <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" style="display:inline-block;">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this product?')">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="9" class="text-center text-muted">No products found</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
