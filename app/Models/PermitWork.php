<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermitWork extends Model
{
    use HasFactory;

    /**
     * Kolom yang dapat diisi (mass assignable).
     */
    protected $fillable = [
        'company_name', 
        'permit_type', 
        'description', 
        'status', 
        'feedback', 
        'user_id', 
        'verified_by'
    ];

    /**
     * Relasi ke model User sebagai pemohon izin.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relasi ke model User sebagai verifikator.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    /**
     * Relasi ke model Document untuk dokumen pendukung pengajuan.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    /**
     * Scope untuk mengfilter pengajuan izin berdasarkan status.
     * 
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $status
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope untuk mengfilter pengajuan izin berdasarkan pemohon.
     * 
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  int  $userId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope untuk mengfilter pengajuan izin berdasarkan verifikator.
     * 
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  int  $verifierId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByVerifier($query, $verifierId)
    {
        return $query->where('verified_by', $verifierId);
    }
}
