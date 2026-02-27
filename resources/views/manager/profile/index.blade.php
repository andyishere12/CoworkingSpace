@include('manager.layouts.header')

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><i class="fas fa-user-circle mr-2"></i>Profil Saya</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('manager.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Profil</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">

            @if(session('success'))
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                    <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="row">

                {{-- Kolom Kiri - Avatar & Info --}}
                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-body text-center">

                            {{-- Avatar --}}
                            <div class="mb-3" style="position:relative; display:inline-block;">
                                @if($user->avatar)
                                    <img src="{{ asset('storage/avatars/' . $user->avatar) }}"
                                        id="avatarPreview"
                                        class="img-circle"
                                        style="width:130px;height:130px;object-fit:cover;border:4px solid #6C3FB5;">
                                @else
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&size=130&background=6C3FB5&color=fff"
                                        id="avatarPreview"
                                        class="img-circle"
                                        style="width:130px;height:130px;border:4px solid #6C3FB5;">
                                @endif
                            </div>

                            <h4 class="mt-2 mb-0">{{ $user->name }}</h4>
                            <p class="text-muted">{{ $user->email }}</p>

                            <span class="badge badge-success px-3 py-2 mb-3">
                                <i class="fas fa-user-tie mr-1"></i>Manager
                            </span>

                            <hr>

                            <div class="text-left">
                                <p class="mb-2">
                                    <i class="fas fa-calendar-alt mr-2 text-muted"></i>
                                    <small class="text-muted">Bergabung:</small><br>
                                    <strong>{{ $user->created_at->format('d M Y') }}</strong>
                                </p>
                                <p class="mb-0">
                                    <i class="fas fa-clock mr-2 text-muted"></i>
                                    <small class="text-muted">Terakhir Update:</small><br>
                                    <strong>{{ $user->updated_at->diffForHumans() }}</strong>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Kolom Kanan - Form --}}
                <div class="col-md-8">

                    {{-- Form Update Profil --}}
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-primary text-white">
                            <h3 class="card-title mb-0">
                                <i class="fas fa-edit mr-2"></i>Update Profil
                            </h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('manager.profile.update') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="form-group">
                                    <label for="name">Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text"
                                        class="form-control @error('name') is-invalid @enderror"
                                        id="name" name="name"
                                        value="{{ old('name', $user->name) }}" required>
                                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="form-group">
                                    <label for="email">Email <span class="text-danger">*</span></label>
                                    <input type="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        id="email" name="email"
                                        value="{{ old('email', $user->email) }}" required>
                                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="form-group">
                                    <label for="avatar">Foto Profil</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file"
                                                class="custom-file-input @error('avatar') is-invalid @enderror"
                                                id="avatar" name="avatar"
                                                accept="image/jpeg,image/png,image/jpg"
                                                onchange="previewAvatar(this)">
                                            <label class="custom-file-label" for="avatar">Pilih foto...</label>
                                        </div>
                                        @error('avatar')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <small class="text-muted">Format: JPG, PNG. Maks: 2MB</small>
                                </div>

                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save mr-1"></i>Simpan Perubahan
                                </button>
                            </form>
                        </div>
                    </div>

                    {{-- Form Ganti Password --}}
                    <div class="card shadow-sm">
                        <div class="card-header bg-warning text-white">
                            <h3 class="card-title mb-0">
                                <i class="fas fa-key mr-2"></i>Ganti Password
                            </h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('manager.profile.password') }}" method="POST">
                                @csrf

                                <div class="form-group">
                                    <label for="current_password">Password Saat Ini <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="password"
                                            class="form-control @error('current_password') is-invalid @enderror"
                                            id="current_password" name="current_password"
                                            placeholder="Masukkan password saat ini" required>
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary" type="button"
                                                onclick="togglePassword('current_password', this)">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                        @error('current_password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="new_password">Password Baru <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="password"
                                            class="form-control @error('new_password') is-invalid @enderror"
                                            id="new_password" name="new_password"
                                            placeholder="Minimal 8 karakter" required>
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary" type="button"
                                                onclick="togglePassword('new_password', this)">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                        @error('new_password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="new_password_confirmation">Konfirmasi Password Baru <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="password"
                                            class="form-control"
                                            id="new_password_confirmation" name="new_password_confirmation"
                                            placeholder="Ulangi password baru" required>
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary" type="button"
                                                onclick="togglePassword('new_password_confirmation', this)">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-warning">
                                    <i class="fas fa-key mr-1"></i>Ganti Password
                                </button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </section>
</div>

@include('manager.layouts.footer')

<script>
function togglePassword(fieldId, btn) {
    const field = document.getElementById(fieldId);
    const icon = btn.querySelector('i');
    if (field.type === 'password') {
        field.type = 'text';
        icon.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
        field.type = 'password';
        icon.classList.replace('fa-eye-slash', 'fa-eye');
    }
}

function previewAvatar(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('avatarPreview').src = e.target.result;
        };
        reader.readAsDataURL(input.files[0]);

        // Update label nama file
        const fileName = input.files[0].name;
        input.nextElementSibling.innerText = fileName;
    }
}
</script>
