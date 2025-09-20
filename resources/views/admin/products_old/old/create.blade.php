@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h2>Create Product</h2>

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" id="productForm">
        @csrf

        {{-- Category --}}
        <div class="mb-3">
            <label class="form-label">Category</label>
            <select name="category_id" id="category" class="form-select" required>
                <option value="">-- Select Category --</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>

        {{-- Subcategory --}}
        <div class="mb-3">
            <label class="form-label">Subcategory</label>
            <select name="sub_category_id" id="subcategory" class="form-select">
                <option value="">-- Select Subcategory --</option>
            </select>
        </div>

        {{-- Sub-subcategory --}}
        <div class="mb-3">
            <label class="form-label">Sub-subcategory</label>
            <select name="sub_sub_category_id" id="subsubcategory" class="form-select">
                <option value="">-- Select Sub-subcategory --</option>
            </select>
        </div>

        {{-- Product Fields --}}
        <div class="mb-3">
            <label class="form-label">Product Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="3"></textarea>
        </div>

        <div class="mb-3 row">
            <div class="col-md-4">
                <label class="form-label">Original Price</label>
                <input type="number" name="original_price" id="original_price" class="form-control" step="0.01" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Discount (%)</label>
                <input type="number" name="discount_percentage" id="discount_percentage" class="form-control" step="1" min="0" max="100">
            </div>
            <div class="col-md-4">
                <label class="form-label">Discounted Price</label>
                <input type="number" name="discounted_price" id="discounted_price" class="form-control" step="0.01" readonly>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Rating (1–5)</label>
            <input type="number" name="rating" class="form-control" min="1" max="5">
        </div>

        {{-- Images --}}
        <div class="mb-3">
            <label class="form-label">Product Images (max 5)</label>
            <input type="file" name="images[]" id="images" class="form-control" accept="image/*" multiple>
            <div id="imagePreview" class="mt-2 d-flex flex-wrap gap-2"></div>
        </div>

        {{-- SEO --}}
        <div class="card mt-4">
            <div class="card-header">SEO Data</div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Meta Title</label>
                    <input type="text" name="meta_title" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">Meta Description</label>
                    <textarea name="meta_description" class="form-control" rows="2"></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Meta Keywords</label>
                    <input type="text" name="meta_keywords" class="form-control">
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-success mt-3">Save Product</button>
    </form>
</div>
@endsection

@push('scripts')
<script>
    // Load subcategories dynamically
    $('#category').on('change', function() {
        let categoryId = $(this).val();
        $('#subcategory').html('<option value="">-- Select Subcategory --</option>');
        $('#subsubcategory').html('<option value="">-- Select Sub-subcategory --</option>');
        if (categoryId) {
            $.get("{{ url('/admin/categories/children') }}/" + categoryId, function(data) {
                data.forEach(sub => {
                    $('#subcategory').append('<option value="'+sub.id+'">'+sub.name+'</option>');
                });
            });
        }
    });

    // Load sub-subcategories dynamically
    $('#subcategory').on('change', function() {
        let subId = $(this).val();
        $('#subsubcategory').html('<option value="">-- Select Sub-subcategory --</option>');
        if (subId) {
            $.get("{{ url('/admin/categories/children') }}/" + subId, function(data) {
                data.forEach(subsub => {
                    $('#subsubcategory').append('<option value="'+subsub.id+'">'+subsub.name+'</option>');
                });
            });
        }
    });

    // Auto-calc discounted price
    $('#original_price, #discount_percentage').on('input', function() {
        let price = parseFloat($('#original_price').val()) || 0;
        let discount = parseFloat($('#discount_percentage').val()) || 0;
        let discounted = price - (price * discount / 100);
        $('#discounted_price').val(discounted.toFixed(2));
    });

    // Image preview (limit 5)
    $('#images').on('change', function() {
        let files = this.files;
        if (files.length > 5) {
            alert("You can only upload up to 5 images.");
            this.value = "";
            return;
        }
        $('#imagePreview').html('');
        [...files].forEach((file, index) => {
            let reader = new FileReader();
            reader.onload = e => {
                $('#imagePreview').append(`
                    <div class="position-relative">
                        <img src="${e.target.result}" class="img-thumbnail" width="120">
                        <div><input type="radio" name="thumbnail" value="${index}" ${index===0 ? 'checked' : ''}> Thumbnail</div>
                    </div>
                `);
            };
            reader.readAsDataURL(file);
        });
    });
</script>
@endpush
