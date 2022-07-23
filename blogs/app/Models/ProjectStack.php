<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectStack extends Model
{
    use HasFactory;

    // untuk default tabel
    protected $table = 'project_stack';
    // untuk default id
    protected $primaryKey = 'id_project_stack';
    // untuk fillable
    protected $fillable = [
        'id_project_stack',
        'id_project',
        'id_stack',
        'by_users'
    ];
    // untuk relasi ke tabel stack
    public function toStack()
    {
        return $this->belongsTo(Stack::class, 'id_stack');
    }
}
