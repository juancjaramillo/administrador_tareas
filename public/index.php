<?php
session_start();
// Redirige según si hay sesion
if (isset($_SESSION['user_id'])) {
    header('Location: ../src/views/dashboard.php');
} else {
    header('Location: ../src/views/login.php');
}
exit;
