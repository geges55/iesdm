<!-- resources/views/permit_works/report.blade.php -->
@extends('layouts.app')

@section('title', 'Laporan Pengajuan Izin')

@section('page_title', 'Laporan Pengajuan Izin')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Rekap Pengajuan Izin</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('permit-works.report') }}" method="GET" class="form-inline mb-3">
            <div class="form-group">
                <label for="month" class="mr-2">Bulan:</label>
                <input type="number" name="month" id="month" class="form-control mr-2" min="1" max="12" value="{{ request('month', now()->month) }}">
            </div>
            <div class="form-group">
                <label for="year" class="mr-2">Tahun:</label>
                <input type="number" name="year" id="year" class="form-control mr-2" min="2000" max="{{ now()->year }}" value="{{ request('year', now()->year) }}">
            </div>
            <button type="submit" class="btn btn-primary">Tampilkan</button>
        </form>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Perusahaan</th>
                    <th>Jenis Izin</th>
                    <th>Status</th>
                    <th>Verifikator</th>
                    <th>Tanggal Pengajuan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($permitWorks as $permitWork)
                    <tr>
                        <td>{{ $permitWork->id }}</td>
                        <td>{{ $permitWork->company_name }}</td>
                        <td>{{ $permitWork->permit_type }}</td>
                        <td>{{ $permitWork->status }}</td>
                        <td>{{ optional($permitWork->verifier)->name }}</td>
                        <td>{{ $permitWork->created_at->format('d-m-Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
