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
                        <li class="breadcrumb-item active">Edit Room</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">

            {{-- Header Form --}}
            <h1 class="page-title mb-4">Edit Room</h1>

            <div class="card shadow-sm">
                <div class="card-body">

                    <form action="{{ route('room.update', $room->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            {{-- Kolom Kiri --}}
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Room Name</label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{ $room->name }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="capacity">Capacity</label>
                                    <input type="number" class="form-control" id="capacity" name="capacity" value="{{ $room->capacity }}" min="1" required>
                                </div>

                                <div class="form-group">
                                    <label for="type">Room Type</label>
                                    <input type="text" class="form-control" id="type" name="type" value="{{ $room->type }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select class="form-control" id="status" name="status" required>
                                        <option value="available" {{ $room->status == 'available' ? 'selected' : '' }}>Available</option>
                                        <option value="unavailable" {{ $room->status == 'unavailable' ? 'selected' : '' }}>Unavailable</option>
                                        <option value="maintenance" {{ $room->status == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                                    </select>
                                </div>
                            </div>

                            {{-- Kolom Kanan --}}
                            <div class="col-md-6">
                                {{-- Placeholder for symmetry --}}
                            </div>
                        </div> {{-- End of First Row --}}

                        {{-- Description Row - Full Width --}}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea class="form-control" id="description" name="description" rows="3">{{ $room->description }}</textarea>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary mt-3">Update Room</button>
                    </form>

                </div>
            </div>

        </div>
    </section>

</div>

@include('layouts.footer')
