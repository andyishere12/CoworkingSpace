<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard - Trackingspace</title>
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

    .stat-card {
      border-radius: 15px;
      padding: 25px;
      color: white;
      position: relative;
      overflow: hidden;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
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

    .bg-purple-gradient {
      background: linear-gradient(135deg, #9C27B0 0%, #7B1FA2 100%);
    }

    /* Rank Badge Styles */
    .rank-badge {
      position: absolute;
      top: -10px;
      left: -10px;
      width: 40px;
      height: 40px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: bold;
      font-size: 18px;
      color: white;
      z-index: 1;
      box-shadow: 0 3px 10px rgba(0, 0, 0, 0.2);
    }

    .rank-1 {
      background: linear-gradient(135deg, #FFD700 0%, #e79600ff 100%);
    }

    .rank-2 {
      background: linear-gradient(135deg, #C0C0C0 0%, #A0A0A0 100%);
    }

    .rank-3 {
      background: linear-gradient(135deg, #CD7F32 0%, #A0522D 100%);
    }

    .rank-4-10 {
      background: linear-gradient(135deg, #6C757D 0%, #495057 100%);
    }

    .member-card {
      border-radius: 15px;
      padding: 20px;
      background: white;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
      transition: all 0.3s ease;
      position: relative;
      overflow: hidden;
      border-top: 5px solid;
    }

    .member-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }

    .member-card.gold {
      border-color: #e6de0dff;
      background: linear-gradient(145deg, #fff9e6 0%, #fff5d6 100%);
    }

    .member-card.silver {
      border-color: #C0C0C0;
      background: linear-gradient(145deg, #f8f9fa 0%, #e9ecef 100%);
    }

    .member-card.bronze {
      border-color: #CD7F32;
      background: linear-gradient(145deg, #fdf2e9 0%, #fae5d3 100%);
    }

    .member-card.regular {
      border-color: #6C757D;
      background: white;
    }

    .member-photo {
      width: 100px;
      height: 100px;
      border-radius: 50%;
      object-fit: cover;
      border: 4px solid #f8f9fa;
      margin: 0 auto 15px;
      display: block;
    }

    .member-photo-small {
      width: 60px;
      height: 60px;
      border-radius: 50%;
      object-fit: cover;
      border: 2px solid #f8f9fa;
    }

    .member-name {
      font-size: 18px;
      font-weight: 600;
      margin-bottom: 5px;
      text-align: center;
    }

    .member-name-small {
      font-size: 14px;
      font-weight: 600;
      margin-bottom: 0;
    }

    .member-type {
      font-size: 12px;
      color: #6c757d;
      text-align: center;
      margin-bottom: 10px;
      padding: 3px 10px;
      background: #f8f9fa;
      border-radius: 20px;
      display: inline-block;
    }

    .member-type-small {
      font-size: 11px;
      padding: 2px 8px;
    }

    .visit-count {
      font-size: 24px;
      font-weight: 700;
      color: #6C3FB5;
      text-align: center;
      margin-bottom: 5px;
    }

    .visit-count-small {
      font-size: 16px;
      font-weight: 600;
      color: #495057;
    }

    .visit-label {
      font-size: 12px;
      color: #6c757d;
      text-align: center;
      text-transform: uppercase;
      letter-spacing: 1px;
    }

    .visit-label-small {
      font-size: 10px;
    }

    .table-member-row:hover {
      background-color: #f8f9fa;
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
                <li class="breadcrumb-item active">Dashboard</li>
              </ol>
            </div>
          </div>
        </div>
      </div>

      <section class="content">
        <div class="container-fluid">
          <!-- Statistic Cards -->
          <div class="row">
            <div class="col-lg-3 col-6">
              <div class="stat-card bg-cyan">
                <div class="stat-icon">
                  <i class="fas fa-users"></i>
                </div>
                <div>
                  <h3>{{ $totalMembers ?? 0 }}</h3>
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
                  <h3>{{ $totalReservations ?? 0 }}</h3>
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
                  <h3>{{ $totalRooms ?? 0 }}</h3>
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
                  <h3>{{ $totalEvents ?? 0 }}</h3>
                  <p>Events</p>
                  <small>Upcoming</small>
                </div>
              </div>
            </div>
          </div>

          <!-- Top 10 Most Frequent Visitors -->
          <div class="row mt-4">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">
                    <i class="fas fa-trophy mr-2"></i>
                    Top 10 Most Frequent Visitors
                  </h3>
                </div>
                <div class="card-body">
                  <!-- Top 3 dengan desain khusus -->
                  <h5 class="mb-3">Top 3 🏆</h5>
                  <div class="row">
                    @forelse($topMembers->take(3) as $index => $member)
                      <div class="col-md-4 mb-4">
                        <div class="member-card 
                              @if($index == 0) gold 
                              @elseif($index == 1) silver 
                              @else bronze 
                              @endif">

                          <!-- Rank Badge -->
                          <div class="rank-badge rank-{{ $index + 1 }}">
                            {{ $index + 1 }}
                          </div>

                          <!-- Member Photo dari database -->
                          <div class="text-center">
                            @if($member->foto)
                              <img src="{{ asset('uploads/foto/' . $member->foto) }}" class="member-photo"
                                alt="{{ $member->nama }}"
                                onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name={{ urlencode($member->nama) }}&background=6C3FB5&color=fff&size=100'">
                            @else
                              <img
                                src="https://ui-avatars.com/api/?name={{ urlencode($member->nama) }}&background=6C3FB5&color=fff&size=100"
                                class="member-photo" alt="{{ $member->nama }}">
                            @endif
                          </div>

                          <!-- Member Name -->
                          <h5 class="member-name">{{ $member->nama }}</h5>

                          <!-- Member Type -->
                          <div class="text-center">
                            <span class="member-type">{{ $member->type }}</span>
                          </div>

                          <!-- Visit Count -->
                          <div class="text-center mt-3">
                            <div class="visit-count">{{ $member->total_visits }}</div>
                            <div class="visit-label">Total Visits</div>
                          </div>

                          <!-- Last Visit -->
                          <div class="text-center mt-2">
                            <small class="text-muted">
                              <i class="fas fa-calendar-alt mr-1"></i>
                              @if($member->last_visit)
                                {{ date('d M Y', strtotime($member->last_visit)) }}
                              @else
                                Never
                              @endif
                            </small>
                          </div>
                        </div>
                      </div>
                    @empty
                      <div class="col-12 text-center py-5">
                        <div class="empty-state">
                          <i class="fas fa-users fa-4x text-muted mb-3"></i>
                          <h5 class="text-muted">No Attendance Data Yet</h5>
                          <p class="text-muted">Start tracking attendance to see top visitors</p>
                        </div>
                      </div>
                    @endforelse
                  </div>

                  <!-- Peringkat 4-10 dalam tabel -->
                  @if($topMembers->count() > 3)
                    <h5 class="mt-5 mb-3">Ranking 4-10</h5>
                    <div class="table-responsive">
                      <table class="table table-hover">
                        <thead class="thead-light">
                          <tr>
                            <th width="10%">Rank</th>
                            <th width="15%">Photo</th>
                            <th width="25%">Member</th>
                            <th width="15%">Type</th>
                            <th width="15%">Total Visits</th>
                            <th width="20%">Last Visit</th>
                          </tr>
                        </thead>
                        <tbody>
                          @php
                            // Hitung rank yang benar untuk 4-10
                            $rankCounter = 4;
                          @endphp

                          @foreach($topMembers->slice(3) as $member)
                            <tr class="table-member-row">
                              <td>
                                <div class="rank-badge rank-4-10"
                                  style="position: relative; top: 0; left: 0; width: 35px; height: 35px;">
                                  {{ $rankCounter }}
                                </div>
                              </td>
                              <td>
                                @if($member->foto)
                                  <img src="{{ asset('uploads/foto/' . $member->foto) }}" class="member-photo-small"
                                    alt="{{ $member->nama }}"
                                    onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name={{ urlencode($member->nama) }}&background=6C757D&color=fff&size=60'">
                                @else
                                  <img
                                    src="https://ui-avatars.com/api/?name={{ urlencode($member->nama) }}&background=6C757D&color=fff&size=60"
                                    class="member-photo-small" alt="{{ $member->nama }}">
                                @endif
                              </td>
                              <td>
                                <div>
                                  <strong class="member-name-small">{{ $member->nama }}</strong>
                                </div>
                              </td>
                              <td>
                                <span class="member-type member-type-small">{{ $member->type }}</span>
                              </td>
                              <td>
                                <div class="text-center">
                                  <div class="visit-count-small">{{ $member->total_visits }}</div>
                                  <div class="visit-label visit-label-small">visits</div>
                                </div>
                              </td>
                              <td>
                                <small class="text-muted">
                                  <i class="fas fa-calendar-alt mr-1"></i>
                                  @if($member->last_visit)
                                    {{ date('d M Y', strtotime($member->last_visit)) }}
                                  @else
                                    Never
                                  @endif
                                </small>
                              </td>
                            </tr>
                            @php $rankCounter++; @endphp
                          @endforeach
                        </tbody>
                      </table>
                    </div>
                  @endif
                </div>
                <div class="card-footer">
                  <div class="row">
                    <div class="col-md-3 text-center">
                      <div class="d-flex align-items-center justify-content-center">
                        <div class="mr-2" style="width: 15px; height: 15px; background: #FFD700; border-radius: 50%;">
                        </div>
                        <span>Rank 1 (Gold)</span>
                      </div>
                    </div>
                    <div class="col-md-3 text-center">
                      <div class="d-flex align-items-center justify-content-center">
                        <div class="mr-2" style="width: 15px; height: 15px; background: #C0C0C0; border-radius: 50%;">
                        </div>
                        <span>Rank 2 (Silver)</span>
                      </div>
                    </div>
                    <div class="col-md-3 text-center">
                      <div class="d-flex align-items-center justify-content-center">
                        <div class="mr-2" style="width: 15px; height: 15px; background: #CD7F32; border-radius: 50%;">
                        </div>
                        <span>Rank 3 (Bronze)</span>
                      </div>
                    </div>
                    <div class="col-md-3 text-center">
                      <div class="d-flex align-items-center justify-content-center">
                        <div class="mr-2" style="width: 15px; height: 15px; background: #6C757D; border-radius: 50%;">
                        </div>
                        <span>Rank 4-10</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!--  Quick Stats -->


          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Quick Stats</h3>
              </div>
              <div class="card-body">
                @php
                  $today = date('Y-m-d');
                  $month = date('Y-m');

                  $todayVisits = DB::table('hadir')->whereDate('tanggal', $today)->count();
                  $monthVisits = DB::table('hadir')->where('tanggal', 'like', $month . '%')->count();
                  $uniqueVisitors = DB::table('hadir')->distinct('member_id')->count('member_id'); // BENAR

                @endphp

                <div class="row">
                  <div class="col-6 mb-3">
                    <div class="info-box bg-gradient-info">
                      <span class="info-box-icon"><i class="fas fa-calendar-day"></i></span>
                      <div class="info-box-content">
                        <span class="info-box-text">Today's Visits</span>
                        <span class="info-box-number">{{ $todayVisits }}</span>
                      </div>
                    </div>
                  </div>
                  <div class="col-6 mb-3">
                    <div class="info-box bg-gradient-success">
                      <span class="info-box-icon"><i class="fas fa-calendar-alt"></i></span>
                      <div class="info-box-content">
                        <span class="info-box-text">This Month</span>
                        <span class="info-box-number">{{ $monthVisits }}</span>
                      </div>
                    </div>
                  </div>
                  <div class="col-6 mb-3">
                    <div class="info-box bg-gradient-warning">
                      <span class="info-box-icon"><i class="fas fa-user-check"></i></span>
                      <div class="info-box-content">
                        <span class="info-box-text">Unique Visitors</span>
                        <span class="info-box-number">{{ $uniqueVisitors }}</span>
                      </div>
                    </div>
                  </div>
                  <div class="col-6 mb-3">
                    <div class="info-box bg-gradient-purple">
                      <span class="info-box-icon"><i class="fas fa-chart-line"></i></span>
                      <div class="info-box-content">
                        <span class="info-box-text">Avg. Daily</span>
                        <span class="info-box-number">
                          @php
                            $daysInMonth = date('d');
                            $avgDaily = $monthVisits > 0 ? round($monthVisits / $daysInMonth, 1) : 0;
                            echo $avgDaily;
                          @endphp
                        </span>
                      </div>
                    </div>
                  </div>
                </div>
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
      <b>Version</b> 1.0.0 | Last Updated: {{ date('d M Y H:i') }}
    </div>
  </footer>
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.0/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/js/adminlte.min.js"></script>

  <script>
    // Auto refresh dashboard every 60 seconds
    $(document).ready(function () {
      setTimeout(function () {
        window.location.reload();
      }, 60000); // 60 seconds
    });
  </script>
</body>

</html>