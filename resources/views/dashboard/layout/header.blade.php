<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>
        @hasSection('title')
            @yield('title') | Velonic
        @else
            Velonic
        @endif
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully responsive admin theme which can be used to build CRM, CMS,ERP etc." name="description" />
    <meta content="Techzaa" name="author" />
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.2/css/dataTables.bootstrap5.min.css">

    <!-- Vector Map CSS -->
    <link rel="stylesheet"
        href="{{ asset('dashboard-assets/vendor/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css') }}">

    <!-- Daterangepicker CSS -->
    <link rel="stylesheet" href="{{ asset('dashboard-assets/vendor/daterangepicker/daterangepicker.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

    <!-- App Config & Theme -->
    <script src="{{ asset('dashboard-assets/js/config.js') }}"></script>
    <link href="{{ asset('dashboard-assets/css/app.min.css') }}" rel="stylesheet" id="app-style" />
    <link href="{{ asset('dashboard-assets/css/icons.min.css') }}" rel="stylesheet" />
    <link rel="icon" type="image/png" href="{{ asset('admin_favicon.png') }}">
    @vite('resources/js/app.js')
</head>

<body>
    <!-- Begin page -->
    <div class="wrapper">


        <!-- ========== Topbar Start ========== -->
        <div class="navbar-custom">
            <div class="topbar container-fluid">
                <div class="d-flex align-items-center gap-1">

                    <!-- Topbar Brand Logo -->
                    <div class="logo-topbar">
                        <!-- Logo light -->
                        <a href="index.html" class="logo-light">
                            <span class="logo-lg">
                                <img src="{{ asset('dashboard-assets/images/logo.png') }}" alt="logo">
                            </span>
                            <span class="logo-sm">
                                <img src="{{ asset('dashboard-assets/images/logo-sm.png') }}" alt="small logo">
                            </span>
                        </a>

                        <!-- Logo Dark -->
                        <a href="index.html" class="logo-dark">
                            <span class="logo-lg">
                                <img src="{{ asset('dashboard-assets/images/logo-dark.png') }}" alt="dark logo">
                            </span>
                            <span class="logo-sm">
                                <img src="{{ asset('dashboard-assets/images/logo-sm.png') }}" alt="small logo">
                            </span>
                        </a>
                    </div>

                    <!-- Sidebar Menu Toggle Button -->
                    <button class="button-toggle-menu">
                        <i class="ri-menu-line"></i>
                    </button>

                    <!-- Horizontal Menu Toggle Button -->
                    <button class="navbar-toggle" data-bs-toggle="collapse" data-bs-target="#topnav-menu-content">
                        <div class="lines">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </button>

                    <!-- Topbar Search Form -->
                    <div class="app-search d-none d-lg-block">
                        <form>
                            <div class="input-group">
                                <input type="search" class="form-control" placeholder="Search...">
                                <span class="ri-search-line search-icon text-muted"></span>
                            </div>
                        </form>
                    </div>
                </div>

                <ul class="topbar-menu d-flex align-items-center gap-3">
                    <li class="dropdown d-lg-none">
                        <a class="nav-link dropdown-toggle arrow-none" data-bs-toggle="dropdown" href="#"
                            role="button" aria-haspopup="false" aria-expanded="false">
                            <i class="ri-search-line fs-22"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-animated dropdown-lg p-0">
                            <form class="p-3">
                                <input type="search" class="form-control" placeholder="Search ..."
                                    aria-label="Recipient's username">
                            </form>
                        </div>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="notificationsDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="ri-notification-3-line fs-22"></i>
                            <span class="badge bg-danger rounded-pill" id="newOrdersCount">
                                {{ auth()->user()->unreadNotifications->count() }}
                            </span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notificationsDropdown"
                            style="width: 300px; max-height: 400px; overflow-y: auto;" id="notificationsList">

                            <li class="dropdown-header">Notifications</li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>

                            @foreach ($notifications as $notification)
                                <li>
                                    <a href="#" class="dropdown-item text-wrap">
                                        {{ $notification->data['message'] }}
                                        <br>
                                        <small
                                            class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </li>

                    <li class="d-none d-sm-inline-block">
                        <a class="nav-link" data-bs-toggle="offcanvas" href="#theme-settings-offcanvas">
                            <i class="ri-settings-3-line fs-22"></i>
                        </a>
                    </li>

                    {{-- <li class="d-none d-sm-inline-block">
                        <div class="nav-link" id="light-dark-mode">
                            <i class="ri-moon-line fs-22"></i>
                        </div>
                    </li> --}}

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="account-user-avatar">
                                <img src="{{ asset('dashboard-assets/images/users/avatar-1.jpg') }}" alt="user-image"
                                    width="32" class="rounded-circle">
                            </span>
                            <span class="d-lg-block d-none">
                                <h5 class="my-0 fw-normal">
                                    {{ Auth::user()->name }}
                                    <i class="ri-arrow-down-s-line d-none d-sm-inline-block align-middle"></i>
                                </h5>
                            </span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li>
                                <h6 class="dropdown-header">Welcome!</h6>
                            </li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}" id="logout-form">
                                    @csrf
                                    <a href="#" class="dropdown-item"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="ri-logout-box-line fs-18 align-middle me-1"></i>
                                        Logout
                                    </a>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
        <!-- ========== Topbar End ========== -->


        <!-- ========== Left Sidebar Start ========== -->
        <div class="leftside-menu">

            <!-- Brand Logo Light -->
            <a href="{{ route('admin.dashboard') }}" class="logo logo-light">
                <span class="logo-lg">
                    <img src="{{ asset('dashboard-assets/images/logo.png') }}" alt="logo">
                </span>
                <span class="logo-sm">
                    <img src="{{ asset('dashboard-assets/images/logo-sm.png') }}" alt="small logo">
                </span>
            </a>

            <!-- Brand Logo Dark -->
            <a href="index.html" class="logo logo-dark">
                <span class="logo-lg">
                    <img src="{{ asset('dashboard-assets/images/logo-dark.png') }}" alt="dark logo">
                </span>
                <span class="logo-sm">
                    <img src="{{ asset('dashboard-assets/images/logo-sm.png') }}" alt="small logo">
                </span>
            </a>

            <!-- Sidebar -left -->
            <div class="h-100" id="leftside-menu-container" data-simplebar>
                <!--- Sidemenu -->
                <ul class="side-nav">

                    <li class="side-nav-title">Main</li>

                    <li class="side-nav-item">
                        <a href="{{ route('admin.dashboard') }}" class="side-nav-link">
                            <i class="ri-dashboard-3-line"></i>
                            <span> Dashboard </span>
                        </a>
                    </li>

                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" data-bs-target="#sidebarPages" role="button"
                            aria-expanded="false" aria-controls="sidebarPages" class="side-nav-link">
                            <i class="ri-store-2-line"></i>
                            <span>Manage Products </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="sidebarPages">
                            <ul class="side-nav-second-level">
                                <li><a href="{{ route('products.index') }}">All Products</a></li>
                                <li><a href="{{ route('products.create') }}">Create Products</a></li>
                                <li><a href="{{ route('categories.index') }}">Categories</a></li>
                                <li><a href="{{ route('tags.index') }}">Tags</a></li>
                                <li><a href="{{ route('coupons.index') }}">Coupons</a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="side-nav-item">
                        <a href="{{ route('admin.orders.index') }}" class="side-nav-link">
                            <i class="ri-shopping-bag-3-line"></i> {{-- Orders --}}
                            <span>Orders</span>
                        </a>
                    </li>

                    <li class="side-nav-item">
                        <a href="{{ route('admin.reviews.index') }}" class="side-nav-link">
                            <i class="ri-star-line"></i> {{-- Reviews --}}
                            <span>Reviews</span>
                        </a>
                    </li>

                    <li class="side-nav-item">
                        <a href="{{ route('admin.blogs.index') }}" class="side-nav-link">
                            <i class="ri-article-line"></i> {{-- Blogs --}}
                            <span>Blogs</span>
                        </a>
                    </li>

                    <li class="side-nav-item">
                        <a href="{{ route('admin.comments.index') }}" class="side-nav-link">
                            <i class="ri-chat-3-line"></i> {{-- Blogs Comments --}}
                            <span>Blogs Comments</span>
                        </a>
                    </li>
                </ul>
                <!--- End Sidemenu -->

                <div class="clearfix"></div>
            </div>
        </div>
        <!-- ========== Left Sidebar End ========== -->

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <div class="content-page">
            <div class="content">
