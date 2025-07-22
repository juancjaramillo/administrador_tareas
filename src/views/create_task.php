<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

require '../helpers/csrf.php';
$csrf_token = generateCsrfToken();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Crear Tarea</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-5">
    <h2>Crear Nueva Tarea</h2>

    <!-- ALERTAS -->
    <?php include 'components/alerts.php'; ?>

    <form action="../controllers/createTaskController.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">

        <div class="mb-3">
            <label>Título</label>
            <input type="text" name="title" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Descripción</label>
            <textarea name="description" class="form-control" rows="3"></textarea>
        </div>
        <div class="mb-3">
            <label>Fecha de vencimiento</label>
            <input type="date" name="due_date" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Prioridad</label>
            <select name="priority" class="form-control">
                <option value="alta">Alta</option>
                <option value="media" selected>Media</option>
                <option value="baja">Baja</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Archivo adjunto</label>
            <input type="file" name="attachment" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Guardar Tarea</button>
        <a href="dashboard.php" class="btn btn-secondary">Volver</a>
    </form>
</body>
</html>
