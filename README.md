# Take The Control - Gestor de Finanzas Personales  

Este proyecto es un **prototipo** desarrollado en **Laravel** para la gestión de usuarios y autenticación a través de login dentro de la aplicación **Take The Control**, orientada al manejo de finanzas personales.  

Incluye:  
- CRUD de usuarios.  
- Inicio de sesión y autenticación.  
- API accesible mediante **Postman** o **Insomnia**.  
- Pruebas unitarias con **PHPUnit**.  

---

## Requisitos previos  

Antes de clonar o ejecutar el proyecto, asegúrate de tener instalado en tu sistema:  

1. **PHP 8.2 o superior**  

2. **Composer**  
   - Gestor de dependencias de PHP: [https://getcomposer.org/download/](https://getcomposer.org/download/).  

3. **MariaDB/MySQL**  
   - El proyecto utiliza la base de datos `take_the_control`.  

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
   - Copiar el archivo de ejemplo
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
Acceder a la ruta: http://127.0.0.1:8000

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
Puedes importar el archivo users.collection.json en Postman o Insomnia para probar todos los endpoints.

## Notas
- Este prototipo está orientado al CRUD del módulo de usuarios y al login. Haciendo uso de APIS.
