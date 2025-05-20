<?php
$servidor = "10.23.25.2";  
$usuario = "amets";       
$contrasena = "mysql";        
$base_datos = "alaiktomugi";   

$conn = new mysqli($servidor, $usuario, $contrasena, $base_datos);

// Verificación de conexión
if ($conn->connect_error) {
    die("Errorea datu-basearekin konektatzean: " . $conn->connect_error);
} else {
    echo "Konexioa ondo burutu da!";
}
?>


