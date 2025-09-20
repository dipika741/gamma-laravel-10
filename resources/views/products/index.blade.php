@extends('layouts.app')

@section('content')
<style>
    /* Remove dark borders */
    table.dataTable thead th {
        background-color: #f2f2f2 !important; /* light grey */
        color: #333 !important;
        border: none !important;
    }

    table.dataTable tbody td {
        border: none !important;
    }

    table.dataTable {
        border: none !important;
    }
</style>

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Products</h2>
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary">+ Add Product</a>
    </div>

    <!-- Filters -->
    <div class="row mb-3">
        <div class="col-md-4">
            <select id="filter-category" class="form-select">
                <option value="">All Categories</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <select id="filter-subcategory" class="form-select" disabled>
                <option value="">All Subcategories</option>
            </select>
        </div>
        <div class="col-md-4">
            <select id="filter-subsubcategory" class="form-select" disabled>
                <option value="">All Sub-Subcategories</option>
            </select>
        </div>
    </div>

    <!-- Table -->
    <table class="table table-bordered table-striped" id="products-table" style="width: 100%;">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Category</th>
                <th>Subcategory</th>
                <th>Sub-Subcategory</th>
                <th>Price</th>
                <th>Discount %</th>
                <th>Discounted Price</th>
                <th>Rating</th>
                <th>Actions</th>
            </tr>
        </thead>
    </table>
</div>
@endsection

@push('scripts')
<script>
$(function () {
    let table = $('#products-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('products.data') }}",
            data: function (d) {
                d.category_id = $('#filter-category').val();
                d.subcategory_id = $('#filter-subcategory').val();
                d.subsubcategory_id = $('#filter-subsubcategory').val();
            }
        },
        columns: [
            { data: 'id', name: 'id' },
            { data: 'name', name: 'name' },
            { data: 'category', name: 'category' },
            { data: 'subcategory', name: 'subcategory' },
            { data: 'subsubcategory', name: 'subsubcategory' },
            { data: 'original_price', name: 'original_price' },
            { data: 'discount_percentage', name: 'discount_percentage' },
            { data: 'discounted_price', name: 'discounted_price' },
            { data: 'rating', name: 'rating' },
            { data: 'actions', name: 'actions', orderable: false, searchable: false }
        ]
    });

    // Category change -> load subcategories
    $('#filter-category').change(function () {
        let categoryId = $(this).val();
        $('#filter-subcategory').prop('disabled', true).html('<option value="">All Subcategories</option>');
        $('#filter-subsubcategory').prop('disabled', true).html('<option value="">All Sub-Subcategories</option>');

        if (categoryId) {
            $.get(`/categories/${categoryId}/subcategories`, function (data) {
                if (data.length > 0) {
                    $('#filter-subcategory').prop('disabled', false);
                    $.each(data, function (i, sub) {
                        $('#filter-subcategory').append(`<option value="${sub.id}">${sub.name}</option>`);
                    });
                }
            });
        }

        table.ajax.reload();
    });

    // Subcategory change -> load sub-subcategories
    $('#filter-subcategory').change(function () {
        let subcategoryId = $(this).val();
        $('#filter-subsubcategory').prop('disabled', true).html('<option value="">All Sub-Subcategories</option>');

        if (subcategoryId) {
            $.get(`/subcategories/${subcategoryId}/subsubcategories`, function (data) {
                if (data.length > 0) {
                    $('#filter-subsubcategory').prop('disabled', false);
                    $.each(data, function (i, subsub) {
                        $('#filter-subsubcategory').append(`<option value="${subsub.id}">${subsub.name}</option>`);
                    });
                }
            });
        }

        table.ajax.reload();
    });

    // Sub-Subcategory change -> reload DataTable
    $('#filter-subsubcategory').change(function () {
        table.ajax.reload();
    });
});
</script>
@endpush
