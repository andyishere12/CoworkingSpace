<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Laporan Event - Trackingspace</title>
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/css/adminlte.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css">

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

    .stat-card {
      border-radius: 10px;
      padding: 20px;
      color: white;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
      margin-bottom: 20px;
    }

    .stat-card h3 {
      font-size: 32px;
      font-weight: 700;
      margin-bottom: 5px;
    }

    .stat-card p {
      font-size: 14px;
      opacity: 0.9;
      margin-bottom: 0;
    }

    .stat-card i {
      font-size: 36px;
      opacity: 0.5;
    }

    .bg-cyan {
      background: linear-gradient(135deg, #00BCD4 0%, #00ACC1 100%);
    }

    .bg-lime {
      background: linear-gradient(135deg, #8BC34A 0%, #7CB342 100%);
    }

    .bg-orange {
      background: linear-gradient(135deg, #FF9800 0%, #FF6F00 100%);
    }

    .bg-red {
      background: linear-gradient(135deg, #F44336 0%, #D32F2F 100%);
    }

    .bg-purple {
      background: linear-gradient(135deg, #9C27B0 0%, #7B1FA2 100%);
    }

    .bg-indigo {
      background: linear-gradient(135deg, #3F51B5 0%, #303F9F 100%);
    }

    .bg-teal {
      background: linear-gradient(135deg, #009688 0%, #00796B 100%);
    }

    .table-cyan th {
      color: #06b6d4 !important;
      font-weight: 600;
      text-transform: uppercase;
      font-size: 13px;
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
          <a href="{{ route('dashboard') }}" class="nav-link">
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
            <i class="fas fa-users"></i> <span class="badge badge-danger">9</span> Active
          </a>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="fas fa-sign-out-alt"></i> Logout (admin)
          </a>
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
              <a href="{{ route('reports.index') }}" class="nav-link active">
                <i class="nav-icon fas fa-chart-bar"></i>
                <p>Reports</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
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
              <h1 class="m-0">Laporan Event</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('reports.index') }}">Laporan</a></li>
                <li class="breadcrumb-item active">Event</li>
              </ol>
            </div>
          </div>
        </div>
      </div>

      <section class="content">
        <div class="container-fluid">
          <!-- Filter Card -->
          <div class="card mb-4">
            <div class="card-body">
              <form action="{{ route('reports.event') }}" method="GET">
                <div class="row">
                  <div class="col-md-3">
                    <div class="form-group">
                      <label>Tanggal Mulai</label>
                      <input type="date" name="start_date" class="form-control" value="{{ $startDate }}">
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label>Tanggal Akhir</label>
                      <input type="date" name="end_date" class="form-control" value="{{ $endDate }}">
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <label>Status</label>
                      <select name="status" class="form-control">
                        <option value="all" {{ $status == 'all' ? 'selected' : '' }}>Semua</option>
                        <option value="active" {{ $status == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ $status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>&nbsp;</label>
                      <div>
                        <button type="submit" class="btn btn-primary mr-2">
                          <i class="fas fa-filter"></i> Filter
                        </button>
                        <a href="{{ route('reports.event') }}" class="btn btn-secondary">
                          <i class="fas fa-redo"></i> Reset
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
              </form>
              <div class="mt-2">
                <button type="button" class="btn btn-success btn-print shadow-sm ml-auto" onclick="window.print()">
                  <i class="fas fa-print mr-2"></i> Cetak Report
                </button>
              </div>
            </div>
          </div>

          <!-- Statistics Cards Row 1 -->
          <div class="row">
            <div class="col-lg-3 col-md-6">
              <div class="stat-card bg-cyan">
                <div class="d-flex justify-content-between align-items-center">
                  <div>
                    <h3>{{ $statistics['total_events'] }}</h3>
                    <p>Total Events (Filtered)</p>
                  </div>
                  <i class="fas fa-calendar-alt"></i>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6">
              <div class="stat-card bg-lime">
                <div class="d-flex justify-content-between align-items-center">
                  <div>
                    <h3>{{ $statistics['active_events'] }}</h3>
                    <p>Active Events</p>
                  </div>
                  <i class="fas fa-check-circle"></i>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6">
              <div class="stat-card bg-red">
                <div class="d-flex justify-content-between align-items-center">
                  <div>
                    <h3>{{ $statistics['inactive_events'] }}</h3>
                    <p>Inactive Events</p>
                  </div>
                  <i class="fas fa-times-circle"></i>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6">
              <div class="stat-card bg-indigo">
                <div class="d-flex justify-content-between align-items-center">
                  <div>
                    <h3>{{ $statistics['all_events_total'] }}</h3>
                    <p>All Events (Total)</p>
                  </div>
                  <i class="fas fa-list"></i>
                </div>
              </div>
            </div>
          </div>

          <!-- Statistics Cards Row 2 -->
          <div class="row">
            <div class="col-lg-4 col-md-6">
              <div class="stat-card bg-purple">
                <div class="d-flex justify-content-between align-items-center">
                  <div>
                    <h3>{{ $statistics['upcoming_events'] }}</h3>
                    <p>Upcoming Events</p>
                  </div>
                  <i class="fas fa-clock"></i>
                </div>
              </div>
            </div>
            <div class="col-lg-4 col-md-6">
              <div class="stat-card bg-orange">
                <div class="d-flex justify-content-between align-items-center">
                  <div>
                    <h3>{{ $statistics['ongoing_events'] }}</h3>
                    <p>Ongoing Events</p>
                  </div>
                  <i class="fas fa-spinner"></i>
                </div>
              </div>
            </div>
            <div class="col-lg-4 col-md-6">
              <div class="stat-card bg-teal">
                <div class="d-flex justify-content-between align-items-center">
                  <div>
                    <h3>{{ $statistics['completed_events'] }}</h3>
                    <p>Completed Events</p>
                  </div>
                  <i class="fas fa-check-double"></i>
                </div>
              </div>
            </div>
          </div>

          <!-- Data Table -->
          <div class="card mt-4">
            <div class="card-header">
              <h3 class="card-title font-weight-bold">Detail Event</h3>
            </div>
            <div class="card-body">
              <p class="text-muted">Total {{ count($eventData) }} items.</p>
              <div class="table-responsive">
                <table id="eventTable" class="table table-hover">
                  <thead class="table-cyan">
                    <tr>
                      <th>No</th>
                      <th>Title</th>
                      <th>Description</th>
                      <th>Start Date</th>
                      <th>End Date</th>
                      <th>Duration</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    @php $no = 1; @endphp
                    @forelse($eventData as $event)
                      <tr>
                        <td>{{ $no++ }}</td>
                        <td><strong>{{ $event->title }}</strong></td>
                        <td>{{ Str::limit($event->description, 50) }}</td>
                        <td>{{ \Carbon\Carbon::parse($event->start_date)->format('d M Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($event->end_date)->format('d M Y') }}</td>
                        <td>
                          <span class="badge badge-info">
                            {{ \Carbon\Carbon::parse($event->start_date)->diffInDays(\Carbon\Carbon::parse($event->end_date)) + 1 }}
                            hari
                          </span>
                        </td>
                        <td>
                          @if($event->status == 'active')
                            <span class="badge badge-success">Active</span>
                          @else
                            <span class="badge badge-secondary">Inactive</span>
                          @endif
                        </td>
                      </tr>
                    @empty
                      <tr>
                        <td colspan="7" class="text-center">Tidak ada data event</td>
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
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.0/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/js/adminlte.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>

  <script>
    $(document).ready(function () {
      $('#eventTable').DataTable({
        "language": {
          "url": "//cdn.datatables.net/plug-ins/1.13.4/i18n/id.json"
        }
      });
    });
  </script>
</body>

</html>