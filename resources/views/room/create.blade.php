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
                        <li class="breadcrumb-item active">Room</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">

            {{-- Konten Utama Form --}}
            <div class="p-3">

                {{-- Header Form --}}
                <h1 class="page-title mb-4">Create Room</h1>

                {{-- Card Form --}}
                <div class="card shadow-sm">
                    <div class="card-body">

                        <form action="{{ route('room.store') }}" method="POST">
                            @csrf

                            <div class="row">
                                {{-- Kolom Kiri --}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Room Name</label>
                                        <input type="text" class="form-control" id="name" name="name" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="capacity">Capacity</label>
                                        <input type="number" class="form-control" id="capacity" name="capacity" min="1" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="type">Room Type</label>
                                        <select class="form-control" id="type" name="type" required>
                                            <option value="Indoor">Indoor</option>
                                            <option value="Outdoor">Outdoor</option>
                                            <option value="Semi Outdoor">Semi Outdoor</option>
                                        </select>
                                    </div>
                                </div>

                                {{-- Kolom Kanan --}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                                    </div>

                                    <div class="form-group">
                                        <label for="status">Status</label>
                                        <select class="form-control" id="status" name="status" required>
                                            <option value="available" selected>Available</option>
                                            <option value="unavailable">Unavailable</option>
                                            <option value="maintenance">Maintenance</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            {{-- Tombol Submit --}}
                            <button type="submit" class="btn btn-primary mt-3">Buat Room</button>

                        </form>

                    </div>
                </div>

    </section>
</div>
@include('layouts.footer')
