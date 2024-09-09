<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    /**
     * Kolom yang dapat diisi (mass assignable).
     */
    protected $fillable = [
        'path', 
        'permit_work_id'
    ];

    /**
     * Relasi ke model PermitWork (pengajuan izin terkait).
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function permitWork()
    {
        return $this->belongsTo(PermitWork::class);
    }

    /**
     * Mengembalikan URL lengkap dari dokumen yang diunggah.
     * 
     * @return string
     */
    public function getDocumentUrlAttribute()
    {
        return asset('storage/' . $this->path);
    }
}
