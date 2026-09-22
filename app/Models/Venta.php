<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    public $timestamps = false;
    protected $table = 'ventas';

    protected $fillable = [
        'nombre_cliente', 
        'correo_cliente', 
        'numero_tarjeta', 
        'valor_total'
    ];

    public function detalles()
    {
        return $this->hasMany(DetalleVenta::class, 'venta_id');
    }
}