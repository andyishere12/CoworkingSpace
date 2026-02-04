@include('manager.layouts.header')

<!-- Content Wrapper -->
<div class="content-wrapper">
    <!-- Content Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Manager Dashboard</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Home</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            
            <!-- Stats Row -->
            <div class="row">
                <!-- Total Members -->
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $totalMembers }}</h3>
                            <p>Total Members</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <a href="{{ route('manager.members.index') }}" class="small-box-footer">
                            More info <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>

                <!-- Pending Reservations -->
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $pendingReservations }}</h3>
                            <p>Pending Reservations</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-bookmark"></i>
                        </div>
                        <a href="{{ route('manager.reservation-approval.index') }}" class="small-box-footer">
                            More info <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>

                <!-- Pending Events -->
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $pendingEvents }}</h3>
                            <p>Pending Events</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-calendar"></i>
                        </div>
                        <a href="{{ route('manager.event-approval.index') }}" class="small-box-footer">
                            More info <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>

                <!-- Active Today -->
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ $activeToday }}</h3>
                            <p>Active Today</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-user-check"></i>
                        </div>
                        <a href="{{ route('manager.analytics') }}" class="small-box-footer">
                            More info <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Info boxes -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-chart-pie mr-2"></i>
                                Quick Actions
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <a href="{{ route('manager.analytics') }}" class="btn btn-app bg-primary">
                                        <i class="fas fa-chart-line"></i> Analytics
                                    </a>
                                </div>
                                <div class="col-md-3">
                                    <a href="{{ route('manager.event-approval.index') }}" class="btn btn-app bg-success">
                                        <i class="fas fa-calendar-check"></i> Approve Events
                                    </a>
                                </div>
                                <div class="col-md-3">
                                    <a href="{{ route('manager.reservation-approval.index') }}" class="btn btn-app bg-warning">
                                        <i class="fas fa-clipboard-check"></i> Approve Reservations
                                    </a>
                                </div>
                                <div class="col-md-3">
                                    <a href="{{ route('manager.users.index') }}" class="btn btn-app bg-info">
                                        <i class="fas fa-users-cog"></i> Manage Users
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
</div>

@include('layouts.footer')
