<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: ../src/views/dashboard.php");
} else {
    header("Location: ../src/views/login.php");
}
exit;
