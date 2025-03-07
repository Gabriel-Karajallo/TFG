<?php
// dashboard_user.php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'user') {
    // Si no está autenticado como usuario, lo rediriges al login
    header("Location: login.php");
    exit();
}

// Aquí va el contenido del dashboard del usuario
echo "Bienvenido, " . $_SESSION['user_name'];

?>