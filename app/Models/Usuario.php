<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Usuario extends Authenticatable
{
    use HasFactory,Notifiable, SoftDeletes;

    // Nombre real de la tabla
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

    // Para que Laravel use 'correo_usuario' como identificador
    public function getAuthIdentifierName()
    {
        return 'correo_usuario';
    }

    // Para que Laravel use 'clave_usuario' en vez de 'password'
    public function getAuthPassword()
    {
        return $this->clave_usuario;
    }

    // Mutador para contraseñas - versión simple y segura
    public function setClaveUsuarioAttribute($value)
    {
        if (!empty($value)) {
            // Verificar si ya está hasheada usando password_get_info
            $info = password_get_info($value);

            // Si no tiene algoritmo, no está hasheada
            if ($info['algo'] === null || $info['algo'] === 0) {
                $this->attributes['clave_usuario'] = Hash::make($value);
            } else {
                // Ya está hasheada, guardar tal como está
                $this->attributes['clave_usuario'] = $value;
            }
        }
    }

    // Accessor para compatibilidad con Laravel
    public function getEmailAttribute()
    {
        return $this->correo_usuario;
    }

    // Método para verificar contraseña
    public function checkPassword($password)
    {
        return Hash::check($password, $this->clave_usuario);
    }
}
