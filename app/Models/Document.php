<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $table = 'documente';

    protected $fillable = [
        'firma_id',
        'user_id',
        'tip',
        'numar_document',
        'data_document',
        'nume_fisier',
        'cale_fisier',
        'observatii',
    ];

    public function firma()
    {
        return $this->belongsTo(Firma::class, 'firma_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}