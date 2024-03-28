<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProdiModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'prodi';
    protected $primaryKey = 'prodi_id';
    protected $fillable = [
        'prodi_id',
        'prodi_kode',
        'prodi_kode'
    ];
}
