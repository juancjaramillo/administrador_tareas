<?php
session_start();
require '../../config/db.php';

if (!isset($_SESSION['user_id']) || !isset($_GET['id'])) {
    header('Location: login.php');
    exit;
}

$taskId = $_GET['id'];
$userId = $_SESSION['user_id'];

// Verificar existencia
$stmt = $pdo->prepare("SELECT attachment FROM tasks WHERE id = ? AND user_id = ?");
$stmt->execute([$taskId, $userId]);
$task = $stmt->fetch();

if ($task) {
    // Eliminar archivo si existe
    if ($task['attachment'] && file_exists("../../public/uploads/" . $task['attachment'])) {
        unlink("../../public/uploads/" . $task['attachment']);
    }

    $delete = $pdo->prepare("DELETE FROM tasks WHERE id = ? AND user_id = ?");
    $delete->execute([$taskId, $userId]);
}

header('Location: dashboard.php');
