@include('manager.layouts.header')

<!-- Content Wrapper -->
<div class="content-wrapper">
    <!-- Content Header -->
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
                    <h3 class="card-title">Events Pending Approval</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Organizer</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Capacity</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($events as $event)
                            <tr>
                                <td>{{ $event->title }}</td>
                                <td>{{ $event->description ?: 'No description' }}</td>
                                <td>{{ \Carbon\Carbon::parse($event->start_date)->format('M d, Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($event->end_date)->format('M d, Y') }}</td>
                                <td>
                                    @if($event->status == 'pending')
                                        <span class="badge badge-warning">Pending</span>
                                    @elseif($event->status == 'approved')
                                        <span class="badge badge-success">Approved</span>
                                    @else
                                        <span class="badge badge-danger">Rejected</span>
                                    @endif
                                </td>
                                <td>
                                    @if($event->status == 'pending')
                                    <form action="{{ route('manager.event-approval.approve', $event->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success">
                                            <i class="fas fa-check"></i> Approve
                                        </button>
                                    </form>
                                    <form action="{{ route('manager.event-approval.reject', $event->id) }}" method="POST" style="display:inline;">
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
                                <td colspan="6" class="text-center">No events found</td>
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