<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    // untuk default tabel
    protected $table = 'project';
    // untuk default id
    protected $primaryKey = 'id_project';
    // untuk fillable
    protected $fillable = [
        'id_project',
        'judul',
        'deskripsi',
        'link',
        'by_users'
    ];
}
