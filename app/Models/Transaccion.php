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
        'Categorias_id_categoria',
        'EntidadesFinancieras_id_entidad_financiera',
        'ProyeccionesFinancieras_id_proyeccion_financiera',
    ];

    protected $casts = [
        'fecha_creacion' => 'datetime',
        'fecha_actualizacion' => 'datetime',
        'fecha_eliminacion' => 'datetime',
    ];

    // 🔹 Relaciones
    public function categoria()
    {
        return $this->belongsTo(CategoriaTransaccion::class, 'Categorias_id_categoria_transaccion', 'id_categoria_transaccion');
    }

    public function entidadFinanciera()
    {
        return $this->belongsTo(EntidadFinanciera::class, 'EntidadesFinancieras_id_entidad_financiera', 'id_entidad_financiera');
    }

    public function proyeccionFinanciera()
    {
        return $this->belongsTo(ProyeccionFinanciera::class, 'ProyeccionesFinancieras_id_proyeccion_financiera', 'id_proyeccion_financiera');
    }
}
