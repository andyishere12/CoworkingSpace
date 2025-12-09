@include('layouts.header')

<head>
    <link rel="stylesheet" href="{{ asset('css/stylecreate.css') }}">
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
                        <li class="breadcrumb-item active">Edit Member</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">

            {{-- Header Form --}}
            <h1 class="page-title mb-4">Edit Member</h1>

            <div class="card shadow-sm">
                <div class="card-body">

                    <form action="{{ route('data_member.update', $data_member->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

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
                                        <small class="text-muted">
                                            @if($data_member->foto)
                                                Current: {{ $data_member->foto }}
                                            @else
                                                No file chosen
                                            @endif
                                        </small>
                                    </div>
                                    @if($data_member->foto)
                                        <img src="{{ asset('storage/'.$data_member->foto) }}" alt="Foto Member" width="150" class="mt-2">
                                    @endif
                                </div>
                            </div>

                            {{-- Kolom Kanan (Informasi Dasar) --}}
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" id="name" name="nama" value="{{ $data_member->nama }}">
                                </div>

                                <div class="form-group">
                                    <label for="birth_date">Birth Date</label>
                                    <div class="input-group">
                                        <input type="date" class="form-control" id="birth_date" name="tanggal_lahir" value="{{ $data_member->tanggal_lahir }}">
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> {{-- End First Row --}}

                        <div class="row">
                            {{-- Kolom Kiri Bawah --}}
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="address">Alamat</label>
                                    <textarea class="form-control" id="address" name="alamat" rows="5">{{ $data_member->alamat }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" value="{{ $data_member->email }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="phone">Nomor Hp</label>
                                    <input type="tel" class="form-control" id="phone" name="no_hp" value="{{ $data_member->no_hp }}">
                                </div>
                            </div>

                            {{-- Kolom Kanan Bawah --}}
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="activity_type">Activity Type</label>
                                    <select class="form-control" id="activity_type" name="aktivitas" required>
                                        <option value="" disabled>Pilih Tipe Aktivitas</option>
                                        <option value="Business" {{ $data_member->aktivitas == 'Business' ? 'selected' : '' }}>Business</option>
                                        <option value="Student" {{ $data_member->aktivitas == 'Student' ? 'selected' : '' }}>Student</option>
                                        <option value="Freelancer" {{ $data_member->aktivitas == 'Freelancer' ? 'selected' : '' }}>Freelancer</option>
                                        <option value="Worker" {{ $data_member->aktivitas == 'Worker' ? 'selected' : '' }}>Worker</option>
                                        <option value="Other" {{ $data_member->aktivitas == 'Other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="institution">Institution</label>
                                    <input type="text" class="form-control" id="institution" name="institusi" value="{{ $data_member->institusi }}">
                                </div>

                                <div class="form-group">
                                    <label for="type">Type</label>
                                    <select class="form-control" id="type" name="type" required>
                                        <option value="" disabled>Pilih Tipe</option>
                                        <option value="Member" {{ $data_member->type == 'Member' ? 'selected' : '' }}>Member</option>
                                        <option value="Mentor" {{ $data_member->type == 'Mentor' ? 'selected' : '' }}>Mentor</option>
                                        <option value="Oficial" {{ $data_member->type == 'Oficial' ? 'selected' : '' }}>Oficial</option>
                                        <option value="Tegal Greate Seal" {{ $data_member->type == 'Tegal Greate Seal' ? 'selected' : '' }}>Tegal Greate Seal</option>
                                        <option value="Student" {{ $data_member->type == 'Student' ? 'selected' : '' }}>Student</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select class="form-control" id="status" name="status" required>
                                        <option value="" disabled>Pilih Tipe</option>
                                        <option value="Aktive" {{ $data_member->status == 'Aktive' ? 'selected' : '' }}>Aktive</option>
                                        <option value="Inactive" {{ $data_member->status == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>

                            </div>
                        </div> {{-- End Second Row --}}

                        <button type="submit" class="btn btn-primary mt-3">Update Member</button>
                    </form>

                </div>
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
