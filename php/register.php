<?php
include 'php/db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = trim($_POST['nombre']);
    $apellidos = trim($_POST['apellidos']);
    $dni = trim($_POST['dni']);
    $telefono = trim($_POST['telefono']);
    $direccion = trim($_POST['direccion']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $hashed_password = password_hash($password, PASSWORD_DEFAULT); // Encriptamos la contraseña

    // Validar si el email ya existe
    $sql_check = "SELECT ID_USUARIO FROM USUARIO WHERE EMAIL = ?";
    $stmt = $conn->prepare($sql_check);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "Error: El correo ya está registrado.";
    } else {
        // Insertar usuario en la base de datos
        $sql_insert = "INSERT INTO USUARIO (NOMBRE, APELLIDOS, DNI, TELEFONO, DIRECCION, EMAIL, PASSWORD) 
                       VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql_insert);
        $stmt->bind_param("sssssss", $nombre, $apellidos, $dni, $telefono, $direccion, $email, $hashed_password);

        if ($stmt->execute()) {
            echo "Registro exitoso. Ahora puedes iniciar sesión.";
        } else {
            echo "Error al registrar usuario.";
        }
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
    <title>Registro - BusBici</title>
    <link href="../css/register.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container register-container">
    <div class="row">
        <!-- Columna del logo en escritorio -->
        <div class="col-md-6 logo-container d-none d-md-flex">
            <img src="../img/logo.png" alt="BusBici Logo" class="logo">
        </div>

        <!-- Columna del formulario -->
        <div class="col-md-6 form-container">
            <h2 class="text-center">Crea tu cuenta</h2>
            
            <!-- Botón de registro con Google -->
            <div class="text-center">
                <a href="#" class="btn btn-danger btn-google">Registrarse con Google</a>
            </div>

            <!-- Línea divisoria -->
            <hr class="my-4">

            <!-- Formulario de registro -->
            <form action="register_process.php" method="POST">
                <div class="mb-3">
                    <label for="name" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="mb-3">
                    <label for="name" class="form-label">Apellidos</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Correo electrónico</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="name" class="form-label">Teléfono</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Registrarse</button>
            </form>

            <!-- Texto de términos y condiciones -->
            <p class="terms-text text-center mt-2">
                Al registrarte, aceptas los <a href="#">Términos de servicio</a> y la <a href="#">Política de privacidad</a>.
            </p>

            <!-- Enlace para iniciar sesión -->
            <div class="text-center mt-4">
                <p>¿Ya tienes cuenta?</p>
                <a href="login.php" class="btn btn-secondary">Iniciar sesión</a>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
