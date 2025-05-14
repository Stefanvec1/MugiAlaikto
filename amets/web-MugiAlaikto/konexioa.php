<?php
$servidor = "localhost"; 
$usuario = "root"; 
$contrasena = "mysql";  
$base_datos = "alaiktomugi"; 

$conn = new mysqli($servidor, $usuario, $contrasena, $base_datos);  

if ($conn->connect_error) {
    die("Errorea datu-basearekin konektatzean: " . $conn->connect_error);
}
?>

