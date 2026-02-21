<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Reservasi</title>
    <link rel="stylesheet" href="{{ asset('css/stylecreate.css') }}">
    <style>
        /* Style notifikasi - konsisten dengan create */
        .notification-container {
            position: fixed;
            top: 70px;
            right: 20px;
            z-index: 99999;
            max-width: 350px;
        }

        .notification {
            background: white;
            border-radius: 10px;
            padding: 15px 20px;
            margin-bottom: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            border-left: 5px solid;
            animation: slideIn 0.5s ease, fadeOut 0.5s ease 4.5s forwards;
            position: relative;
            overflow: hidden;
            cursor: pointer;
        }

        .notification.success {
            border-left-color: #28a745;
            color: #155724;
            background-color: #d4edda;
        }

        .notification.error {
            border-left-color: #dc3545;
            color: #721c24;
            background-color: #f8d7da;
        }

        .notification.warning {
            border-left-color: #ffc107;
            color: #856404;
            background-color: #fff3cd;
        }

        @keyframes slideIn {
            from { transform: translateX(100%); opacity: 0; }
            to   { transform: translateX(0); opacity: 1; }
        }

        @keyframes fadeOut {
            from { transform: translateX(0); opacity: 1; }
            to   { transform: translateX(100%); opacity: 0; }
        }

        .form-control.is-invalid {
            border-color: #dc3545;
        }

        .invalid-feedback {
            display: block;
            color: #dc3545;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            padding: 10px 20px;
            font-size: 16px;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
    </style>
</head>
<body>

@include('layouts.header')

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Reservasi</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                        <li class="breadcrumb-item active">Edit Reservasi</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="p-3">
                <h1 class="page-title mb-4">Edit Reservasi</h1>

                <div class="card shadow-sm">
                    <div class="card-body">
                        <form action="{{ route('reservasi.update', $reservasi->id) }}" method="POST" id="reservasiForm">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                {{-- Kolom Kiri --}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nama_pemesanan">Nama Pemesanan <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('nama_pemesanan') is-invalid @enderror" id="nama_pemesanan" name="nama_pemesanan" value="{{ old('nama_pemesanan', $reservasi->nama_pemesanan) }}" required>
                                        @error('nama_pemesanan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="kontak">Kontak <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('kontak') is-invalid @enderror" id="kontak" name="kontak" value="{{ old('kontak', $reservasi->kontak) }}" placeholder="Contoh: 08123456789" required>
                                        @error('kontak') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="institusi">Institusi <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('institusi') is-invalid @enderror" id="institusi" name="institusi" value="{{ old('institusi', $reservasi->institusi) }}" required>
                                        @error('institusi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>

                                {{-- Kolom Kanan --}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="ruangan">Room <span class="text-danger">*</span></label>
                                        <select class="form-control @error('ruangan') is-invalid @enderror" id="ruangan" name="ruangan" required>
                                            <option value="" disabled {{ old('ruangan', $reservasi->ruangan) ? '' : 'selected' }}>Pilih Room</option>
                                            <option value="Room A" {{ old('ruangan', $reservasi->ruangan) == 'Room A' ? 'selected' : '' }}>Room A</option>
                                            <option value="Room B" {{ old('ruangan', $reservasi->ruangan) == 'Room B' ? 'selected' : '' }}>Room B</option>
                                            <option value="Room C" {{ old('ruangan', $reservasi->ruangan) == 'Room C' ? 'selected' : '' }}>Room C</option>
                                            <option value="Room D" {{ old('ruangan', $reservasi->ruangan) == 'Room D' ? 'selected' : '' }}>Room D</option>
                                        </select>
                                        @error('ruangan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="purpose">Purpose <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('purpose') is-invalid @enderror" id="purpose" name="purpose" value="{{ old('purpose', $reservasi->purpose) }}" required>
                                        @error('purpose') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="attends">Attends <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control @error('attends') is-invalid @enderror" id="attends" name="attends" min="1" value="{{ old('attends', $reservasi->attends) }}" required>
                                        @error('attends') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>

                            {{-- Description --}}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description', $reservasi->description) }}</textarea>
                                        @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>

                            {{-- Date --}}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="tanggal">Date <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control @error('tanggal') is-invalid @enderror" id="tanggal" name="tanggal" value="{{ old('tanggal', $reservasi->tanggal) }}" min="{{ date('Y-m-d') }}" required>
                                        @error('tanggal') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>

                            {{-- Start & End Time --}}
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="waktu_mulai">Start Time <span class="text-danger">*</span></label>
                                        <input 
                                            type="time" 
                                            class="form-control @error('waktu_mulai') is-invalid @enderror" 
                                            id="waktu_mulai" 
                                            name="waktu_mulai" 
                                            value="{{ old('waktu_mulai', \Carbon\Carbon::parse($reservasi->waktu_mulai)->format('H:i')) }}"
                                            required>
                                        @error('waktu_mulai') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="waktu_selesai">End Time <span class="text-danger">*</span></label>
                                        <input 
                                            type="time" 
                                            class="form-control @error('waktu_selesai') is-invalid @enderror" 
                                            id="waktu_selesai" 
                                            name="waktu_selesai" 
                                            value="{{ old('waktu_selesai', \Carbon\Carbon::parse($reservasi->waktu_selesai)->format('H:i')) }}"
                                            required>
                                        @error('waktu_selesai') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>

                            {{-- Status --}}
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Status Saat Ini</label>
                                        <div class="form-control" style="background:#f8f9fa; cursor:default;">
                                            <span class="badge px-2 py-1
                                                @if($reservasi->status == 'Approved') badge-success
                                                @elseif($reservasi->status == 'Rejected') badge-danger
                                                @else badge-warning @endif">
                                                {{ $reservasi->status }}
                                            </span>
                                        </div>
                                        <small class="text-muted">Status diubah oleh Manager melalui Reservation Approval.</small>
                                    </div>
                                </div>
                            </div>

                            {{-- Tombol --}}
                            <div class="mt-3">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Update Reservasi
                                </button>
                                <a href="{{ route('reservasi.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Batal
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

{{-- Notification Container --}}
<div class="notification-container" id="notificationContainer"></div>

{{-- Flash Messages Container (data attribute) --}}
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

        const notification = document.createElement('div');
        notification.className = `notification ${type}`;
        notification.innerHTML = `
            <div style="flex: 1;">
                <div style="display: flex; align-items: center; gap: 6px; margin-bottom: 4px;">
                    <strong>${type === 'success' ? 'Berhasil!' : type === 'error' ? 'Error!' : 'Perhatian!'}</strong>
                </div>
                <div style="margin: 0;">${message}</div>
            </div>
        `;

        container.appendChild(notification);

        setTimeout(() => {
            if (notification.parentNode) {
                notification.style.animation = 'fadeOut 0.5s ease forwards';
                setTimeout(() => notification.remove(), 500);
            }
        }, 5000);

        notification.addEventListener('click', () => {
            notification.style.animation = 'fadeOut 0.5s ease forwards';
            setTimeout(() => notification.remove(), 500);
        });
    }

    function validateTime() {
        const waktuMulai = document.getElementById('waktu_mulai').value;
        const waktuSelesai = document.getElementById('waktu_selesai').value;

        if (waktuMulai && waktuSelesai) {
            if (waktuSelesai <= waktuMulai) {
                showNotification('Waktu selesai harus lebih besar dari waktu mulai!', 'error');
                document.getElementById('waktu_selesai').value = '';
                return false;
            }
        }
        return true;
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Ambil flash messages dari data attribute
        const flashMessages = document.getElementById('flash-messages');
        if (flashMessages) {
            const successMessage = flashMessages.dataset.success;
            const errorMessage = flashMessages.dataset.error;
            const warningMessage = flashMessages.dataset.warning;
            const validationErrorsString = flashMessages.dataset.validationErrors;

            if (successMessage) showNotification(successMessage, 'success');
            if (errorMessage) showNotification(errorMessage, 'error');
            if (warningMessage) showNotification(warningMessage, 'warning');

            if (validationErrorsString) {
                validationErrorsString.split('|').forEach(error => {
                    if (error.trim()) showNotification(error, 'error');
                });
            }
        }

        // Validasi waktu
        const waktuSelesaiInput = document.getElementById('waktu_selesai');
        if (waktuSelesaiInput) {
            waktuSelesaiInput.addEventListener('change', validateTime);
        }

        const form = document.getElementById('reservasiForm');
        if (form) {
            form.addEventListener('submit', function(e) {
                if (!validateTime()) {
                    e.preventDefault();
                }
            });
        }
    });
</script>

</body>
</html>