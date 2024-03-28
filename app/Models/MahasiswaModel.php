<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MahasiswaModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'mahasiswa';
    protected $primaryKey = 'mhs_id';
    protected $fillable = [
        'mhs_nbi', 'mhs_nama', 'mhs_alamat', 'mhs_jenis_kelamin', 'mhs_tgl_lahir', 'mhs_pembimbing_id', 'created_by', 'updated_by', 'deleted_by'
    ];

    // Relasi dengan model Pembimbing
    public function pembimbing()
    {
        return $this->belongsTo(Pembimbing::class, 'mhs_pembimbing_id');
    }
}
