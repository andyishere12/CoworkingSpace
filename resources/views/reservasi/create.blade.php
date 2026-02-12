<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Reservasi</title>
    <link rel="stylesheet" href="{{ asset('css/stylecreate.css') }}">
    <style>
        /* Style untuk notifikasi pop-up */
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

        .notification.info {
            border-left-color: #17a2b8;
            color: #0c5460;
            background-color: #d1ecf1;
        }

        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes fadeOut {
            from {
                transform: translateX(0);
                opacity: 1;
            }
            to {
                transform: translateX(100%);
                opacity: 0;
            }
        }

        /* Form validation styles */
        .form-control.is-invalid {
            border-color: #dc3545;
        }

        .invalid-feedback {
            display: block;
            color: #dc3545;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        /* Button styles */
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
                        <li class="breadcrumb-item active">Reservasi</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="p-3">
                {{-- Header Form --}}
                <h1 class="page-title mb-4">Create Reservasi</h1>

                {{-- Card Form --}}
                <div class="card shadow-sm">
                    <div class="card-body">
                        <form action="{{ route('reservasi.store') }}" method="POST" id="reservasiForm">
                            @csrf

                            <div class="row">
                                {{-- Kolom Kiri --}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nama_pemesanan">Nama Pemesanan <span class="text-danger">*</span></label>
                                        <input 
                                            type="text" 
                                            class="form-control @error('nama_pemesanan') is-invalid @enderror" 
                                            id="nama_pemesanan" 
                                            name="nama_pemesanan" 
                                            value="{{ old('nama_pemesanan') }}"
                                            required>
                                        @error('nama_pemesanan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="kontak">Kontak <span class="text-danger">*</span></label>
                                        <input 
                                            type="text" 
                                            class="form-control @error('kontak') is-invalid @enderror" 
                                            id="kontak" 
                                            name="kontak" 
                                            value="{{ old('kontak') }}"
                                            placeholder="Contoh: 08123456789"
                                            required>
                                        @error('kontak')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="institusi">Institusi <span class="text-danger">*</span></label>
                                        <input 
                                            type="text" 
                                            class="form-control @error('institusi') is-invalid @enderror" 
                                            id="institusi" 
                                            name="institusi" 
                                            value="{{ old('institusi') }}"
                                            required>
                                        @error('institusi')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Kolom Kanan --}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="ruangan">Room <span class="text-danger">*</span></label>
                                        <select 
                                            class="form-control @error('ruangan') is-invalid @enderror" 
                                            id="ruangan" 
                                            name="ruangan" 
                                            required>
                                            <option value="" disabled {{ old('ruangan') ? '' : 'selected' }}>Pilih Room</option>
                                            <option value="Room A" {{ old('ruangan') == 'Room A' ? 'selected' : '' }}>Room A</option>
                                            <option value="Room B" {{ old('ruangan') == 'Room B' ? 'selected' : '' }}>Room B</option>
                                            <option value="Room C" {{ old('ruangan') == 'Room C' ? 'selected' : '' }}>Room C</option>
                                            <option value="Room D" {{ old('ruangan') == 'Room D' ? 'selected' : '' }}>Room D</option>
                                        </select>
                                        @error('ruangan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="purpose">Purpose <span class="text-danger">*</span></label>
                                        <input 
                                            type="text" 
                                            class="form-control @error('purpose') is-invalid @enderror" 
                                            id="purpose" 
                                            name="purpose" 
                                            value="{{ old('purpose') }}"
                                            required>
                                        @error('purpose')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="attends">Attends <span class="text-danger">*</span></label>
                                        <input 
                                            type="number" 
                                            class="form-control @error('attends') is-invalid @enderror" 
                                            id="attends" 
                                            name="attends" 
                                            min="1" 
                                            value="{{ old('attends', 1) }}"
                                            required>
                                        @error('attends')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            {{-- Description Row - Full Width --}}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <textarea 
                                            class="form-control @error('description') is-invalid @enderror" 
                                            id="description" 
                                            name="description" 
                                            rows="3">{{ old('description') }}</textarea>
                                        @error('description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            {{-- Date Row --}}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="tanggal">Date <span class="text-danger">*</span></label>
                                        <input 
                                            type="date" 
                                            class="form-control @error('tanggal') is-invalid @enderror" 
                                            id="tanggal" 
                                            name="tanggal" 
                                            value="{{ old('tanggal') }}"
                                            min="{{ date('Y-m-d') }}"
                                            required>
                                        @error('tanggal')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            {{-- Start and End Time Row --}}
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="waktu_mulai">Start Time <span class="text-danger">*</span></label>
                                        <input 
                                            type="time" 
                                            class="form-control @error('waktu_mulai') is-invalid @enderror" 
                                            id="waktu_mulai" 
                                            name="waktu_mulai" 
                                            value="{{ old('waktu_mulai') }}"
                                            required>
                                        @error('waktu_mulai')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
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
                                            value="{{ old('waktu_selesai') }}"
                                            required>
                                        @error('waktu_selesai')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            {{-- Status Row --}}
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="status">Status <span class="text-danger">*</span></label>
                                        <select 
                                            class="form-control @error('status') is-invalid @enderror" 
                                            id="status" 
                                            name="status" 
                                            required>
                                            <option value="Pending" {{ old('status', 'Pending') == 'Pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="Approved" {{ old('status') == 'Approved' ? 'selected' : '' }}>Approved</option>
                                            <option value="Rejected" {{ old('status') == 'Rejected' ? 'selected' : '' }}>Rejected</option>
                                        </select>
                                        @error('status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            {{-- Tombol Submit --}}
                            <div class="mt-3">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Buat Reservasi
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

@include('layouts.footer')

<script>
    // Fungsi untuk menampilkan notifikasi
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

    // Validasi waktu mulai dan selesai
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

    // Event listeners
    document.addEventListener('DOMContentLoaded', function() {
        const flashMessages = document.getElementById('flash-messages');
        
        if (flashMessages) {
            const successMessage = flashMessages.dataset.success;
            const errorMessage = flashMessages.dataset.error;
            const validationErrorsString = flashMessages.dataset.validationErrors;

            if (successMessage) {
                showNotification(successMessage, 'success');
            }
            
            if (errorMessage) {
                showNotification(errorMessage, 'error');
            }
            
            if (validationErrorsString) {
                const errors = validationErrorsString.split('|');
                errors.forEach(error => {
                    if (error.trim()) {
                        showNotification(error, 'error');
                    }
                });
            }
        }

        // Validasi waktu
        const waktuSelesaiInput = document.getElementById('waktu_selesai');
        if (waktuSelesaiInput) {
            waktuSelesaiInput.addEventListener('change', validateTime);
        }

        // Form validation before submit
        const form = document.getElementById('reservasiForm');
        if (form) {
            form.addEventListener('submit', function(e) {
                if (!validateTime()) {
                    e.preventDefault();
                    return false;
                }
            });
        }
    });
</script>

</body>
</html>