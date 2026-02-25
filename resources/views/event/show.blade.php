@include('layouts.header')

<head>
    <link rel="stylesheet" href="{{ asset('css/stylecreate.css') }}">
</head>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Event</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Show Event</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <h1 class="page-title mb-4">Detail Event</h1>

            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>ID:</strong> {{ $event->id }}</p>
                            <p><strong>Title:</strong> {{ $event->title }}</p>
                            <p><strong>Organizer:</strong> {{ $event->organizer ?? '-' }}</p>
                            <p><strong>Description:</strong> {{ $event->description ?: 'N/A' }}</p>
                            <p><strong>Jumlah Peserta:</strong> {{ $event->jumlah_peserta ?? '0' }} orang</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Start Date:</strong>
                                {{ \Carbon\Carbon::parse($event->start_date)->format('d M Y') }}</p>
                            <p><strong>End Date:</strong> {{ \Carbon\Carbon::parse($event->end_date)->format('d M Y') }}
                            </p>
                            <p>
                                <strong>Status:</strong>
                                <span class="badge px-2 py-1
                                    @if($event->status == 'approved') badge-success
                                    @elseif($event->status == 'rejected') badge-danger
                                    @elseif($event->status == 'pending') badge-warning
                                    @else badge-secondary @endif">
                                    {{ ucfirst($event->status) }}
                                </span>
                            </p>
                            <p><strong>Created At:</strong> {{ $event->created_at->format('d M Y H:i') }}</p>
                            <p><strong>Updated At:</strong> {{ $event->updated_at->format('d M Y H:i') }}</p>
                        </div>
                    </div>

                    <div class="mt-3">
                        <a href="{{ route('event.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left mr-1"></i> Back to List
                        </a>
                        <a href="{{ route('event.edit', $event->id) }}" class="btn btn-warning ml-2">
                            <i class="fas fa-edit mr-1"></i> Edit Event
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@include('layouts.footer')