<?php
include 'db_connect.php'; // Asegúrate de que la ruta sea correcta

$nombre = "Karly";
$apellido = "Urbani";
$direccion = "Oficina Central";
$dni = "12345678X";
$email = "karly@busbici.com";
$password = "1234";
$hashed_password = password_hash($password, PASSWORD_DEFAULT); // Cifrar la contraseña

$sql = "INSERT INTO ADMINISTRATIVO (NOMBRE, APELLIDO, DIRECCION, DNI, EMAIL, PASSWORD) 
        VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->execute([$nombre, $apellido, $direccion, $dni, $email, $hashed_password]);

echo "Administrador insertado correctamente.";
?>
