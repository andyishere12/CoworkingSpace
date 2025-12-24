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
  <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> -->
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
            <button type="button" class="btn btn-success btn-print shadow-sm ml" onclick="window.print()">
              <i class="fas fa-print mr-2"></i> Cetak Room
            </button>
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
                      <tr data-id="{{ $room->id }}" data-name="{{ $room->name }}" data-capacity="{{ $room->capacity }}"
                        data-type="{{ $room->type }}" data-status="{{ $room->status }}">
                        <td>{{ $room->id ?? 'N/A' }}</td>
                        <td>{{ $room->name ?? 'N/A' }}</td>
                        <td>{{ $room->capacity ?? 'N/A' }}</td>
                        <td>{{ $room->type ?? 'N/A' }}</td>
                        <td>{{ $room->description ?? 'N/A' }}</td>
                        <td>
                          <span class="badge badge-success px-2 py-1">
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

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.0/js/bootstrap.bundle.min.js"></script> -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/js/adminlte.min.js"></script>
  <script src="bootstrap/4.6.0/js/bootstrap.bundle.min.js"></script>

</body>

</html>