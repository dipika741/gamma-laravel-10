@extends('admin.layout')

@section('title', 'Subsubcategories')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Subsubcategories</h2>

    <a href="{{ route('admin.subsubcategories.create') }}" class="btn btn-primary mb-3">
        Add New SubsubCategory
    </a>

    <table id="subsubcategories-table" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Category</th>
                <th>Subcategory</th>
                <th>Actions</th>
            </tr>
        </thead>
    </table>
</div>
@endsection

@push('styles')
    {{-- DataTables CSS --}}
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
@endpush

@push('scripts')
    {{-- jQuery (must be loaded first) --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    {{-- Bootstrap Bundle --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    {{-- DataTables JS --}}
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <script>
    $(document).ready(function () {
        $('#subsubcategories-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.subsubcategories.data') }}",
            columns: [
                { data: 'id', name: 'id' },
                { data: 'name', name: 'name' },
                { data: 'category', name: 'category' },
                { data: 'subcategory', name: 'subcategory' },
                { data: 'actions', name: 'actions', orderable: false, searchable: false },
            ],
            order: [[0, 'desc']],
            pageLength: 10
        });
    });
    </script>
@endpush
