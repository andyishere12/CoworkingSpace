@include('manager.layouts.header')

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Settings</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('manager.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Settings</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">

            {{-- Success/Error Messages --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            {{-- Info Alert --}}
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <i class="fas fa-info-circle mr-2"></i>
                <strong>Note:</strong> To update your profile information (name, email, avatar), please visit the 
                <a href="{{ route('manager.profile.index') }}" class="alert-link">Profile page</a>.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            {{-- Tabs Navigation --}}
            <ul class="nav nav-tabs mb-4" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#notifications">
                        <i class="fas fa-bell mr-2"></i>Notifications
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#ai-settings">
                        <i class="fas fa-robot mr-2"></i>AI Analytics
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#dashboard">
                        <i class="fas fa-chart-line mr-2"></i>Dashboard
                    </a>
                </li>
            </ul>

            {{-- Tab Content --}}
            <div class="tab-content">

                {{-- TAB 1: NOTIFICATION SETTINGS --}}
                <div class="tab-pane fade show active" id="notifications">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Notification Preferences</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('manager.settings.notifications') }}" method="POST">
                                @csrf

                                <h5 class="mb-3">Email Notifications</h5>
                                
                                <div class="custom-control custom-switch mb-3">
                                    <input type="checkbox" class="custom-control-input" id="email_pending_events" 
                                           name="email_pending_events" 
                                           {{ session('notification_settings.email_pending_events', true) ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="email_pending_events">
                                        New Pending Events
                                        <small class="d-block text-muted">Get notified when new events need approval</small>
                                    </label>
                                </div>

                                <div class="custom-control custom-switch mb-3">
                                    <input type="checkbox" class="custom-control-input" id="email_pending_reservations" 
                                           name="email_pending_reservations"
                                           {{ session('notification_settings.email_pending_reservations', true) ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="email_pending_reservations">
                                        New Pending Reservations
                                        <small class="d-block text-muted">Get notified when new reservations need approval</small>
                                    </label>
                                </div>

                                <div class="custom-control custom-switch mb-3">
                                    <input type="checkbox" class="custom-control-input" id="email_weekly_summary" 
                                           name="email_weekly_summary"
                                           {{ session('notification_settings.email_weekly_summary', true) ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="email_weekly_summary">
                                        Weekly Summary
                                        <small class="d-block text-muted">Receive weekly analytics summary every Monday</small>
                                    </label>
                                </div>

                                <hr>

                                <h5 class="mb-3 mt-4">Browser Notifications</h5>

                                <div class="custom-control custom-switch mb-3">
                                    <input type="checkbox" class="custom-control-input" id="browser_notifications" 
                                           name="browser_notifications"
                                           {{ session('notification_settings.browser_notifications', false) ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="browser_notifications">
                                        Enable Browser Push Notifications
                                        <small class="d-block text-muted">Get real-time notifications in your browser</small>
                                    </label>
                                </div>

                                <div class="alert alert-warning mt-3">
                                    <i class="fas fa-exclamation-triangle mr-2"></i>
                                    <strong>Note:</strong> Browser notifications require your permission. You'll be prompted when enabling this feature.
                                </div>

                                <button type="submit" class="btn btn-primary mt-3">
                                    <i class="fas fa-save mr-1"></i> Save Preferences
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- TAB 2: AI ANALYTICS SETTINGS --}}
                <div class="tab-pane fade" id="ai-settings">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">AI Analytics Configuration</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('manager.settings.ai') }}" method="POST">
                                @csrf

                                <div class="custom-control custom-switch mb-4">
                                    <input type="checkbox" class="custom-control-input" id="ai_enabled" 
                                           name="ai_enabled"
                                           {{ session('ai_settings.ai_enabled', true) ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="ai_enabled">
                                        <strong>Enable AI-Powered Recommendations</strong>
                                        <small class="d-block text-muted">Turn on/off Gemini AI analytics on dashboard</small>
                                    </label>
                                </div>

                                <div class="form-group">
                                    <label for="ai_cache_duration">Cache Duration</label>
                                    <select name="ai_cache_duration" id="ai_cache_duration" class="form-control">
                                        <option value="3600" {{ session('ai_settings.ai_cache_duration', 21600) == 3600 ? 'selected' : '' }}>1 Hour</option>
                                        <option value="21600" {{ session('ai_settings.ai_cache_duration', 21600) == 21600 ? 'selected' : '' }}>6 Hours (Recommended)</option>
                                        <option value="86400" {{ session('ai_settings.ai_cache_duration', 21600) == 86400 ? 'selected' : '' }}>24 Hours</option>
                                    </select>
                                    <small class="text-muted">How long to cache AI recommendations (reduces API calls)</small>
                                </div>

                                <div class="form-group">
                                    <label for="ai_max_recommendations">Max Recommendations</label>
                                    <select name="ai_max_recommendations" id="ai_max_recommendations" class="form-control">
                                        <option value="3" {{ session('ai_settings.ai_max_recommendations', 5) == 3 ? 'selected' : '' }}>3 Recommendations</option>
                                        <option value="5" {{ session('ai_settings.ai_max_recommendations', 5) == 5 ? 'selected' : '' }}>5 Recommendations</option>
                                        <option value="7" {{ session('ai_settings.ai_max_recommendations', 5) == 7 ? 'selected' : '' }}>7 Recommendations</option>
                                    </select>
                                </div>

                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle mr-2"></i>
                                    <strong>How it works:</strong> AI recommendations use Google Gemini API to analyze your coworking space data and provide actionable insights. Caching helps reduce API costs and improve performance.
                                </div>

                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save mr-1"></i> Save AI Settings
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- TAB 3: DASHBOARD PREFERENCES --}}
                <div class="tab-pane fade" id="dashboard">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Dashboard Preferences</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('manager.settings.dashboard') }}" method="POST">
                                @csrf

                                <div class="form-group">
                                    <label for="default_date_range">Default Date Range</label>
                                    <select name="default_date_range" id="default_date_range" class="form-control">
                                        <option value="7" {{ session('dashboard_settings.default_date_range', '30') == '7' ? 'selected' : '' }}>Last 7 Days</option>
                                        <option value="30" {{ session('dashboard_settings.default_date_range', '30') == '30' ? 'selected' : '' }}>Last 30 Days</option>
                                        <option value="90" {{ session('dashboard_settings.default_date_range', '30') == '90' ? 'selected' : '' }}>Last 90 Days</option>
                                        <option value="all" {{ session('dashboard_settings.default_date_range', '30') == 'all' ? 'selected' : '' }}>All Time</option>
                                    </select>
                                    <small class="text-muted">Default time period for dashboard statistics</small>
                                </div>

                                <h5 class="mt-4 mb-3">Visible Widgets</h5>
                                <p class="text-muted small">Choose which widgets to display on your dashboard</p>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="custom-control custom-switch mb-3">
                                            <input type="checkbox" class="custom-control-input" id="show_members_widget" 
                                                   name="show_members_widget"
                                                   {{ session('dashboard_settings.show_members_widget', true) ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="show_members_widget">
                                                <i class="fas fa-users text-info mr-2"></i>Total Members
                                            </label>
                                        </div>

                                        <div class="custom-control custom-switch mb-3">
                                            <input type="checkbox" class="custom-control-input" id="show_reservations_widget" 
                                                   name="show_reservations_widget"
                                                   {{ session('dashboard_settings.show_reservations_widget', true) ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="show_reservations_widget">
                                                <i class="fas fa-bookmark text-warning mr-2"></i>Pending Reservations
                                            </label>
                                        </div>

                                        <div class="custom-control custom-switch mb-3">
                                            <input type="checkbox" class="custom-control-input" id="show_events_widget" 
                                                   name="show_events_widget"
                                                   {{ session('dashboard_settings.show_events_widget', true) ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="show_events_widget">
                                                <i class="fas fa-calendar text-success mr-2"></i>Pending Events
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="custom-control custom-switch mb-3">
                                            <input type="checkbox" class="custom-control-input" id="show_active_widget" 
                                                   name="show_active_widget"
                                                   {{ session('dashboard_settings.show_active_widget', true) ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="show_active_widget">
                                                <i class="fas fa-user-check text-danger mr-2"></i>Active Members Today
                                            </label>
                                        </div>

                                        <div class="custom-control custom-switch mb-3">
                                            <input type="checkbox" class="custom-control-input" id="show_analytics" 
                                                   name="show_analytics"
                                                   {{ session('dashboard_settings.show_analytics', true) ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="show_analytics">
                                                <i class="fas fa-chart-line text-primary mr-2"></i>Quick Analytics Section
                                            </label>
                                        </div>

                                        <div class="custom-control custom-switch mb-3">
                                            <input type="checkbox" class="custom-control-input" id="show_recent_activity" 
                                                   name="show_recent_activity"
                                                   {{ session('dashboard_settings.show_recent_activity', true) ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="show_recent_activity">
                                                <i class="fas fa-history text-secondary mr-2"></i>Recent Activity Feed
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="alert alert-success mt-3">
                                    <i class="fas fa-lightbulb mr-2"></i>
                                    <strong>Tip:</strong> Disable widgets you don't frequently use to make your dashboard cleaner and faster!
                                </div>

                                <button type="submit" class="btn btn-primary mt-3">
                                    <i class="fas fa-save mr-1"></i> Save Dashboard Settings
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
</div>

@include('manager.layouts.footer')
