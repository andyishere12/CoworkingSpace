@include('manager.layouts.header')

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><i class="fas fa-users-cog mr-2"></i>User Management</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('manager.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Users</li>
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
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                    <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
                </div>
            @endif

            {{-- Stats --}}
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card bg-info text-white">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-white mb-1">Total Users</h6>
                                <h3 class="mb-0">{{ $users->count() }}</h3>
                            </div>
                            <i class="fas fa-users fa-2x"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-primary text-white">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-white mb-1">Admin</h6>
                                <h3 class="mb-0">{{ $users->where('role', 'admin')->count() }}</h3>
                            </div>
                            <i class="fas fa-user-shield fa-2x"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-success text-white">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-white mb-1">Manager</h6>
                                <h3 class="mb-0">{{ $users->where('role', 'manager')->count() }}</h3>
                            </div>
                            <i class="fas fa-user-tie fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Table --}}
            <div class="card shadow-sm">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-list mr-2"></i>Daftar User</h3>
                    <div class="card-tools">
                        <a href="{{ route('manager.users.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus mr-1"></i>Tambah User
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th style="width:5%">#</th>
                                    <th style="width:10%">Avatar</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Dibuat</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($users as $i => $user)
                                <tr @if($user->id === auth()->id()) style="background:#f0fff0;" @endif>
                                    <td>{{ $i + 1 }}</td>
                                    <td>
                                        @if($user->avatar)
                                            <img src="{{ asset('storage/avatars/' . $user->avatar) }}"
                                                class="img-circle" style="width:40px;height:40px;object-fit:cover;">
                                        @else
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&size=40&background=6C3FB5&color=fff"
                                                class="img-circle" style="width:40px;height:40px;">
                                        @endif
                                    </td>
                                    <td>
                                        <strong>{{ $user->name }}</strong>
                                        @if($user->id === auth()->id())
                                            <span class="badge badge-secondary ml-1">You</span>
                                        @endif
                                    </td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @if($user->role === 'manager')
                                            <span class="badge badge-success px-2 py-1">
                                                <i class="fas fa-user-tie mr-1"></i>Manager
                                            </span>
                                        @else
                                            <span class="badge badge-primary px-2 py-1">
                                                <i class="fas fa-user-shield mr-1"></i>Admin
                                            </span>
                                        @endif
                                    </td>
                                    <td>{{ $user->created_at->format('d M Y') }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('manager.users.edit', $user->id) }}"
                                            class="btn btn-sm btn-warning mr-1">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        @if($user->id !== auth()->id())
                                            <button type="button" class="btn btn-sm btn-danger"
                                                data-toggle="modal" data-target="#deleteModal{{ $user->id }}">
                                                <i class="fas fa-trash"></i> Hapus
                                            </button>
                                        @else
                                            <button class="btn btn-sm btn-secondary" disabled>
                                                <i class="fas fa-trash"></i> Hapus
                                            </button>
                                        @endif
                                    </td>
                                </tr>

                                {{-- Delete Modal --}}
                                <div class="modal fade" id="deleteModal{{ $user->id }}" tabindex="-1" role="dialog">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header bg-danger text-white">
                                                <h5 class="modal-title">
                                                    <i class="fas fa-trash mr-2"></i>Hapus User
                                                </h5>
                                                <button type="button" class="close text-white" data-dismiss="modal">
                                                    <span>&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Apakah Anda yakin ingin menghapus user:</p>
                                                <p><strong>{{ $user->name }}</strong> ({{ $user->email }})?</p>
                                                <p class="text-danger"><small><i class="fas fa-exclamation-triangle mr-1"></i>Tindakan ini tidak bisa dibatalkan.</small></p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                <form action="{{ route('manager.users.destroy', $user->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">
                                                        <i class="fas fa-trash mr-1"></i>Ya, Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4">
                                        <i class="fas fa-users fa-2x text-muted mb-2 d-block"></i>
                                        Tidak ada user ditemukan.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </section>
</div>

@include('manager.layouts.footer')