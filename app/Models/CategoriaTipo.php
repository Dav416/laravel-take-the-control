<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoriaTipo extends Model
{
    use SoftDeletes;

    protected $table = 'categorias_tipos';
    protected $primaryKey = 'id_categoria_tipo';
    public $timestamps = true;

    // Fechas personalizadas
    const CREATED_AT = 'fecha_creacion';
    const UPDATED_AT = 'fecha_actualizacion';
    const DELETED_AT = 'fecha_eliminacion';

    protected $fillable = [
        'nombre_categoria_tipo',
        'descripcion_categoria_tipo',
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
        return 'id_categoria_tipo';
    }

    // Relación con Tipos
    public function tipos()
    {
        return $this->hasMany(Tipo::class, 'categoria_tipo_id', 'id_categoria_tipo');
    }
}
