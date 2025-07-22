<?php
require '../../config/db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email    = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    try {
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->execute([$username, $email, $password]);
        $_SESSION['success'] = 'Registro exitoso. Ahora puedes iniciar sesión.';
        header('Location: ../views/login.php');
    } catch (PDOException $e) {
        $_SESSION['error'] = 'Error: ' . $e->getMessage();
        header('Location: ../views/register.php');
    }
}
