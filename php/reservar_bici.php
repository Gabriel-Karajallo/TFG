<?php
session_start();
include '../php/db_connect.php';

// Ajustar la zona horaria a España
date_default_timezone_set('Europe/Madrid');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["error" => "Usuario no autenticado"]);
    exit();
}

$user_id = $_SESSION['user_id'];

// Buscar una bicicleta disponible con el menor ID posible
$sql = "SELECT ID_BICI FROM BICICLETA WHERE ESTADO = 'DISPONIBLE' ORDER BY ID_BICI ASC LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->execute();
$bici = $stmt->fetch(PDO::FETCH_ASSOC);

if ($bici) {
    $bici_id = $bici['ID_BICI'];
    error_log("Bici seleccionada: " . $bici_id);
    
    // Verificar si el usuario ya tiene una bicicleta en uso
    $check_sql = "SELECT ID_BICI FROM BICICLETA WHERE ID_USUARIO = ? AND ESTADO = 'EN USO'";
    $stmt = $conn->prepare($check_sql);
    $stmt->execute([$user_id]);
    $bici_actual = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($bici_actual) {
        echo json_encode(["error" => "Ya tienes una bicicleta en uso (ID: " . $bici_actual['ID_BICI'] . ")"]);
        exit();
    }

    // Obtener la fecha y la hora actual con la zona horaria correcta
    $fecha_actual = date("Y-m-d");
    $hora_reserva = date("H:i:s");

    // Marcar la bicicleta como "EN USO" y asignarla al usuario
    $update_sql = "UPDATE BICICLETA SET ESTADO = 'EN USO', ID_USUARIO = ? WHERE ID_BICI = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->execute([$user_id, $bici_id]);

    if ($stmt->rowCount() > 0) {
        // También actualizar la tabla USUARIO para guardar el ID_BICI en el usuario
        $update_user_sql = "UPDATE USUARIO SET ID_BICI = ? WHERE ID_USUARIO = ?";
        $stmt = $conn->prepare($update_user_sql);
        $stmt->execute([$bici_id, $user_id]);

        // Registrar en la tabla ALQUILER con la fecha y hora de la reserva
        $insert_sql = "INSERT INTO ALQUILER (ID_USUARIO, ID_BICI, FECHA, HORA_RESERVA) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($insert_sql);
        $stmt->execute([$user_id, $bici_id, $fecha_actual, $hora_reserva]);

        echo json_encode(["success" => true, "bici_id" => $bici_id, "hora_reserva" => $hora_reserva]);
    } else {
        echo json_encode(["error" => "No se pudo actualizar la bicicleta"]);
    }
} else {
    echo json_encode(["error" => "No hay bicicletas disponibles en este momento."]);
}
?>
