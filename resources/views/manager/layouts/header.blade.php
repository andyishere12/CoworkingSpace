<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Trackingspace - Manager Dashboard</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- AdminLTE -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/css/adminlte.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/stylemember.css') }}">

    <!-- ✅ TAMBAHAN: Stack untuk CSS tambahan dari halaman -->
    @stack('styles')

    <style>
        /* Manager Dashboard Custom Styles */
        .bg-gradient-info {
            background: linear-gradient(135deg, #00BCD4 0%, #00ACC1 100%) !important;
        }

        .bg-gradient-warning {
            background: linear-gradient(135deg, #FF9800 0%, #FF6F00 100%) !important;
        }

        .bg-gradient-success {
            background: linear-gradient(135deg, #8BC34A 0%, #7CB342 100%) !important;
        }

        .bg-gradient-danger {
            background: linear-gradient(135deg, #F44336 0%, #D32F2F 100%) !important;
        }

        .bg-gradient-primary {
            background: linear-gradient(135deg, #6C3FB5 0%, #8B5FD6 100%) !important;
            color: white;
        }

        .small-box .icon {
            font-size: 70px;
            opacity: 0.3;
        }

        .callout {
            border-left-width: 5px;
        }

        .btn-app {
            min-height: 80px;
        }

        .nav-icon-box {
            display: inline-block;
            width: 35px;
            height: 35px;
            line-height: 35px;
            text-align: center;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            margin-right: 5px;
        }

        .navbar-light .navbar-nav .nav-link {
            color: rgba(0, 0, 0, .7);
            transition: all 0.3s;
        }

        .navbar-light .navbar-nav .nav-link:hover,
        .navbar-light .navbar-nav .nav-link.active {
            color: #6C3FB5;
            background: rgba(108, 63, 181, 0.1);
            border-radius: 5px;
        }

        /* Sidebar improvements */
        .sidebar-dark-primary .nav-sidebar>.nav-item>.nav-link.active {
            background-color: rgba(255, 255, 255, 0.1);
            color: #fff;
        }

        .badge.right {
            float: right;
            margin-top: 3px;
            margin-right: 10px;
        }
    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                        <i class="fas fa-bars"></i>
                    </a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a href="{{ route('manager.dashboard') }}" class="nav-link">
                        <div class="nav-icon-box">
                            <i class="fas fa-home"></i>
                        </div>
                        Home
                    </a>
                </li>

                <li class="nav-item">
                    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="nav-link btn btn-link" style="border: none; background: none; padding: 0.5rem 1rem;">
                            <div class="nav-icon-box">
                                <i class="fas fa-sign-out-alt"></i>
                            </div>
                            Logout
                        </button>
                    </form>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="{{ route('manager.dashboard') }}" class="brand-link">
                <img src="{{ asset('gambar/icontrasa.jpeg') }}"
                    alt="Logo"
                    class="brand-image img-circle elevation-3">
                <span class="brand-text">Trackingspace</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- User Panel - SAMA PERSIS SEPERTI ADMIN -->
                <div class="user-panel mt-3 pb-3 mb-3">
                    <div class="image">
                        <img src="https://ui-avatars.com/api/?name=Manager&size=80&background=6C3FB5&color=fff"
                            class="img-circle elevation-2"
                            alt="Manager">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block text-white font-weight-bold">
                            Manager
                        </a>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                        <!-- Dashboard -->
                        <li class="nav-item">
                            <a href="{{ route('manager.dashboard') }}" class="nav-link active">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>

                        <!-- Analytics -->
                        <li class="nav-item">
                            <a href="{{ route('manager.analytics') }}"
                                class="nav-link {{ request()->routeIs('manager.analytics') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-chart-line"></i>
                                <p>Analytics</p>
                            </a>
                        </li>

                        <!-- Members -->
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-users"></i>
                                <p>
                                    Members
                                    <span class="badge badge-secondary right">Soon</span>
                                </p>
                            </a>
                        </li>

                        <!-- Event Approval -->
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-calendar-check"></i>
                                <p>
                                    Event Approval
                                    <span class="badge badge-warning right">Soon</span>
                                </p>
                            </a>
                        </li>

                        <!-- Reservation Approval -->
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-clipboard-check"></i>
                                <p>
                                    Reservation Approval
                                    <span class="badge badge-warning right">Soon</span>
                                </p>
                            </a>
                        </li>

                        <!-- Users -->
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-user-cog"></i>
                                <p>
                                    Users
                                    <span class="badge badge-info right">Soon</span>
                                </p>
                            </a>
                        </li>

                        <!-- Settings -->
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-cog"></i>
                                <p>
                                    Settings
                                    <span class="badge badge-secondary right">Soon</span>
                                </p>
                            </a>
                        </li>

                        <!-- Profile -->
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-user"></i>
                                <p>Profile</p>
                            </a>
                        </li>

                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper akan dimulai di file halaman -->
        <!-- Tag TIDAK DITUTUP di sini, biarkan footer yang menutup -->

        <!-- ✅ TAMBAHAN: Stack untuk JavaScript tambahan dari halaman -->
        @stack('scripts')