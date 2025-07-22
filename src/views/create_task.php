<?php
session_start();
require '../helpers/auth.php';
ensureLoggedIn();

require '../helpers/csrf.php';
$csrf_token = generateCsrfToken();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Crear Tarea</title>
   <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
   <script src="../../public/js/prevent-back.js"></script>
</head>
<body class="container mt-5">
  <?php include 'components/navbar.php'; ?>
  <?php include 'components/alerts.php'; ?>

  <h2>Crear Nueva Tarea</h2>
  <form action="../controllers/createTaskController.php" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token) ?>">

    <div class="mb-3">
      <label class="form-label">Título</label>
      <input type="text" name="title" class="form-control" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Descripción</label>
      <textarea name="description" class="form-control" rows="3"></textarea>
    </div>
    <div class="mb-3">
      <label class="form-label">Fecha de vencimiento</label>
      <input type="date" name="due_date" class="form-control" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Prioridad</label>
      <select name="priority" class="form-select">
        <option value="alta">Alta</option>
        <option value="media" selected>Media</option>
        <option value="baja">Baja</option>
      </select>
    </div>
    <div class="mb-3">
      <label class="form-label">Archivo adjunto</label>
      <input type="file" name="attachment" class="form-control" accept=".pdf,image/*">
      <div class="form-text">Opcional, max 2MB.</div>
    </div>
    <button type="submit" class="btn btn-primary">Guardar</button>
    <a href="dashboard.php" class="btn btn-secondary">Cancelar</a>
  </form>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
