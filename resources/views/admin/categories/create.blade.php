@extends('admin.layout')

@section('content')
<div class="container">
    <h2>Add Category</h2>

    @if($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif
    
    <form method="POST" action="{{ route('admin.categories.store') }}">
        @csrf
        <div class="form-group mb-3">
            <label>Category Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Save</button>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
