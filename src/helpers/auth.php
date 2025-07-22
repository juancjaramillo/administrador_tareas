<?php
// Inicia sesión, envía cabeceras anti‑cache y verifica login

function ensureLoggedIn() {   
    //Solo arrancar sesión si no está activa
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }

    //Cabeceras para evitar que el navegador cachee páginas protegidas
    header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
    header('Cache-Control: post-check=0, pre-check=0', false);
    header('Pragma: no-cache');
    header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');

    // Si no hay usuario en sesión, redirige al login
    if (!isset($_SESSION['user_id'])) {
        header('Location: login.php');
        exit;
    }
}
