<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Operational Hours - Trackingspace</title>
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

    .btn-update {
      background-color: #f8f9fa;
      border: 1px solid #dee2e6;
      color: #495057;
      padding: 6px 16px;
      border-radius: 6px;
      font-size: 14px;
    }

    .btn-update:hover {
      background-color: #e9ecef;
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
          <a href="{{ route('dashboard') }}" class="nav-link">
            <i class="fas fa-chart-line"></i> Dashboard
          </a>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="fas fa-users"></i> <span class="badge badge-danger">0</span> Active
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
              <a href="#" class="nav-link">
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
              <a href="{{ route('operational-hours.index') }}" class="nav-link active">
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
              <h1 class="m-0">Operational Hours</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Operational Hours</li>
              </ol>
            </div>
          </div>
        </div>
      </div>

      <section class="content">
        <div class="container-fluid">
          <div class="card">
            <div class="card-header">
              <div class="d-flex justify-content-between align-items-center">
                <h3 class="card-title font-weight-bold">Operational Hours</h3>
                <a href="{{ route('operational-hours.edit') }}" class="btn btn-update">
                  <i class="fas fa-edit"></i> Update All
                </a>
              </div>
            </div>
            <div class="card-body">
              @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                  {{ session('success') }}
                  <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
              @endif

              <p class="text-muted">Total {{ $operationalHours->count() }} items.</p>

              <div class="table-responsive">
                <table class="table table-hover">
                  <thead class="table-cyan">
                    <tr>
                      <th>DAY</th>
                      <th>OPEN TIME</th>
                      <th>CLOSE TIME</th>
                      <th class="text-center">ACTION</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($operationalHours as $hour)
                      <tr>
                        <td>{{ $hour->day }}</td>
                        <td>{{ $hour->is_closed ? 'Closed' : $hour->open_time }}</td>
                        <td>{{ $hour->is_closed ? 'Closed' : $hour->close_time }}</td>
                        <td class="text-center">
                          <a href="{{ route('operational-hours.edit') }}" class="text-info">
                            <i class="fas fa-edit"></i>
                          </a>
                        </td>
                      </tr>
                    @endforeach
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
</body>

</html>