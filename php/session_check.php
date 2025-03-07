<?php
session_start();
include 'db_connect.php'; 

// Si no hay sesión activa, redirige al login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../php/login.php");
    exit();
}

// Comprueba si el usuario es un CLIENTE o un ADMINISTRADOR
$user_id = $_SESSION['user_id'];

// Verifica si el usuario está en la tabla USUARIO
$sql_user = "SELECT ID_USUARIO FROM USUARIO WHERE ID_USUARIO = ?";
$stmt = $conn->prepare($sql_user);
$stmt->execute([$user_id]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

if ($usuario) {
    header("Location: ../php/dashboard_user.php");
    exit();
}

// Verifica si el usuario está en la tabla ADMINISTRATIVO
$sql_admin = "SELECT ID_ADMIN FROM ADMINISTRATIVO WHERE ID_ADMIN = ?";
$stmt = $conn->prepare($sql_admin);
$stmt->execute([$user_id]);
$admin = $stmt->fetch(PDO::FETCH_ASSOC);

if ($admin) {
    header("Location: ../php/dashboard_admin.php");
    exit();
}

// Si no está en ninguna tabla, cerrar sesión y redirigir al login
session_destroy();
header("Location: ../php/login.php");
exit();
?>
