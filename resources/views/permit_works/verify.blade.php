<!-- resources/views/permit_works/verify.blade.php -->
@extends('layouts.app')

@section('title', 'Verifikasi Pengajuan Izin')

@section('page_title', 'Verifikasi Pengajuan Izin')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar Pengajuan Izin</h3>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Perusahaan</th>
                    <th>Jenis Izin</th>
                    <th>Deskripsi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($permitWorks as $permitWork)
                    <tr>
                        <td>{{ $permitWork->id }}</td>
                        <td>{{ $permitWork->company_name }}</td>
                        <td>{{ $permitWork->permit_type }}</td>
                        <td>{{ $permitWork->description }}</td>
                        <td>
                            <form action="{{ route('permit-works.verify.process', $permitWork->id) }}" method="POST">
                                @csrf
                                <select name="status" class="form-control">
                                    <option value="approved">Approve</option>
                                    <option value="rejected">Reject</option>
                                    <option value="need_revision">Need Revision</option>
                                </select>
                                <input type="text" name="feedback" placeholder="Feedback (optional)" class="form-control mt-1">
                                <button type="submit" class="btn btn-primary mt-1">Verifikasi</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
