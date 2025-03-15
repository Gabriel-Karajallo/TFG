<?php
// Conexión de la base de datos
$host = "sql103.infinityfree.com"; // Dirección del servidor de base de datos (en Tinkerhost)
$dbname = "if0_38489826_busbici"; // Nombre de la base de datos
$username = "if0_38489826"; // nombre de usuario de la base de datos
$password = "cgKG1997"; // contraseña de la base de datos

// Crear la conexión a la base de datos
try {
    // Establecer la conexión utilizando PDO
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    
    // Establecer el modo de error de PDO a excepciones
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Si la conexión fue exitosa, descomentar la siguiente línea:
     echo "Conexión exitosa a la base de datos!";
} catch (PDOException $e) {
    // Si ocurre un error en la conexión, mostrar un mensaje de error
    echo "Error de conexión: " . $e->getMessage();
}
?>
