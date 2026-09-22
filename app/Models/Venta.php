<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Venta extends Model
{
    protected $table = 'ventas';
    protected $fillable = ['cliente_nombre', 'clente_email', ''];

    public function productos(): HasMany
    {
        return $this->hasMany(Producto::class, 'producto_id');
    }
}