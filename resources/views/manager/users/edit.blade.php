@include('manager.layouts.header')

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><i class="fas fa-user-edit mr-2"></i>Edit User</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('manager.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('manager.users.index') }}">Users</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-8">

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

                    <div class="card shadow-sm">
                        <div class="card-header bg-warning text-white">
                            <h3 class="card-title mb-0">
                                <i class="fas fa-user-edit mr-2"></i>Edit User: {{ $user->name }}
                            </h3>
                        </div>
                        <div class="card-body">

                            {{-- Info User --}}
                            <div class="d-flex align-items-center mb-4 p-3" style="background:#f8f9fa; border-radius:8px;">
                                @if($user->avatar)
                                    <img src="{{ asset('storage/avatars/' . $user->avatar) }}"
                                        class="img-circle mr-3" style="width:60px;height:60px;object-fit:cover;">
                                @else
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&size=60&background=6C3FB5&color=fff"
                                        class="img-circle mr-3" style="width:60px;height:60px;">
                                @endif
                                <div>
                                    <h5 class="mb-0">{{ $user->name }}</h5>
                                    <small class="text-muted">{{ $user->email }}</small><br>
                                    <span class="badge {{ $user->role === 'manager' ? 'badge-success' : 'badge-primary' }} mt-1">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                    @if($user->id === auth()->id())
                                        <span class="badge badge-secondary ml-1">You</span>
                                    @endif
                                </div>
                            </div>

                            <form action="{{ route('manager.users.update', $user->id) }}" method="POST">
                                @csrf
                                @method('PUT')

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
                                    <label for="role">Role <span class="text-danger">*</span></label>
                                    <select class="form-control @error('role') is-invalid @enderror"
                                        id="role" name="role" required
                                        {{ $user->id === auth()->id() ? 'disabled' : '' }}>
                                        <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                                        <option value="manager" {{ old('role', $user->role) == 'manager' ? 'selected' : '' }}>Manager</option>
                                    </select>
                                    @if($user->id === auth()->id())
                                        <input type="hidden" name="role" value="{{ $user->role }}">
                                        <small class="text-warning"><i class="fas fa-lock mr-1"></i>Anda tidak bisa mengubah role akun sendiri.</small>
                                    @endif
                                    @error('role')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <hr>
                                <p class="text-muted mb-3">
                                    <i class="fas fa-key mr-1"></i>
                                    <strong>Reset Password</strong> — kosongkan jika tidak ingin mengubah password.
                                </p>

                                <div class="form-group">
                                    <label for="password">Password Baru</label>
                                    <div class="input-group">
                                        <input type="password"
                                            class="form-control @error('password') is-invalid @enderror"
                                            id="password" name="password"
                                            placeholder="Kosongkan jika tidak diubah">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password', this)">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                        @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="password_confirmation">Konfirmasi Password Baru</label>
                                    <div class="input-group">
                                        <input type="password"
                                            class="form-control"
                                            id="password_confirmation" name="password_confirmation"
                                            placeholder="Ulangi password baru">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password_confirmation', this)">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <button type="submit" class="btn btn-warning">
                                        <i class="fas fa-save mr-1"></i>Update User
                                    </button>
                                    <a href="{{ route('manager.users.index') }}" class="btn btn-secondary ml-2">
                                        <i class="fas fa-times mr-1"></i>Batal
                                    </a>
                                </div>
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
</script>