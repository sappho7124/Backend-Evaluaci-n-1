<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    public $timestamps = false;
    protected $table = 'productos';
    protected $fillable = ['nombre', 'descripcion', 'precio', 'stock', 'franquicia', 'categoria_id'];

    protected $appends = ['precio_final', 'es_promocion'];

    public function getEsPromocionAttribute()
    {
        return $this->stock > 20;
    }

    public function getPrecioFinalAttribute()
    {
        return $this->stock > 20 ? round($this->precio * 0.90, 2) : (float) $this->precio;
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }

    public function detalles()
    {
        return $this->hasMany(DetalleVenta::class, 'producto_id');
    }
}