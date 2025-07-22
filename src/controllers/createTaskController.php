<?php
// Crea una nueva tarea para el usuario logueado

require '../../config/db.php';
require '../helpers/csrf.php';
session_start();

// CSRF
if (!verifyCsrfToken($_POST['csrf_token'] ?? null)) {
    $_SESSION['error'] = 'Token CSRF inválido.';
    header('Location: ../views/create_task.php');
    exit;
}

// Sesión activa
if (!isset($_SESSION['user_id'])) {
    header('Location: ../views/login.php');
    exit;
}

// Sanitizar y validar campos
$title       = htmlspecialchars(trim($_POST['title']), ENT_QUOTES);
$description = htmlspecialchars(trim($_POST['description']), ENT_QUOTES);
$due_date    = $_POST['due_date'];
$priority    = $_POST['priority'];
$user_id     = $_SESSION['user_id'];
$fileName    = null;

// Adjuntar archivo (opcional)
if (!empty($_FILES['attachment']['name'])) {
    $uploadDir    = '../../public/uploads/';
    $origName     = basename($_FILES['attachment']['name']);
    $fileName     = time() . '_' . preg_replace("/[^a-zA-Z0-9\._-]/", "", $origName);
    $targetPath   = $uploadDir . $fileName;
    $fileType     = mime_content_type($_FILES['attachment']['tmp_name']);
    $allowedTypes = ['application/pdf','image/jpeg','image/png'];

    if (!in_array($fileType, $allowedTypes, true)) {
        $_SESSION['error'] = 'Sólo se admiten PDF, JPG o PNG.';
        header('Location: ../views/create_task.php');
        exit;
    }
    if (!move_uploaded_file($_FILES['attachment']['tmp_name'], $targetPath)) {
        $_SESSION['error'] = 'Fallo al subir el archivo.';
        header('Location: ../views/create_task.php');
        exit;
    }
}

// Insertar en BD
try {
    $stmt = $pdo->prepare("
        INSERT INTO tasks (user_id,title,description,due_date,priority,attachment)
        VALUES (?, ?, ?, ?, ?, ?)
    ");
    $stmt->execute([$user_id,$title,$description,$due_date,$priority,$fileName]);
    $_SESSION['success'] = 'Tarea creada con éxito.';
} catch (PDOException $e) {
    $_SESSION['error'] = 'Error al guardar tarea: ' . $e->getMessage();
}

header('Location: ../views/create_task.php');
exit;
