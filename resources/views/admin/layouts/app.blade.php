<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/admin/categories') }}">Admin Panel</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a href="{{ route('admin.categories.index') }}" class="nav-link">Categories</a></li>
                    <li class="nav-item"><a href="{{ route('admin.subcategories.index') }}" class="nav-link">Subcategories</a></li>
                    <li class="nav-item"><a href="{{ route('admin.subsubcategories.index') }}" class="nav-link">Sub-Subcategories</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        @yield('content')
    </div>
</body>
</html>
