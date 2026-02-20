@include('manager.layouts.header')

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Reservation Approval</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('manager.dashboard') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item active">Reservation Approval</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">

            {{-- Flash Messages --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                    <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                    <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
                </div>
            @endif

            {{-- Statistics Cards --}}
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card text-white bg-warning mb-3">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-white mb-1">Pending</h6>
                                    <h3 class="mb-0">{{ $stats['total_pending'] }}</h3>
                                </div>
                                <i class="fas fa-clock fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-white bg-success mb-3">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-white mb-1">Approved</h6>
                                    <h3 class="mb-0">{{ $stats['total_approved'] }}</h3>
                                </div>
                                <i class="fas fa-check-circle fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-white bg-danger mb-3">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-white mb-1">Rejected</h6>
                                    <h3 class="mb-0">{{ $stats['total_rejected'] }}</h3>
                                </div>
                                <i class="fas fa-times-circle fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-white bg-info mb-3">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-white mb-1">Total</h6>
                                    <h3 class="mb-0">{{ $stats['total_all'] }}</h3>
                                </div>
                                <i class="fas fa-bookmark fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tabs --}}
            <ul class="nav nav-tabs mb-4" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#pending" role="tab">
                        <i class="fas fa-clock mr-1"></i>Pending
                        @if($stats['total_pending'] > 0)
                            <span class="badge badge-warning ml-1">{{ $stats['total_pending'] }}</span>
                        @endif
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#approved" role="tab">
                        <i class="fas fa-check-circle mr-1"></i>Approved
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#rejected" role="tab">
                        <i class="fas fa-times-circle mr-1"></i>Rejected
                    </a>
                </li>
            </ul>

            <div class="tab-content">

                {{-- TAB PENDING --}}
                <div class="tab-pane fade show active" id="pending" role="tabpanel">
                    @if($pendingReservasi->count() > 0)
                        <div class="row">
                            @foreach($pendingReservasi as $reservasi)
                                <div class="col-md-6 mb-4">
                                    <div class="card border-warning shadow-sm">
                                        <div class="card-header bg-warning text-white">
                                            <h5 class="mb-0">
                                                <i class="fas fa-bookmark mr-2"></i>
                                                {{ $reservasi->nama_pemesanan }}
                                            </h5>
                                        </div>
                                        <div class="card-body">

                                            <div class="row mb-2">
                                                <div class="col-6">
                                                    <small class="text-muted d-block">Kontak</small>
                                                    <strong>{{ $reservasi->kontak }}</strong>
                                                </div>
                                                <div class="col-6">
                                                    <small class="text-muted d-block">Institusi</small>
                                                    <strong>{{ $reservasi->institusi ?? '-' }}</strong>
                                                </div>
                                            </div>

                                            <div class="row mb-2">
                                                <div class="col-6">
                                                    <small class="text-muted d-block">Tanggal</small>
                                                    <strong>{{ \Carbon\Carbon::parse($reservasi->tanggal)->format('d M Y') }}</strong>
                                                </div>
                                                <div class="col-6">
                                                    <small class="text-muted d-block">Waktu</small>
                                                    <strong>
                                                        {{ \Carbon\Carbon::parse($reservasi->waktu_mulai)->format('H:i') }}
                                                        &ndash;
                                                        {{ \Carbon\Carbon::parse($reservasi->waktu_selesai)->format('H:i') }}
                                                    </strong>
                                                </div>
                                            </div>

                                            <div class="row mb-2">
                                                <div class="col-6">
                                                    <small class="text-muted d-block">Ruangan</small>
                                                    <strong>{{ $reservasi->ruangan }}</strong>
                                                </div>
                                                <div class="col-6">
                                                    <small class="text-muted d-block">Jumlah Peserta</small>
                                                    <strong>{{ $reservasi->attends }} orang</strong>
                                                </div>
                                            </div>

                                            <div class="row mb-2">
                                                <div class="col-6">
                                                    <small class="text-muted d-block">Tujuan</small>
                                                    <strong>{{ $reservasi->purpose ?? '-' }}</strong>
                                                </div>
                                                <div class="col-6">
                                                    <small class="text-muted d-block">Diajukan</small>
                                                    <strong>{{ $reservasi->created_at->diffForHumans() }}</strong>
                                                </div>
                                            </div>

                                            @if($reservasi->description)
                                                <div class="mb-3">
                                                    <small class="text-muted d-block">Keterangan</small>
                                                    <p class="mb-0">{{ $reservasi->description }}</p>
                                                </div>
                                            @endif

                                            {{-- Tombol Approve & Reject --}}
                                            <div class="row mt-3">
                                                <div class="col-6">
                                                    <button type="button" class="btn btn-success btn-block"
                                                        data-toggle="modal"
                                                        data-target="#approveModal{{ $reservasi->id }}">
                                                        <i class="fas fa-check mr-1"></i>Approve
                                                    </button>
                                                </div>
                                                <div class="col-6">
                                                    <button type="button" class="btn btn-danger btn-block"
                                                        data-toggle="modal"
                                                        data-target="#rejectModal{{ $reservasi->id }}">
                                                        <i class="fas fa-times mr-1"></i>Reject
                                                    </button>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                {{-- Modal Approve (Bootstrap 4) --}}
                                <div class="modal fade" id="approveModal{{ $reservasi->id }}" tabindex="-1" role="dialog">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header bg-success text-white">
                                                <h5 class="modal-title">
                                                    <i class="fas fa-check-circle mr-2"></i>
                                                    Setujui Reservasi
                                                </h5>
                                                <button type="button" class="close text-white" data-dismiss="modal">
                                                    <span>&times;</span>
                                                </button>
                                            </div>
                                            <form action="{{ route('manager.reservation-approval.approve', $reservasi->id) }}" method="POST">
                                                @csrf
                                                <div class="modal-body">
                                                    <p>Apakah Anda yakin ingin menyetujui reservasi dari:</p>
                                                    <p><strong>{{ $reservasi->nama_pemesanan }}</strong>
                                                    ({{ \Carbon\Carbon::parse($reservasi->tanggal)->format('d M Y') }})?</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-success">
                                                        <i class="fas fa-check mr-1"></i>Ya, Setujui
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                {{-- Modal Reject (Bootstrap 4) --}}
                                <div class="modal fade" id="rejectModal{{ $reservasi->id }}" tabindex="-1" role="dialog">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header bg-danger text-white">
                                                <h5 class="modal-title">
                                                    <i class="fas fa-times-circle mr-2"></i>
                                                    Tolak Reservasi
                                                </h5>
                                                <button type="button" class="close text-white" data-dismiss="modal">
                                                    <span>&times;</span>
                                                </button>
                                            </div>
                                            <form action="{{ route('manager.reservation-approval.reject', $reservasi->id) }}" method="POST">
                                                @csrf
                                                <div class="modal-body">
                                                    <p>Apakah Anda yakin ingin menolak reservasi dari:</p>
                                                    <p><strong>{{ $reservasi->nama_pemesanan }}</strong>
                                                    ({{ \Carbon\Carbon::parse($reservasi->tanggal)->format('d M Y') }})?</p>
                                                    <div class="form-group">
                                                        <label>Alasan Penolakan <small class="text-muted">(opsional)</small></label>
                                                        <textarea class="form-control" name="rejection_reason"
                                                            rows="3"
                                                            placeholder="Tuliskan alasan penolakan..."></textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                                        Batal
                                                    </button>
                                                    <button type="submit" class="btn btn-danger">
                                                        <i class="fas fa-times mr-1"></i>Ya, Tolak
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-inbox fa-4x text-muted mb-3 d-block"></i>
                            <h5 class="text-muted">Tidak ada reservasi yang menunggu persetujuan</h5>
                        </div>
                    @endif
                </div>

                {{-- TAB APPROVED --}}
                <div class="tab-pane fade" id="approved" role="tabpanel">
                    @if($approvedReservasi->count() > 0)
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr class="bg-success text-white">
                                                <th>Nama Pemesan</th>
                                                <th>Institusi</th>
                                                <th>Ruangan</th>
                                                <th>Tanggal</th>
                                                <th>Waktu</th>
                                                <th>Peserta</th>
                                                <th>Tujuan</th>
                                                <th>Disetujui</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($approvedReservasi as $reservasi)
                                                <tr>
                                                    <td><strong>{{ $reservasi->nama_pemesanan }}</strong></td>
                                                    <td>{{ $reservasi->institusi ?? '-' }}</td>
                                                    <td>{{ $reservasi->ruangan }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($reservasi->tanggal)->format('d M Y') }}</td>
                                                    <td>
                                                        {{ \Carbon\Carbon::parse($reservasi->waktu_mulai)->format('H:i') }}
                                                        &ndash;
                                                        {{ \Carbon\Carbon::parse($reservasi->waktu_selesai)->format('H:i') }}
                                                    </td>
                                                    <td>{{ $reservasi->attends }} orang</td>
                                                    <td>{{ $reservasi->purpose ?? '-' }}</td>
                                                    <td>{{ $reservasi->updated_at->diffForHumans() }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-inbox fa-4x text-muted mb-3 d-block"></i>
                            <h5 class="text-muted">Belum ada reservasi yang disetujui</h5>
                        </div>
                    @endif
                </div>

                {{-- TAB REJECTED --}}
                <div class="tab-pane fade" id="rejected" role="tabpanel">
                    @if($rejectedReservasi->count() > 0)
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr class="bg-danger text-white">
                                                <th>Nama Pemesan</th>
                                                <th>Institusi</th>
                                                <th>Ruangan</th>
                                                <th>Tanggal</th>
                                                <th>Waktu</th>
                                                <th>Peserta</th>
                                                <th>Tujuan</th>
                                                <th>Ditolak</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($rejectedReservasi as $reservasi)
                                                <tr>
                                                    <td><strong>{{ $reservasi->nama_pemesanan }}</strong></td>
                                                    <td>{{ $reservasi->institusi ?? '-' }}</td>
                                                    <td>{{ $reservasi->ruangan }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($reservasi->tanggal)->format('d M Y') }}</td>
                                                    <td>
                                                        {{ \Carbon\Carbon::parse($reservasi->waktu_mulai)->format('H:i') }}
                                                        &ndash;
                                                        {{ \Carbon\Carbon::parse($reservasi->waktu_selesai)->format('H:i') }}
                                                    </td>
                                                    <td>{{ $reservasi->attends }} orang</td>
                                                    <td>{{ $reservasi->purpose ?? '-' }}</td>
                                                    <td>{{ $reservasi->updated_at->diffForHumans() }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-inbox fa-4x text-muted mb-3 d-block"></i>
                            <h5 class="text-muted">Belum ada reservasi yang ditolak</h5>
                        </div>
                    @endif
                </div>

            </div>{{-- /.tab-content --}}

        </div>
    </section>
</div>

@include('manager.layouts.footer')