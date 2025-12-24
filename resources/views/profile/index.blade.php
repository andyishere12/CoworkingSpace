<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Profile - Trackingspace</title>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/css/adminlte.min.css">

    <style>
        body {
            font-family: 'Source Sans Pro', sans-serif;
            background-color: #f4f6f9;
        }

        .main-sidebar {
            background: linear-gradient(180deg, #6C3FB5 0%, #8B5FD6 100%) !important;
            padding-right: 15px; 
        }

        .brand-link {
            background: transparent !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1) !important;
            padding: 20px 15px;
        }

        .brand-link .brand-text {
            color: white !important;
            font-weight: 600;
            font-size: 20px;
        }

        .user-panel {
            padding-left: 15px;
            padding-right: 15px;
            margin-left: 10px;

        }

        .user-panel .image {
            display: block !important;
            float: none !important;
            /* Hapus float kiri bawaan AdminLTE */
            margin: 0 0 10px 0 !important;
            /* Atur margin: bawah saja */
            padding: 0 !important;
        }

        .user-panel .image img {
            width: 80px;
            height: 80px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            display: block;
            margin: 0 auto;
            /* Pastikan gambar di tengah */
        }

        .user-panel .info {
            display: block !important;
            width: 100% !important;
            padding: 0 !important;
            /* Hapus padding kiri bawaan */
            margin: 0 !important;
            text-align: center !important;
        }

        .user-panel .info a {
            color: white !important;
            font-size: 16px;
            font-weight: 500;
        }

        .sidebar-dark-primary .nav-sidebar>.nav-item>.nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 12px 15px;
            margin: 4px 10px;
            border-radius: 8px;
        }

        .sidebar-dark-primary .nav-sidebar>.nav-item>.nav-link:hover {
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
        }

        .sidebar-dark-primary .nav-sidebar>.nav-item>.nav-link.active {
            background-color: rgba(255, 255, 255, 0.15);
            color: white;
        }

        .profile-img-container {
            text-align: center;
            padding: 30px;
        }

        .profile-img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            border: 5px solid #6C3FB5;
            margin-bottom: 20px;
            object-fit: cover;
        }

        .profile-name {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .profile-role {
            color: #6c757d;
            font-size: 16px;
            margin-bottom: 20px;
        }
    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a href="{{ route('scan') }}" class="nav-link">
                        <i class="fas fa-home"></i> Home
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link active">
                        <i class="fas fa-chart-line"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-users"></i> <span class="badge badge-danger">{{ $todayAttendance ?? 0 }}</span> Active
                        Today
                    </a>
                </li>
                <li class="nav-item">
                    <form action="{{ route('logout') }}" method="POST" class="m-0">
                        @csrf
                        <button type="submit" class="nav-link btn btn-link text-danger w-100 text-start">
                            <div class="nav-icon-box d-inline-block me-2">
                                <i class="fas fa-sign-out-alt"></i>
                            </div>
                            Logout (admin)
                        </button>
                    </form>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <a href="{{ route('dashboard') }}" class="brand-link">
                <a href="{{ route('dashboard') }}" class="brand-link">
                    <img src="{{ asset('gambar/icontrasa.jpeg') }}"
                        alt="Logo"
                        class="brand-image img-circle elevation-3">
                    <span class="brand-text">Trackingspace</span>
                </a>
                <div class="sidebar">
                    <div class="user-panel mt-3 pb-3 mb-3">
                        <div class="image">
                            @if(Auth::user()->avatar)
                            <img src="{{ asset('storage/avatars/' . Auth::user()->avatar) }}"
                                class="img-circle elevation-2"
                                alt="{{ Auth::user()->name }}">
                            @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'Admin') }}&size=80&background=6C3FB5&color=fff"
                                class="img-circle elevation-2"
                                alt="User Image">
                            @endif
                        </div>
                        <div class="info">
                            <u style="color: white;">
                                <a href="#" class="d-block text-white font-weight-bold">
                                    {{ Auth::user()->name ?? 'Admin' }}
                                </a>
                            </u>
                        </div>
                    </div>
                    <nav class="mt-2">
                        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                            <li class="nav-item">
                                <a href="{{ route('dashboard') }}" class="nav-link">
                                    <i class="nav-icon fas fa-tachometer-alt"></i>
                                    <p>Dashboard</p>
                                </a>
                            </li>
                            <!-- <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-tasks"></i>
                                <p>Priority Task</p>
                            </a>
                        </li> -->
                            <li class="nav-item">
                                <a href="{{ route('attendance.index') }}" class="nav-link">
                                    <i class="nav-icon fas fa-clock"></i>
                                    <p>Attendance</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('data_member.index') }}" class="nav-link">
                                    <i class="nav-icon fas fa-users"></i>
                                    <p>Members</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('reservasi.index') }}" class="nav-link ">
                                    <i class="nav-icon fas fa-bookmark"></i>
                                    <p>Reservations</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('room.index') }}" class="nav-link">
                                    <i class="nav-icon fas fa-door-open"></i>
                                    <p>Rooms</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('event.index') }}" class="nav-link">
                                    <i class="nav-icon fas fa-calendar"></i>
                                    <p>Events</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('operational-hours.index') }}" class="nav-link">
                                    <i class="nav-icon fas fa-clock"></i>
                                    <p>Open Hours</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('reports.index') }}" class="nav-link">
                                    <i class="nav-icon fas fa-chart-bar"></i>
                                    <p>Reports</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('profile.index') }}" class="nav-link active">
                                    <i class="nav-icon fas fa-user"></i>
                                    <p>Profile</p>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
        </aside>

        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">My Profile</h1>
                        </div>
                    </div>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">

                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <i class="fas fa-check-circle"></i> {{ session('success') }}
                    </div>
                    @endif

                    <div class="row">
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="profile-img-container">
                                        @if($user->avatar)
                                        <img src="{{ asset('storage/avatars/' . $user->avatar) }}" alt="Profile Photo"
                                            class="profile-img">
                                        @else
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&size=150&background=6C3FB5&color=fff"
                                            alt="Profile Photo" class="profile-img">
                                        @endif

                                        <div class="profile-name">{{ $user->name }}</div>
                                        <div class="profile-role">
                                            <i class="fas fa-shield-alt"></i> Super Admin
                                        </div>

                                        <button type="button" class="btn btn-sm btn-outline-primary"
                                            onclick="document.getElementById('avatarInput').click()">
                                            <i class="fas fa-camera"></i> Change Photo
                                        </button>
                                    </div>
                                    <hr>
                                    <div class="p-3">
                                        <h5><i class="fas fa-info-circle text-primary"></i> Account Info</h5>
                                        <table class="table table-sm table-borderless">
                                            <tr>
                                                <td><strong>Email:</strong></td>
                                                <td>{{ $user->email }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Join Date:</strong></td>
                                                <td>{{ $user->created_at->format('d M Y') }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header bg-primary">
                                    <h3 class="card-title"><i class="fas fa-user-edit"></i> Edit Profile</h3>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('profile.update') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf

                                        <input type="file" name="avatar" id="avatarInput" style="display:none"
                                            onchange="this.form.submit()">

                                        <div class="form-group">
                                            <label>Full Name</label>
                                            <input type="text" name="name" class="form-control"
                                                value="{{ $user->name }}" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Email Address</label>
                                            <input type="email" name="email" class="form-control"
                                                value="{{ $user->email }}" required>
                                        </div>
                                        <div class="text-right">
                                            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i>
                                                Save Changes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header bg-warning">
                                    <h3 class="card-title"><i class="fas fa-lock"></i> Change Password</h3>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('profile.password') }}" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <label>Current Password</label>
                                            <input type="password" name="current_password" class="form-control"
                                                required>
                                        </div>
                                        <div class="form-group">
                                            <label>New Password</label>
                                            <input type="password" name="new_password" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Confirm New Password</label>
                                            <input type="password" name="new_password_confirmation" class="form-control"
                                                required>
                                        </div>
                                        <div class="text-right">
                                            <button type="submit" class="btn btn-warning"><i class="fas fa-key"></i>
                                                Update Password</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </section>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/js/adminlte.min.js"></script>
</body>

<footer class="main-footer">
    <strong>Copyright &copy; 2025 <a href="#">Trackingspace</a>.</strong> All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> 1.0.0
    </div>
</footer>
</div>

</html>