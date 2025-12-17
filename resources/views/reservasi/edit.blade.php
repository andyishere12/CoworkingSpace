@include('layouts.header')

<head>
    <link rel="stylesheet" href="{{ asset('css/stylecreate.css') }}">
</head>
<div class="content-wrapper">

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Reservasi</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Edit Reservasi</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">

            {{-- Header Form --}}
            <h1 class="page-title mb-4">Edit Reservasi</h1>

            <div class="card shadow-sm">
                <div class="card-body">

                    <form action="{{ route('reservasi.update', $reservasi->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            {{-- Kolom Kiri --}}
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nama_pemesanan">Nama Pemesanan</label>
                                    <input type="text" class="form-control" id="nama_pemesanan" name="nama_pemesanan" value="{{ $reservasi->nama_pemesanan }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="kontak">Kontak</label>
                                    <input type="text" class="form-control" id="kontak" name="kontak" value="{{ $reservasi->kontak }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="institusi">Institusi</label>
                                    <input type="text" class="form-control" id="institusi" name="institusi" value="{{ $reservasi->institusi }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="purpose">Purpose</label>
                                    <input type="text" class="form-control" id="purpose" name="purpose" value="{{ $reservasi->purpose }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="attends">Attends</label>
                                    <input type="number" class="form-control" id="attends" name="attends" value="{{ $reservasi->attends }}" min="1" required>
                                </div>
                            </div>

                            {{-- Kolom Kanan --}}
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="ruangan">Room</label>
                                    <select class="form-control" id="ruangan" name="ruangan" required>
                                        <option value="" disabled>Pilih Room</option>
                                        <option value="Room A" {{ $reservasi->ruangan == 'Room A' ? 'selected' : '' }}>Room A</option>
                                        <option value="Room B" {{ $reservasi->ruangan == 'Room B' ? 'selected' : '' }}>Room B</option>
                                        <option value="Room C" {{ $reservasi->ruangan == 'Room C' ? 'selected' : '' }}>Room C</option>
                                        <option value="Room D" {{ $reservasi->ruangan == 'Room D' ? 'selected' : '' }}>Room D</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="tanggal">Date</label>
                                    <input type="date" class="form-control" id="tanggal" name="tanggal" value="{{ $reservasi->tanggal }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="waktu_mulai">Start Time</label>
                                    <input type="time" class="form-control" id="waktu_mulai" name="waktu_mulai" value="{{ $reservasi->waktu_mulai }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="waktu_selesai">End Time</label>
                                    <input type="time" class="form-control" id="waktu_selesai" name="waktu_selesai" value="{{ $reservasi->waktu_selesai }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select class="form-control" id="status" name="status" required>
                                        <option value="Pending" {{ $reservasi->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="Approved" {{ $reservasi->status == 'Approved' ? 'selected' : '' }}>Approved</option>
                                        <option value="Rejected" {{ $reservasi->status == 'Rejected' ? 'selected' : '' }}>Rejected</option>
                                    </select>
                                </div>
                            </div>
                        </div> {{-- End of First Row --}}

                        {{-- Description Row - Full Width --}}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea class="form-control" id="description" name="description" rows="3">{{ $reservasi->description }}</textarea>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary mt-3">Update Reservasi</button>
                    </form>

                </div>
            </div>

        </div>
    </section>

</div>

@include('layouts.footer')
