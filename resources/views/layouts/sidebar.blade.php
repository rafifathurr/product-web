<div class="main-header">
    <!-- Logo Header -->
    <div class="logo-header" style="padding-left:0 !important" data-background-color="blue">
        <div class="logo my-auto">
            <img src="{{ asset('logo.png') }}" width="150" alt="navbar brand" class="navbar-brand">
        </div>
        <button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse"
            data-target="collapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon">
                <i class="icon-menu" style="color:#7F453F;"></i>
            </span>
        </button>
        <button class="topbar-toggler more"><i class="icon-options-vertical"></i></button>
        <div class="nav-toggle">
            <button class="btn btn-toggle toggle-sidebar">
                <i class="icon-menu" style="color:#7F453F;"></i>
            </button>
        </div>
    </div>
    <!-- End Logo Header -->
    <!-- Navbar Header -->
    <nav class="navbar navbar-header navbar-expand-lg" data-background-color="blue2">
        <div class="container-fluid">
            <ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
                <li class="nav-item dropdown hidden-caret">
                    <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#" aria-expanded="false">
                        <div class="avatar-sm">
                            @if (Auth::guard('admin')->check())
                                <img src="{{ asset('img/admin.png') }}" style="background-color:white;" alt="..."
                                    class="avatar-img rounded-circle">
                            @else
                                <img src="{{ asset('img/user.png') }}" alt="..." class="avatar-img rounded-circle">
                            @endif
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-user animated fadeIn">
                        <div class="dropdown-user-scroll scrollbar-outer">
                            <li>
                                <form action="{{ route('auth.logout') }}" method="post">
                                    @csrf
                                    <button class="dropdown-item">Log Out</button>
                                </form>
                            </li>
                        </div>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
    <!-- End Navbar -->
</div>
<!-- Sidebar -->
<div class="sidebar sidebar-style-2">
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <ul class="nav nav-primary">
                @if (Auth::guard('admin')->check())
                    <li class="nav-item {{ $title === 'Dashboard' ? 'active' : '' }}">
                        <a href="{{ route('admin.dashboard.index') }}" aria-expanded="false">
                            <i class="fas fa-home"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li
                        class="nav-item {{ $title === 'List User' || $title === 'Add User' || $title === 'Edit User' || $title === 'Detail User' ? 'active' : '' }}"">
                        <a href="{{ route('admin.users.index') }}" class="collapsed" aria-expanded="false">
                            <i class="fa fa-user-plus"></i>
                            <p>Manajemen User</p>
                        </a>
                    </li>
                    <li
                        class="nav-item {{ $title === 'List Products' || $title === 'Add Products' || $title === 'Edit Products' || $title === 'Detail Products' ? 'active' : '' }}">
                        <a href="{{ route('admin.product.index') }}" class="collapsed" aria-expanded="false">
                            <i class="fas fa-boxes"></i>
                            <p>Manajemen Produk</p>
                        </a>
                    </li>
                @else
                    <li
                        class="nav-item {{ $title === 'List Order' || $title === 'Add Order' || $title === 'Edit Order' || $title === 'Detail Order' ? 'active' : '' }}">
                        <a href="{{ route('user.order.index') }}" aria-expanded="false">
                            <i class="fas fa-clipboard-list"></i>
                            <p>Order</p>
                        </a>
                    </li>
                    <li
                        class="nav-item {{ $title === 'List Products' || $title === 'Add Products' || $title === 'Edit Products' || $title === 'Detail Products' ? 'active' : '' }}">
                        <a href="{{ route('user.product.index') }}" class="collapsed" aria-expanded="false">
                            <i class="fas fa-boxes"></i>
                            <p>Product</p>
                        </a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</div>
<!-- End Sidebar -->
