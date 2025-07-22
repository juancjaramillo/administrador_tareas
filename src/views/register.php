<?php include '../../config/db.php'; ?>
<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Registro</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-5">
    <h2>Registro de Usuario</h2>
    <form action="../../src/controllers/registerController.php" method="POST">
        <div class="mb-3">
            <label>Nombre de usuario</label>
            <input type="text" name="username" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Correo electrónico</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Contraseña</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Registrarse</button>
        <a href="login.php" class="btn btn-link">Ya tengo cuenta</a>
    </form>
</body>
</html>
