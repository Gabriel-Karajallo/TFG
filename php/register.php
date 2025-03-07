<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

//Conexion a la base de datos
include '../php/db_connect.php';
if (!$conn) {
    die("Error de conexión: " . mysqli_connect_error());
} else {
    echo "Conexión exitosa";
}

// Verificar que la solicitud sea POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = trim($_POST['nombre']);
    $apellidos = trim($_POST['apellidos']);
    $dni = trim($_POST['dni']);
    $telefono = trim($_POST['telefono']);
    $direccion = trim($_POST['direccion']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $hashed_password = password_hash($password, PASSWORD_DEFAULT); // Encriptamos la contraseña

    try {
        // Validar si el email ya existe
        $sql_check = "SELECT ID_USUARIO FROM USUARIO WHERE EMAIL = :email";
        $stmt = $conn->prepare($sql_check);
        $stmt->bindParam(":email", $email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            echo "Error: El correo ya está registrado.";
        } else {
            // Insertar usuario en la base de datos
            $sql_insert = "INSERT INTO USUARIO (NOMBRE, APELLIDOS, DNI, TELEFONO, DIRECCION, EMAIL, PASSWORD) 
                           VALUES (:nombre, :apellidos, :dni, :telefono, :direccion, :email, :password)";
            $stmt = $conn->prepare($sql_insert);
            $stmt->bindParam(":nombre", $nombre);
            $stmt->bindParam(":apellidos", $apellidos);
            $stmt->bindParam(":dni", $dni);
            $stmt->bindParam(":telefono", $telefono);
            $stmt->bindParam(":direccion", $direccion);
            $stmt->bindParam(":email", $email);
            $stmt->bindParam(":password", $hashed_password);

            if ($stmt->execute()) {
                echo "Registro exitoso. Ahora puedes iniciar sesión.";
            } else {
                echo "Error al registrar usuario.";
            }
        }
    } catch (PDOException $e) {
        echo "Error en la base de datos: " . $e->getMessage();
    }
}
?>

<?php include('../html/register.html'); ?>