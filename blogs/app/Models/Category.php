<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // untuk default tabel
    protected $table = 'category';
    // untuk default id
    protected $primaryKey = 'id_category';
    // untuk fillable
    protected $fillable = [
        'id_category',
        'nama',
        'by_users'
    ];
}
