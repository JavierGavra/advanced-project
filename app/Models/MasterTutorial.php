<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterTutorial extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul', 
        'kode_matkul', 
        'nama_matkul', 
        'presentation_url', 
        'finished_url', 
        'creator_email'
    ];

    public function details()
    {
        return $this->hasMany(DetailTutorial::class)->orderBy('order');
    }
}
