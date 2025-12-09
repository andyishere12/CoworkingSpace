@include('layouts.header')

<head>
    <link rel="stylesheet" href={{ asset('css/stylecreate.css') }}>
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
                                                <input type="file" class="custom-file-input" id="photo" name="foto">
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
                                                placeholder="dd/mm/yyyy">
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
                                            <option value="Student">Student</option>
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
@include('layouts.footer')
<script>
document.querySelector('.custom-file-input').addEventListener('change', function(e) {
    var fileName = e.target.files[0].name;
    e.target.nextElementSibling.innerText = fileName; 
});
</script>
