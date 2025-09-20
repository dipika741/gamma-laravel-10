@extends('admin.layout')

@section('content')
<div class="container">
    <h2>Add SubsubCategory</h2>

    @if($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif

    <form action="{{ route('admin.subsubcategories.store') }}" method="POST">
        @csrf

        <!-- <div class="mb-3">
            <label>Category</label>
            <select name="category_id" class="form-control">
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Subcategory</label>
            <select name="subcategory_id" class="form-control">
                @foreach($subcategories as $subcat)
                    <option value="{{ $subcat->id }}">{{ $subcat->name }}</option>
                @endforeach
            </select>
        </div> -->

          {{-- Category --}}
<div class="mb-3">
    <label for="category_id" class="form-label">Category s<span class="text-danger">*</span></label>
    <select name="category_id" id="category_id" class="form-control" required>
    <option value="">-- Select Category --</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" >
                        {{ $cat->name }}
                    </option>
                @endforeach
    </select>
</div>

{{-- Subcategory --}}
<div class="mb-3">
    <label for="subcategory_id" class="form-label">Subcategory</label>
    <select name="subcategory_id" id="subcategory_id" class="form-control">
    <option value="">-- Select Subcategory --</option>
                @foreach($subcategories as $subcat)
                    <option value="{{ $subcat->id }}">
                        {{ $subcat->name }}
                    </option>
                @endforeach
    </select>
</div>

        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}">
        </div>

        <button class="btn btn-success">Save</button>
    </form>
</div>
@endsection

@push('scripts')
<script>



$(document).ready(function () { 
   

        // 🔹 Dependent Dropdowns with AJAX (Category → Subcategory)
        $('#category_id').on('change', function () { 
        let categoryId = $(this).val();
        let $subcategory = $('#subcategory_id');
        let $subsub = $('#sub_sub_category_id');

        $subcategory.html('<option value="">-- Loading... --</option>');
        $subsub.html('<option value="">-- Select Subcategory First --</option>');

        if (categoryId) {
            $.get(`/admin/categories/${categoryId}/subcategories`, function (data) {
                $subcategory.html('<option value="">-- Select Subcategory --</option>');
                $.each(data, function (index, sub) {
                    $subcategory.append(`<option value="${sub.id}">${sub.name}</option>`);
                });
            });
        } else {
            $subcategory.html('<option value="">-- Select Category First --</option>');
        }
    });

    // 🔹 Dependent Dropdowns with AJAX (Subcategory → Sub-Subcategory)
    $('#subcategory_id').on('change', function () {
        let subcategoryId = $(this).val();
        let $subsub = $('#sub_sub_category_id');

        $subsub.html('<option value="">-- Loading... --</option>');

        if (subcategoryId) {
            $.get(`/admin/subcategories/${subcategoryId}/subsubcategories`, function (data) {
                $subsub.html('<option value="">-- Select Sub-Subcategory --</option>');
                $.each(data, function (index, subsub) {
                    $subsub.append(`<option value="${subsub.id}">${subsub.name}</option>`);
                });
            });
        } else {
            $subsub.html('<option value="">-- Select Subcategory First --</option>');
        }
    });


});
</script>
@endpush
