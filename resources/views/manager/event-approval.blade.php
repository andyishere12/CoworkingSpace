@include('manager.layouts.header')

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Event Approval</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('manager.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Event Approval</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">

            @if(session('success'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                </div>
            @endif

            <!-- Statistics Cards -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card bg-warning text-white">
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
                    <div class="card bg-success text-white">
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
                    <div class="card bg-danger text-white">
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
                    <div class="card bg-info text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-white mb-1">Total Events</h6>
                                    <h3 class="mb-0">{{ $stats['total_all'] }}</h3>
                                </div>
                                <i class="fas fa-calendar-alt fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabs Bootstrap 4 -->
            <ul class="nav nav-tabs mb-4" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#pending" role="tab">
                        <i class="fas fa-clock mr-1"></i>Pending
                        <span class="badge badge-warning ml-1">{{ $stats['total_pending'] }}</span>
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

                <!-- Pending Tab -->
                <div class="tab-pane fade show active" id="pending" role="tabpanel">
                    @if($pendingEvents->count() > 0)
                        <div class="row">
                            @foreach($pendingEvents as $event)
                                <div class="col-md-6 mb-4">
                                    <div class="card border-warning">
                                        <div class="card-header bg-warning text-white">
                                            <h5 class="mb-0">
                                                <i class="fas fa-calendar-alt mr-2"></i>{{ $event->nama_event }}
                                            </h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row mb-2">
                                                <div class="col-6">
                                                    <small class="text-muted">Organizer</small>
                                                    <p class="mb-0"><strong>{{ $event->organizer_name }}</strong></p>
                                                </div>
                                                <div class="col-6">
                                                    <small class="text-muted">Tanggal Event</small>
                                                    <p class="mb-0"><strong>{{ \Carbon\Carbon::parse($event->tanggal_event)->format('d M Y') }}</strong></p>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-6">
                                                    <small class="text-muted">Jumlah Peserta</small>
                                                    <p class="mb-0"><strong>{{ $event->jumlah_peserta ?? 0 }} orang</strong></p>
                                                </div>
                                                <div class="col-6">
                                                    <small class="text-muted">Diajukan</small>
                                                    <p class="mb-0"><strong>{{ $event->created_at->diffForHumans() }}</strong></p>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <small class="text-muted">Deskripsi</small>
                                                <p class="mb-0">{{ $event->deskripsi ?? 'Tidak ada deskripsi' }}</p>
                                            </div>
                                            <div class="row">
                                                <div class="col-6">
                                                    <button type="button" class="btn btn-success btn-block"
                                                        onclick="approveEvent({{ $event->id }}, '{{ addslashes($event->nama_event) }}')">
                                                        <i class="fas fa-check mr-1"></i>Approve
                                                    </button>
                                                </div>
                                                <div class="col-6">
                                                    <button type="button" class="btn btn-danger btn-block"
                                                        data-toggle="modal" data-target="#rejectModal{{ $event->id }}">
                                                        <i class="fas fa-times mr-1"></i>Reject
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Reject Modal Bootstrap 4 -->
                                <div class="modal fade" id="rejectModal{{ $event->id }}" tabindex="-1" role="dialog">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header bg-danger text-white">
                                                <h5 class="modal-title">Tolak Event: {{ $event->nama_event }}</h5>
                                                <button type="button" class="close text-white" data-dismiss="modal">
                                                    <span>&times;</span>
                                                </button>
                                            </div>
                                            <form action="{{ route('manager.event-approval.reject', $event->id) }}" method="POST">
                                                @csrf
                                                <div class="modal-body">
                                                    <p>Apakah Anda yakin ingin menolak event ini?</p>
                                                    <div class="form-group">
                                                        <label>Alasan Penolakan (opsional)</label>
                                                        <textarea class="form-control" name="rejection_reason" rows="3"
                                                            placeholder="Tuliskan alasan penolakan..."></textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-danger">
                                                        <i class="fas fa-times mr-1"></i>Ya, Tolak Event
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
                            <i class="fas fa-inbox fa-4x text-muted mb-3"></i>
                            <h5 class="text-muted">Tidak ada event yang menunggu persetujuan</h5>
                        </div>
                    @endif
                </div>

                <!-- Approved Tab -->
                <div class="tab-pane fade" id="approved" role="tabpanel">
                    @if($approvedEvents->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr class="bg-success text-white">
                                        <th>Nama Event</th>
                                        <th>Organizer</th>
                                        <th>Tanggal Event</th>
                                        <th>Peserta</th>
                                        <th>Disetujui</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($approvedEvents as $event)
                                        <tr>
                                            <td><strong>{{ $event->nama_event }}</strong></td>
                                            <td>{{ $event->organizer_name }}</td>
                                            <td>{{ \Carbon\Carbon::parse($event->tanggal_event)->format('d M Y') }}</td>
                                            <td>{{ $event->jumlah_peserta ?? 0 }} orang</td>
                                            <td>{{ $event->updated_at->diffForHumans() }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-inbox fa-4x text-muted mb-3"></i>
                            <h5 class="text-muted">Belum ada event yang disetujui</h5>
                        </div>
                    @endif
                </div>

                <!-- Rejected Tab -->
                <div class="tab-pane fade" id="rejected" role="tabpanel">
                    @if($rejectedEvents->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr class="bg-danger text-white">
                                        <th>Nama Event</th>
                                        <th>Organizer</th>
                                        <th>Tanggal Event</th>
                                        <th>Peserta</th>
                                        <th>Ditolak</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($rejectedEvents as $event)
                                        <tr>
                                            <td><strong>{{ $event->nama_event }}</strong></td>
                                            <td>{{ $event->organizer_name }}</td>
                                            <td>{{ \Carbon\Carbon::parse($event->tanggal_event)->format('d M Y') }}</td>
                                            <td>{{ $event->jumlah_peserta ?? 0 }} orang</td>
                                            <td>{{ $event->updated_at->diffForHumans() }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-inbox fa-4x text-muted mb-3"></i>
                            <h5 class="text-muted">Belum ada event yang ditolak</h5>
                        </div>
                    @endif
                </div>

            </div>{{-- /.tab-content --}}

        </div>
    </section>
</div>

@include('manager.layouts.footer')

<form id="approveForm" method="POST" style="display:none;">
    @csrf
</form>

<script>
function approveEvent(eventId, eventName) {
    if (confirm('Apakah Anda yakin ingin menyetujui event "' + eventName + '"?')) {
        var form = document.getElementById('approveForm');
        form.action = '/manager/event-approval/' + eventId + '/approve';
        form.submit();
    }
}
</script>