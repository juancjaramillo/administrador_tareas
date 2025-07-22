<?php

// Cierra sesión, evita cache y reemplaza historial

session_start();
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Cache-Control: post-check=0, pre-check=0', false);
header('Pragma: no-cache');
header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');

// Destruir sesión
session_unset();
session_destroy();

// Que “Atrás” no muestre dashboard
echo "<script>
        history.replaceState({}, '', '/administrador_tareas/public/index.php');
        window.location.replace('/administrador_tareas/public/index.php');
      </script>";
exit;
