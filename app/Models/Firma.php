<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Firma extends Model
{
    protected $table = 'firme';
    protected $fillable = [
        'nume',
        'cui', 
        'adresa',
        'telefon',
        'email',
        'user_id',
    ];

    public function users()
    {
    return $this->belongsToMany(User::class);
    }
    public function documente()
    {
    return $this->hasMany(Document::class, 'firma_id');
    }
}