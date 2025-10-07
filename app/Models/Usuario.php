<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;

class Usuario extends Authenticatable
{
    use HasApiTokens, HasFactory,Notifiable, SoftDeletes;

    // Nombre real de la tabla
    protected $table = 'usuarios';

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

    /**
     * Obtener la clave de ruta para el model binding
     */
    public function getRouteKeyName()
    {
        return 'id_usuario';
    }

    /**
     * Obtener el identificador único para la autenticación
     */
    public function getAuthIdentifier()
    {
        return $this->id_usuario; // ← Devuelve el ID numérico, no el correo
    }

    /**
     * Obtener el nombre de la columna del identificador único
     */
    public function getAuthIdentifierName()
    {
        return 'id_usuario'; // ← Esto es para las consultas
    }

    /**
     * Obtener la columna usada para buscar el usuario (login)
     */
    public function username()
    {
        return 'correo_usuario'; // Para el login
    }

    // Para que Laravel use 'clave_usuario' en vez de 'password'
    public function getAuthPassword()
    {
        return $this->clave_usuario;
    }

    // Mutador para contraseñas
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

    // Cascade con SoftDeletes
    protected static function booted()
    {
        static::deleting(function ($usuario) {
            if ($usuario->isForceDeleting()) {
                $usuario->proyeccionesFinancieras()->forceDelete();
                $usuario->transacciones()->forceDelete();
                $usuario->saldosDisponibles()->forceDelete();
            } else {
                $usuario->proyeccionesFinancieras()->delete();
                $usuario->transacciones()->delete();
            }
        });
    }

    // 🔹 Relación con Proyecciones Financieras
    public function proyeccionesFinancieras()
    {
        return $this->hasMany(ProyeccionFinanciera::class, 'usuario_id', 'id_usuario');
    }

    /**
     * Relación con Transacciones
     */
    public function transacciones()
    {
        return $this->hasMany(Transaccion::class, 'usuario_id', 'id_usuario');
    }

    /**
     * Relación con Saldos Disponibles
     */
    public function saldosDisponibles()
    {
        return $this->hasMany(SaldoDisponible::class, 'usuario_id', 'id_usuario');
    }

    /**
     * Obtener saldo del mes actual
     */
    public function saldoActual()
    {
        return SaldoDisponible::obtenerSaldo($this->id_usuario);
    }
}
