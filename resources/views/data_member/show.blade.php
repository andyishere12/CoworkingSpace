<!-- @extends('layouts.app')

@section('content')
<div class="container">
    <div class="card shadow-sm p-4" style="max-width: 400px; margin: auto;">
        <h4 class="text-center mb-3">Detail Member</h4>

        <div class="text-center mb-3">
            {{-- QR Code --}}
            {!! QrCode::size(200)->generate($member->nama . ' | ' . $member->type) !!}
        </div>

        <div class="text-center">
            <p><strong>Nama:</strong> {{ $member->nama }}</p>
            <p><strong>Type:</strong> {{ $member->type }}</p>
        </div>

        <div class="text-center mt-3">
            <a href="{{ route('data_member.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</div>
@endsection -->
