@include('manager.layouts.header')

<!-- Content Wrapper -->
<div class="content-wrapper">
    <!-- Content Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        <i class="fas fa-chart-line text-primary"></i> 
                        Manager Dashboard
                    </h1>
                    <p class="text-muted mb-0">Real-time analytics and AI-powered insights</p>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            
            <!-- Stats Overview -->
            <div class="row">
                <!-- Total Members -->
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-gradient-info">
                        <div class="inner">
                            <h3>{{ $totalMembers }}</h3>
                            <p>Total Members</p>
                            <div class="progress mb-2" style="height: 3px;">
                                <div class="progress-bar" style="width: 100%"></div>
                            </div>
                            <small><i class="fas fa-arrow-up"></i> Active management</small>
                        </div>
                        <div class="icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <a href="#" class="small-box-footer">
                            View Members <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>

                <!-- Pending Reservations -->
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-gradient-warning">
                        <div class="inner">
                            <h3>{{ $pendingReservations }}</h3>
                            <p>Pending Reservations</p>
                            <div class="progress mb-2" style="height: 3px;">
                                <div class="progress-bar bg-white" style="width: {{ $pendingReservations > 0 ? '70%' : '0%' }}"></div>
                            </div>
                            <small><i class="fas fa-clock"></i> Awaiting approval</small>
                        </div>
                        <div class="icon">
                            <i class="fas fa-bookmark"></i>
                        </div>
                        <a href="#" class="small-box-footer">
                            Review Now <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>

                <!-- Pending Events -->
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-gradient-success">
                        <div class="inner">
                            <h3>{{ $pendingEvents }}</h3>
                            <p>Pending Events</p>
                            <div class="progress mb-2" style="height: 3px;">
                                <div class="progress-bar bg-white" style="width: {{ $pendingEvents > 0 ? '50%' : '0%' }}"></div>
                            </div>
                            <small><i class="fas fa-calendar-check"></i> Need decision</small>
                        </div>
                        <div class="icon">
                            <i class="fas fa-calendar"></i>
                        </div>
                        <a href="#" class="small-box-footer">
                            Approve Events <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>

                <!-- Active Today -->
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-gradient-danger">
                        <div class="inner">
                            <h3>{{ $activeToday }}</h3>
                            <p>Active Members Today</p>
                            <div class="progress mb-2" style="height: 3px;">
                                <div class="progress-bar bg-white" style="width: 85%"></div>
                            </div>
                            <small><i class="fas fa-user-check"></i> Currently checked in</small>
                        </div>
                        <div class="icon">
                            <i class="fas fa-users-cog"></i>
                        </div>
                        <a href="#" class="small-box-footer">
                            View Analytics <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Quick Info -->
            <div class="row">
                <div class="col-12">
                    <div class="alert alert-info">
                        <h5><i class="icon fas fa-info"></i> Welcome, Manager!</h5>
                        Dashboard sedang menampilkan data real-time dari sistem.
                    </div>
                </div>
            </div>

        </div>
    </section>
</div>

@include('manager.layouts.footer')