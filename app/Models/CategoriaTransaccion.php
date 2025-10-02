<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoriaTransaccion extends Model
{
    use SoftDeletes;

    protected $table = 'categorias_transacciones';
    protected $primaryKey = 'id_categoria_transaccion';
    public $timestamps = true;

    // Fechas personalizadas
    const CREATED_AT = 'fecha_creacion';
    const UPDATED_AT = 'fecha_actualizacion';
    const DELETED_AT = 'fecha_eliminacion';

    protected $fillable = [
        'nombre_categoria_transaccion',
        'descripcion_categoria_transaccion',
    ];

    protected $casts = [
        'fecha_creacion' => 'datetime',
        'fecha_actualizacion' => 'datetime',
        'fecha_eliminacion' => 'datetime',
    ];

    // Relación con Transacciones
    public function transacciones()
    {
        return $this->hasMany(Transaccion::class, 'Categorias_id_categoria_transaccion', 'id_categoria_transaccion');
    }
}
