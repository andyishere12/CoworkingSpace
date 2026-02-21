@include('manager.layouts.header')

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><i class="fas fa-users mr-2"></i>Members</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('manager.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Members</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">

            {{-- Stats --}}
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card bg-info text-white">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-white mb-1">Total Member</h6>
                                <h3 class="mb-0">{{ $allmember->count() }}</h3>
                            </div>
                            <i class="fas fa-users fa-2x"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-success text-white">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-white mb-1">Aktif</h6>
                                <h3 class="mb-0">{{ $allmember->where('status', 'Aktif')->count() }}</h3>
                            </div>
                            <i class="fas fa-user-check fa-2x"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-warning text-white">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-white mb-1">Tidak Aktif</h6>
                                <h3 class="mb-0">{{ $allmember->where('status', 'Tidak Aktif')->count() }}</h3>
                            </div>
                            <i class="fas fa-user-times fa-2x"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-primary text-white">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-white mb-1">Institusi</h6>
                                <h3 class="mb-0">{{ $allmember->unique('institusi')->count() }}</h3>
                            </div>
                            <i class="fas fa-building fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Search --}}
            <div class="card shadow-sm">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-list mr-2"></i>Daftar Member</h3>
                    <div class="card-tools">
                        <form action="{{ route('manager.members.index') }}" method="GET" class="d-flex">
                            <input type="text" name="search" class="form-control form-control-sm mr-2"
                                placeholder="Cari nama, institusi, status..."
                                value="{{ $search ?? '' }}" style="width:250px;">
                            <button type="submit" class="btn btn-sm btn-primary mr-1">
                                <i class="fas fa-search"></i>
                            </button>
                            @if($search)
                                <a href="{{ route('manager.members.index') }}" class="btn btn-sm btn-secondary">
                                    <i class="fas fa-times"></i>
                                </a>
                            @endif
                        </form>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th style="width:5%">#</th>
                                    <th style="width:8%">Foto</th>
                                    <th>Nama</th>
                                    <th>Institusi</th>
                                    <th>Aktivitas</th>
                                    <th>Type</th>
                                    <th>Status</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($allmember as $i => $member)
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td>
                                        @if($member->foto)
                                            <img src="{{ asset('uploads/foto/' . $member->foto) }}"
                                                class="img-circle" style="width:40px;height:40px;object-fit:cover;">
                                        @else
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($member->nama) }}&size=40&background=6C3FB5&color=fff"
                                                class="img-circle" style="width:40px;height:40px;">
                                        @endif
                                    </td>
                                    <td>
                                        <strong>{{ $member->nama }}</strong><br>
                                        <small class="text-muted">{{ $member->email }}</small>
                                    </td>
                                    <td>{{ $member->institusi ?? '-' }}</td>
                                    <td>{{ $member->aktivitas ?? '-' }}</td>
                                    <td>
                                        <span class="badge badge-info px-2 py-1">{{ $member->type ?? '-' }}</span>
                                    </td>
                                    <td>
                                        @if($member->status == 'Aktif')
                                            <span class="badge badge-success px-2 py-1">Aktif</span>
                                        @else
                                            <span class="badge badge-danger px-2 py-1">{{ $member->status }}</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('manager.members.show', $member->id) }}"
                                            class="btn btn-sm btn-info">
                                            <i class="fas fa-eye mr-1"></i>Detail
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center py-4">
                                        <i class="fas fa-users fa-2x text-muted mb-2 d-block"></i>
                                        @if($search)
                                            Tidak ada member dengan kata kunci "<strong>{{ $search }}</strong>"
                                        @else
                                            Belum ada data member.
                                        @endif
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
