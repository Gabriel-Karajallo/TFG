<?php
session_start();
include '../php/db_connect.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["error" => "Usuario no autenticado"]);
    exit();
}

$user_id = $_SESSION['user_id'];

// Verificar si el usuario tiene una bicicleta en uso
$sql = "SELECT ID_BICI FROM BICICLETA WHERE ID_USUARIO = ? AND ESTADO = 'EN USO'";
$stmt = $conn->prepare($sql);
$stmt->execute([$user_id]);
$bici = $stmt->fetch(PDO::FETCH_ASSOC);

if ($bici) {
    $bici_id = $bici['ID_BICI'];

    // Liberar la bicicleta
    $update_sql = "UPDATE BICICLETA SET ESTADO = 'DISPONIBLE', ID_USUARIO = NULL WHERE ID_BICI = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->execute([$bici_id]);

    // Eliminar la referencia en el usuario
    $update_user_sql = "UPDATE USUARIO SET ID_BICI = NULL WHERE ID_USUARIO = ?";
    $stmt = $conn->prepare($update_user_sql);
    $stmt->execute([$user_id]);

    echo json_encode(["success" => true]);
} else {
    echo json_encode(["error" => "No tienes una bicicleta reservada."]);
}
?>