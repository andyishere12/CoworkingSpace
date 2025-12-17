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
          <h1 class="m-0">Room</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Room</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">

      {{-- Tombol aksi --}}
      <div class="d-flex gap-2 mb-3">
        <a href="{{ route('room.create') }}" class="btn btn-info">
          <i class="fas fa-plus mr-1"></i> Create Room
        </a>
        <a href="" class="btn btn-warning">
          <i class="fas fa-file-excel mr-1"></i> Import Excel
        </a>
      </div>

      {{-- Card tabel --}}
      <div class="card shadow-sm">
        <div class="card-body">
          <p class="text-muted mb-3">
            Menampilkan {{ count($allrooms ?? []) }} item
          </p>

          <div class="table-responsive">
            <table class="table table-hover">
              <thead style="background-color: #f8f9fa;">
                <tr class="text-secondary" style="font-size: 0.8rem; text-transform: uppercase;">
                  <th>ID</th>
                  <th>ROOM NAME</th>
                  <th>CAPACITY</th>
                  <th>ROOM TYPE</th>
                  <th>DESCRIPTION</th>
                  <th>STATUS</th>
                  <th>ACTIONS</th>
                </tr>
              </thead>

              <tbody>
                @forelse ($allrooms  as $room)
                  <tr>
                    <td>{{ $room->id ?? 'N/A' }}</td>
                    <td>{{ $room->name ?? 'N/A' }}</td>
                    <td>{{ $room->capacity ?? 'N/A' }}</td>
                    <td>{{ $room->type ?? 'N/A' }}</td>
                    <td>{{ $room->description ?? 'N/A' }}</td>
                    <td>
                      <span class="badge badge-success px-2 py-1">
                        {{ $room->status ?? 'N/A' }}
                      </span>
                    </td>
                    <td>
                      <div class="d-flex justify-content-center gap-2">
                        {{-- Tombol Show --}}
                        <a href="{{ route('room.show', $room->id) }}" class="btn btn-sm btn-info">
                          Show
                        </a>

                        {{-- Tombol Edit --}}
                        <a href="{{ route('room.edit', $room->id) }}" class="btn btn-sm btn-warning">
                          Edit
                        </a>

                        {{-- Hapus --}}
                        <form action="{{ route('room.destroy', $room->id) }}" method="POST"
                          onsubmit="return confirm('Hapus data?')" style="display: inline;">
                          @csrf
                          @method('DELETE')
                          <button class="btn btn-sm btn-danger" type="submit">Hapus</button>
                        </form>
                      </div>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="7" class="text-center">Tidak ada data room.</td>
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

@include('layouts.footer')