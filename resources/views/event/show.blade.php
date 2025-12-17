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
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Show Event</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">

            {{-- Header --}}
            <h1 class="page-title mb-4">Detail Event</h1>

            <div class="card shadow-sm">
                <div class="card-body">

                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>ID:</strong> {{ $event->id }}</p>
                            <p><strong>Title:</strong> {{ $event->title }}</p>
                            <p><strong>Description:</strong> {{ $event->description ?: 'N/A' }}</p>
                            <p><strong>Start Date:</strong> {{ $event->start_date }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>End Date:</strong> {{ $event->end_date }}</p>
                            <p><strong>Status:</strong> {{ $event->status }}</p>
                            <p><strong>Created At:</strong> {{ $event->created_at }}</p>
                            <p><strong>Updated At:</strong> {{ $event->updated_at }}</p>
                        </div>
                    </div>

                    <a href="{{ route('event.index') }}" class="btn btn-secondary mt-3">Back to List</a>

                </div>
            </div>

        </div>
    </section>

</div>

@include('layouts.footer')
