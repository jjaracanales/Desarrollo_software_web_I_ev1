<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proyecto extends Model
{
    protected $fillable = [
        'nombre',
        'fecha_inicio',
        'estado',
        'responsable',
        'monto'
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'monto' => 'decimal:2'
    ];
}
