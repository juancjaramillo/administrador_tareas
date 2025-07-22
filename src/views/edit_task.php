<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

require '../../config/db.php';

$taskId = $_GET['id'] ?? null;
$userId = $_SESSION['user_id'];

$stmt = $pdo->prepare("SELECT * FROM tasks WHERE id = ? AND user_id = ?");
$stmt->execute([$taskId, $userId]);
$task = $stmt->fetch();

if (!$task) {
    die('Tarea no encontrada o sin permisos.');
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Editar Tarea</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-5">
    <h2>Editar Tarea</h2>
    <form action="../controllers/updateTaskController.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $task['id'] ?>">
        <div class="mb-3">
            <label>Título</label>
            <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($task['title']) ?>" required>
        </div>
        <div class="mb-3">
            <label>Descripción</label>
            <textarea name="description" class="form-control" rows="3"><?= htmlspecialchars($task['description']) ?></textarea>
        </div>
        <div class="mb-3">
            <label>Fecha de vencimiento</label>
            <input type="date" name="due_date" class="form-control" value="<?= $task['due_date'] ?>" required>
        </div>
        <div class="mb-3">
            <label>Prioridad</label>
            <select name="priority" class="form-control">
                <option value="alta" <?= $task['priority'] === 'alta' ? 'selected' : '' ?>>Alta</option>
                <option value="media" <?= $task['priority'] === 'media' ? 'selected' : '' ?>>Media</option>
                <option value="baja" <?= $task['priority'] === 'baja' ? 'selected' : '' ?>>Baja</option>
            </select>
        </div>
        <div class="mb-3">
            <label>¿Completada?</label>
            <select name="completed" class="form-control">
                <option value="0" <?= !$task['completed'] ? 'selected' : '' ?>>No</option>
                <option value="1" <?= $task['completed'] ? 'selected' : '' ?>>Sí</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Archivo adjunto</label>
            <?php if ($task['attachment']): ?>
                <p><a href="../../public/uploads/<?= $task['attachment'] ?>" target="_blank">Ver archivo actual</a></p>
            <?php endif; ?>
            <input type="file" name="attachment" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Actualizar Tarea</button>
        <a href="dashboard.php" class="btn btn-secondary">Cancelar</a>
    </form>
</body>
</html>
