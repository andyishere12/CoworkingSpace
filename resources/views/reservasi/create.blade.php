<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Buat Reservasi - Trackingspace</title>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/css/adminlte.min.css">
    <link rel="stylesheet" href="{{ asset('css/stylecreate.css') }}">

    <style>
        /* Sidebar custom dari index */
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

        /* Style notifikasi (dipertahankan dari create asli) */
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
            cursor: pointer;
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

        /* Form validation styles */
        .form-control.is-invalid {
            border-color: #dc3545;
        }

        .invalid-feedback {
            display: block;
            color: #dc3545;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            padding: 10px 20px;
            font-size: 16px;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
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
                        <img
                            src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'Admin') }}&size=80&background=6C3FB5&color=fff"
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
                            <a href="{{ route('data_member.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-users"></i>
                                <p>Members</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('reservasi.index') }}" class="nav-link active">
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
                            <h1 class="m-0">Buat Reservasi</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('reservasi.index') }}">Reservasi</a></li>
                                <li class="breadcrumb-item active">Create</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">
                    <div class="p-3">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                {{-- FORM CREATE (dipertahankan utuh dari create.asli) --}}
                                <form action="{{ route('reservasi.store') }}" method="POST" id="reservasiForm">
                                    @csrf

                                    <div class="row">
                                        {{-- Kolom Kiri --}}
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="nama_pemesanan">Nama Pemesanan <span class="text-danger">*</span></label>
                                                <input 
                                                    type="text" 
                                                    class="form-control @error('nama_pemesanan') is-invalid @enderror" 
                                                    id="nama_pemesanan" 
                                                    name="nama_pemesanan" 
                                                    value="{{ old('nama_pemesanan') }}"
                                                    required>
                                                @error('nama_pemesanan')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="kontak">Kontak <span class="text-danger">*</span></label>
                                                <input 
                                                    type="text" 
                                                    class="form-control @error('kontak') is-invalid @enderror" 
                                                    id="kontak" 
                                                    name="kontak" 
                                                    value="{{ old('kontak') }}"
                                                    placeholder="Contoh: 08123456789"
                                                    required>
                                                @error('kontak')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="institusi">Institusi <span class="text-danger">*</span></label>
                                                <input 
                                                    type="text" 
                                                    class="form-control @error('institusi') is-invalid @enderror" 
                                                    id="institusi" 
                                                    name="institusi" 
                                                    value="{{ old('institusi') }}"
                                                    required>
                                                @error('institusi')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        {{-- Kolom Kanan --}}
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="ruangan">Room <span class="text-danger">*</span></label>
                                                <select 
                                                    class="form-control @error('ruangan') is-invalid @enderror" 
                                                    id="ruangan" 
                                                    name="ruangan" 
                                                    required>
                                                    <option value="" disabled {{ old('ruangan') ? '' : 'selected' }}>Pilih Room</option>
                                                    <option value="Room A" {{ old('ruangan') == 'Room A' ? 'selected' : '' }}>Room A</option>
                                                    <option value="Room B" {{ old('ruangan') == 'Room B' ? 'selected' : '' }}>Room B</option>
                                                    <option value="Room C" {{ old('ruangan') == 'Room C' ? 'selected' : '' }}>Room C</option>
                                                    <option value="Room D" {{ old('ruangan') == 'Room D' ? 'selected' : '' }}>Room D</option>
                                                </select>
                                                @error('ruangan')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="purpose">Purpose <span class="text-danger">*</span></label>
                                                <input 
                                                    type="text" 
                                                    class="form-control @error('purpose') is-invalid @enderror" 
                                                    id="purpose" 
                                                    name="purpose" 
                                                    value="{{ old('purpose') }}"
                                                    required>
                                                @error('purpose')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="attends">Attends <span class="text-danger">*</span></label>
                                                <input 
                                                    type="number" 
                                                    class="form-control @error('attends') is-invalid @enderror" 
                                                    id="attends" 
                                                    name="attends" 
                                                    min="1" 
                                                    value="{{ old('attends', 1) }}"
                                                    required>
                                                @error('attends')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Description Row - Full Width --}}
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="description">Description</label>
                                                <textarea 
                                                    class="form-control @error('description') is-invalid @enderror" 
                                                    id="description" 
                                                    name="description" 
                                                    rows="3">{{ old('description') }}</textarea>
                                                @error('description')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Date Row --}}
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="tanggal">Date <span class="text-danger">*</span></label>
                                                <input 
                                                    type="date" 
                                                    class="form-control @error('tanggal') is-invalid @enderror" 
                                                    id="tanggal" 
                                                    name="tanggal" 
                                                    value="{{ old('tanggal') }}"
                                                    min="{{ date('Y-m-d') }}"
                                                    required>
                                                @error('tanggal')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Start and End Time Row --}}
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="waktu_mulai">Start Time <span class="text-danger">*</span></label>
                                                <input 
                                                    type="time" 
                                                    class="form-control @error('waktu_mulai') is-invalid @enderror" 
                                                    id="waktu_mulai" 
                                                    name="waktu_mulai" 
                                                    value="{{ old('waktu_mulai') }}"
                                                    required>
                                                @error('waktu_mulai')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="waktu_selesai">End Time <span class="text-danger">*</span></label>
                                                <input 
                                                    type="time" 
                                                    class="form-control @error('waktu_selesai') is-invalid @enderror" 
                                                    id="waktu_selesai" 
                                                    name="waktu_selesai" 
                                                    value="{{ old('waktu_selesai') }}"
                                                    required>
                                                @error('waktu_selesai')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Status Row --}}
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="status">Status <span class="text-danger">*</span></label>
                                                <select 
                                                    class="form-control @error('status') is-invalid @enderror" 
                                                    id="status" 
                                                    name="status" 
                                                    required>
                                                    <option value="Pending" {{ old('status', 'Pending') == 'Pending' ? 'selected' : '' }}>Pending</option>
                                                    <option value="Approved" {{ old('status') == 'Approved' ? 'selected' : '' }}>Approved</option>
                                                    <option value="Rejected" {{ old('status') == 'Rejected' ? 'selected' : '' }}>Rejected</option>
                                                </select>
                                                @error('status')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Tombol Submit --}}
                                    <div class="mt-3">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save"></i> Buat Reservasi
                                        </button>
                                        <a href="{{ route('reservasi.index') }}" class="btn btn-secondary">
                                            <i class="fas fa-times"></i> Batal
                                        </a>
                                    </div>
                                </form>
                            </div>
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

    {{-- Notification Container & Script (dipertahankan dari create.asli) --}}
    <div class="notification-container" id="notificationContainer"></div>

    <div id="flash-messages"
        data-success="{{ session('success') }}"
        data-error="{{ session('error') }}"
        data-warning="{{ session('warning') }}"
        data-validation-errors="{{ $errors->any() ? implode('|', $errors->all()) : '' }}">
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/js/adminlte.min.js"></script>

    <script>
        // Fungsi notifikasi (lengkap, dari create.asli)
        function showNotification(message, type = 'success') {
            const container = document.getElementById('notificationContainer');
            if (!container) return;

            const notification = document.createElement('div');
            notification.className = `notification ${type}`;
            notification.innerHTML = `
                <div style="flex: 1;">
                    <div style="display: flex; align-items: center; gap: 6px; margin-bottom: 4px;">
                        <strong>${type === 'success' ? 'Berhasil!' : type === 'error' ? 'Error!' : 'Perhatian!'}</strong>
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

        // Validasi waktu mulai dan selesai
        function validateTime() {
            const waktuMulai = document.getElementById('waktu_mulai').value;
            const waktuSelesai = document.getElementById('waktu_selesai').value;

            if (waktuMulai && waktuSelesai) {
                if (waktuSelesai <= waktuMulai) {
                    showNotification('Waktu selesai harus lebih besar dari waktu mulai!', 'error');
                    document.getElementById('waktu_selesai').value = '';
                    return false;
                }
            }
            return true;
        }

        // Event listeners
        document.addEventListener('DOMContentLoaded', function() {
            const flashMessages = document.getElementById('flash-messages');
            
            if (flashMessages) {
                const successMessage = flashMessages.dataset.success;
                const errorMessage = flashMessages.dataset.error;
                const warningMessage = flashMessages.dataset.warning;
                const validationErrorsString = flashMessages.dataset.validationErrors;

                if (successMessage) {
                    showNotification(successMessage, 'success');
                }
                
                if (errorMessage) {
                    showNotification(errorMessage, 'error');
                }

                if (warningMessage) {
                    showNotification(warningMessage, 'warning');
                }
                
                if (validationErrorsString) {
                    const errors = validationErrorsString.split('|');
                    errors.forEach(error => {
                        if (error.trim()) {
                            showNotification(error, 'error');
                        }
                    });
                }
            }

            // Validasi waktu
            const waktuSelesaiInput = document.getElementById('waktu_selesai');
            if (waktuSelesaiInput) {
                waktuSelesaiInput.addEventListener('change', validateTime);
            }

            // Form validation before submit
            const form = document.getElementById('reservasiForm');
            if (form) {
                form.addEventListener('submit', function(e) {
                    if (!validateTime()) {
                        e.preventDefault();
                        return false;
                    }
                });
            }
        });
    </script>
</body>

</html>