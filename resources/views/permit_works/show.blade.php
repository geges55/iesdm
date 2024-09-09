@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Detail Pengajuan Izin</h1>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $permitWork->company_name }}</h5>
            <p class="card-text"><strong>Tipe Izin:</strong> {{ $permitWork->permit_type }}</p>
            <p class="card-text"><strong>Deskripsi:</strong> {{ $permitWork->description }}</p>
            <p class="card-text"><strong>Status:</strong> {{ ucfirst($permitWork->status) }}</p>
            <p class="card-text"><strong>Feedback:</strong> {{ $permitWork->feedback ?? 'Belum ada feedback' }}</p>

            <h5>Dokumen Pendukung</h5>
            <ul>
                @foreach($permitWork->documents as $document)
                    <li><a href="{{ asset('storage/' . $document->path) }}" target="_blank">Lihat Dokumen</a></li>
                @endforeach
            </ul>

            <a href="{{ route('permit-works.index') }}" class="btn btn-primary">Kembali</a>
        </div>
    </div>
</div>
@endsection
