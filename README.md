# Administrador de Tareas

Aplicación web en PHP nativo para gestionar tareas por usuario.

## Tecnologías
- PHP 8.1+
- MySQL
- Bootstrap 5
- JavaScript (puro)
- PHPUnit
- GitHub Actions (CI)

## Estructura
- `public/` – punto de entrada (index.php)
- `config/` – `db.php` (conexión PDO)
- `src/views/` – vistas HTML con Bootstrap (incluye `components/navbar.php` y `components/alerts.php`)
- `src/controllers/` – lógica de login, registro, CRUD y logout
- `src/helpers/csrf.php` – seguridad CSRF
- `database.sql` – script SQL en la raíz para crear la base de datos y las tablas

## Instrucciones
1. Clonar el repositorio
2. Crear base de datos `administrador_tareas`
3. Importar el script SQL con las tablas `users` y `tasks`
4. Configurar `config/db.php` con tus credenciales
5. Iniciar XAMPP y abrir:  
   👉 `http://localhost/administrador_tareas/public/index.php`
