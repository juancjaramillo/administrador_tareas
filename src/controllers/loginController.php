<?php

// Procesar el login de usuarios
require '../../config/db.php';
require '../helpers/csrf.php';
session_start();

// 1) Verificar CSRF
if (!verifyCsrfToken($_POST['csrf_token'] ?? null)) {
    $_SESSION['error'] = 'Token CSRF inválido.';
    header('Location: ../views/login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email']);
    $password = $_POST['password'];

    // 2) Consultar usuario en BD
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    // 3) Verificar contraseña
    if ($user && password_verify($password, $user['password'])) {
        session_regenerate_id(true);
        $_SESSION['user_id']  = $user['id'];
        $_SESSION['username'] = $user['username'];
        header('Location: ../views/dashboard.php');
        exit;
    }

    $_SESSION['error'] = 'Email o contraseña incorrectos.';
    header('Location: ../views/login.php');
    exit;
}
