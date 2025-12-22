<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Attendance - Trackingspace</title>

  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/css/adminlte.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body {
      font-family: 'Source Sans Pro', sans-serif;
      background-color: #f4f6f9;
    }

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
      border-bottom: 1px solid rgba(255, 255, 255, 0.1) !important;
      text-align: center;
      display: block !important;
      padding: 25px 10px !important;
    }

    .user-panel .image {
      display: inline-block;
      float: none !important;
      margin: 0 auto 15px;
    }

    .user-panel .image img {
      width: 80px;
      height: 80px;
      border: 3px solid rgba(255, 255, 255, 0.3);
    }

    .user-panel .info {
      display: block;
      padding: 0;
      margin: 0;
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

    .table-cyan th {
      color: #06b6d4 !important;
      font-weight: 600;
      text-transform: uppercase;
      font-size: 13px;
    }

    /* --- BUTTON STYLING --- */
    .btn-purple {
      background: linear-gradient(135deg, #6C3FB5 0%, #8B5FD6 100%);
      border: none;
      color: white !important;
      font-weight: 600;
      padding: 8px 25px;
      border-radius: 8px;
      transition: all 0.3s ease;
      box-shadow: 0 4px 6px rgba(108, 63, 181, 0.2);
    }

    .btn-purple:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 12px rgba(108, 63, 181, 0.3);
      background: linear-gradient(135deg, #5b349a 0%, #7a4fc2 100%);
      color: white;
    }

    .btn-reset {
      background-color: #f1f5f9;
      color: #64748b !important;
      border: 1px solid #e2e8f0;
      font-weight: 600;
      padding: 8px 25px;
      border-radius: 8px;
      transition: all 0.3s ease;
    }

    .btn-reset:hover {
      background-color: #e2e8f0;
      color: #475569 !important;
      transform: translateY(-2px);
    }

    .btn-print {
      font-weight: 600;
      padding: 8px 25px;
      border-radius: 8px;
      transition: all 0.3s ease;
      box-shadow: 0 4px 6px rgba(40, 167, 69, 0.1);
    }

    .btn-print:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 12px rgba(40, 167, 69, 0.2);
    }

    /* --- MODERN TABLE STYLING --- */
    .card-modern {
      border: none;
      border-radius: 15px;
      overflow: hidden;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05) !important;
    }

    .table {
      margin-bottom: 0;
    }

    /* Header Tabel Ungu Modern */
    .table-modern-header {
      background-color: #6C3FB5;
      color: white !important;
    }

    .table-modern-header th {
      border: none !important;
      text-transform: uppercase;
      font-size: 13px;
      font-weight: 600;
      letter-spacing: 1px;
      padding: 18px 15px !important;
    }

    .table td {
      border-color: #f1f1f1 !important;
      padding: 16px 15px !important;
      vertical-align: middle;
      color: #444;
    }

    .table-hover tbody tr:hover {
      background-color: #fcfaff;
      /* Highlight ungu sangat muda saat hover */
      transition: 0.2s;
    }

    /* Styling Nama Member */
    .member-name {
      color: #2D3748;
      font-weight: 700;
      font-size: 15px;
    }

    /* Durasi Box Modern */
    .duration-box {
      background: #f3effb;
      color: #6C3FB5 !important;
      padding: 4px 12px;
      border-radius: 8px;
      font-weight: 700;
      font-size: 13px;
      border: 1px solid #e2d5f5;
      display: inline-block;
    }

    /* Status Badges */
    .badge-modern {
      padding: 7px 14px;
      border-radius: 8px;
      font-weight: 600;
      font-size: 12px;
    }

    .badge-check-in {
      background-color: #e6fffa;
      color: #047857;
    }

    .badge-check-out {
      background-color: #ebf4ff;
      color: #1a56db;
    }

    /* Text Colors */
    .text-time-in {
      color: #10b981;
      font-weight: 700;
    }

    .text-time-out {
      color: #3b82f6;
      font-weight: 700;
    }

    .text-not-set {
      color: #9ca3af;
      font-style: italic;
      font-size: 13px;
    }

    /* Custom Scrollbar untuk Table Responsive */
    .table-responsive::-webkit-scrollbar {
      height: 6px;
    }

    .table-responsive::-webkit-scrollbar-thumb {
      background: #e2e8f0;
      border-radius: 10px;
    }
  </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <nav class="main-header navbar navbar-expand navbar-light no-print">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
      </ul>
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a href="{{ route('scan') }}" class="nav-link"><i class="fas fa-home"></i> Home</a>
        </li>
        <li class="nav-item">
          <a href="{{ route('dashboard') }}" class="nav-link"><i class="fas fa-chart-line"></i> Dashboard</a>
        </li>
        <li class="nav-item">
          <form action="{{ route('logout') }}" method="POST" class="m-0">
            @csrf
            <button type="submit" class="nav-link btn btn-link text-danger border-0">
              <i class="fas fa-sign-out-alt"></i> Logout (admin)
            </button>
          </form>
        </li>
      </ul>
    </nav>

    <!-- Sidebar -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <a href="{{ route('dashboard') }}" class="brand-link">
        <img src="https://adminlte.io/themes/v3/dist/img/AdminLTELogo.png" alt="Logo"
          class="brand-image img-circle elevation-3">
        <span class="brand-text">Trackingspace</span>
      </a>
      <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3">
          <div class="image">
            <img src="https://adminlte.io/themes/v3/dist/img/user2-160x160.jpg" class="img-circle elevation-2"
              alt="User">
          </div>
          <div class="info">
            <a href="#">admin</a>
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
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-tasks"></i>
                <p>Priority Task</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('attendance.index') }}" class="nav-link active">
                <i class="nav-icon fas fa-clock"></i>
                <p>Attendance</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route(name: 'data_member.index') }}" class="nav-link">
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

    <div class="content-wrapper">
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0 font-weight-bold">Attendance Management</h1>
            </div>
          </div>
        </div>
      </div>

      <section class="content">
        <div class="container-fluid">

          <div class="card no-print card-modern mb-4">
            <div class="card-body p-4">
              <form method="GET" action="{{ route('attendance.index') }}">
                <div class="row align-items-end">
                  <div class="col-md-3">
                    <label class="font-weight-bold small text-muted mb-2">TANGGAL MULAI</label>
                    <input type="date" class="form-control border-0 bg-light" name="start_date"
                      value="{{ $startDate }}">
                  </div>
                  <div class="col-md-3">
                    <label class="font-weight-bold small text-muted mb-2">TANGGAL SELESAI</label>
                    <input type="date" class="form-control border-0 bg-light" name="end_date" value="{{ $endDate }}">
                  </div>
                  <div class="col-md-6 d-flex gap-2">
                    <button type="submit" class="btn btn-purple">
                      <i class="fas fa-filter mr-2"></i> Filter
                    </button>

                    <a href="{{ route('attendance.index') }}" class="btn btn-reset">
                      <i class="fas fa-sync-alt mr-2"></i> Reset
                    </a>

                    <button type="button" class="btn btn-success btn-print shadow-sm ml-auto" onclick="window.print()">
                      <i class="fas fa-print mr-2"></i> Cetak Report
                    </button>
                  </div>
                </div>
              </form>
            </div>
          </div>

          <div class="card card-modern">
            <div class="card-body p-0">
              <div class="table-responsive">
                <table class="table table-hover">
                  <thead class="table-modern-header">
                    <tr>
                      <th class="pl-4">Nama Member</th>
                      <th>Tipe</th>
                      <th>Tanggal</th>
                      <th>Check In</th>
                      <th>Check Out</th>
                      <th>Durasi Kerja</th>
                      <th class="text-center">Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($attendances as $attendance)
                      <tr>
                        <td class="pl-4">
                          <div class="member-name">{{ $attendance->member->nama ?? '-' }}</div>
                          <small class="text-muted">ID: {{ $attendance->member->id ?? '-' }}</small>
                        </td>
                        <td>
                          @php
                            $type = $attendance->member->type ?? '-';
                            $badgeColor = match ($type) {
                              'Member' => 'bg-success text-white',
                              'Mentor' => 'bg-primary text-white',
                              'Oficial' => 'bg-warning text-dark',
                              default => 'bg-secondary text-white',
                            };
                          @endphp
                          <span class="badge {{ $badgeColor }} p-2" style="font-size: 0.85rem;">{{ $type }}</span>
                        </td>
                        <td>{{ \Carbon\Carbon::parse($attendance->tanggal)->format('d M Y') }}</td>
                        <td><span class="text-time-in"><i
                              class="far fa-clock mr-1"></i>{{ $attendance->waktu_masuk }}</span></td>
                        <td>
                          @if($attendance->waktu_keluar)
                            <span class="text-time-out"><i
                                class="far fa-clock mr-1"></i>{{ $attendance->waktu_keluar }}</span>
                          @else
                            <span class="text-not-set">Belum Keluar</span>
                          @endif
                        </td>
                        <td>
                          @if($attendance->formatted_durasi != '-')
                            <div class="duration-box">{{ $attendance->formatted_durasi }}</div>
                          @else
                            <span class="text-muted">—</span>
                          @endif
                        </td>
                        <td class="text-center">
                          @if($attendance->waktu_keluar)
                            <span class="badge-modern badge-check-out"><i class="fas fa-check-circle mr-1"></i>
                              Selesai</span>
                          @else
                            <span class="badge-modern badge-check-in"><i class="fas fa-spinner fa-spin mr-1"></i>
                              Aktif</span>
                          @endif
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>

          <div class="mt-4 d-flex justify-content-between align-items-center">
            <div class="text-muted small">Menampilkan {{ $attendances->count() }} data dari total
              {{ $attendances->total() }}
            </div>
            <div>{{ $attendances->links('pagination::bootstrap-4') }}</div>
          </div>
        </div>
      </section>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/js/adminlte.min.js"></script>
</body>

</html>