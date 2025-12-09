@include('layouts.header')
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

      {{-- Konten Utama Tabel --}}
      <div class="p-3"> 

        {{-- Tombol Aksi --}}
        <div class="d-flex gap-2 mb-3" style="gap: 10px;"> {{-- Tambahkan style gap untuk kompatibilitas --}}
          <a href="{{ route('data_member.create') }}" class="btn btn-info"> {{-- Ubah btn-primary ke btn-info untuk warna biru --}}
            <i class="fas fa-plus mr-1"></i> Create Member
          </a>
          <a href="" class="btn btn-warning"> {{-- Ubah btn-success ke btn-warning untuk warna oranye --}}
            <i class="fas fa-file-excel mr-1"></i> Import Excel
          </a>
        </div>

        {{-- Card Tabel --}}
        <div class="card shadow-sm">
          <div class="card-body">

            <p class="text-muted mb-3">
              Showing {{ count($allmember) }} items
            </p>

            <div class="table-responsive">
              <table class="table table-hover" style="width: 100%;">
                {{-- HAPUS text-center dari tabel --}}
                <thead style="background-color: #f8f9fa;"> {{-- Header lebih terang --}}
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
                        <span class="badge badge-success px-2 py-1"> {{-- Ubah badge-info ke badge-success untuk warna hijau --}}
                          {{ $r->status }}
                        </span>
                      </td>
                      <td>
                        <div class="d-flex justify-content-center gap-2" style="gap: 5px;">

                          <a href="{{ route('data_member.show', $r->id) }}" class="btn btn-sm btn-info">
                            Detail
                          </a>

                          <a href="{{ route('data_member.edit', $r->id) }}" class="btn btn-sm btn-warning">
                            Edit
                          </a>

                          <form action="{{ route('data_member.destroy', $r->id) }}" method="POST" onsubmit="return confirm('Hapus data?')" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" type="submit">
                              Hapus
                            </button>
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

    </div>
  </section>
</div>

@include('layouts.footer')