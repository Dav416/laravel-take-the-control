<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoriaProyeccion extends Model
{
    use SoftDeletes;

    protected $table = 'categorias_proyecciones';
    protected $primaryKey = 'id_categoria_proyeccion';
    public $timestamps = true;

    // Fechas personalizadas
    const CREATED_AT = 'fecha_creacion';
    const UPDATED_AT = 'fecha_actualizacion';
    const DELETED_AT = 'fecha_eliminacion';

    protected $fillable = [
        'nombre_categoria_proyeccion',
        'descripcion_categoria_proyeccion',
        'usuario_id',
    ];

    protected $casts = [
        'fecha_creacion'     => 'datetime',
        'fecha_actualizacion'=> 'datetime',
        'fecha_eliminacion'  => 'datetime',
    ];

    /**
     * Obtener la clave de ruta para el model binding
     */
    public function getRouteKeyName()
    {
        return 'id_categoria_proyeccion';
    }

    /**
     * Relación: Una categoría de proyección pertenece a un usuario
     */
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id', 'id_usuario');
    }

    // Relación con Proyecciones Financieras
    public function proyecciones()
    {
        return $this->hasMany(ProyeccionFinanciera::class, 'categoria_id', 'id_categoria_proyeccion');
    }
}
