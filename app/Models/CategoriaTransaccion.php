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
        'usuario_id',
    ];

    protected $casts = [
        'fecha_creacion' => 'datetime',
        'fecha_actualizacion' => 'datetime',
        'fecha_eliminacion' => 'datetime',
    ];

    /**
     * Obtener la clave de ruta para el model binding
     */
    public function getRouteKeyName()
    {
        return 'id_categoria_transaccion';
    }

    /**
     * Relación: Una categoría de transacción pertenece a un usuario
     */
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id', 'id_usuario');
    }

    // Relación con Transacciones
    public function transacciones()
    {
        return $this->hasMany(Transaccion::class, 'categoria_id', 'id_categoria_transaccion');
    }
}
