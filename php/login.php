<?php
session_start();
include '../php/db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Primero, intentamos buscar el usuario en la tabla USUARIO
    $sql_user = "SELECT ID_USUARIO, NOMBRE, PASSWORD FROM USUARIO WHERE EMAIL = ?";
    $stmt = $conn->prepare($sql_user);
    $stmt->execute([$email]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    // Si no es un usuario, buscamos en la tabla ADMINISTRATIVO
    if (!$usuario) {
        $sql_admin = "SELECT ID_ADMIN, NOMBRE, PASSWORD FROM ADMINISTRATIVO WHERE EMAIL = ?";
        $stmt = $conn->prepare($sql_admin);
        $stmt->execute([$email]);
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Verificamos la contraseña
    if ($usuario && password_verify($password, $usuario['PASSWORD'])) {
        // Usuario cliente
        $_SESSION['user_id'] = $usuario['ID_USUARIO'];
        $_SESSION['user_name'] = $usuario['NOMBRE'];
        $_SESSION['role'] = 'user';  // Role = 'user' para usuario normal
        header("Location: dashboard_user.php");
        exit();
    } elseif ($admin && password_verify($password, $admin['PASSWORD'])) {
        // Usuario administrativo
        $_SESSION['admin_id'] = $admin['ID_ADMIN'];
        $_SESSION['admin_name'] = $admin['NOMBRE'];
        $_SESSION['role'] = 'admin';  // Role = 'admin' para administrativo
        header("Location: dashboard_admin.php");
        exit();
    } else {
        // Si no se encuentra el usuario o la contraseña no es válida
        $error = "Correo o contraseña incorrectos.";
    }
}
?>
<?php include('../html/login.html'); ?>