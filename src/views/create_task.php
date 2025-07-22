<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// CSRF
require '../helpers/csrf.php';
$csrf_token = generateCsrfToken();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Crear Tarea</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">

  <!-- Menú principal -->
  <?php include 'components/navbar.php'; ?>

  <!-- Alertas -->
  <?php include 'components/alerts.php'; ?>

  <h2>Crear Nueva Tarea</h2>
  <form action="../controllers/createTaskController.php" method="POST" enctype="multipart/form-data">
    <!-- CSRF token -->
    <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">

    <div class="mb-3">
      <label for="title" class="form-label">Título</label>
      <input type="text" id="title" name="title" class="form-control" required>
    </div>

    <div class="mb-3">
      <label for="description" class="form-label">Descripción</label>
      <textarea id="description" name="description" class="form-control" rows="3"></textarea>
    </div>

    <div class="mb-3">
      <label for="due_date" class="form-label">Fecha de vencimiento</label>
      <input type="date" id="due_date" name="due_date" class="form-control" required>
    </div>

    <div class="mb-3">
      <label for="priority" class="form-label">Prioridad</label>
      <select id="priority" name="priority" class="form-select" required>
        <option value="alta">Alta</option>
        <option value="media" selected>Media</option>
        <option value="baja">Baja</option>
      </select>
    </div>

    <div class="mb-3">
      <label for="attachment" class="form-label">Archivo adjunto</label>
      <input type="file" id="attachment" name="attachment" class="form-control">
    </div>

    <button type="submit" class="btn btn-primary">Guardar Tarea</button>
    <a href="dashboard.php" class="btn btn-secondary">Volver</a>
  </form>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
