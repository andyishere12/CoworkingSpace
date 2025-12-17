@include('layouts.header')

<head>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/stylemodal.css') }}">
</head>
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Detail Reservasi</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('reservasi.index') }}">Reservasi</a></li>
            <li class="breadcrumb-item active">Detail</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
      <div class="card shadow-sm">
        <div class="card-body">
          <div class="row">
            <div class="col-md-6">
              <h5>Informasi Reservasi</h5>
              <table class="table table-borderless">
                <tr>
                  <th>ID</th>
                  <td>{{ $reservasi->id }}</td>
                </tr>
                <tr>
                  <th>Nama Pemesanan</th>
                  <td>{{ $reservasi->nama_pemesanan }}</td>
                </tr>
                <tr>
                  <th>Kontak</th>
                  <td>{{ $reservasi->kontak }}</td>
                </tr>
                <tr>
                  <th>Institusi</th>
                  <td>{{ $reservasi->institusi }}</td>
                </tr>
                <tr>
                  <th>Purpose</th>
                  <td>{{ $reservasi->purpose }}</td>
                </tr>
                <tr>
                  <th>Description</th>
                  <td>{{ $reservasi->description }}</td>
                </tr>
                <tr>
                  <th>Attends</th>
                  <td>{{ $reservasi->attends }}</td>
                </tr>
                <tr>
                  <th>Tanggal</th>
                  <td>{{ $reservasi->tanggal }}</td>
                </tr>
                <tr>
                  <th>Waktu Mulai</th>
                  <td>{{ $reservasi->waktu_mulai }}</td>
                </tr>
                <tr>
                  <th>Waktu Selesai</th>
                  <td>{{ $reservasi->waktu_selesai }}</td>
                </tr>
                <tr>
                  <th>Ruangan</th>
                  <td>{{ $reservasi->ruangan }}</td>
                </tr>
                <tr>
                  <th>Status</th>
                  <td>
                    <span class="badge badge-success px-2 py-1">
                      {{ $reservasi->status }}
                    </span>
                  </td>
                </tr>
              </table>
            </div>
          </div>
          <div class="mt-3">
            <a href="{{ route('reservasi.index') }}" class="btn btn-secondary">Kembali</a>
            <a href="{{ route('reservasi.edit', $reservasi->id) }}" class="btn btn-warning">Edit</a>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

@include('layouts.footer')
