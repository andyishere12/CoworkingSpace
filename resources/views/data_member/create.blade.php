@include('layouts.header')

<head>
    <link rel="stylesheet" href={{ asset('css/stylecreate.css') }}>
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
        }

        .notification::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            height: 4px;
            background: currentColor;
            width: 100%;
            animation: progress 5s linear forwards;
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

        @keyframes progress {
            from {
                width: 100%;
            }
            to {
                width: 0%;
            }
        }
    </style>
</head>
<div class="content-wrapper">

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Members</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Members Admin</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">

            {{-- Konten Utama Tabel --}}
            <div class="p-3">

                {{-- Header Form --}}
                <h1 class="page-title mb-4">Create Member</h1>

                {{-- Card Form --}}
                <div class="card shadow-sm">
                    <div class="card-body">

                        <form action="{{ route('data_member.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                {{-- Kolom Kiri (Photo & Webcam) --}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="photo">Photo</label>
                                        <div class="d-flex align-items-center mb-2">
                                            <div class="custom-file mr-3" style="width: 200px;">
                                                <input  accept="image/*" type="file" class="custom-file-input" id="photo" name="foto">
                                                <label class="custom-file-label" for="photo">Choose File</label>
                                            </div>
                                            {{-- Placeholder for "No file chosen" (Bootstrap 4/5 handles this with
                                            JS) --}}
                                            <small class="text-muted">No file chosen</small>
                                        </div>
                                    </div>
                                </div>

                                {{-- Kolom Kanan (Informasi Dasar) --}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" class="form-control" id="name" name="nama" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="birth_date">Birth Date</label>
                                        <div class="input-group">
                                            <input type="date" class="form-control" id="birth_date" name="tanggal_lahir"
                                                placeholder="mm/dd/yyyy">
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i
                                                        class="fas fa-calendar-alt"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> {{-- End of First Row --}}

                            <div class="row">
                                {{-- Kolom Kiri Bawah --}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="address">Alamat</label>
                                        <textarea class="form-control" id="address" name="alamat" rows="5"></textarea>
                                    </div>

                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="phone">Nomor Hp</label>
                                        <input type="tel" class="form-control" id="phone" name="no_hp">
                                    </div>
                                </div>

                                {{-- Kolom Kanan Bawah --}}
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="activity_type">Activity Type</label>
                                        <select class="form-control" id="activity_type" name="aktivitas" required>
                                            <option value="" disabled selected>Pilih Tipe Aktivitas</option>
                                            <option value="Business">Business</option>
                                            <option value="Student">Worker</option>
                                            <option value="Freelancer">Freelancer</option>
                                            <option value="Worker">Comunity</option>
                                            <option value="Other">Student</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="institution">Institution</label>
                                        <input type="text" class="form-control" id="institution" name="institusi">
                                    </div>

                                    <div class="form-group">
                                        <label for="activity_type">Type</label>
                                        <select class="form-control" id="activity_type" name="type" required>
                                            <option value="" disabled selected>Pilih Tipe</option>
                                            <option value="Member">Member</option>
                                            <option value="Mentor">Mentor</option>
                                            <option value="Oficial">Oficial</option>
                                            <option value="Tegal Greate Seal">Tegal Greate Seal</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="activity_type">Status</label>
                                        <select class="form-control" id="activity_type" name="status" required>
                                            <option value="" disabled selected>Pilih Tipe</option>
                                            <option value="Aktive">Aktive</option>
                                            <option value="Inactive">Inactive</option>
                                        </select>
                                    </div>

                                </div>
                            </div> {{-- End of Second Row --}}

                            {{-- Tombol Submit (Opsional, tergantung tampilan akhir yang Anda inginkan) --}}
                            <button type="submit" class="btn btn-primary mt-3">Tambah Member</button>

                        </form>

                    </div>
                </div>

    </section>
</div>

<!-- Container untuk notifikasi -->
<div class="notification-container" id="notificationContainer"></div>

@include('layouts.footer')
<script>
document.querySelector('.custom-file-input').addEventListener('change', function(e) {
    var fileName = e.target.files[0].name;
    e.target.nextElementSibling.innerText = fileName; 
});

function showNotification(message, type = 'success') {
    const container = document.getElementById('notificationContainer');
    if (!container) return;

    // Icon dihapus, hanya teks
    const notification = document.createElement('div');
    notification.className = `notification ${type}`;
    notification.innerHTML = `
        <div style="flex: 1;">
            <div style="display: flex; align-items: center; gap: 6px; margin-bottom: 4px;">
                <strong>${type === 'success' ? 'Berhasil!' : 'Perhatian!'}</strong>
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
</script>

<div class="notification-container" id="notificationContainer" data-success-message="{{ session('success') }}" data-error-message="{{ $errors->first() }}"></div>

<script>
$(document).ready(function() {
  const successMessage = $('#notificationContainer').data('success-message');
  const errorMessage = $('#notificationContainer').data('error-message');
  
  if (successMessage) {
    showNotification(successMessage, 'success');
  }
  if (errorMessage) {
    showNotification(errorMessage, 'error');
  }
});
</script>