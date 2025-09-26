<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Usuario extends Authenticatable
{
    use Notifiable, SoftDeletes;

    // Nombre real de la tabla (con mayúscula como en tu DB)
    protected $table = 'Usuarios';

    // Clave primaria personalizada
    protected $primaryKey = 'id_usuario';

    // Configuración de timestamps personalizados
    const CREATED_AT = 'fecha_creacion';
    const UPDATED_AT = 'fecha_actualizacion';
    const DELETED_AT = 'fecha_eliminacion';

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'nombre_usuario',
        'nombre_cuenta_usuario',
        'clave_usuario',
        'correo_usuario',
    ];

    // Campos que deben ocultarse al devolver JSON
    protected $hidden = [
        'clave_usuario',
        'remember_token',
    ];

    // Cast de fechas
    protected $casts = [
        'fecha_creacion' => 'datetime',
        'fecha_actualizacion' => 'datetime',
        'fecha_eliminacion' => 'datetime',
    ];

    // ⚡️ Para que Laravel use 'clave_usuario' en vez de 'password'
    public function getAuthPassword()
    {
        return $this->clave_usuario;
    }

    // ⚡️ Para que Laravel use 'correo_usuario' como identificador
    public function getAuthIdentifierName()
    {
        return 'correo_usuario';
    }

    // ⚡️ Mutador: cada vez que guardes una clave, la encripta automáticamente
    public function setClaveUsuarioAttribute($value)
    {
        // Solo encriptar si no está ya encriptada y no está vacía
        if (!empty($value) && !password_get_info($value)['algo']) {
            $this->attributes['clave_usuario'] = bcrypt($value);
        } elseif (!empty($value)) {
            $this->attributes['clave_usuario'] = $value;
        }
    }

    // Accessor para compatibilidad (Laravel espera 'email' en algunos casos)
    public function getEmailAttribute()
    {
        return $this->correo_usuario;
    }
}
