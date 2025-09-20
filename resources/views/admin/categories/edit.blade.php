@extends('admin.layout')

@section('content')
<div class="container">
    <h2>Edit Category</h2>

    @if($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif
    
    <form method="POST" action="{{ route('admin.categories.update', $category->id) }}">
        @csrf @method('PUT')
        <div class="form-group mb-3">
            <label>Category Name</label>
            <input type="text" name="name" value="{{ $category->name }}" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
