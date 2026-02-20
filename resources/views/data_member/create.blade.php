<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create Member - Trackingspace</title>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/css/adminlte.min.css">
    <link rel="stylesheet" href="{{ asset('css/stylecreate.css') }}">

    <style>
        /* Sidebar custom dari index */
        .main-sidebar {
            background: linear-gradient(180deg, #6C3FB5 0%, #8B5FD6 100%) !important;
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
            margin: 0 0 10px 0 !important;
            padding: 0 !important;
        }

        .user-panel .image img {
            width: 80px;
            height: 80px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            display: block;
            margin: 0 auto;
        }

        .user-panel .info {
            display: block !important;
            width: 100% !important;
            padding: 0 !important;
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

        /* Style notifikasi (dipertahankan dari create/edit asli) */
        .notification-container {
            position: fixed;
            top: 70px;
            right: 20px;
            z-index: 99999;
            max-width: 350px;
        }

        .notification {
            background: white;
            border-radius: 10px;
            padding: 15px 20px;
            margin-bottom: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            border-left: 5px solid;
            animation: slideIn 0.5s ease, fadeOut 0.5s ease 4.5s forwards;
            position: relative;
            overflow: hidden;
        }

        .notification::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            height: 4px;
            background: currentColor;
            width: 100%;
            animation: progress 5s linear forwards;
        }

        .notification.success {
            border-left-color: #28a745;
            color: #155724;
            background-color: #d4edda;
        }

        .notification.error {
            border-left-color: #dc3545;
            color: #721c24;
            background-color: #f8d7da;
        }

        .notification.warning {
            border-left-color: #ffc107;
            color: #856404;
            background-color: #fff3cd;
        }

        .notification.info {
            border-left-color: #17a2b8;
            color: #0c5460;
            background-color: #d1ecf1;
        }

        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes fadeOut {
            from {
                transform: translateX(0);
                opacity: 1;
            }
            to {
                transform: translateX(100%);
                opacity: 0;
            }
        }

        @keyframes progress {
            from {
                width: 100%;
            }
            to {
                width: 0%;
            }
        }
    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Navbar (salin dari index) -->
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
                    <a href="{{ route('dashboard') }}" class="nav-link">
                        <i class="fas fa-chart-line"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-users"></i> <span class="badge badge-danger">0</span> Active Today
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

        <!-- Sidebar (salin dari index) -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <a href="{{ route('dashboard') }}" class="brand-link">
                <img src="{{ asset('gambar/icontrasa.jpeg') }}" alt="Logo" class="brand-image img-circle elevation-3">
                <span class="brand-text">Trackingspace</span>
            </a>
            <div class="sidebar">
                <div class="user-panel mt-3 pb-3 mb-3">
                    <div class="image">
                        @if(Auth::user()->avatar)
                        <img src="{{ asset('storage/avatars/' . Auth::user()->avatar) }}" class="img-circle elevation-2"
                            alt="{{ Auth::user()->name }}">
                        @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'Admin') }}&size=80&background=6C3FB5&color=fff"
                            class="img-circle elevation-2" alt="User Image">
                        @endif
                    </div>
                    <div class="info">
                        <a href="#" class="d-block text-white font-weight-bold">
                            {{ Auth::user()->name ?? 'Admin' }}
                        </a>
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
                        <li class="nav-item">
                            <a href="{{ route('attendance.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-clock"></i>
                                <p>Attendance</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('data_member.index') }}" class="nav-link active">
                                <i class="nav-icon fas fa-users"></i>
                                <p>Members</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('reservasi.index') }}" class="nav-link">
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
                            <a href="{{ route('profile.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-user"></i>
                                <p>Profile</p>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>

        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Create Member</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('data_member.index') }}">Members</a></li>
                                <li class="breadcrumb-item active">Create</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <form action="{{ route('data_member.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="row">
                                    {{-- Kolom Kiri (Photo) --}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="photo">Photo</label>
                                            <div class="d-flex align-items-center mb-2">
                                                <div class="custom-file mr-3" style="width: 200px;">
                                                    <input accept="image/*" type="file" class="custom-file-input" id="photo" name="foto">
                                                    <label class="custom-file-label" for="photo">Choose File</label>
                                                </div>
                                                <small class="text-muted">No file chosen</small>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Kolom Kanan (Informasi Dasar) --}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">Name</label>
                                            <input type="text" class="form-control" id="name" name="nama" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="birth_date">Birth Date</label>
                                            <div class="input-group">
                                                <input type="date" class="form-control" id="birth_date" name="tanggal_lahir"
                                                    placeholder="mm/dd/yyyy">
                                                <div class="input-group-append">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    {{-- Kolom Kiri Bawah --}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="address">Alamat</label>
                                            <textarea class="form-control" id="address" name="alamat" rows="5"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="email" class="form-control" id="email" name="email" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="phone">Nomor Hp</label>
                                            <input type="tel" class="form-control" id="phone" name="no_hp">
                                        </div>
                                    </div>

                                    {{-- Kolom Kanan Bawah --}}
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label for="activity_type">Activity Type</label>
                                            <select class="form-control" id="activity_type" name="aktivitas" required>
                                                <option value="" disabled selected>Pilih Tipe Aktivitas</option>
                                                <option value="Business">Business</option>
                                                <option value="Student">Worker</option>
                                                <option value="Freelancer">Freelancer</option>
                                                <option value="Worker">Comunity</option>
                                                <option value="Other">Student</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="institution">Institution</label>
                                            <input type="text" class="form-control" id="institution" name="institusi">
                                        </div>
                                        <div class="form-group">
                                            <label for="type">Type</label>
                                            <select class="form-control" id="type" name="type" required>
                                                <option value="" disabled selected>Pilih Tipe</option>
                                                <option value="Member">Member</option>
                                                <option value="Mentor">Mentor</option>
                                                <option value="Oficial">Oficial</option>
                                                <option value="Tegal Greate Seal">Tegal Greate Seal</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="status">Status</label>
                                            <select class="form-control" id="status" name="status" required>
                                                <option value="" disabled selected>Pilih Tipe</option>
                                                <option value="Aktive">Aktive</option>
                                                <option value="Inactive">Inactive</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary mt-3">Tambah Member</button>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <footer class="main-footer">
            <strong>Copyright &copy; 2025 <a href="#">Trackingspace</a>.</strong> All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 1.0.0
            </div>
        </footer>
    </div>

    <!-- Notification Container -->
    <div class="notification-container" id="notificationContainer"></div>
    <div class="notification-container" id="notificationContainer" data-success-message="{{ session('success') }}" data-error-message="{{ $errors->first() }}"></div>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/js/adminlte.min.js"></script>

    <script>
        // Custom file input - menampilkan nama file
        document.querySelector('.custom-file-input').addEventListener('change', function(e) {
            var fileName = e.target.files[0].name;
            e.target.nextElementSibling.innerText = fileName;
        });

        // Fungsi notifikasi (dipertahankan utuh)
        function showNotification(message, type = 'success') {
            const container = document.getElementById('notificationContainer');
            if (!container) return;

            const notification = document.createElement('div');
            notification.className = `notification ${type}`;
            notification.innerHTML = `
                <div style="flex: 1;">
                    <div style="display: flex; align-items: center; gap: 6px; margin-bottom: 4px;">
                        <strong>${type === 'success' ? 'Berhasil!' : 'Perhatian!'}</strong>
                    </div>
                    <div style="margin: 0;">${message}</div>
                </div>
            `;

            container.appendChild(notification);

            setTimeout(() => {
                if (notification.parentNode) {
                    notification.style.animation = 'fadeOut 0.5s ease forwards';
                    setTimeout(() => notification.remove(), 500);
                }
            }, 5000);

            notification.addEventListener('click', () => {
                notification.style.animation = 'fadeOut 0.5s ease forwards';
                setTimeout(() => notification.remove(), 500);
            });
        }

        // Notifikasi dari session
        $(document).ready(function() {
            const successMessage = $('#notificationContainer').data('success-message');
            const errorMessage = $('#notificationContainer').data('error-message');

            if (successMessage) {
                showNotification(successMessage, 'success');
            }
            if (errorMessage) {
                showNotification(errorMessage, 'error');
            }
        });
    </script>
</body>

</html>