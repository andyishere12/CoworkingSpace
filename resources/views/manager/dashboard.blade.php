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
                                <div class="progress-bar bg-white" style="width: {{ $pendingReservations > 0 ? 70 : 0 }}%"></div>
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
                                <div class="progress-bar bg-white" style="width: {{ $pendingEvents > 0 ? 50 : 0 }}%"></div>
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
                        <a href="{{ route('manager.analytics') }}" class="small-box-footer">
                            View Analytics <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Welcome Alert -->
            <div class="row">
                <div class="col-12">
                    <div class="alert alert-info alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h5><i class="fas fa-info"></i> Welcome, Manager!</h5>
                        Dashboard sedang menampilkan data real-time dari sistem.
                    </div>
                </div>
            </div>

            <!-- ✅ NEW: Analytics Preview + Recent Activity -->
            <div class="row">

                <!-- Analytics Preview -->
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header border-0">
                            <h3 class="card-title">
                                <i class="fas fa-chart-bar mr-2"></i>
                                Quick Analytics
                            </h3>
                            <div class="card-tools">
                                <a href="{{ route('manager.analytics') }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-eye"></i> Full Analytics
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <div class="info-box bg-light">
                                        <span class="info-box-icon bg-info">
                                            <i class="fas fa-clock"></i>
                                        </span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Peak Hour</span>
                                            <span class="info-box-number">10:00</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="info-box bg-light">
                                        <span class="info-box-icon bg-success">
                                            <i class="fas fa-redo"></i>
                                        </span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Retention</span>
                                            <span class="info-box-number">100%</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="info-box bg-light">
                                        <span class="info-box-icon bg-warning">
                                            <i class="fas fa-hourglass-half"></i>
                                        </span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Avg Duration</span>
                                            <span class="info-box-number">8h 6m</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="info-box bg-light">
                                        <span class="info-box-icon bg-danger">
                                            <i class="fas fa-arrow-up"></i>
                                        </span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Visit Growth</span>
                                            <span class="info-box-number">+100%</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header border-0">
                            <h3 class="card-title">
                                <i class="fas fa-history mr-2"></i>
                                Recent Activity
                            </h3>
                            <div class="card-tools">
                                <span class="badge badge-primary">Today</span>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <ul class="products-list product-list-in-card pl-2 pr-2">
                                <li class="item">
                                    <div class="product-img">
                                        <span class="badge badge-success" style="width:50px; height:50px; line-height:50px;">
                                            <i class="fas fa-user-plus fa-2x"></i>
                                        </span>
                                    </div>
                                    <div class="product-info">
                                        <a href="#" class="product-title">
                                            New Member Registered
                                            <span class="badge badge-success float-right">New</span>
                                        </a>
                                        <span class="product-description">
                                            Member #{{ $totalMembers }} joined today
                                        </span>
                                    </div>
                                </li>
                                <li class="item">
                                    <div class="product-img">
                                        <span class="badge badge-warning" style="width:50px; height:50px; line-height:50px;">
                                            <i class="fas fa-bookmark fa-2x"></i>
                                        </span>
                                    </div>
                                    <div class="product-info">
                                        <a href="#" class="product-title">
                                            {{ $pendingReservations }} Reservations Pending
                                            <span class="badge badge-warning float-right">Action Needed</span>
                                        </a>
                                        <span class="product-description">
                                            Awaiting your approval
                                        </span>
                                    </div>
                                </li>
                                <li class="item">
                                    <div class="product-img">
                                        <span class="badge badge-info" style="width:50px; height:50px; line-height:50px;">
                                            <i class="fas fa-calendar fa-2x"></i>
                                        </span>
                                    </div>
                                    <div class="product-info">
                                        <a href="#" class="product-title">
                                            {{ $pendingEvents }} Events Pending
                                            <span class="badge badge-info float-right">Review</span>
                                        </a>
                                        <span class="product-description">
                                            Need decision for upcoming events
                                        </span>
                                    </div>
                                </li>
                                <li class="item">
                                    <div class="product-img">
                                        <span class="badge badge-danger" style="width:50px; height:50px; line-height:50px;">
                                            <i class="fas fa-users fa-2x"></i>
                                        </span>
                                    </div>
                                    <div class="product-info">
                                        <a href="#" class="product-title">
                                            {{ $activeToday }} Members Active
                                            <span class="badge badge-danger float-right">Live</span>
                                        </a>
                                        <span class="product-description">
                                            Currently checked in at coworking space
                                        </span>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ✅ NEW: Quick Actions Panel -->
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-bolt mr-2"></i>
                                Quick Actions
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-2 col-6">
                                    <a href="{{ route('manager.analytics') }}" class="btn btn-app bg-primary">
                                        <span class="badge bg-teal">Live</span>
                                        <i class="fas fa-chart-line"></i>
                                        Analytics
                                    </a>
                                </div>
                                <div class="col-lg-2 col-6">
                                    <a href="#" class="btn btn-app bg-warning">
                                        <span class="badge bg-orange">{{ $pendingReservations }}</span>
                                        <i class="fas fa-bookmark"></i>
                                        Reservations
                                    </a>
                                </div>
                                <div class="col-lg-2 col-6">
                                    <a href="#" class="btn btn-app bg-success">
                                        <span class="badge bg-green">{{ $pendingEvents }}</span>
                                        <i class="fas fa-calendar"></i>
                                        Events
                                    </a>
                                </div>
                                <div class="col-lg-2 col-6">
                                    <a href="#" class="btn btn-app bg-info">
                                        <span class="badge bg-cyan">{{ $totalMembers }}</span>
                                        <i class="fas fa-users"></i>
                                        Members
                                    </a>
                                </div>
                                <div class="col-lg-2 col-6">
                                    <a href="#" class="btn btn-app bg-secondary">
                                        <span class="badge bg-gray">Soon</span>
                                        <i class="fas fa-cog"></i>
                                        Settings
                                    </a>
                                </div>
                                <div class="col-lg-2 col-6">
                                    <a href="#" class="btn btn-app bg-purple">
                                        <i class="fas fa-user"></i>
                                        Profile
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

@include('manager.layouts.footer')