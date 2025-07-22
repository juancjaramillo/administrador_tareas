<?php

// Elimina una tarea y su archivo adjunto

require '../../config/db.php';
require '../helpers/auth.php';
ensureLoggedIn();
session_start();

$taskId = $_GET['id'] ?? null;
$userId = $_SESSION['user_id'];

// Borrar archivo si existe
$stmt = $pdo->prepare("SELECT attachment FROM tasks WHERE id = ? AND user_id = ?");
$stmt->execute([$taskId,$userId]);
$row = $stmt->fetch();
if ($row && $row['attachment']) {
    $path = "../../public/uploads/" . $row['attachment'];
    if (file_exists($path)) unlink($path);
}

// Borrar registro
$del = $pdo->prepare("DELETE FROM tasks WHERE id = ? AND user_id = ?");
$del->execute([$taskId,$userId]);

$_SESSION['success'] = $del->rowCount()
    ? 'Tarea eliminada.'
    : 'No se pudo eliminar la tarea.';

header('Location: ../views/dashboard.php');
exit;
