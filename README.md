# Administrador de Tareas

Desarrollar un sistema avanzado de gestión de tareas que permitan a los usuarios realizar las siguientes acciones:

1. Registro e inicio de sección de usuarios: los usuarios deben poder registrarse e iniciar sección en el sistema para gestionar sus propias tareas.

2. Gestión de tareas por usuarios: cada usuario debe tener solo acceso a sus propias tareas. Cuando un usuario inicie sección, debe poder ver, agregar, editar y eliminar las tareas que ha creado.

3. Funcionalidades avanzadas de las tareas: 
-permitir la asignación de propiedades a las tareas (alta, media, baja).
-permitir adjuntar archivos a las tareas.
-permitir la clasificación y filtrado de tareas por prioridad, fecha de vencimiento, etc.

4.interfaz de usuarios amigable: diseñar una interfaz de usuario intuitiva y amigable que permita a los usuarios gestionar fácilmente sus tareas 


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
2. Crear en base de datos Mysql una BD llamada `administrador_tareas`
3. Importar el script SQL con las tablas `users` y `tasks`
4. Configurar `config/db.php` con sus credenciales
5. Iniciar XAMPP y abrir:  
   👉 `http://localhost/administrador_tareas/public/index.php`
