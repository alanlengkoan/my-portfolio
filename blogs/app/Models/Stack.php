<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stack extends Model
{
    use HasFactory;

    // untuk default tabel
    protected $table = 'stack';
    // untuk default id
    protected $primaryKey = 'id_stack';
    // untuk fillable
    protected $fillable = [
        'id_stack',
        'nama',
        'icon',
        'by_users'
    ];
}
