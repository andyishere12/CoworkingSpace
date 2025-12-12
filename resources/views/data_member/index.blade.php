@include('layouts.header')

<head>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href={{ asset('css/stylemodal.css') }}>
</head>
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Members</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Members Admin</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">

      {{-- Tombol aksi --}}
      <div class="d-flex gap-2 mb-3">
        <a href="{{ route('data_member.create') }}" class="btn btn-info">
          <i class="fas fa-plus mr-1"></i> Create Member
        </a>
        <a href="" class="btn btn-warning">
          <i class="fas fa-file-excel mr-1"></i> Import Excel
        </a>
      </div>

      {{-- Card tabel --}}
      <div class="card shadow-sm">
        <div class="card-body">
          <p class="text-muted mb-3">
            Showing {{ count($allmember) }} items
          </p>

          <div class="table-responsive">
            <table class="table table-hover" style="width: 100%;">
              <thead style="background-color: #f8f9fa;">
                <tr class="text-secondary" style="font-size: 0.8rem; text-transform: uppercase;">
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



@include('layouts.footer')

{{-- Script untuk modal & QR code --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

<script>
  // Tombol Download
$('#btnDownload').click(function () {

    // Bagian yang ingin dijadikan gambar
    const modalBody = document.querySelector('#detailModal .modal-body');

    html2canvas(modalBody, { scale: 2 }).then(canvas => {
        // Convert ke file download
        const link = document.createElement('a');
        link.download = 'member_detail.png';
        link.href = canvas.toDataURL("image/png");
        link.click();
    });
});

  $(document).on('click', '.btn-detail', function () {
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