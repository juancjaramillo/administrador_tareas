<?php

// Actualiza una tarea existente

require '../../config/db.php';
require '../helpers/csrf.php';
session_start();

// CSRF
if (!verifyCsrfToken($_POST['csrf_token'] ?? null)) {
    $_SESSION['error'] = 'Token CSRF inválido.';
    header('Location: ../views/dashboard.php');
    exit;
}

// Sesión activa
if (!isset($_SESSION['user_id'])) {
    header('Location: ../views/login.php');
    exit;
}

$id          = $_POST['id'];
$user_id     = $_SESSION['user_id'];
$title       = htmlspecialchars(trim($_POST['title']), ENT_QUOTES);
$description = htmlspecialchars(trim($_POST['description']), ENT_QUOTES);
$due_date    = $_POST['due_date'];
$priority    = $_POST['priority'];
$completed   = isset($_POST['completed']) ? (int) $_POST['completed'] : 0;

// Verificar existencia
$stmt = $pdo->prepare("SELECT * FROM tasks WHERE id = ? AND user_id = ?");
$stmt->execute([$id, $user_id]);
$task = $stmt->fetch();

if (!$task) {
    $_SESSION['error'] = 'Tarea no encontrada.';
    header('Location: ../views/dashboard.php');
    exit;
}

// Archivo adjunto nuevo (opcional)
$fileName = $task['attachment'];
if (!empty($_FILES['attachment']['name'])) {
    $uploadDir    = '../../public/uploads/';
    $origName     = basename($_FILES['attachment']['name']);
    $fileName     = time() . '_' . preg_replace("/[^a-zA-Z0-9\._-]/", "", $origName);
    $targetPath   = $uploadDir . $fileName;
    $fileType     = mime_content_type($_FILES['attachment']['tmp_name']);
    $allowedTypes = ['application/pdf', 'image/jpeg', 'image/png'];

    if (!in_array($fileType, $allowedTypes, true)) {
        $_SESSION['error'] = 'Formato inválido.';
        header('Location: ../views/edit_task.php?id=' . urlencode($id));
        exit;
    }
    move_uploaded_file($_FILES['attachment']['tmp_name'], $targetPath);
}

// Actualizar
try {
    $upd = $pdo->prepare("
        UPDATE tasks SET
          title       = ?, 
          description = ?, 
          due_date    = ?, 
          priority    = ?, 
          completed   = ?, 
          attachment  = ?
        WHERE id = ? AND user_id = ?
    ");
    $upd->execute([$title, $description, $due_date, $priority, $completed, $fileName, $id, $user_id]);
    $_SESSION['success'] = 'Tarea modificada correctamente.';
} catch (PDOException $e) {
    $_SESSION['error'] = 'Error al actualizar: ' . $e->getMessage();
}

header('Location: ../views/dashboard.php');
exit;
