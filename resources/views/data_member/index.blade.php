<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Members - Trackingspace</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/css/adminlte.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href={{ asset('css/stylemodal.css') }}>

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
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
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
                <div class="d-flex gap-2">
                  <a href="{{ route('data_member.create') }}" class="btn btn-info">
                    <i class="fas fa-plus mr-1"></i> Create Member
                  </a>
                  <a href="" class="btn btn-warning">
                    <i class="fas fa-file-excel mr-1"></i> Import Excel
                  </a>
                </div>
              </div>
            </div>
            <div class="card-body">
              @if(session('success'))
              <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert">&times;</button>
              </div>
              @endif

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

                  <tbody>
                    @foreach ($allmember as $r)
                    <tr>
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
                        <div class="d-flex justify-content-center gap-2">
                          {{-- Tombol Detail --}}
                          <button class="btn btn-sm btn-info btn-detail" data-id="{{ $r->id }}" data-nama="{{ $r->nama }}"
                            data-type="{{ $r->type }}" data-status="{{ $r->status }}"
                            data-foto="{{ asset('uploads/foto/' . $r->foto) }}">
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
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            Tutup
          </button>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.0/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/js/adminlte.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

  <script>
    // Tombol Download
    $('#btnDownload').click(function() {

      // Bagian yang ingin dijadikan gambar
      const modalBody = document.querySelector('#detailModal .modal-body');

      html2canvas(modalBody, {
        scale: 2
      }).then(canvas => {
        // Convert ke file download
        const link = document.createElement('a');
        link.download = 'member_detail.png';
        link.href = canvas.toDataURL("image/png");
        link.click();
      });
    });

    $(document).on('click', '.btn-detail', function() {
      var nama = $(this).data('nama');
      var type = $(this).data('type');
      var status = $(this).data('status');
      var foto = $(this).data('foto'); // path foto, misal /uploads/member.jpg

      $('#modalNama').text(nama);
      $('#modalType').text(type);
      $('#modalStatus').text(status);

      // Set foto
      $('#modalFoto').attr('src', foto);

      // Clear QR code sebelumnya
      $('#qrcode').html('');

      // Generate QR code di atas foto
      new QRCode(document.getElementById("qrcode"), {
        text: nama + ' | ' + type,
        width: 170,
        height: 170,
        colorDark: "#000000",
        colorLight: "transparent",
        correctLevel: QRCode.CorrectLevel.H
      });

      // Tampilkan modal
      var myModal = new bootstrap.Modal(document.getElementById('detailModal'));
      myModal.show();
    });
  </script>
</body>

</html>