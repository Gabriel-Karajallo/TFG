<?php
session_start();
session_destroy();
header("Location: ../php/login.php"); // Redirigir a la página de inicio
exit();
?>