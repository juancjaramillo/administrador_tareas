<?php
function generateCsrfToken(): string {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Verifica que el token enviado coincida con el de la sesión.
 * Retorna false si el token no existe o no es un string.
 */
function verifyCsrfToken($token): bool {
    if (
        empty($_SESSION['csrf_token']) 
        || !is_string($token)
    ) {
        return false;
    }
    //  comparamos cadenas seguras
    return hash_equals($_SESSION['csrf_token'], $token);
}
