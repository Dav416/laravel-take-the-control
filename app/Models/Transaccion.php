<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaccion extends Model
{
    use SoftDeletes;

    protected $table = 'transacciones';
    protected $primaryKey = 'id_transaccion';
    public $timestamps = true;

    // Fechas personalizadas
    const CREATED_AT = 'fecha_creacion';
    const UPDATED_AT = 'fecha_actualizacion';
    const DELETED_AT = 'fecha_eliminacion';

    protected $fillable = [
        'nombre_transaccion',
        'descripcion_transaccion',
        'valor_transaccion',
        'tipo_id',
        'categoria_id',
        'entidad_financiera_id',
        'proyeccion_financiera_id',
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
        return 'id_transaccion';
    }

    // 🔹 Relaciones
    public function categoria()
    {
    return $this->belongsTo(CategoriaTransaccion::class, 'categoria_id', 'id_categoria_transaccion');
    }

    public function entidadFinanciera()
    {
        return $this->belongsTo(EntidadFinanciera::class, 'entidad_financiera_id', 'id_entidad_financiera');
    }

    public function proyeccionFinanciera()
    {
        return $this->belongsTo(ProyeccionFinanciera::class, 'proyeccion_financiera_id', 'id_proyeccion_financiera');
    }
    public function tipo()
    {
        return $this->belongsTo(Tipo::class, 'tipo_id', 'id_tipo');
    }
}
