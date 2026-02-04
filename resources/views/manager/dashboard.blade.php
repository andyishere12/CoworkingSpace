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
                            <h3>150</h3>
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
                            <h3>8</h3>
                            <p>Pending Reservations</p>
                            <div class="progress mb-2" style="height: 3px;">
                                <div class="progress-bar bg-white" style="width: 70%"></div>
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
                            <h3>5</h3>
                            <p>Pending Events</p>
                            <div class="progress mb-2" style="height: 3px;">
                                <div class="progress-bar bg-white" style="width: 50%"></div>
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
                            <h3>42</h3>
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

            <!-- Advanced Analytics Section -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-chart-line mr-2"></i>
                                Advanced Analytics Dashboard
                            </h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <a href="#" class="btn btn-sm btn-primary">
                                    <i class="fas fa-expand"></i> Full Analytics
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <!-- Monthly Trend Chart -->
                                <div class="col-md-8">
                                    <div class="chart-container" style="position: relative; height: 300px;">
                                        <canvas id="monthlyTrendChart"></canvas>
                                    </div>
                                    <p class="text-center text-muted mt-2">
                                        <small>Monthly Visitor Trend - Last 6 Months</small>
                                    </p>
                                </div>

                                <!-- Member Distribution -->
                                <div class="col-md-4">
                                    <div class="chart-container" style="position: relative; height: 300px;">
                                        <canvas id="memberDistributionChart"></canvas>
                                    </div>
                                    <p class="text-center text-muted mt-2">
                                        <small>Member Type Distribution</small>
                                    </p>
                                </div>
                            </div>

                            <!-- Key Metrics Row -->
                            <div class="row mt-4">
                                <div class="col-md-3">
                                    <div class="info-box bg-light">
                                        <span class="info-box-icon bg-info">
                                            <i class="fas fa-percentage"></i>
                                        </span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Occupancy Rate</span>
                                            <span class="info-box-number">75%</span>
                                            <div class="progress">
                                                <div class="progress-bar bg-info" style="width: 75%"></div>
                                            </div>
                                            <span class="progress-description">
                                                <i class="fas fa-arrow-up text-success"></i> 5% vs last month
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="info-box bg-light">
                                        <span class="info-box-icon bg-success">
                                            <i class="fas fa-redo"></i>
                                        </span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Retention Rate</span>
                                            <span class="info-box-number">82%</span>
                                            <div class="progress">
                                                <div class="progress-bar bg-success" style="width: 82%"></div>
                                            </div>
                                            <span class="progress-description">
                                                <i class="fas fa-arrow-up text-success"></i> Excellent
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="info-box bg-light">
                                        <span class="info-box-icon bg-warning">
                                            <i class="fas fa-clock"></i>
                                        </span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Avg Duration</span>
                                            <span class="info-box-number">3.5h</span>
                                            <div class="progress">
                                                <div class="progress-bar bg-warning" style="width: 70%"></div>
                                            </div>
                                            <span class="progress-description">
                                                <i class="fas fa-minus text-muted"></i> Stable
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="info-box bg-light">
                                        <span class="info-box-icon bg-danger">
                                            <i class="fas fa-fire"></i>
                                        </span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Peak Hour</span>
                                            <span class="info-box-number">10:00</span>
                                            <div class="progress">
                                                <div class="progress-bar bg-danger" style="width: 100%"></div>
                                            </div>
                                            <span class="progress-description">
                                                <i class="fas fa-users"></i> Busiest time
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- AI-Powered Recommendations -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-outline card-success">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-robot mr-2"></i>
                                AI-Powered Insights & Recommendations
                            </h3>
                            <div class="card-tools">
                                <span class="badge badge-success">
                                    <i class="fas fa-sync-alt fa-spin"></i> Real-time Analysis
                                </span>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <!-- High Priority Insights -->
                                <div class="col-md-6">
                                    <div class="callout callout-warning">
                                        <h5><i class="fas fa-exclamation-triangle"></i> Attention Needed</h5>
                                        <p><strong>Capacity Alert:</strong> Monday 09:00-11:00 consistently hits 95% capacity. Consider:</p>
                                        <ul class="mb-2">
                                            <li>Opening additional workspace</li>
                                            <li>Implementing booking system for peak hours</li>
                                            <li>Early bird promotions for 07:00-09:00</li>
                                        </ul>
                                        <button class="btn btn-sm btn-warning">
                                            <i class="fas fa-cog"></i> Take Action
                                        </button>
                                    </div>

                                    <div class="callout callout-danger">
                                        <h5><i class="fas fa-chart-line"></i> Retention Risk</h5>
                                        <p><strong>15 members</strong> haven't visited in 30+ days. AI suggests:</p>
                                        <ul class="mb-2">
                                            <li>Send personalized re-engagement email</li>
                                            <li>Offer comeback discount (10-15%)</li>
                                            <li>Schedule follow-up call</li>
                                        </ul>
                                        <button class="btn btn-sm btn-danger">
                                            <i class="fas fa-envelope"></i> Send Campaign
                                        </button>
                                    </div>
                                </div>

                                <!-- Positive Insights -->
                                <div class="col-md-6">
                                    <div class="callout callout-success">
                                        <h5><i class="fas fa-trophy"></i> Success Metrics</h5>
                                        <p><strong>Student segment performing great!</strong></p>
                                        <ul class="mb-2">
                                            <li>70% of total visits (up from 65%)</li>
                                            <li>Average 4.2 hours per session</li>
                                            <li>High satisfaction scores (4.7/5)</li>
                                        </ul>
                                        <p class="mb-2"><strong>AI Recommendation:</strong> Invest more in student-focused amenities and study spaces.</p>
                                        <button class="btn btn-sm btn-success">
                                            <i class="fas fa-lightbulb"></i> View Strategy
                                        </button>
                                    </div>

                                    <div class="callout callout-info">
                                        <h5><i class="fas fa-lightbulb"></i> Growth Opportunity</h5>
                                        <p><strong>Weekend utilization low (35%)</strong></p>
                                        <ul class="mb-2">
                                            <li>Partner with local communities</li>
                                            <li>Host weekend workshops/events</li>
                                            <li>Special weekend packages</li>
                                        </ul>
                                        <button class="btn btn-sm btn-info">
                                            <i class="fas fa-calendar-plus"></i> Plan Events
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Quick Actions from AI -->
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <h6 class="text-muted mb-3">
                                        <i class="fas fa-magic"></i> AI-Suggested Quick Actions
                                    </h6>
                                    <div class="btn-group-toggle" data-toggle="buttons">
                                        <label class="btn btn-outline-primary btn-sm">
                                            <input type="checkbox"> <i class="fas fa-instagram"></i> Post on Instagram (Best time: 19:00)
                                        </label>
                                        <label class="btn btn-outline-success btn-sm ml-2">
                                            <input type="checkbox"> <i class="fas fa-envelope"></i> Send weekly newsletter
                                        </label>
                                        <label class="btn btn-outline-warning btn-sm ml-2">
                                            <input type="checkbox"> <i class="fas fa-broom"></i> Schedule deep cleaning (low traffic day)
                                        </label>
                                        <label class="btn btn-outline-info btn-sm ml-2">
                                            <input type="checkbox"> <i class="fas fa-phone"></i> Call top 5 members for feedback
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions Panel -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header bg-gradient-primary">
                            <h3 class="card-title">
                                <i class="fas fa-bolt mr-2"></i>
                                Quick Management Actions
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-2">
                                    <a href="#" class="btn btn-app bg-primary w-100">
                                        <i class="fas fa-chart-line"></i>
                                        Full Analytics
                                    </a>
                                </div>
                                <div class="col-md-2">
                                    <a href="#" class="btn btn-app bg-success w-100">
                                        <span class="badge badge-warning">5</span>
                                        <i class="fas fa-calendar-check"></i>
                                        Approve Events
                                    </a>
                                </div>
                                <div class="col-md-2">
                                    <a href="#" class="btn btn-app bg-warning w-100">
                                        <span class="badge badge-danger">8</span>
                                        <i class="fas fa-clipboard-check"></i>
                                        Approve Bookings
                                    </a>
                                </div>
                                <div class="col-md-2">
                                    <a href="#" class="btn btn-app bg-info w-100">
                                        <i class="fas fa-users-cog"></i>
                                        Manage Users
                                    </a>
                                </div>
                                <div class="col-md-2">
                                    <a href="#" class="btn btn-app bg-secondary w-100">
                                        <i class="fas fa-users"></i>
                                        View Members
                                    </a>
                                </div>
                                <div class="col-md-2">
                                    <a href="#" class="btn btn-app bg-dark w-100">
                                        <i class="fas fa-cog"></i>
                                        Settings
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
<!-- /.content-wrapper -->

@include('manager.layouts.footer')

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- Dashboard Charts Script -->
<script>
// Monthly Trend Chart
const trendCtx = document.getElementById('monthlyTrendChart');
if (trendCtx) {
    new Chart(trendCtx.getContext('2d'), {
        type: 'line',
        data: {
            labels: ['July', 'August', 'September', 'October', 'November', 'December'],
            datasets: [{
                label: 'Visitors',
                data: [120, 150, 180, 160, 190, 220],
                borderColor: '#007bff',
                backgroundColor: 'rgba(0, 123, 255, 0.1)',
                tension: 0.4,
                fill: true,
                pointRadius: 5,
                pointBackgroundColor: '#007bff',
                pointBorderColor: '#fff',
                pointBorderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    padding: 12,
                    titleFont: {
                        size: 14
                    },
                    bodyFont: {
                        size: 13
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
}

// Member Distribution Donut Chart
const distributionCtx = document.getElementById('memberDistributionChart');
if (distributionCtx) {
    new Chart(distributionCtx.getContext('2d'), {
        type: 'doughnut',
        data: {
            labels: ['Student', 'Professional', 'Freelancer', 'Business', 'Other'],
            datasets: [{
                data: [70, 13, 10, 5, 2],
                backgroundColor: [
                    '#007bff',
                    '#28a745',
                    '#ffc107',
                    '#dc3545',
                    '#6c757d'
                ],
                borderWidth: 2,
                borderColor: '#fff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 15,
                        font: {
                            size: 11
                        },
                        usePointStyle: true
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.label + ': ' + context.parsed + '%';
                        }
                    }
                }
            },
            cutout: '65%'
        }
    });
}
</script>