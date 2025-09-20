@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h2>Edit Product</h2>

    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row">
            {{-- Category --}}
            <div class="col-md-4 mb-3">
                <label for="category_id" class="form-label">Main Category</label>
                <select name="category_id" id="category_id" class="form-select" required>
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4 mb-3">
                <label for="sub_category_id" class="form-label">Sub Category</label>
                <select name="sub_category_id" id="sub_category_id" class="form-select">
                    <option value="">Select Sub Category</option>
                    @foreach($subcategories as $sub)
                        <option value="{{ $sub->id }}" {{ $product->sub_category_id == $sub->id ? 'selected' : '' }}>
                            {{ $sub->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4 mb-3">
                <label for="sub_sub_category_id" class="form-label">Sub-Sub Category</label>
                <select name="sub_sub_category_id" id="sub_sub_category_id" class="form-select">
                    <option value="">Select Sub-Sub Category</option>
                    @foreach($subsubcategories as $subsub)
                        <option value="{{ $subsub->id }}" {{ $product->sub_sub_category_id == $subsub->id ? 'selected' : '' }}>
                            {{ $subsub->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Product Info --}}
            <div class="col-md-6 mb-3">
                <label for="name" class="form-label">Product Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $product->name) }}" required>
            </div>

            <div class="col-md-6 mb-3">
                <label for="rating" class="form-label">Rating</label>
                <input type="number" name="rating" class="form-control" step="0.1" min="0" max="5"
                       value="{{ old('rating', $product->rating) }}">
            </div>

            <div class="col-12 mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="4">{{ old('description', $product->description) }}</textarea>
            </div>

            {{-- Prices --}}
            <div class="col-md-4 mb-3">
                <label for="original_price" class="form-label">Original Price</label>
                <input type="number" step="0.01" name="original_price" class="form-control"
                       value="{{ old('original_price', $product->original_price) }}">
            </div>
            <div class="col-md-4 mb-3">
                <label for="discount_percentage" class="form-label">Discount %</label>
                <input type="number" min="0" max="100" name="discount_percentage" class="form-control"
                       value="{{ old('discount_percentage', $product->discount_percentage) }}">
            </div>
            <div class="col-md-4 mb-3">
                <label for="discounted_price" class="form-label">Discounted Price</label>
                <input type="number" step="0.01" name="discounted_price" class="form-control"
                       value="{{ old('discounted_price', $product->discounted_price) }}" readonly>
            </div>

            {{-- Existing Images --}}
            <div class="col-12 mb-4">
                <label class="form-label">Existing Images</label>
                <div class="row">
                    @foreach($product->images as $image)
                        <div class="col-md-3 mb-3">
                            <div class="card">
                                <img src="{{ asset('storage/'.$image->image_path) }}" class="card-img-top" style="height:150px;object-fit:cover;">
                                <div class="card-body text-center">
                                    {{-- Set Thumbnail --}}
                                    <div class="col-md-3 text-center" id="image-{{ $image->id }}">
    <img src="{{ asset('storage/' . $image->image_path) }}" 
         class="img-fluid mb-2 rounded" 
         style="max-height: 150px;">

    @if($image->is_thumbnail)
        <span class="badge bg-success d-block mb-1">Thumbnail</span>
    @endif

    <button type="button" 
            class="btn btn-sm btn-danger delete-image" 
            data-id="{{ $image->id }}">
        Delete
    </button>

    @if(!$image->is_thumbnail)
        <button type="button" 
                class="btn btn-sm btn-primary set-thumbnail" 
                data-id="{{ $image->id }}">
            Set as Thumbnail
        </button>
    @endif
</div>


                                    <!-- @if($image->is_thumbnail)
                                        <span class="badge bg-success">Thumbnail</span>
                                    @else
                                        <form action="{{ route('admin.products.setThumbnail', [$product->id, $image->id]) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <button class="btn btn-sm btn-outline-primary">Set Thumbnail</button>
                                        </form>
                                    @endif -->
                                    {{-- Delete Image --}}
                                    <form action="{{ route('admin.products.deleteImage', [$product->id, $image->id]) }}" method="POST" class="d-inline"
                                          onsubmit="return confirm('Delete this image?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="mb-3">
    <label class="form-label">Existing Images - delete one </label>
    <div class="row">
        @foreach($product->images as $image)
            <div class="col-md-3 text-center" id="image-{{ $image->id }}">
                <img src="{{ asset('storage/' . $image->image_path) }}" 
                     class="img-fluid mb-2 rounded" 
                     style="max-height: 150px;">

                @if($image->is_thumbnail)
                    <span class="badge bg-success d-block mb-1">Thumbnail</span>
                @endif

                <button type="button" 
                        class="btn btn-sm btn-danger delete-image" 
                        data-id="{{ $image->id }}">
                    Delete
                </button>
            </div>
        @endforeach
    </div>
</div>


            {{-- Upload New Images --}}
            <div class="col-12 mb-4">
                <label for="images" class="form-label">Upload New Images</label>
                <input type="file" name="images[]" multiple class="form-control">
                <small class="text-muted">Max 5 images, JPG/PNG only</small>
            </div>

            {{-- SEO --}}
            <div class="col-12 mb-4">
                <div class="card">
                    <div class="card-header">SEO Settings</div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="meta_title" class="form-label">Meta Title</label>
                            <input type="text" name="meta_title" class="form-control"
                                   value="{{ old('meta_title', $product->seo->meta_title ?? '') }}">
                        </div>
                        <div class="mb-3">
                            <label for="meta_description" class="form-label">Meta Description</label>
                            <textarea name="meta_description" class="form-control" rows="3">{{ old('meta_description', $product->seo->meta_description ?? '') }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="meta_keywords" class="form-label">Meta Keywords</label>
                            <input type="text" name="meta_keywords" class="form-control"
                                   value="{{ old('meta_keywords', $product->seo->meta_keywords ?? '') }}">
                        </div>
                    </div>
                </div>
            </div>

            {{-- Buttons --}}
            <div class="col-12">
                <button class="btn btn-primary">Update Product</button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </div>
    </form>
</div>
@endsection

<script>
document.querySelectorAll('.delete-image').forEach(button => {
    button.addEventListener('click', function () {
        let imageId = this.getAttribute('data-id');
        if (confirm('Are you sure you want to delete this image?')) {
            fetch(`/admin/product-images/${imageId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('image-' + imageId).remove();
                } else {
                    alert('Error deleting image');
                }
            })
            .catch(err => console.error(err));
        }
    });
});

document.querySelectorAll('.set-thumbnail').forEach(button => {
    button.addEventListener('click', function () {
        let imageId = this.getAttribute('data-id');
        fetch(`/admin/product-images/${imageId}/set-thumbnail`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Refresh the page or update UI
                location.reload(); // easiest way to show the new thumbnail
            } else {
                alert('Failed to update thumbnail');
            }
        })
        .catch(err => console.error(err));
    });
});
</script>


