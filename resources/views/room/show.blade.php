@include('layouts.header')

<head>
    <link rel="stylesheet" href="{{ asset('css/stylecreate.css') }}">
</head>
<div class="content-wrapper">

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Room</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Show Room</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">

            {{-- Header --}}
            <h1 class="page-title mb-4">Detail Room</h1>

            <div class="card shadow-sm">
                <div class="card-body">

                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>ID:</strong> {{ $room->id }}</p>
                            <p><strong>Room Name:</strong> {{ $room->name }}</p>
                            <p><strong>Capacity:</strong> {{ $room->capacity }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Room Type:</strong> {{ $room->type }}</p>
                            <p><strong>Description:</strong> {{ $room->description ?: 'N/A' }}</p>
                            <p><strong>Status:</strong> {{ $room->status }}</p>
                        </div>
                    </div>

                    <a href="{{ route('room.index') }}" class="btn btn-secondary mt-3">Back to List</a>

                </div>
            </div>

        </div>
    </section>

</div>

@include('layouts.footer')
