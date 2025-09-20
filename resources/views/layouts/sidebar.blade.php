<!-- Admin Sidebar -->
<aside class="bg-dark text-white p-3 vh-100" style="width: 250px;">
    <h4 class="mb-4">Admin Panel</h4>
    <ul class="nav flex-column">

        <!-- Dashboard -->
        <li class="nav-item mb-2">
            <a href="{{ route('admin.categories.index') }}" class="nav-link text-white">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
        </li>

        <!-- Categories -->
        <li class="nav-item mb-2">
            <a href="{{ route('admin.categories.index') }}" class="nav-link text-white">
                <i class="bi bi-folder"></i> Categories
            </a>
        </li>

        <!-- Subcategories -->
        <li class="nav-item mb-2">
            <a href="{{ route('admin.subcategories.index') }}" class="nav-link text-white">
                <i class="bi bi-folder2"></i> Subcategories
            </a>
        </li>

        <!-- Sub-subcategories -->
        <li class="nav-item mb-2">
            <a href="{{ route('admin.subsubcategories.index') }}" class="nav-link text-white">
                <i class="bi bi-folder-symlink"></i> Sub-subcategories
            </a>
        </li>

        <!-- Products -->
        <li class="nav-item mb-2">
            <a href="{{ route('admin.products.index') }}" class="nav-link text-white">
                <i class="bi bi-box-seam"></i> Products
            </a>
        </li>

    </ul>
</aside>
