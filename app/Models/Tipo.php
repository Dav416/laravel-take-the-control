<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tipo extends Model
{
    use SoftDeletes;

    protected $table = 'tipos';
    protected $primaryKey = 'id_tipo';
    public $timestamps = true;

    const CREATED_AT = 'fecha_creacion';
    const UPDATED_AT = 'fecha_actualizacion';
    const DELETED_AT = 'fecha_eliminacion';

    protected $fillable = [
        'nombre_tipo',
        'descripcion_tipo',
        'categoria_tipo_id',
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
        return 'id_tipo';
    }

    /**
     * Relación: Un tipo tiene muchas transacciones
     */
    public function transacciones()
    {
        return $this->hasMany(Transaccion::class, 'tipo_id', 'id_tipo');
    }

    /**
     * Relación: Un tipo tiene una categoría
     */
    public function categoria()
    {
        return $this->belongsTo(CategoriaTipo::class, 'categoria_tipo_id', 'id_categoria_tipo');
    }
}
