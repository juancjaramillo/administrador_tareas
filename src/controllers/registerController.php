<?php
// Registra nuevos usuarios

require '../../config/db.php';
require '../helpers/csrf.php';
session_start();

// Verificar CSRF
if (!verifyCsrfToken($_POST['csrf_token'] ?? null)) {
    $_SESSION['error'] = 'Token CSRF inválido.';
    header('Location: ../views/register.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email    = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    try {
        // Insertar en la tabla users
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->execute([$username, $email, $password]);
        $_SESSION['success'] = 'Registro completo. Puedes iniciar sesión.';
        header('Location: ../views/login.php');
        exit;
    } catch (PDOException $e) {      
        $_SESSION['error'] = 'Error al registrar: ' . $e->getMessage();
        header('Location: ../views/register.php');
        exit;
    }
}
