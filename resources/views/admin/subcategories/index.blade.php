@extends('admin.layout')

@section('content')
<div class="container">
    <h2>Subcategories</h2>
    <a href="{{ route('admin.subcategories.create') }}" class="btn btn-primary mb-3">Add Subcategory</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th><th>Category</th><th>Name</th><th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($subcategories as $subcategory)
            <tr>
                <td>{{ $subcategory->id }}</td>
                <td>{{ $subcategory->category->name }}</td>
                <td>{{ $subcategory->name }}</td>
                <td>
                    <a href="{{ route('admin.subcategories.edit', $subcategory->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('admin.subcategories.destroy', $subcategory->id) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button type="submit" onclick="return confirm('Are you sure?')" class="btn btn-sm btn-danger">
                            Delete
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
