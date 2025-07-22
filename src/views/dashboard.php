<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

require '../../config/db.php';

$userId = $_SESSION['user_id'];

// Filtros
$priorityFilter = $_GET['priority'] ?? '';
$dateFrom = $_GET['from'] ?? '';
$dateTo = $_GET['to'] ?? '';

$sql = "SELECT * FROM tasks WHERE user_id = ?";
$params = [$userId];

if ($priorityFilter) {
    $sql .= " AND priority = ?";
    $params[] = $priorityFilter;
}
if ($dateFrom) {
    $sql .= " AND due_date >= ?";
    $params[] = $dateFrom;
}
if ($dateTo) {
    $sql .= " AND due_date <= ?";
    $params[] = $dateTo;
}

$sql .= " ORDER BY due_date ASC";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$tasks = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Mis Tareas</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-5">
    <h2>Bienvenido, <?= htmlspecialchars($_SESSION['username']) ?></h2>
    <a href="logout.php" class="btn btn-danger mb-3">Cerrar sesión</a>
    <a href="create_task.php" class="btn btn-success mb-3">+ Nueva Tarea</a>

    <!-- Filtros -->
    <form method="GET" class="row mb-4 g-3">
        <div class="col-md-3">
            <label for="priority" class="form-label">Prioridad</label>
            <select name="priority" class="form-select" id="priority">
                <option value="">Todas</option>
                <option value="alta" <?= $priorityFilter == 'alta' ? 'selected' : '' ?>>Alta</option>
                <option value="media" <?= $priorityFilter == 'media' ? 'selected' : '' ?>>Media</option>
                <option value="baja" <?= $priorityFilter == 'baja' ? 'selected' : '' ?>>Baja</option>
            </select>
        </div>
        <div class="col-md-3">
            <label for="from" class="form-label">Desde</label>
            <input type="date" name="from" id="from" value="<?= $dateFrom ?>" class="form-control">
        </div>
        <div class="col-md-3">
            <label for="to" class="form-label">Hasta</label>
            <input type="date" name="to" id="to" value="<?= $dateTo ?>" class="form-control">
        </div>
        <div class="col-md-3 d-flex align-items-end">
            <button type="submit" class="btn btn-primary w-100">Filtrar</button>
        </div>
    </form>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Título</th>
                <th>Descripción</th>
                <th>Vencimiento</th>
                <th>Prioridad</th>
                <th>Completada</th>
                <th>Adjunto</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($tasks) === 0): ?>
                <tr><td colspan="7" class="text-center">No se encontraron tareas.</td></tr>
            <?php endif; ?>
            <?php foreach ($tasks as $task): ?>
            <tr>
                <td><?= htmlspecialchars($task['title']) ?></td>
                <td><?= htmlspecialchars($task['description']) ?></td>
                <td><?= $task['due_date'] ?></td>
                <td><span class="badge bg-<?= $task['priority'] == 'alta' ? 'danger' : ($task['priority'] == 'media' ? 'warning' : 'success') ?>">
                    <?= $task['priority'] ?>
                </span></td>
                <td><?= $task['completed'] ? '✔️' : '❌' ?></td>
                <td>
                    <?php if ($task['attachment']): ?>
                        <a href="../../public/uploads/<?= urlencode($task['attachment']) ?>" target="_blank">Ver archivo</a>
                    <?php else: ?>
                        Sin archivo
                    <?php endif; ?>
                </td>
                <td>
                    <a href="edit_task.php?id=<?= $task['id'] ?>" class="btn btn-warning btn-sm">Editar</a>
                    <a href="delete_task.php?id=<?= $task['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro que deseas eliminar esta tarea?')">Eliminar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
