<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PembimbingModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'pembimbing';
    protected $primaryKey = 'pembimbing_id';
    protected $fillable = [
        'pembimbing_npp',
        'pembimbing_nama',
        'pembimbing_alamat',
        'pembimbing_jenis_kelamin',
        'pembimbing_no_hp',
    ];
}
