<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('admin.dashboard') }}" class="brand-link">
        <img src="{{ asset('admin-page/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">Abdi Jaya</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->
                <li class="nav-header">DASHBOARD</li>
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-fw fa-home"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-header">ORDERS</li>
                <li class="nav-item">
                    <a href="{{ route('order.index') }}" class="nav-link {{ request()->routeIs('order.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-fw fa-plus-circle"></i>
                        <p>Add Order</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.history') }}" class="nav-link {{ request()->routeIs('admin.history') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-fw fa-history"></i>
                        <p>Order History</p>
                    </a>
                </li>
                <li class="nav-header">CUSTOMERS</li>
                <li class="nav-item">
                    <a href="{{ route('customers.index') }}" class="nav-link {{ request()->routeIs('customers.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-fw fa-users"></i>
                        <p>Customer</p>
                    </a>
                </li>
                <li class="nav-header">PRODUCTS</li>
                <li class="nav-item">
                    <a href="{{ route('products.index') }}" class="nav-link {{ request()->routeIs('products.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-fw fa-box-open"></i>
                        <p>All Products</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('categories.index') }}" class="nav-link {{ request()->routeIs('categories.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-fw fa-tags"></i>
                        <p>Categories</p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
