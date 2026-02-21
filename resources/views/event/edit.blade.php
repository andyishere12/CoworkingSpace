<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Event</title>
    <link rel="stylesheet" href="{{ asset('css/stylecreate.css') }}">
    <style>
        .notification-container { position: fixed; top: 70px; right: 20px; z-index: 99999; max-width: 350px; }
        .notification { background: white; border-radius: 10px; padding: 15px 20px; margin-bottom: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.2); border-left: 5px solid; animation: slideIn 0.5s ease, fadeOut 0.5s ease 4.5s forwards; cursor: pointer; }
        .notification.success { border-left-color: #28a745; color: #155724; background-color: #d4edda; }
        .notification.error   { border-left-color: #dc3545; color: #721c24; background-color: #f8d7da; }
        .notification.warning { border-left-color: #ffc107; color: #856404; background-color: #fff3cd; }
        @keyframes slideIn { from { transform: translateX(100%); opacity: 0; } to { transform: translateX(0); opacity: 1; } }
        @keyframes fadeOut { from { transform: translateX(0); opacity: 1; } to { transform: translateX(100%); opacity: 0; } }
        .form-control.is-invalid { border-color: #dc3545; }
        .invalid-feedback { display: block; color: #dc3545; font-size: 0.875rem; margin-top: 0.25rem; }
        .btn-primary { background-color: #007bff; border-color: #007bff; padding: 10px 20px; font-size: 16px; }
        .btn-primary:hover { background-color: #0056b3; border-color: #0056b3; }
    </style>
</head>
<body>

@include('layouts.header')

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6"><h1 class="m-0">Event</h1></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                        <li class="breadcrumb-item active">Edit Event</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="p-3">
                <h1 class="page-title mb-4">Edit Event</h1>

                <div class="card shadow-sm">
                    <div class="card-body">
                        <form action="{{ route('event.update', $event->id) }}" method="POST" id="eventForm">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                {{-- Kolom Kiri --}}
                                <div class="col-md-6">

                                    <div class="form-group">
                                        <label for="title">Title <span class="text-danger">*</span></label>
                                        <input type="text"
                                            class="form-control @error('title') is-invalid @enderror"
                                            id="title" name="title"
                                            value="{{ old('title', $event->title) }}" required>
                                        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>


                                    <div class="form-group">
                                        <label for="organizer">Organizer</label>
                                        <input type="text"
                                            class="form-control @error('organizer') is-invalid @enderror"
                                            id="organizer" name="organizer"
                                            value="{{ old('organizer', $event->organizer ?? '') }}"
                                            placeholder="Nama organizer / penyelenggara event">
                                        @error('organizer')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>


                                    <div class="form-group">
                                        <label for="start_date">Start Date <span class="text-danger">*</span></label>
                                        <input type="date"
                                            class="form-control @error('start_date') is-invalid @enderror"
                                            id="start_date" name="start_date"
                                            value="{{ old('start_date', $event->start_date) }}" required>
                                        @error('start_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="jumlah_peserta">Jumlah Peserta</label>
                                        <input type="number"
                                            class="form-control @error('jumlah_peserta') is-invalid @enderror"
                                            id="jumlah_peserta" name="jumlah_peserta"
                                            value="{{ old('jumlah_peserta', $event->jumlah_peserta ?? 0) }}"
                                            min="0">
                                        @error('jumlah_peserta')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>

                                </div>

                                {{-- Kolom Kanan --}}
                                <div class="col-md-6">

                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <textarea class="form-control @error('description') is-invalid @enderror"
                                            id="description" name="description"
                                            rows="4">{{ old('description', $event->description) }}</textarea>
                                        @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="end_date">End Date <span class="text-danger">*</span></label>
                                        <input type="date"
                                            class="form-control @error('end_date') is-invalid @enderror"
                                            id="end_date" name="end_date"
                                            value="{{ old('end_date', $event->end_date) }}" required>
                                        @error('end_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="form-group">
                                        <label>Status Saat Ini</label>
                                        <div class="form-control" style="background:#f8f9fa; cursor:default;">
                                            <span class="badge px-2 py-1
                                                @if($event->status == 'approved') badge-success
                                                @elseif($event->status == 'rejected') badge-danger
                                                @else badge-warning @endif">
                                                {{ ucfirst($event->status ?? 'pending') }}
                                            </span>
                                        </div>
                                        <small class="text-muted">Status diubah oleh Manager melalui Event Approval.</small>
                                    </div>

                                </div>
                            </div>

                            <div class="mt-3">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save mr-1"></i> Update Event
                                </button>
                                <a href="{{ route('event.index') }}" class="btn btn-secondary ml-2">
                                    <i class="fas fa-times mr-1"></i> Batal
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<div class="notification-container" id="notificationContainer"></div>
<div id="flash-messages"
     data-success="{{ session('success') }}"
     data-error="{{ session('error') }}"
     data-warning="{{ session('warning') }}"
     data-validation-errors="{{ $errors->any() ? implode('|', $errors->all()) : '' }}">
</div>

@include('layouts.footer')

<script>
function showNotification(message, type = 'success') {
    const container = document.getElementById('notificationContainer');
    if (!container) return;
    const n = document.createElement('div');
    n.className = `notification ${type}`;
    n.innerHTML = `<div><strong>${type === 'success' ? 'Berhasil!' : type === 'error' ? 'Error!' : 'Perhatian!'}</strong><div>${message}</div></div>`;
    container.appendChild(n);
    setTimeout(() => { if (n.parentNode) { n.style.animation = 'fadeOut 0.5s ease forwards'; setTimeout(() => n.remove(), 500); } }, 5000);
    n.addEventListener('click', () => { n.style.animation = 'fadeOut 0.5s ease forwards'; setTimeout(() => n.remove(), 500); });
}

document.addEventListener('DOMContentLoaded', function() {
    const f = document.getElementById('flash-messages');
    if (f) {
        if (f.dataset.success) showNotification(f.dataset.success, 'success');
        if (f.dataset.error)   showNotification(f.dataset.error, 'error');
        if (f.dataset.warning) showNotification(f.dataset.warning, 'warning');
        if (f.dataset.validationErrors) {
            f.dataset.validationErrors.split('|').forEach(e => { if (e.trim()) showNotification(e, 'error'); });
        }
    }
});
</script>

</body>
</html>