<?php
// dashboard_admin.php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    // Si no está autenticado como administrador, lo redirigimos al login
    header("Location: login.php");
    exit();
}

// Aquí va el contenido del dashboard del administrador
echo "Bienvenido Administrador, " . $_SESSION['admin_name'];

?>