@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Pengajuan Izin</h1>

    <form action="{{ route('permit-works.update', $permitWork->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="company_name">Nama Perusahaan</label>
            <input type="text" name="company_name" id="company_name" class="form-control" value="{{ old('company_name', $permitWork->company_name) }}" required>
        </div>

        <div class="form-group">
            <label for="permit_type">Tipe Izin</label>
            <select name="permit_type" id="permit_type" class="form-control" required>
                @foreach($permitTypes as $type)
                    <option value="{{ $type }}" {{ $permitWork->permit_type == $type ? 'selected' : '' }}>
                        {{ $type }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="description">Deskripsi</label>
            <textarea name="description" id="description" class="form-control" required>{{ old('description', $permitWork->description) }}</textarea>
        </div>

        <div class="form-group">
            <label for="document">Unggah Dokumen Tambahan (Opsional)</label>
            <input type="file" name="document[]" id="document" class="form-control" multiple>
        </div>

        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        <a href="{{ route('permit-works.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>

<script>
    document.getElementById('editForm').addEventListener('submit', function(event) {
        var files = document.getElementById('document').files;
        var allowedExtensions = /(\.pdf|\.jpg)$/i;
        var invalidFiles = [];
    
        for (var i = 0; i < files.length; i++) {
            if (!allowedExtensions.exec(files[i].name)) {
                invalidFiles.push(files[i].name);
            }
        }
    
        if (invalidFiles.length > 0) {
            alert('Hanya file PDF dan JPG yang diizinkan. File yang tidak valid: ' + invalidFiles.join(', '));
            event.preventDefault(); // Mencegah form disubmit
        }
    });
    </script>
@endsection
