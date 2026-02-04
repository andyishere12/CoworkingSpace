@include('manager.layouts.header')

<!-- Content Wrapper -->
<div class="content-wrapper">
    <!-- Content Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Reservation Approval</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('manager.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Reservation Approval</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                {{ session('success') }}
            </div>
            @endif

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Reservations Pending Approval</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Requested By</th>
                                <th>Contact</th>
                                <th>Date</th>
                                <th>Start Time</th>
                                <th>End Time</th>
                                <th>Purpose</th>
                                <th>Attendees</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($reservations as $reservation)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $reservation->dataMember->name ?? 'N/A' }}</td>
                                <td>{{ $reservation->room->name ?? 'N/A' }}</td>
                                <td>{{ \Carbon\Carbon::parse($reservation->start_time)->format('M d, Y h:i A') }}</td>
                                <td>{{ \Carbon\Carbon::parse($reservation->end_time)->format('M d, Y h:i A') }}</td>
                                <td>{{ $reservation->purpose }}</td>
                                <td>{{ $reservation->attendees }}</td>
                                <td>
                                    @if($reservation->status == 'pending')
                                        <span class="badge badge-warning">Pending</span>
                                    @elseif($reservation->status == 'approved')
                                        <span class="badge badge-success">Approved</span>
                                    @else
                                        <span class="badge badge-danger">Rejected</span>
                                    @endif
                                </td>
                                <td>
                                    @if($reservation->status == 'pending')
                                    <form action="{{ route('manager.reservation-approval.approve', $reservation->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success">
                                            <i class="fas fa-check"></i> Approve
                                        </button>
                                    </form>
                                    <form action="{{ route('manager.reservation-approval.reject', $reservation->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fas fa-times"></i> Reject
                                        </button>
                                    </form>
                                    @else
                                        <span class="text-muted">No action needed</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="10" class="text-center">No reservations found</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </section>
</div>

@include('layouts.footer')
