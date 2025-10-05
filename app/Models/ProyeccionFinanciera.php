<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProyeccionFinanciera extends Model
{
    use SoftDeletes;

    protected $table = 'proyecciones_financieras';
    protected $primaryKey = 'id_proyeccion_financiera';
    public $timestamps = true;

    // Fechas personalizadas
    const CREATED_AT = 'fecha_creacion';
    const UPDATED_AT = 'fecha_actualizacion';
    const DELETED_AT = 'fecha_eliminacion';

    protected $fillable = [
        'nombre_proyeccion_financiera',
        'descripcion_proyeccion_financiera',
        'meta_proyeccion_financiera',
        'categoria_id',
    ];

    protected $casts = [
        'fecha_creacion' => 'datetime',
        'fecha_actualizacion' => 'datetime',
        'fecha_eliminacion' => 'datetime',
        'meta_proyeccion_financiera' => 'decimal:2',
    ];

    /**
     * Obtener la clave de ruta para el model binding
     */
    public function getRouteKeyName()
    {
        return 'id_proyeccion_financiera';
    }

    // Relación con Transacciones
    public function transacciones()
    {
        return $this->hasMany(Transaccion::class, 'proyeccion_financiera_id', 'id_proyeccion_financiera');
    }

    // Relación con CategoriasProyecciones (tabla extra que mencionas en la FK)
    public function categoriaProyeccion()
    {
         return $this->belongsTo(CategoriaProyeccion::class, 'categoria_id', 'id_categoria_proyeccion');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id', 'id_usuario');
    }
}
