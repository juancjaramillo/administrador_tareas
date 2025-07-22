<?php
require '../../config/db.php';
require '../../src/helpers/csrf.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verifyCsrfToken($_POST['csrf_token'])) {
        $_SESSION['error'] = 'Token CSRF inválido.';
        header('Location: ../views/dashboard.php');
        exit;
    }

    if (!isset($_SESSION['user_id'])) {
        header('Location: ../views/login.php');
        exit;
    }

    $id = $_POST['id'];
    $user_id = $_SESSION['user_id'];
    $title = htmlspecialchars(trim($_POST['title']));
    $description = htmlspecialchars(trim($_POST['description']));
    $due_date = $_POST['due_date'];
    $priority = $_POST['priority'];
    $completed = isset($_POST['completed']) ? (int) $_POST['completed'] : 0;

    // Obtener tarea existente
    $stmt = $pdo->prepare("SELECT * FROM tasks WHERE id = ? AND user_id = ?");
    $stmt->execute([$id, $user_id]);
    $task = $stmt->fetch();

    if (!$task) {
        $_SESSION['error'] = 'Tarea no encontrada o sin permisos.';
        header('Location: ../views/dashboard.php');
        exit;
    }

    $fileName = $task['attachment'];
    if (!empty($_FILES['attachment']['name'])) {
        $uploadDir = '../../public/uploads/';
        $originalName = basename($_FILES['attachment']['name']);
        $fileName = time() . '_' . preg_replace("/[^a-zA-Z0-9\._-]/", "", $originalName);
        $targetPath = $uploadDir . $fileName;
        $fileType = mime_content_type($_FILES['attachment']['tmp_name']);

        if (!in_array($fileType, ['application/pdf', 'image/jpeg', 'image/png'])) {
            $_SESSION['error'] = 'Tipo de archivo inválido.';
            header('Location: ../views/edit_task.php?id=' . $id);
            exit;
        }

        move_uploaded_file($_FILES['attachment']['tmp_name'], $targetPath);
    }

    $update = $pdo->prepare("UPDATE tasks SET title = ?, description = ?, due_date = ?, priority = ?, completed = ?, attachment = ? WHERE id = ? AND user_id = ?");
    $update->execute([$title, $description, $due_date, $priority, $completed, $fileName, $id, $user_id]);

    $_SESSION['success'] = 'Tarea actualizada correctamente.';
    header('Location: ../views/dashboard.php');
}
