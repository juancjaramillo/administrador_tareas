<?php



require '../helpers/auth.php';
ensureLoggedIn();     

require '../../config/db.php';

$taskId = $_GET['id'] ?? null;
$userId = $_SESSION['user_id'];

if (!$taskId) {
    // Si no se pasa ID, mostramos un error y volvemos
    $_SESSION['error'] = 'No se especificó la tarea a eliminar.';
    header('Location: dashboard.php');
    exit;
}

// 1) Recuperar nombre de archivo adjunto (si existe)
$stmt = $pdo->prepare("SELECT attachment FROM tasks WHERE id = ? AND user_id = ?");
$stmt->execute([$taskId, $userId]);
$task = $stmt->fetch();

if ($task) {
    if (!empty($task['attachment'])) {
        $filePath = __DIR__ . '/../../public/uploads/' . $task['attachment'];
        if (file_exists($filePath)) {
            // Intentar borrar el archivo físico
            unlink($filePath);
        }
    }

    // 2) Borrar registro de la base de datos
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

// 3) Redirigir de vuelta al dashboard
header('Location: dashboard.php');
exit;
