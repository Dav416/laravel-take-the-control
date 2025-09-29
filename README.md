# Take The Control - Gestor de Finanzas Personales  

Este proyecto es un **prototipo** desarrollado en **Laravel** para la gestión y autenticación de usuarios.  

Contiene:  
- CRUD de usuarios.  
- Inicio de sesión y autenticación.  
- APIS accesibles mediante **Postman** o **Insomnia**.  
- Pruebas unitarias con **PHPUnit**.  

---

## Requisitos previos  

1. **PHP 8.2 o superior**  

2. **Composer**  
   - Gestor de dependencias de PHP: [https://getcomposer.org/download/](https://getcomposer.org/download/).  

3. **MariaDB/MySQL**  
   - Por convención usar el nombre `take_the_control` para la base de datos.  

4. **Git** (para clonar el repositorio).  

6. **Postman o Insomnia** para probar las APIs.  

---

## Instalación del proyecto  

1. **Clonar el repositorio**  
```bash
    git clone https://github.com/Dav416/laravel-take-the-control.git
    cd laravel-take-the-control
```
2. **Instalar dependencias**
```bash
    composer install
```
3. **Configurar el archivo de entorno**
   - Copiar el archivo de ejemplo `env.example`, ya se manual o ejecutando el siguiente comando en la terminal.
```bash
    cp .env.example .env
```
- Luego editar .env con la configuración de la base de datos:

    ```bash
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=take_the_control
    DB_USERNAME=root
    DB_PASSWORD=
    ```
4. **Generar la key de la aplicación**
```bash
    php artisan key:generate
```
5. **Crear la base de datos**
```sql
    CREATE DATABASE take_the_control;
```
6. **Ejecutar migraciones y seeders**
```bash
    php artisan migrate:fresh --seed
```
6. **Levantar servidor de desarrollo**
```bash
    php artisan serve
```
7. **Acceder a la ruta:** http://127.0.0.1:8000

8. **Iniciar sesión**
## Notas 
- La base de datos viene alimentada con 2 usuarios fijos y 10 usuarios creados aleatoriamente.
- La contraseña para los 12 usuarios existentes es por defecto `password123`.

## Credenciales disponibles
### Usuario Test
- Usuario:
`test@example.com`
- Contraseña:
`password123`
### Usuario Prueba
- Usuario:
`user_test@example.com`
- Contraseña:
`password123`

## Endpoints principales
**Usuarios**
- GET /api/usuarios → Listar usuarios.
- POST /api/usuarios → Crear usuario.
- GET /api/usuarios/{id} → Ver detalle de usuario.
- PUT /api/usuarios/{id} → Actualizar usuario.
- DELETE /api/usuarios/{id} → Eliminar usuario.
**Autenticación**
- POST /login → Iniciar sesión.
- POST /logout → Cerrar sesión.

## Pruebas unitarias con PHPUnit
Para ejecutar las pruebas unitarias, ejecutar el siguiente comando en la terminal:
```bash
    php artisan test
```
## Pruebas de API con Postman o Insomnia
Puedes importar el archivo `users.collection.json` en Postman o Insomnia para probar todos los endpoints.
# Notas
- Las APIS de `login` y `logout` funcionan exclusivamente desde la vista, debido a que exigen el protocolo CSRF. Por ello al utilizar Postman o Insomnia es normal encontrarse un `status code 419` indicando que falta el token CSRF.
