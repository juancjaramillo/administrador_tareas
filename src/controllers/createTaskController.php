<?php
require '../../config/db.php';
require '../../src/helpers/csrf.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Verificar token CSRF
    if (!verifyCsrfToken($_POST['csrf_token'])) {
        $_SESSION['error'] = 'Token CSRF inválido.';
        header('Location: ../views/create_task.php');
        exit;
    }

    // Validar sesión
    if (!isset($_SESSION['user_id'])) {
        header('Location: ../views/login.php');
        exit;
    }

    // Capturar y sanitizar datos
    $title = htmlspecialchars(trim($_POST['title']));
    $description = htmlspecialchars(trim($_POST['description']));
    $due_date = $_POST['due_date'];
    $priority = $_POST['priority'];
    $user_id = $_SESSION['user_id'];
    $fileName = null;

    // Validar campos obligatorios
    if (empty($title) || empty($due_date) || empty($priority)) {
        $_SESSION['error'] = 'Por favor complete todos los campos obligatorios.';
        header('Location: ../views/create_task.php');
        exit;
    }

    // Validar archivo adjunto (opcional)
    if (!empty($_FILES['attachment']['name'])) {
        $uploadDir = '../../public/uploads/';
        $originalName = basename($_FILES['attachment']['name']);
        $fileName = time() . '_' . preg_replace("/[^a-zA-Z0-9\._-]/", "", $originalName);
        $targetPath = $uploadDir . $fileName;
        $fileType = mime_content_type($_FILES['attachment']['tmp_name']);

        // Validar tipo MIME
        $allowedTypes = ['application/pdf', 'image/jpeg', 'image/png'];
        if (!in_array($fileType, $allowedTypes)) {
            $_SESSION['error'] = 'Tipo de archivo no permitido (solo PDF, JPG, PNG).';
            header('Location: ../views/create_task.php');
            exit;
        }

        // Mover archivo
        if (!move_uploaded_file($_FILES['attachment']['tmp_name'], $targetPath)) {
            $_SESSION['error'] = 'Error al subir el archivo.';
            header('Location: ../views/create_task.php');
            exit;
        }
    }

    // Insertar en BD
    try {
        $stmt = $pdo->prepare("INSERT INTO tasks (user_id, title, description, due_date, priority, attachment) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$user_id, $title, $description, $due_date, $priority, $fileName]);

        $_SESSION['success'] = 'Tarea creada exitosamente.';
        header('Location: ../views/dashboard.php');
    } catch (PDOException $e) {
        $_SESSION['error'] = 'Error al guardar la tarea: ' . $e->getMessage();
        header('Location: ../views/create_task.php');
    }
}
