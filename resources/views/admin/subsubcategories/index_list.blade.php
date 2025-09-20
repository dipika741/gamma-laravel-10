@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h2>Subsubcategories</h2>
    <a href="{{ route('admin.subsubcategories.create') }}" class="btn btn-primary mb-3">Add New</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <tr>
            <th>ID</th>
            <th>Category</th>
            <th>Subcategory</th>
            <th>Name</th>
            <th>Actions</th>
        </tr>
        @foreach($subsubcategories as $ssc)
        <tr>
            <td>{{ $ssc->id }}</td>
            <td>{{ $ssc->category->name }}</td>
            <td>{{ $ssc->subcategory->name }}</td>
            <td>{{ $ssc->name }}</td>
            <td>
                <a href="{{ route('admin.subsubcategories.edit', $ssc->id) }}" class="btn btn-sm btn-warning">Edit</a>
                <form action="{{ route('admin.subsubcategories.destroy', $ssc->id) }}" method="POST" style="display:inline;">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this?')">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
</div>
@endsection
