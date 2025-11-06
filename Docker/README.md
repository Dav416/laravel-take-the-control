# Notas para montar el proyecto en Docker
1. Asegurarse de configurar correctamente el archivo de entorno `.env`.
    - Revisar que las variables de entorno de la base de datos coincidan con las del archivo `compose.yml`.
    - La variable de entorno `DB_HOST` debe ser `mysql`, para poder comunicarse con el servicio de base de datos.
    - La variable de entorno `DB_USERNAME` no puede ser `root`.
    - Revisar que la variable de entorno `APP_KEY` no esté vacía en caso de estarlo debe ser generada con el comando `php artisan key:generate`.
2. Subir el contenedor con el comando `docker-compose up -d`.
3. Para usar cualquier comando de Laravel, ejecutar el comando `docker compose run --rm <service> <comando>`.
4. Migrar la base de datos y generar los seeders con el comando `docker compose run --rm php php artisan migrate:fresh --seed`.
5. Otros comandos de Laravel:

```bash
# Generar la APP_KEY
docker compose run --rm php php artisan key:generate

# Migrar la base de datos
docker compose run --rm php php artisan migrate

# Ejecutar seeders
docker compose run --rm php php artisan db:seed

# Limpiar cachés
docker compose run --rm php php artisan optimize:clear

# Instalar dependencias
docker compose run --rm php composer install
```
6. http://localhost:8080
7. Iniciar sesión con el usuario `test@example.com` y la contraseña `password123`.
8. Para bajar el contenedor, ejecutar el comando `docker-compose down`.
