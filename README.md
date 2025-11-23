# Take The Control - Gestor de Finanzas Personales

Este proyecto es un **prototipo** desarrollado en **Laravel** para la gestión de finanzas personales.

Contiene:

-   Inicio de sesión
-   Autenticación de usuarios a través de LaravelSanctum.
-   CRUD de usuarios.
-   CRUD de transacciones.
-   Vistas de usuarios.
-   Vistas de transacciones.
-   Modelo MVC.
-   Migraciones y seeders.
-   APIS accesibles mediante **Postman** o **Insomnia**.
-   Pruebas unitarias con **PHPUnit**.

---

## Requisitos previos

1. **PHP 8.2 o superior**

2. **Composer**

    - Gestor de dependencias de PHP: [https://getcomposer.org/download/](https://getcomposer.org/download/).

3. **Node.js 20.19+ o 22.12+**

    - Descargarlo desde [https://nodejs.org/](https://nodejs.org/).

4. **pnpm** (gestor de paquetes JavaScript)

    - Instalar globalmente: `npm install -g pnpm`

5. **MariaDB/MySQL**

    - Por convención usar el nombre `take_the_control` para la base de datos.

6. **Git** (para clonar el repositorio).

7. **Postman o Insomnia** para probar las APIs.

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
    pnpm install
```

3. **Configurar el archivo de entorno**
    - Copiar el archivo de ejemplo `env.example`, ya se manual o ejecutando el siguiente comando en la terminal.

```bash
    cp .env.example .env
```

-   Luego editar .env con la configuración de la base de datos:

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

7. **Levantar servidor de desarrollo**

Para ejecutar el entorno de desarrollo con hot reload (recarga automática al cambiar archivos), necesitas ejecutar dos comandos en dos terminales diferentes:

**Terminal 1 - Vite (compilador de assets)**

```bash
    pnpm run dev
```

**Terminal 2 - Servidor Laravel**

```bash
    php artisan serve
```

8. **Acceder a la ruta:** http://127.0.0.1:8000

9. **Iniciar sesión**

## Notas

-   El proyecto utiliza **Bootstrap 5.3.0** para los estilos CSS y **Vite** como bundler.
-   La base de datos cuenta con las siguientes entidades:
    -   Usuarios
    -   Categorias Transacciones
    -   Categorias Proyecciones
    -   Entidades Financieras
    -   Proyecciones Financieras
    -   Transacciones
-   Cada entidad tiene sus respectivas migraciones y seeders.
-   La base de datos viene seedeada con 2 usuarios default y 10 usuarios creados aleatoriamente.
-   La contraseña para los 12 usuarios existentes es por defecto `password123`.

## Credenciales disponibles

### Usuario Test

-   Usuario:
    `test@example.com`
-   Contraseña:
    `password123`

### Usuario Prueba

-   Usuario:
    `user_test@example.com`
-   Contraseña:
    `password123`

## Endpoints principales

**Usuarios**

-   GET /api/usuarios → Listar usuarios.
-   POST /api/usuarios → Crear usuario.
-   GET /api/usuarios/{id} → Ver detalle de usuario.
-   PUT /api/usuarios/{id} → Actualizar usuario.
-   DELETE /api/usuarios/{id} → Eliminar usuario.
    **Autenticación**
-   POST /login → Iniciar sesión.
-   POST /logout → Cerrar sesión.

## Compilación para producción

Para compilar los assets de forma estática (sin hot reload), ejecuta:

```bash
    pnpm run build
```

Los archivos compilados se generarán en `public/build/` y se servirán automáticamente con `php artisan serve`.

## Pruebas unitarias con PHPUnit

Para ejecutar las pruebas unitarias, ejecutar el siguiente comando en la terminal:

```bash
    php artisan test
```

## Pruebas de API con Postman o Insomnia

Puedes importar el archivo `users.collection.json` en Postman o Insomnia para probar todos los endpoints.
