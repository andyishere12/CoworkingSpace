<!-- @extends('layouts.app')

@section('content')

<div class="container">

    <div class="card shadow-lg p-4" style="max-width: 400px; margin: auto;">
        <h4 class="text-center mb-3">Detail Member</h4>

        <div class="text-center mb-3">
            {{-- QR Code --}}
            {!! QrCode::size(200)->generate("ID=$data_member->id; Nama=$data_member->nama; Type=$data_member->type") !!}
        </div>

        <p><strong>Nama:</strong> {{ $data_member->nama }}</p>
        <p><strong>Type:</strong> {{ $data_member->type }}</p>
        <p><strong>Aktivitas:</strong> {{ $data_member->aktivitas }}</p>

        <a href="{{ route('data_member.index') }}" class="btn btn-secondary w-100 mt-3">Kembali</a>
    </div>

</div>
@endsection -->
