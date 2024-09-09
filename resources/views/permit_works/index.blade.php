<!-- resources/views/permit_works/index.blade.php -->
@extends('layouts.app')

@section('title', 'Daftar Pengajuan Izin')

@section('page_title', 'Daftar Pengajuan Izin')

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif


@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar Pengajuan Izin</h3>
        <div class="card-tools">
            <a href="{{ route('permit-works.create') }}" class="btn btn-success">Buat Pengajuan Baru</a>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Perusahaan</th>
                    <th>Jenis Izin</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($permitWorks as $permitWork)
                    <tr>
                        <td>{{ $permitWork->id }}</td>
                        <td>{{ $permitWork->company_name }}</td>
                        <td>{{ $permitWork->permit_type }}</td>
                        <td>{{ $permitWork->status }}</td>
                        <td>
                            <a href="{{ route('permit-works.show', $permitWork->id) }}" class="btn btn-info btn-sm">Detail</a>
                            <a href="{{ route('permit-works.edit', $permitWork->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('permit-works.destroy', $permitWork->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
