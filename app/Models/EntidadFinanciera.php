<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EntidadFinanciera extends Model
{
    use SoftDeletes;

    protected $table = 'entidades_financieras';
    protected $primaryKey = 'id_entidad_financiera';
    public $timestamps = true;

    // Fechas personalizadas
    const CREATED_AT = 'fecha_creacion';
    const UPDATED_AT = 'fecha_actualizacion';
    const DELETED_AT = 'fecha_eliminacion';

    protected $fillable = [
        'nombre_entidad_financiera',
        'descripcion_entidad_financiera',
    ];

    protected $casts = [
        'fecha_creacion' => 'datetime',
        'fecha_actualizacion' => 'datetime',
        'fecha_eliminacion' => 'datetime',
    ];

    // Relación con Transacciones
    public function transacciones()
    {
        return $this->hasMany(Transaccion::class, 'EntidadesFinancieras_id_entidad_financiera', 'id_entidad_financiera');
    }
}
