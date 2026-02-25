@include('manager.layouts.header')

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><i class="fas fa-user mr-2"></i>Detail Member</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('manager.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('manager.members.index') }}">Members</a></li>
                        <li class="breadcrumb-item active">Detail</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">

                {{-- Kolom Kiri - Info Member --}}
                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-body text-center">
                            @if($member->foto)
                                <img src="{{ asset('uploads/foto/' . $member->foto) }}"
                                    class="img-circle mb-3"
                                    style="width:120px;height:120px;object-fit:cover;border:4px solid #6C3FB5;">
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($member->nama) }}&size=120&background=6C3FB5&color=fff"
                                    class="img-circle mb-3"
                                    style="width:120px;height:120px;border:4px solid #6C3FB5;">
                            @endif
                            <h4>{{ $member->nama }}</h4>
                            <p class="text-muted mb-1">{{ $member->institusi ?? '-' }}</p>
                            <span class="badge {{ $member->status == 'Aktif' ? 'badge-success' : 'badge-danger' }} px-3 py-2 mb-3">
                                {{ $member->status }}
                            </span>
                            <hr>
                            <div class="text-left">
                                <p><i class="fas fa-envelope mr-2 text-muted"></i>{{ $member->email }}</p>
                                <p><i class="fas fa-phone mr-2 text-muted"></i>{{ $member->no_hp ?? '-' }}</p>
                                <p><i class="fas fa-map-marker-alt mr-2 text-muted"></i>{{ $member->alamat ?? '-' }}</p>
                                <p><i class="fas fa-birthday-cake mr-2 text-muted"></i>
                                    {{ $member->tanggal_lahir ? \Carbon\Carbon::parse($member->tanggal_lahir)->format('d M Y') : '-' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Kolom Kanan - Detail & Riwayat --}}
                <div class="col-md-8">

                    {{-- Detail Member --}}
                    <div class="card shadow-sm mb-4">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-info-circle mr-2"></i>Informasi Member</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <table class="table table-borderless table-sm">
                                        <tr>
                                            <th class="text-muted" style="width:40%">ID</th>
                                            <td>{{ $member->id }}</td>
                                        </tr>
                                        <tr>
                                            <th class="text-muted">Nama</th>
                                            <td>{{ $member->nama }}</td>
                                        </tr>
                                        <tr>
                                            <th class="text-muted">Email</th>
                                            <td>{{ $member->email }}</td>
                                        </tr>
                                        <tr>
                                            <th class="text-muted">No. HP</th>
                                            <td>{{ $member->no_hp ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th class="text-muted">Tgl Lahir</th>
                                            <td>{{ $member->tanggal_lahir ? \Carbon\Carbon::parse($member->tanggal_lahir)->format('d M Y') : '-' }}</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="table table-borderless table-sm">
                                        <tr>
                                            <th class="text-muted" style="width:40%">Institusi</th>
                                            <td>{{ $member->institusi ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th class="text-muted">Aktivitas</th>
                                            <td>{{ $member->aktivitas ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th class="text-muted">Type</th>
                                            <td>
                                                <span class="badge badge-info">{{ $member->type ?? '-' }}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="text-muted">Status</th>
                                            <td>
                                                <span class="badge {{ $member->status == 'Aktif' ? 'badge-success' : 'badge-danger' }}">
                                                    {{ $member->status }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="text-muted">Bergabung</th>
                                            <td>{{ $member->created_at->format('d M Y') }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            @if($member->alamat)
                                <div class="mt-2">
                                    <strong class="text-muted">Alamat:</strong>
                                    <p class="mb-0">{{ $member->alamat }}</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Riwayat Reservasi --}}
                    <div class="card shadow-sm mb-4">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-bookmark mr-2"></i>Riwayat Reservasi</h3>
                        </div>
                        <div class="card-body p-0">
                            @php
                                $reservasiMember = \App\Models\Reservasi::where('nama_pemesanan', $member->nama)
                                    ->orderBy('tanggal', 'desc')->take(5)->get();
                            @endphp
                            @if($reservasiMember->count() > 0)
                                <table class="table table-sm mb-0">
                                    <thead>
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Ruangan</th>
                                            <th>Waktu</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($reservasiMember as $r)
                                        <tr>
                                            <td>{{ \Carbon\Carbon::parse($r->tanggal)->format('d M Y') }}</td>
                                            <td>{{ $r->ruangan }}</td>
                                            <td>{{ \Carbon\Carbon::parse($r->waktu_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($r->waktu_selesai)->format('H:i') }}</td>
                                            <td>
                                                <span class="badge
                                                    @if($r->status == 'Approved') badge-success
                                                    @elseif($r->status == 'Rejected') badge-danger
                                                    @else badge-warning @endif">
                                                    {{ $r->status }}
                                                </span>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <div class="text-center py-3 text-muted">
                                    <i class="fas fa-bookmark fa-2x mb-2 d-block"></i>
                                    Belum ada riwayat reservasi.
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Tombol Kembali --}}
                    <a href="{{ route('manager.members.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left mr-1"></i>Kembali ke List
                    </a>

                </div>
            </div>
        </div>
    </section>
</div>

@include('manager.layouts.footer')
