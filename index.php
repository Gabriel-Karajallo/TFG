<?php
include 'php/db_connect.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido a BusBici</title>
    <!-- Enlace al archivo de estilos CSS -->
    <link href="css/style.css" rel="stylesheet">
    <!-- Enlace a Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Enlace de Fuentes -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Alata&family=Luckiest+Guy&family=M+PLUS+1:wght@100..900&family=Quicksand:wght@300..700&family=Rethink+Sans:ital,wght@0,400..800;1,400..800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Alata&family=Luckiest+Guy&family=M+PLUS+1:wght@100..900&family=Quicksand:wght@300..700&family=Rethink+Sans:ital,wght@0,400..800;1,400..800&family=Rubik+Mono+One&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Sección de bienvenida -->
    <div class="welcome-section">
        <div class="container">
            <div class="row align-items-center">
                <!-- Columna para el logo -->
                <div class="col-md-6 text-center text-md-center logo-container">
                    <img src="img/logo.png" alt="BusBici" class="logo">
                </div>
                
                <!-- Columna para el contenido -->
                <div class="col-md-6 container">
                    <!-- Frase principal -->
                    <p class="welcome-text alata-regular"><strong>Movilidad sostenible, <br> el futuro es ahora</strong></p>

                    <!-- Subtítulo -->
                    <h3 class="subtitle">Únete hoy</h3>

                    <!-- Botón de registro con Google -->
                    <div class="google-buttom">
                        <a href="#" class="btn custom-btn registro-google" id="bottoms" style="background-color: #84b775;">
                            <svg class="google" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 488 512">
                                <path fill="#ffffff" d="M488 261.8C488 403.3 391.1 504 248 504 110.8 504 0 393.2 0 256S110.8 8 248 8c66.8 0 123 24.5 166.3 64.9l-67.5 64.9C258.5 52.6 94.3 116.6 94.3 256c0 86.5 69.1 156.6 153.7 156.6 98.2 0 135-70.4 140.8-106.9H248v-85.3h236.1c2.3 12.7 3.9 24.9 3.9 41.4z"/></svg>
                            Registrarse con Google</a>
                    </div>

                    <!-- Línea divisoria -->
                    <hr class="my-4">

                    <!-- Botón de creación de cuenta -->
                    <div class="create-buttom">
                        <a href="registro.php" class="btn custom-btn " id="bottoms" style="background-color: #84b775; 
                        ">Crear cuenta</a>
                    </div>
                    

                    <!-- Texto de términos y condiciones debajo del botón de creación de cuenta -->
                    <p class="terms-text  mt-2">Al registrarte, aceptas los Términos de servicio y la Política de privacidad, incluida la política de Uso de Cookies.</p>

                    <!-- Enlace para iniciar sesión -->
                    <div class="mt-4">
                        <p>¿Ya tienes una cuenta?</p>
                        <a href="login.php" class="btn custom-btn" id="login-bottom" style="border-color: #84b775;">Iniciar sesión 
                            <svg id="google" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <style>
                              .user-1 {
                                animation: user-1 1s cubic-bezier(0.83, -0.07, 0, 1.04) both infinite alternate-reverse;
                            }
                            @keyframes user-1 {
                              0% {
                                transform: translateY(0) translateX(0);
                              }
                              100% {
                                transform: translateY(-1px) translateX(-2px);
                              }
                            }
                            </style>
                              <circle class="user-1" cx="12" cy="8.245" r="2.5" stroke="#84b775" stroke-width="1.5"/>
                              <ellipse cx="12" cy="15.926" stroke="#3f3f3f" stroke-width="1.5" rx="5" ry="2.329"/>
                            </svg>
                            </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Enlace a los scripts de Bootstrap (JS) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>