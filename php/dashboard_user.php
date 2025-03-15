<?php
include '../php/db_connect.php';
// dashboard_user.php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'user') {
    header("Location: login.php");
    exit();
}

$user_name = $_SESSION['user_name']; // Obtener el nombre del usuario

$user_id = $_SESSION['user_id'];

// Obtener la bici actual del usuario
$sql = "SELECT ID_BICI FROM BICICLETA WHERE ID_USUARIO = ? AND ESTADO = 'EN USO'";
$stmt = $conn->prepare($sql);
$stmt->execute([$user_id]);
$bici = $stmt->fetch(PDO::FETCH_ASSOC);

$bici_id = $bici ? $bici['ID_BICI'] : null;


?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - BusBici</title>
    <link rel="stylesheet" href="../css/dashboard_user.css">
</head>

<body>
    <header>
        <button id="menu-toggle">☰ Menú</button>
    </header>

    <aside id="sidebar">
        <button id="close-sidebar">✖</button>
        <nav>
            <ul>
                <li><a href="#incidencias">Reportar Incidencia</a></li>
                <li><a href="tel:+123456789">Llamar Servicio Técnico</a></li>
                <li><a href="#configuracion">Configuración Usuario</a></li>
                <li><a href="../php/logout.php"
                        onclick="return confirm('¿Estás seguro de que deseas cerrar sesión?')">Cerrar Sesión</a></li>
            </ul>
        </nav>
    </aside>

    <main>
        <section class="reserva">
            <h1>¡Hola, <?php echo htmlspecialchars($user_name); ?>!</h1>
            <div id="aviso-importante" style="text-align: center; display: block;">
                <p>
                    <span style="color: #84b775; font-weight: bold;">¡AVISO IMPORTANTE!</span>
                    Recuerda que antes de reservar una bici, debes haber utilizado previamente la tarjeta del
                    consorcio de transporte en el autobús. Lo comprobaremos cuando vayas a recoger tu bici.
                </p>
                <img id="imagen-tarjeta" src="../img/tarjeta.png" alt="Tarjeta del Consorcio"
                    style="max-width: 100%; height: auto; margin-top: 10px;">
            </div>

            <h2>Reserva tu Bicicleta</h2>

            <div>
                <p id="loading-text" style="display: none;"></p>
            </div>
            <div class="boton_reserva">
                <button id="reservar-btn"
                    style="display: <?php echo $bici_id ? 'none' : 'block'; ?>; margin: 0 auto;">Reservar
                    Bici
                </button>
            </div>


            <div id="reserva-info" style="display: <?php echo $bici_id ? 'block' : 'none'; ?>;">
                <p>Has reservado la bicicleta con ID: <span id="bici-id"><?php echo $bici_id ?: ''; ?></span></p>
                <button id="cancelar-btn">Cancelar Reserva</button>
                <div id="contador-reserva" style="display: none;">
                    <p>Tiempo restante para recoger la bici: <span id="tiempo-restante">15:00</span></p>
                </div>
            </div>

        </section>
    </main>
    <img id="imagen-inferior" src="../img/sevilla1.jpg" alt="Imagen inferior">

    <script src="../js/dashboard_user.js?v=<?php echo time(); ?>"></script>
</body>

</html>