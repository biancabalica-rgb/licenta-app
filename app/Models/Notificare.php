<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notificare extends Model
{
    protected $table = 'notificari';

    protected $fillable = [
        'tip',
        'titlu',
        'mesaj',
        'citita',
    ];
}