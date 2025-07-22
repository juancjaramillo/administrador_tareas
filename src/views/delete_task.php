<?php
require '../helpers/auth.php';
ensureLoggedIn();     

require '../../config/db.php';

$taskId = $_GET['id'] ?? null;
$userId = $_SESSION['user_id'];

if (!$taskId) {   
    $_SESSION['error'] = 'No se especificó la tarea a eliminar.';
    header('Location: dashboard.php');
    exit;
}

$stmt = $pdo->prepare("SELECT attachment FROM tasks WHERE id = ? AND user_id = ?");
$stmt->execute([$taskId, $userId]);
$task = $stmt->fetch();

if ($task) {
    if (!empty($task['attachment'])) {
        $filePath = __DIR__ . '/../../public/uploads/' . $task['attachment'];
        if (file_exists($filePath)) {   
            unlink($filePath);
        }
    }

   
    $del = $pdo->prepare("DELETE FROM tasks WHERE id = ? AND user_id = ?");
    $del->execute([$taskId, $userId]);

    if ($del->rowCount()) {
        $_SESSION['success'] = 'Tarea eliminada correctamente.';
    } else {
        $_SESSION['error'] = 'No se pudo eliminar la tarea.';
    }
} else {
    $_SESSION['error'] = 'Tarea no encontrada o no tienes permisos.';
}


header('Location: dashboard.php');
exit;
