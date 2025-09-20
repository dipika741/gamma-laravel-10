@extends('admin.layout')

@section('content')
<div class="container">
    <h2>Edit Subcategory</h2>

    @if($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif
    
    <form method="POST" action="{{ route('admin.subcategories.update', $subcategory->id) }}">
        @csrf @method('PUT')
        <div class="form-group mb-3">
            <label>Parent Category</label>
            <select name="category_id" class="form-control" required>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ $subcategory->category_id == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group mb-3">
            <label>Subcategory Name</label>
            <input type="text" name="name" value="{{ $subcategory->name }}" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('admin.subcategories.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
