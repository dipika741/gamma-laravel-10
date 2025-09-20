@extends('admin.layout')

@section('title', 'Sub-Subcategories')

@section('content')
<div class="container">
    <h2 class="mb-4">Sub-Sub Categories</h2>
    <a href="{{ route('admin.subsubcategories.create') }}" class="btn btn-primary mb-3">
        Add New Sub-SubCategory
    </a>

    <table class="table table-bordered" id="subsubcategories-table">
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

@push('scripts')
<!-- Datatables + Buttons -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css">

<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

<script>
$(document).ready(function () {
    $('#subsubcategories-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.subsubcategories.data') }}",
        columns: [
            {
                data: null,
                orderable: false,
                searchable: false,
                render: function (data, type, row, meta) {
                    return meta.row + 1; // Serial ID (starts at 1)
                }
            },
            { data: 'name', name: 'name' },
            { data: 'category_name', name: 'category.name' },
            { data: 'subcategory_name', name: 'subcategory.name' },
            {
                data: 'actions',
                orderable: false,
                searchable: false
            }
        ],
        order: [[1, 'asc']],
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });
});
</script>
@endpush
