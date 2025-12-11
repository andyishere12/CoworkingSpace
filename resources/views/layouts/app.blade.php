<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Trackingspace - Dashboard Admin</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome-free/5.15.4/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/css/adminlte.min.css">
  
  <style>
    body {
      font-family: 'Source Sans Pro', sans-serif;
      background-color: #f4f6f9;
    }

    /* Sidebar styling */
    .main-sidebar {
      background: linear-gradient(180deg, #6C3FB5 0%, #8B5FD6 100%) !important;
    }

    .brand-link {
      background: transparent !important;
      border-bottom: 1px solid rgba(255,255,255,0.1) !important;
      padding: 20px 15px;
    }

    .brand-link .brand-image {
      width: 40px;
      height: 40px;
    }

    .brand-link .brand-text {
      color: white !important;
      font-weight: 600;
      font-size: 20px;
    }

    /* User panel centered */
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

    /* Sidebar menu */
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

    .sidebar-dark-primary .nav-sidebar .nav-icon {
      color: rgba(255,255,255,0.9);
      margin-right: 10px;
    }

    /* Top navbar */
    .main-header {
      background: white;
      border-bottom: 1px solid #e3e6f0;
    }

    .navbar-light .navbar-nav .nav-link {
      color: #5a5c69;
      font-weight: 500;
      padding: 8px 12px;
      margin: 0 3px;
      border-radius: 8px;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .navbar-light .navbar-nav .nav-link:hover {
      background-color: #f8f9fc;
    }

    .navbar-light .navbar-nav .nav-link.active {
      background-color: #6C3FB5;
      color: white !important;
    }

    .nav-icon-box {
      width: 32px;
      height: 32px;
      background-color: rgba(108, 63, 181, 0.1);
      border-radius: 6px;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
    }

    .nav-icon-box i {
      font-size: 14px;
      color: #6C3FB5;
    }

    .nav-link.active .nav-icon-box {
      background-color: rgba(255, 255, 255, 0.2);
    }

    .nav-link.active .nav-icon-box i {
      color: white;
    }

    .nav-link:hover .nav-icon-box {
      background-color: rgba(108, 63, 181, 0.15);
    }

    /* Content area */
    .content-wrapper {
      background-color: #f4f6f9;
    }

    .content-header h1 {
      font-size: 24px;
      font-weight: 600;
      color: #2c3e50;
    }

    /* Stat boxes modern design */
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

    /* Chart cards */
    .chart-card {
      border-radius: 15px;
      border: none;
      box-shadow: 0 2px 10px rgba(0,0,0,0.08);
      margin-bottom: 20px;
    }

    .chart-card .card-header {
      background: white;
      border-bottom: 1px solid #f0f0f0;
      padding: 20px;
      border-radius: 15px 15px 0 0;
    }

    .chart-card .card-title {
      font-size: 16px;
      font-weight: 600;
      color: #2c3e50;
      margin: 0;
    }

    .chart-card .card-body {
      padding: 20px;
    }

    /* Breadcrumb */
    .breadcrumb {
      background: transparent;
      padding: 0;
      margin: 0;
    }

    .breadcrumb-item a {
      color: #6C3FB5;
    }

    .breadcrumb-item.active {
      color: #6c757d;
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
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
      </ul>

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a href="#" class="nav-link">
            <div class="nav-icon-box">
              <i class="fas fa-home"></i>
            </div>
            Home
          </a>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link active">
            <div class="nav-icon-box">
              <i class="fas fa-chart-line"></i>
            </div>
            Dashboard
          </a>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link">
            <div class="nav-icon-box">
              <i class="fas fa-users"></i>
            </div>
            <span class="badge badge-danger ml-1">0</span> Active
          </a>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link">
            <div class="nav-icon-box">
              <i class="fas fa-sign-out-alt"></i>
            </div>
            Logout (admin)
          </a>
        </li>
      </ul>
    </nav>

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="#" class="brand-link">
        <img src="https://adminlte.io/themes/v3/dist/img/AdminLTELogo.png" alt="Logo" class="brand-image img-circle elevation-3">
        <span class="brand-text">Trackingspace</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- User panel -->
        <div class="user-panel mt-3 pb-3 mb-3">
          <div class="image">
            <img src="https://adminlte.io/themes/v3/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
          </div>
          <div class="info">
            <a href="#">admin</a>
          </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item">
              <a href="#" class="nav-link active">
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
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-bookmark"></i>
                <p>Reservations</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-door-open"></i>
                <p>Rooms</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-calendar"></i>
                <p>Events</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-clock"></i>
                <p>Open Hours</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
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
      <!-- Content Header -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">Trackingspace - Dashboard Admin</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
              </ol>
            </div>
          </div>
        </div>
      </div>

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <!-- Stat boxes -->
          <div class="row">
            <div class="col-lg-3 col-6">
              <div class="stat-card bg-cyan">
                <h3>208</h3>
                <p>Total Members</p>
                <i class="fas fa-user-friends stat-icon"></i>
              </div>
            </div>
            
            <div class="col-lg-3 col-6">
              <div class="stat-card bg-lime">
                <h3>10/day <small>19/mo</small></h3>
                <p>Average Visits</p>
                <i class="fas fa-chart-line stat-icon"></i>
              </div>
            </div>
            
            <div class="col-lg-3 col-6">
              <div class="stat-card bg-orange-gradient">
                <h3>0 <small>0/mo</small></h3>
                <p>Events</p>
                <i class="fas fa-calendar-check stat-icon"></i>
              </div>
            </div>
            
            <div class="col-lg-3 col-6">
              <div class="stat-card bg-red-gradient">
                <h3>5 <small>0/mo</small></h3>
                <p>Reservations</p>
                <i class="fas fa-bookmark stat-icon"></i>
              </div>
            </div>
          </div>

          <!-- Charts Row -->
          <div class="row mt-4">
            <!-- Weekly Visit Pattern -->
            <div class="col-lg-4">
              <div class="card chart-card">
                <div class="card-header">
                  <h3 class="card-title">Busy Days in December</h3>
                  <p class="text-muted mb-0" style="font-size: 12px;">Weekly Visit Pattern</p>
                </div>
                <div class="card-body">
                  <canvas id="weekly-chart" style="height: 250px;"></canvas>
                </div>
              </div>
            </div>

            <!-- Activity Distribution -->
            <div class="col-lg-4">
              <div class="card chart-card">
                <div class="card-header">
                  <h3 class="card-title">Activity Distribution</h3>
                  <p class="text-muted mb-0" style="font-size: 12px;">Member Activities</p>
                </div>
                <div class="card-body">
                  <canvas id="donut-chart" style="height: 250px;"></canvas>
                </div>
              </div>
            </div>

            <!-- Monthly Visits -->
            <div class="col-lg-4">
              <div class="card chart-card">
                <div class="card-header">
                  <h3 class="card-title">Monthly Visits (2025)</h3>
                  <p class="text-muted mb-0" style="font-size: 12px;">Number of Visits</p>
                </div>
                <div class="card-body">
                  <canvas id="bar-chart" style="height: 250px;"></canvas>
                </div>
              </div>
            </div>
          </div>

        </div>
      </section>
    </div>

    <!-- Footer -->
    <footer class="main-footer">
      <strong>Copyright &copy; 2025 <a href="#">Trackingspace</a>.</strong>
      All rights reserved.
      <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> 1.0.0
      </div>
    </footer>
  </div>

  <!-- jQuery -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.0/js/bootstrap.bundle.min.js"></script>
  <!-- ChartJS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
  <!-- AdminLTE App -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/js/adminlte.min.js"></script>

  <script>
    // Weekly Visit Pattern Chart
    const weeklyCtx = document.getElementById('weekly-chart').getContext('2d');
    new Chart(weeklyCtx, {
      type: 'line',
      data: {
        labels: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
        datasets: [
          {
            label: 'Current Week',
            data: [15, 11, 6, 8, 4, 0],
            borderColor: '#00BCD4',
            backgroundColor: 'rgba(0, 188, 212, 0.1)',
            tension: 0.4,
            fill: true,
            pointRadius: 4,
            pointBackgroundColor: '#00BCD4'
          },
          {
            label: 'Last Week',
            data: [17, 19, 12, 15, 11, 0],
            borderColor: '#E0E0E0',
            backgroundColor: 'rgba(224, 224, 224, 0.1)',
            tension: 0.4,
            fill: true,
            pointRadius: 4,
            pointBackgroundColor: '#E0E0E0'
          }
        ]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            display: true,
            position: 'bottom'
          }
        },
        scales: {
          y: {
            beginAtZero: true,
            title: {
              display: true,
              text: 'Number of Visits'
            }
          },
          x: {
            title: {
              display: true,
              text: 'Days'
            }
          }
        }
      }
    });

    // Activity Distribution Donut Chart
    const donutCtx = document.getElementById('donut-chart').getContext('2d');
    new Chart(donutCtx, {
      type: 'doughnut',
      data: {
        labels: ['Student: 70.2%', 'Worker: 13.0%', 'Freelance: 10.1%', 'Business: 5.3%', 'Community: 1.4%'],
        datasets: [{
          data: [70.2, 13.0, 10.1, 5.3, 1.4],
          backgroundColor: ['#E74C3C', '#27AE60', '#3498DB', '#F39C12', '#9B59B6'],
          borderWidth: 0
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            display: true,
            position: 'right',
            labels: {
              boxWidth: 15,
              padding: 15
            }
          }
        },
        cutout: '65%'
      }
    });

    // Monthly Visits Bar Chart
    const barCtx = document.getElementById('bar-chart').getContext('2d');
    new Chart(barCtx, {
      type: 'bar',
      data: {
        labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
        datasets: [{
          label: 'Visits',
          data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 194, 38],
          backgroundColor: ['#E0E0E0', '#E0E0E0', '#E0E0E0', '#E0E0E0', '#E0E0E0', '#E0E0E0', '#E0E0E0', '#E0E0E0', '#E0E0E0', '#E0E0E0', '#5C7CFA', '#4ECDC4'],
          borderRadius: 5
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            display: false
          }
        },
        scales: {
          y: {
            beginAtZero: true,
            max: 250,
            ticks: {
              stepSize: 50
            }
          },
          x: {
            grid: {
              display: false
            }
          }
        }
      }
    });
  </script>
</body>

</html>