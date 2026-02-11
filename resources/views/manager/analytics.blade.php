@include('manager.layouts.header')

<!-- Content Wrapper -->
<div class="content-wrapper">
    <!-- Content Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Analytics Dashboard</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('manager.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Analytics</li>
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
                <!-- Jam Sibuk -->
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $peakHours }}</h3>
                            <p>Jam Sibuk</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-clock"></i>
                        </div>
                    </div>
                </div>

                <!-- Tingkat Retensi -->
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $retentionRate }}%</h3>
                            <p>Tingkat Retensi</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-redo"></i>
                        </div>
                    </div>
                </div>

                <!-- Durasi Rata-rata -->
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $avgDurationFormatted }}</h3>
                            <p>Durasi Rata-rata</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-hourglass-half"></i>
                        </div>
                    </div>
                </div>

                <!-- Indeks Kunjungan -->
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>
                                @if($visitIndexChange > 0)
                                    <i class="fas fa-arrow-up"></i> +{{ $visitIndexChange }}%
                                @elseif($visitIndexChange < 0)
                                    <i class="fas fa-arrow-down"></i> {{ $visitIndexChange }}%
                                @else
                                    {{ $visitIndexChange }}%
                                @endif
                            </h3>
                            <p>Indeks Kunjungan</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- AI Recommendations -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header bg-primary">
                            <h3 class="card-title">
                                <i class="fas fa-robot mr-2"></i>
                                AI-Powered Recommendations
                            </h3>
                            <span class="badge badge-light float-right">
                                <i class="fas fa-brain"></i> Free AI Analysis
                            </span>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @forelse($recommendations as $recommendation)
                                <div class="col-lg-6 col-md-12 mb-3">
                                    <div class="alert alert-{{ $recommendation['color'] }}">
                                        <h5>
                                            <i class="fas fa-{{ $recommendation['icon'] }}"></i>
                                            {{ $recommendation['title'] }}
                                        </h5>
                                        <p>{{ $recommendation['description'] }}</p>
                                        <ul class="mb-0">
                                            @foreach($recommendation['suggestions'] as $suggestion)
                                            <li>{{ $suggestion }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                                @empty
                                <div class="col-12">
                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle"></i> 
                                        Mulai tracking attendance untuk mendapatkan AI insights
                                    </div>
                                </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
</div>

@include('manager.layouts.footer')