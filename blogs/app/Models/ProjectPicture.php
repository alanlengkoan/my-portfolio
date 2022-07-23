<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectPicture extends Model
{
    use HasFactory;

    // untuk default tabel
    protected $table = 'project_picture';
    // untuk default id
    protected $primaryKey = 'id_project_picture';
    // untuk fillable
    protected $fillable = [
        'id_project_picture',
        'id_project',
        'picture',
        'by_users'
    ];
}
