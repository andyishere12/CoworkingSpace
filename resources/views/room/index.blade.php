<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Room - Trackingspace</title>
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/css/adminlte.min.css">
  <link rel="stylesheet" href="{{ asset('css/stylemodal.css') }}">
  <link rel="stylesheet" href="adminlte.min.css">

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

    .nav-icon-box {
      width: 30px;
      height: 30px;
      background-color: rgba(255, 255, 255, 0.2);
      border-radius: 6px;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-right: 10px;
    }

    .btn-gap {
      display: flex;
      gap: 8px;
    }

    /* Style untuk notifikasi pop-up - konsisten dengan reservasi */
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
            <i class="fas fa-users"></i> <span class="badge badge-danger">{{ $todayAttendance ?? 0 }}</span> Active Today
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

    <!-- Sidebar -->
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
              <a href="{{ route('reservasi.index') }}" class="nav-link">
                <i class="nav-icon fas fa-bookmark"></i>
                <p>Reservations</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('room.index') }}" class="nav-link active">
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
              <h1 class="m-0">Room</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Room</li>
              </ol>
            </div>
          </div>
        </div>
      </div>

      <section class="content">
        <div class="container-fluid">

          {{-- Tombol aksi --}}
          <div class="d-flex gap-2 mb-3">
            <a href="{{ route('room.create') }}" class="btn btn-info mr-2">
              <i class="fas fa-plus mr-1"></i> Create Room
            </a>
            <button type="button" class="btn btn-success btn-print shadow-sm mr-2" onclick="window.print()">
              <i class="fas fa-print mr-2"></i> Cetak Room
            </button>

            <!-- Export icons: Excel and PDF -->
            <a href="{{ route('room.export.excel') }}" class="btn btn-success btn-sm" title="Export Excel" aria-label="Export Excel" style="padding:8px 10px;">
              <i class="fas fa-file-excel"></i>
            </a>
            <a href="{{ route('room.export.pdf') }}" class="btn btn-danger btn-sm ml-2" title="Export PDF" aria-label="Export PDF" style="padding:8px 10px;">
              <i class="fas fa-file-pdf"></i>
            </a>
          </div>

          {{-- Card tabel --}}
          <div class="card shadow-sm">
            <div class="card-body">
              <p class="text-muted mb-3">
                Menampilkan {{ count($allrooms ?? []) }} item
              </p>

              <div class="table-responsive">
                <table class="table table-hover" style="width: 100%;">
                  <thead class="table-cyan">
                    <tr>
                      <th style="width: 5%;">ID</th>
                      <th style="width: 20%;">Room Name</th>
                      <th style="width: 10%;">Capacity</th>
                      <th style="width: 15%;">Room Type</th>
                      <th style="width: 18%;">Description</th>
                      <th style="width: 10%;">Status</th>
                      <th style="width: 15%;" class="text-center">Actions</th>
                    </tr>
                  </thead>

                  <tbody>
                    @forelse ($allrooms as $room)
                    <tr>
                      <td>{{ $room->id ?? 'N/A' }}</td>
                      <td>{{ $room->name ?? 'N/A' }}</td>
                      <td>{{ $room->capacity ?? 'N/A' }}</td>
                      <td>{{ $room->type ?? 'N/A' }}</td>
                      <td>{{ $room->description ?? 'N/A' }}</td>
                      <td>
                        <span class="badge px-2 py-1 
                          @if($room->status == 'available') badge-success
                          @elseif($room->status == 'unavailable') badge-warning
                          @elseif($room->status == 'maintenance') badge-danger
                          @else badge-secondary @endif">
                          {{ $room->status ?? 'N/A' }}
                        </span>
                      </td>
                      <td>
                        <div class="btn-gap justify-content-center">
                          {{-- Show --}}
                          <a href="{{ route('room.show', $room->id) }}" class="btn btn-sm btn-info">
                            Show
                          </a>
                          {{-- Edit --}}
                          <a href="{{ route('room.edit', $room->id) }}" class="btn btn-sm btn-warning">
                            Edit
                          </a>
                          {{-- Hapus --}}
                          <form action="{{ route('room.destroy', $room->id) }}" method="POST"
                            onsubmit="return confirm('Hapus data?')" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" type="submit">
                              Hapus
                            </button>
                          </form>
                        </div>
                      </td>
                    </tr>
                    @empty
                    <tr>
                      <td colspan="7" class="text-center">
                        Tidak ada data room.
                      </td>
                    </tr>
                    @endforelse
                  </tbody>
                </table>
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

  {{-- Container untuk notifikasi pop-up --}}
  <div class="notification-container" id="notificationContainer" data-success-message="{{ session('success') }}"></div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/js/adminlte.min.js"></script>
  <script src="bootstrap/4.6.0/js/bootstrap.bundle.min.js"></script>

  <script>
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

    $(document).ready(function() {
      const successMessage = $('#notificationContainer').data('success-message');
      if (successMessage) {
        showNotification(successMessage, 'success');
      }
    });
  </script>
</body>

</html>