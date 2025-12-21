<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard - Trackingspace</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
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
      border-bottom: 1px solid rgba(255,255,255,0.1) !important;
      padding: 20px 15px;
    }
    .brand-link .brand-text {
      color: white !important;
      font-weight: 600;
      font-size: 20px;
    }
    .user-panel {
      border-bottom: 1px solid rgba(255,255,255,0.1) !important;
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
      border: 3px solid rgba(255,255,255,0.3);
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
    .sidebar-dark-primary .nav-sidebar > .nav-item > .nav-link {
      color: rgba(255,255,255,0.8);
      padding: 12px 15px;
      margin: 4px 10px;
      border-radius: 8px;
    }
    .sidebar-dark-primary .nav-sidebar > .nav-item > .nav-link:hover {
      background-color: rgba(255,255,255,0.1);
      color: white;
    }
    .sidebar-dark-primary .nav-sidebar > .nav-item > .nav-link.active {
      background-color: rgba(255,255,255,0.15);
      color: white;
    }
    .stat-card {
      border-radius: 15px;
      padding: 25px;
      color: white;
      position: relative;
      overflow: hidden;
      box-shadow: 0 4px 15px rgba(0,0,0,0.1);
      transition: transform 0.3s ease;
    }
    .stat-card:hover {
      transform: translateY(-5px);
    }
    .stat-card .stat-icon {
      position: absolute;
      right: 20px;
      top: 50%;
      transform: translateY(-50%);
      font-size: 60px;
      opacity: 0.3;
    }
    .stat-card h3 {
      font-size: 36px;
      font-weight: 700;
      margin-bottom: 5px;
    }
    .stat-card p {
      font-size: 14px;
      opacity: 0.9;
      margin-bottom: 0;
    }
    .stat-card small {
      font-size: 12px;
      opacity: 0.8;
    }
    .bg-cyan {
      background: linear-gradient(135deg, #00BCD4 0%, #00ACC1 100%);
    }
    .bg-lime {
      background: linear-gradient(135deg, #8BC34A 0%, #7CB342 100%);
    }
    .bg-orange-gradient {
      background: linear-gradient(135deg, #FF9800 0%, #FF6F00 100%);
    }
    .bg-red-gradient {
      background: linear-gradient(135deg, #F44336 0%, #D32F2F 100%);
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
          <a href="{{ route('dashboard') }}" class="nav-link active">
            <i class="fas fa-chart-line"></i> Dashboard
          </a>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="fas fa-users"></i> <span class="badge badge-danger">0</span> Active
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
        <img src="https://adminlte.io/themes/v3/dist/img/AdminLTELogo.png" alt="Logo" class="brand-image img-circle elevation-3">
        <span class="brand-text">Trackingspace</span>
      </a>
      <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3">
          <div class="image">
            <img src="https://adminlte.io/themes/v3/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User">
          </div>
          <div class="info">
            <a href="#">admin</a>
          </div>
        </div>
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
            <li class="nav-item">
              <a href="{{ route('dashboard') }}" class="nav-link active">
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
              <h1 class="m-0">Dashboard</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
              </ol>
            </div>
          </div>
        </div>
      </div>

      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-lg-3 col-6">
              <div class="stat-card bg-cyan">
                <div class="stat-icon">
                  <i class="fas fa-users"></i>
                </div>
                <div>
                  <h3>150</h3>
                  <p>Members</p>
                  <small>Total Registered</small>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-6">
              <div class="stat-card bg-lime">
                <div class="stat-icon">
                  <i class="fas fa-bookmark"></i>
                </div>
                <div>
                  <h3>53</h3>
                  <p>Reservations</p>
                  <small>This Month</small>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-6">
              <div class="stat-card bg-orange-gradient">
                <div class="stat-icon">
                  <i class="fas fa-door-open"></i>
                </div>
                <div>
                  <h3>44</h3>
                  <p>Rooms</p>
                  <small>Available</small>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-6">
              <div class="stat-card bg-red-gradient">
                <div class="stat-icon">
                  <i class="fas fa-calendar"></i>
                </div>
                <div>
                  <h3>65</h3>
                  <p>Events</p>
                  <small>Upcoming</small>
                </div>
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
