<?php
include 'php/db_connect.php';
?>

<?php
// Incluye el archivo de conexión con la base de datos si lo necesitas
// include('includes/db_connect.php');
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión - BusBici</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="row">
            <!-- Columna de login -->
            <div class="col-12 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h3 class="text-center mb-4">Iniciar sesión</h3>
                        <form action="php/login_process.php" method="POST">
                            <!-- Campo para el correo -->
                            <div class="mb-3">
                                <label for="email" class="form-label">Correo electrónico</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <!-- Campo para la contraseña -->
                            <div class="mb-3">
                                <label for="password" class="form-label">Contraseña</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <!-- Botón de inicio de sesión -->
                            <button type="submit" class="btn btn-primary w-100">Iniciar sesión</button>
                        </form>

                        <!-- Enlace para registro -->
                        <div class="text-center mt-3">
                            <p>¿No tienes cuenta? <a href="register.php">Regístrate</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts necesarios para Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
