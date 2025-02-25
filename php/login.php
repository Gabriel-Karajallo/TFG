<?php
include 'php/db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Buscar el usuario en la base de datos
    $sql = "SELECT ID_USUARIO, PASSWORD FROM USUARIO WHERE EMAIL = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id_usuario, $hashed_password);
        $stmt->fetch();

        // Verificar contraseña
        if (password_verify($password, $hashed_password)) {
            $_SESSION['user_id'] = $id_usuario;
            $_SESSION['email'] = $email;
            header("Location: dashboard.php"); // Redirige al panel de usuario
            exit();
        } else {
            echo "Contraseña incorrecta.";
        }
    } else {
        echo "Usuario no encontrado.";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - BusBici</title>
    <!-- Enlace a Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Enlace a los estilos personalizados -->
    <link href="../css/login.css" rel="stylesheet">
</head>
<body>
    <div class="login-section">
        <div class="container">
            <div class="row align-items-center">
                <!-- Columna del logo -->
                <div class="col-md-6 text-center text-md-start">
                    <img src="../img/logo.png" alt="BusBici Logo" class="logo-login">
                </div>
                <!-- Columna del formulario -->
                <div class="col-md-6">
                    <div class="login-form">
                        <h2 class="text-center">Inicia Sesión</h2>
                        <form action="php/login_action.php" method="POST">
                            <div class="mb-3">
                                <input type="text" class="form-control" id="email" name="email" placeholder="Usuario" required>
                            </div>
                            <div class="mb-3">
                                <input type="password" class="form-control" id="password" name="password" placeholder="Contraseña" required>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary w-100" 
                                style="
                                    background-color: #84b775;
                                    border: none;">
                                    Iniciar Sesión</button>
                            </div>
                        </form>
                        <div class="text-center mt-3">
                            <p><a href="#">¿Olvidaste tu contraseña?</a></p>
                            <hr>
                            <a href="#" class="btn btn-danger w-100" style="
                                    background-color: #84b775;
                                    border: none;">
                                    Inicia sesión con Google</a>
                            <p class="mt-3">¿No tienes cuenta? <a href="register.php">Regístrate aquí</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
