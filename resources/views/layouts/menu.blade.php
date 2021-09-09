<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
        <li class="nav-item">
            <a href="{{ url('/') }}" class="nav-link active">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>Dashboard</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('user.index') }}" class="nav-link">
                <i class="nav-icon fas fa-user"></i>
                <p>Users</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('customer.index') }}" class="nav-link">
                <i class="nav-icon fas fa-users"></i>
                <p>Customer</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('category.index') }}" class="nav-link">
                <i class="nav-icon fas fa-th"></i>
                <p>Kategori Produk</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('product.index') }}" class="nav-link">
                <i class="nav-icon fas fa-th"></i>
                <p>Produk</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('order.index') }}" class="nav-link">
                <i class="nav-icon fas fa-shopping-cart"></i>
                <p>Penjualan</p>
            </a>
        </li>
    </ul>
</nav>
