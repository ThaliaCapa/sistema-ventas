<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre_empresa',
        'telefono',
        'correo',
        'direccion',
        'codigo_postal',
        'moneda',
        'logo',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}