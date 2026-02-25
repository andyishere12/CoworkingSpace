<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Members - Trackingspace</title>
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/css/adminlte.min.css">
  <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> -->
  <link rel="stylesheet" href={{ asset('css/stylemodal.css') }}>
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

    .table-cyan th {
      color: #000000ff !important;
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

    /* Styling untuk search box */
    .search-container {
      position: relative;
      max-width: 300px;
    }

    .search-results {
      position: absolute;
      top: 100%;
      left: 0;
      right: 0;
      background: white;
      border: 1px solid #ddd;
      border-radius: 0 0 4px 4px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
      max-height: 300px;
      overflow-y: auto;
      z-index: 1000;
      display: none;
    }

    .search-result-item {
      padding: 10px 15px;
      border-bottom: 1px solid #eee;
      cursor: pointer;
      transition: background-color 0.2s;
    }

    .search-result-item:hover {
      background-color: #f8f9fa;
    }

    .search-result-item:last-child {
      border-bottom: none;
    }

    .search-highlight {
      color: #6C3FB5;
      font-weight: bold;
    }

    .table td {
      color: black !important;
    }

    .btn-gap {
      display: flex;
      gap: 8px;
    }

    /* Style untuk modal detail */
    .section-title {
      font-size: 1.1rem;
      border-bottom: 2px solid #6C3FB5;
      padding-bottom: 5px;
    }

    .info-item {
      padding: 8px 0;
      border-bottom: 1px solid #f0f0f0;
    }

    .info-item:last-child {
      border-bottom: none;
    }

    .info-value {
      font-size: 1rem;
      color: #ffffffff;
      margin-bottom: 0;
    }

    .badge {
      font-size: 0.9rem;
      font-weight: 500;
    }

    .member-info {
      background: #f8f9fa;
      padding: 20px;
      border-radius: 10px;
      border-left: 4px solid #6C3FB5;
    }

    .qr-box {
      background: white;
      padding: 15px;
      border-radius: 10px;
      border: 1px solid #ddd;
    }

    /* --- Perbaikan Visual Modal Detail --- */

    /* Pastikan teks terbaca (Ganti warna putih ke gelap) */
    .info-value {
      color: #222222 !important;
      /* Warna hitam pekat agar mudah dibaca */
      font-size: 1.1rem !important;
      /* Ukuran font lebih besar dari label */
      font-weight: 700 !important;
      /* Dibuat tebal (bold) */
      margin-bottom: 0;
      line-height: 1.2;
    }

    .info-item label {
      color: #6c757d !important;
      /* Warna muted untuk label */
      display: block;
      margin-bottom: 2px;
    }

    .info-item label,
    .info-section label {
      color: #888888 !important;
      /* Warna abu-abu agar tidak dominan */
      font-size: 0.85rem !important;
      /* Ukuran lebih kecil */
      font-weight: 500;
      text-transform: uppercase;
      /* Membuat label jadi huruf kapital semua agar rapi */
      letter-spacing: 0.5px;
      margin-bottom: 2px;
      display: block;
    }

    /* Merapikan Section Title */
    .section-title {
      font-size: 1.1rem;
      font-weight: 700;
      color: #6C3FB5 !important;
      border-bottom: 2px solid #6C3FB5;
      padding-bottom: 8px;
      margin-bottom: 15px !important;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    /* Merapikan Box QR Code agar Center & Simetris */
    .qr-box {
      background: #ffffff !important;
      padding: 15px;
      border-radius: 12px;
      border: 1px solid #e0e0e0 !important;
      display: inline-block;
      /* Agar box mengikuti lebar QR */
      margin: 0 auto;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    }

    #detailQrcode canvas,
    #detailQrcode img {
      margin: 0 auto !important;
      /* Memastikan barcode di tengah box */
      display: block;
    }

    /* Layouting Member Info */
    .member-info {
      background: #ffffff;
      padding: 25px;
      border-radius: 15px;
      border-left: 5px solid #6C3FB5;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }

    /* Merapikan Badge */
    .badge-info {
      background-color: #17a2b8;
      color: white;
    }

    .badge-success {
      background-color: #28a745;
      color: white;
    }

    #detailModal .modal-body {


      /* Style agar area QR Code punya background */
      #qrcode {
        background-color: white;
        /* Ganti dengan path gambar backgroundmu */
        background-size: cover;
        background-position: center;
        padding: 9px !important;
        /* Memberi ruang antara barcode dan tepi background */
        border-radius: 10px;
        display: inline-block;
      }

      /* Memastikan gambar barcode di atas background terlihat jelas */
      #qrcode img {
        border: 2px solid white;
        /* Memberi frame putih agar barcode mudah discan */
        border-radius: 5px;
      }

      .qr-box {
        background-color: white;
        border: none !important;
        padding: 0 !important;
      }

      /* Style untuk foto modal barcode */
      #modalFoto {
        border: 3px solid #6C3FB5;
        background-color: #f8f9fa;
      }

      #detailModal .modal-content {
        background: transparent;
      }

      #detailModal .modal-body {
        background: rgba(255, 255, 255, 0.95);
        border-radius: 10px;
        margin: 10px;
      }
    }

    /* Style untuk notifikasi pop-up */
    .notification-container {
      position: fixed;
      top: 70px;
      /* Di bawah navbar */
      right: 20px;
      z-index: 99999;
      max-width: 550px;
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
              <h1 class="m-0">Members</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Members Admin</li>
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
                <h3 class="card-title font-weight-bold">Members</h3>
                <div class="d-flex gap-2 align-items-center">
                  <!-- Search Box -->
                  <div class="search-container">
                    <input type="text" id="searchInput" class="form mr-2" placeholder="Search members..."
                      style="min-width: 250px;">
                    <div id="searchResults" class="search-results"></div>
                  </div>

                  <a href="{{ route('data_member.create') }}" class="btn btn-info mr-2">
                    <i class="fas fa-plus mr-1"></i> Create Member
                  </a>
                  <button type="button" class="btn btn-success btn-print shadow-sm ml- mr-2" onclick="cetakDataMember()">
                    <i class="fas fa-print mr-2"></i> Cetak Data Member
                  </button>

                  <!-- Export icons: Excel and PDF (icon-only, keep same routes) -->
                  <a href="{{ route('members.export.excel') }}" class="btn btn-success btn-sm" title="Export Excel" aria-label="Export Excel" style="padding:8px 10px;">
                    <i class="fas fa-file-excel"></i>
                  </a>
                  <a href="{{ route('members.export.pdf') }}" class="btn btn-danger btn-sm ml-2" title="Export PDF" aria-label="Export PDF" style="padding:8px 10px;">
                    <i class="fas fa-file-pdf"></i>
                  </a>
                </div>
              </div>
            </div>
            <div class="card-body">
              <!-- @if(session('success'))
              <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert">&times;</button>
              </div>
              @endif -->

              <p class="text-muted">Total {{ count($allmember) }} items.</p>

              <div class="table-responsive">
                <table class="table table-hover" style="width: 100%;">
                  <thead class="table-cyan">
                    <tr>
                      <th style="width: 5%;">Id</th>
                      <th style="width: 25%;">Nama</th>
                      <th style="width: 15%;">Type</th>
                      <th style="width: 20%;">Aktivitas</th>
                      <th style="width: 15%;">Status</th>
                      <th style="width: 20%;" class="text-center">Actions</th>
                    </tr>
                  </thead>

                  <tbody id="membersTable">
                    @foreach ($allmember as $r)
                    <tr data-id="{{ $r->id }}" data-nama="{{ $r->nama }}" data-type="{{ $r->type }}"
                      data-aktivitas="{{ $r->aktivitas }}" data-status="{{ $r->status }}">
                      <td>{{ $r->id }}</td>
                      <td>{{ $r->nama }}</td>
                      <td>{{ $r->type }}</td>
                      <td>{{ $r->aktivitas }}</td>
                      <td>
                        <span class="badge badge-success px-2 py-1">
                          {{ $r->status }}
                        </span>
                      </td>
                      <td>
                        <div class="btn-gap justify-content-center">
                          <!-- button barcode -->
                          <button class="btn btn-sm btn-secondary btn-barcode" data-id="{{ $r->id }}"
                            data-foto="{{ asset('uploads/foto/' . $r->foto) }}">
                            <i class="fas fa-qrcode"></i>
                          </button>
                          {{-- Tombol Detail (data lengkap) --}}
                          <button class="btn btn-sm btn-info btn-detail" data-id="{{ $r->id }}">
                            Detail
                          </button>

                          {{-- Tombol Edit --}}
                          <a href="{{ route('data_member.edit', $r->id) }}" class="btn btn-sm btn-warning">
                            Edit
                          </a>

                          {{-- Hapus --}}
                          <form action="{{ route('data_member.destroy', $r->id) }}" method="POST"
                            onsubmit="return confirm('Hapus data?')" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" type="submit">Hapus</button>
                          </form>
                        </div>
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

  <div class="modal fade" id="detailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content" style="border-radius: 15px; overflow: hidden;">
        <div class="modal-header bg-light">
          <h5 class="modal-title fw-bold">Detail Member</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body text-center">
          <div class="mb-4 d-flex justify-content-center">
            <img id="modalFoto" src="" alt="" class="rounded-circle shadow"
              style="width: 150px; height: 150px; object-fit: cover;">
          </div>

          <div class="qr-box mb-3">
            <div class="d-flex justify-content-center">
              <div id="qrcode" class="border p-2 rounded"></div>
            </div>
          </div>

          <div class="watermark-overlay">
            <div id="modaFoto" class="mb-4 d-flex justify-content-center">
              <img class="wewe" style="width: 100px; height: 100px;">
            </div>
          </div>

          <div class="text-center mt-3">
            <div class="info-card p-3 mt-3 mx-auto">
              <div class="info-row">
                <span class="label">Nama</span>
                <span class="value" id="modalNama"></span>
              </div>

              <div class="info-row">
                <span class="label">Type</span>
                <span class="value" id="modalType"></span>
              </div>

              <div class="info-row">
                <span class="label">Status</span>
                <span class="value" id="modalStatus"></span>
              </div>
            </div>
          </div>
        </div>

        <div class="modal-footer bg-light">
          <button type="button" class="btn btn-success" id="btnDownload">
            Download
          </button>

          <button type="button" class="btn btn-secondary" data-dismiss="modal">
            Tutup
          </button>
        </div>

      </div>
    </div>
  </div>


  <div class="modal fade" id="detailMemberModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content"
        style="border-radius: 20px; border: none; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.2);">
        <div class="modal-header bg-primary text-white"
          style="background: linear-gradient(90deg, #6C3FB5, #8B5FD6) !important;">
          <h5 class="modal-title fw-bold">
            <i class="fas fa-id-card-alt mr-2"></i> Profil Lengkap Member
          </h5>
          <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body" style="background-color: #f8f9fa; padding: 30px;">
          <div class="row">
            <div class="col-md-4 text-center">
              <div class="mb-4">
                <img id="detailFoto" src="" alt="Foto Member" class="img-fluid rounded-circle shadow"
                  style="width: 180px; height: 180px; object-fit: cover; border: 5px solid white;">
              </div>

              <div class="qr-container text-center">
                <p class="text-muted small mb-2">SCAN MEMBER ID</p>
                <div class="qr-box">
                  <div id="detailQrcode"></div>
                </div>
              </div>
            </div>

            <div class="col-md-8">
              <div class="member-info"
                style="background: white; padding: 20px; border-radius: 12px; border-left: 5px solid #6C3FB5;">

                <div class="info-section mb-4">
                  <h5 class="section-title"
                    style="color: #6C3FB5; border-bottom: 2px solid #6C3FB5; padding-bottom: 5px; margin-bottom: 15px;">
                    <i class="fas fa-user-circle mr-2"></i> INFORMASI PRIBADI
                  </h5>
                  <div class="row">
                    <div class="col-md-6">
                      <label>Nama Lengkap</label>
                      <p class="info-value" id="detailNama">Memuat...</p>
                    </div>
                    <div class="col-md-6">
                      <label>No. Telepon</label>
                      <p class="info-value" id="detailNoHp">Memuat...</p>
                    </div>
                    <div class="col-md-6">
                      <label>Tanggal Lahir</label>
                      <p class="info-value" id="detailTanggalLahir">Memuat...</p>
                    </div>
                    <div class="col-md-6">
                      <label>Email</label>
                      <p class="info-value" id="detailEmail">Memuat...</p>
                    </div>
                  </div>
                </div>

                <div class="info-section">
                  <h5 class="section-title"
                    style="color: #6C3FB5; border-bottom: 2px solid #6C3FB5; padding-bottom: 5px; margin-bottom: 15px;">
                    <i class="fas fa-university mr-2"></i> INSTITUSI
                  </h5>
                  <div class="row">
                    <div class="col-12">
                      <label>Nama Institusi / Perusahaan</label>
                      <p class="info-value" id="detailInstitusi">Memuat...</p>
                    </div>
                  </div>
                </div>

              </div>
            </div>
          </div>
        </div>

        <div class="modal-footer bg-white border-0">
          <button type="button" class="btn btn-light shadow-sm" data-dismiss="modal">Tutup</button>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.0/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/js/adminlte.min.js"></script>
  <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> -->
  <script src="bootstrap/4.6.0/js/bootstrap.bundle.min.js"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

  <script>
    // Tombol Download (nama file disesuaikan dengan nama member)
    $('#btnDownload').click(function() {
      const modalBody = document.querySelector('#detailModal .modal-body');
      html2canvas(modalBody, {
        scale: 2
      }).then(canvas => {
        const link = document.createElement('a');
        const rawName = (document.querySelector('#modalNama') && document.querySelector('#modalNama').textContent) ? document.querySelector('#modalNama').textContent.trim() : 'member';
        const safeName = rawName.replace(/[^a-z0-9\-_]/gi, '_');
        link.download = `${safeName} Member Card.png`;
        link.href = canvas.toDataURL("image/png");
        link.click();
      });
    });

    $(document).on('click', '.btn-barcode', function() {
      var row = $(this).closest('tr');
      var memberId = row.data('id');
      var nama = row.data('nama');
      var type = row.data('type');
      var status = row.data('status');
      var foto = $(this).data('foto');

      // Isi modal barcode
      $('#modalNama').text(nama);
      $('#modalType').text(type);
      $('#modalStatus').text(status);
      $('#modalFoto').attr('src', foto);
      $('#qrcode').html('');

      // Generate QR Code
      new QRCode(document.getElementById("qrcode"), {
        text: memberId.toString(),
        width: 220,
        height: 220,
        colorDark: "#000000",
        colorLight: "transparent",
        correctLevel: QRCode.CorrectLevel.H
      });

      // Tampilkan modal barcode
      $('#detailModal').modal('show');
    });

    // Real-time Search Functionality
    $(document).ready(function() {
      let searchTimeout;
      let allMembers = []; // Untuk menyimpan semua data member

      // Ambil data member saat halaman dimuat
      function loadAllMembers() {
        $.ajax({
          url: "{{ route('data_member.index') }}",
          method: 'GET',
          dataType: 'json',
          success: function(data) {
            // Simpan data member
            allMembers = data;
          },
          error: function(xhr) {
            console.error('Error loading members:', xhr);
          }
        });
      }

      // Load data saat halaman dimuat
      loadAllMembers();

      // Real-time search
      $('#searchInput').on('input', function() {
        clearTimeout(searchTimeout);
        const searchTerm = $(this).val().toLowerCase();

        if (searchTerm.length === 0) {
          $('#searchResults').hide().empty();
          return;
        }

        searchTimeout = setTimeout(function() {
          $.ajax({
            url: "{{ route('data_member.index') }}",
            method: 'GET',
            data: {
              search: searchTerm
            },
            success: function(response) {
              const members = response;
              const resultsContainer = $('#searchResults');
              resultsContainer.empty();

              if (members.length === 0) {
                resultsContainer.append('<div class="search-result-item">No results found</div>');
              } else {
                members.slice(0, 10).forEach(function(member) {
                  const highlightedName = highlightText(member.nama, searchTerm);
                  const item = $(`
                    <div class="search-result-item" data-id="${member.id}">
                      <div class="fw-bold">${highlightedName}</div>
                      <small class="text-muted">${member.type} • ${member.aktivitas}</small>
                    </div>
                  `);
                  resultsContainer.append(item);
                });
              }

              resultsContainer.show();
            },
            error: function(xhr) {
              console.error('Error searching:', xhr);
            }
          });
        }, 300); // Debounce 300ms
      });

      // Highlight text in search results
      function highlightText(text, searchTerm) {
        if (!searchTerm) return text;
        const regex = new RegExp(`(${searchTerm})`, 'gi');
        return text.replace(regex, '<span class="search-highlight">$1</span>');
      }

      // When clicking on a search result
      $(document).on('click', '.search-result-item', function() {
        const memberId = $(this).data('id');
        const searchTerm = $('#searchInput').val();

        // Find the row and highlight it
        $('#membersTable tr').removeClass('table-primary');
        const targetRow = $(`#membersTable tr[data-id="${memberId}"]`);
        targetRow.addClass('table-primary');

        // Scroll to the row
        $('html, body').animate({
          scrollTop: targetRow.offset().top - 100
        }, 500);

        // Clear search
        $('#searchInput').val('');
        $('#searchResults').hide().empty();
      });

      // Hide search results when clicking outside
      $(document).on('click', function(e) {
        if (!$(e.target).closest('.search-container').length) {
          $('#searchResults').hide();
        }
      });

      // Client-side filtering for instant feedback
      $('#searchInput').on('keyup', function() {
        const searchTerm = $(this).val().toLowerCase();

        if (searchTerm.length === 0) {
          // Show all rows
          $('#membersTable tr').show();
          $('.text-muted').text(`Total ${$('#membersTable tr').length} items.`);
          return;
        }

        // Filter rows
        let visibleCount = 0;
        $('#membersTable tr').each(function() {
          const row = $(this);
          const nama = row.data('nama').toLowerCase();
          const type = row.data('type').toLowerCase();
          const aktivitas = row.data('aktivitas').toLowerCase();
          const status = row.data('status').toLowerCase();

          if (nama.includes(searchTerm) ||
            type.includes(searchTerm) ||
            aktivitas.includes(searchTerm) ||
            status.includes(searchTerm)) {
            row.show();
            visibleCount++;
          } else {
            row.hide();
          }
        });

        $('.text-muted').text(`Total ${visibleCount} items.`);
      });
    });

    // Event handler untuk tombol detail (data lengkap)
    $(document).on('click', '.btn-detail', function() {
      var memberId = $(this).data('id');

      // Mengambil data member via AJAX
      $.ajax({
        url: "{{ route('data_member.show', ':id') }}".replace(':id', memberId),
        method: 'GET',
        headers: {
          'Accept': 'application/json'
        },
        success: function(response) {
          // Isi data ke dalam modal detail
          $('#detailFoto').attr('src', "{{ asset('uploads/foto') }}/" + response.foto);
          $('#detailNama').text(response.nama);
          $('#detailTanggalLahir').text(response.tanggal_lahir);
          $('#detailAlamat').text(response.alamat);
          $('#detailEmail').text(response.email);
          $('#detailNoHp').text(response.no_hp);
          $('#detailAktivitas').text(response.aktivitas);
          $('#detailInstitusi').text(response.institusi);
          $('#detailType').text(response.type);
          $('#detailStatus').text(response.status);

          // Generate QR Code untuk ID member
          $('#detailQrcode').html(''); // Bersihkan QR lama
          new QRCode(document.getElementById("detailQrcode"), {
            text: response.id.toString(),
            width: 120,
            height: 120,
            colorDark: "#000000",
            colorLight: "#ffffff",
            correctLevel: QRCode.CorrectLevel.H
          });

          $('#detailMemberModal').modal('show');
        },
        error: function(xhr) {
          console.error('Error:', xhr);
          alert('Gagal memuat data member.');
        }
      });
    });
        // Fungsi untuk menampilkan notifikasi
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
  </script>

  <div class="notification-container" id="notificationContainer" data-success-message="{{ session('success') }}"></div>

  <script>
    // Tampilkan notifikasi jika ada session success
    $(document).ready(function() {
      const successMessage = $('#notificationContainer').data('success-message');
      if (successMessage) {
        showNotification(successMessage, 'success');
      }
    });

    // Fungsi untuk cetak data member dengan PDF layout
    function cetakDataMember() {
      const printFrame = document.getElementById('printFrame');
      printFrame.src = "{{ route('data-member.print') }}";
      printFrame.onload = function() {
        printFrame.contentWindow.print();
      };
    }
    
  </script>
  <!-- Hidden iframe for printing -->
  <iframe id="printFrame" style="display:none;"></iframe>

</body>

</html>
