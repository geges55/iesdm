<!-- resources/views/permit_works/create.blade.php -->
@extends('layouts.app')

@section('title', 'Pengajuan Izin Baru')

@section('page_title', 'Pengajuan Izin Baru')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Formulir Pengajuan Izin</h3>
    </div>
    <div class="card-body">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('permit-works.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="company_name">Nama Perusahaan</label>
                <input type="text" name="company_name" class="form-control" id="company_name" required>
            </div>

            <div class="form-group">
                <label for="permit_type">Jenis Izin</label>
                <select name="permit_type" id="permit_type" class="form-control" required>
                    <option value="">Pilih Jenis Izin</option>
                    <option value="izin_pertambangan">Izin Pertambangan</option>
                    <option value="izin_energi">Izin Energi</option>
                </select>
            </div>

            <div class="form-group">
                <label for="document">Unggah Dokumen Pendukung</label>
                <input type="file" name="document[]" class="form-control" id="document" multiple required>
            </div>

            <div class="form-group">
                <label for="description">Deskripsi Pengajuan</label>
                <textarea name="description" id="description" class="form-control" rows="4" required></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Kirim Pengajuan</button>
        </form>
    </div>
</div>
@endsection
