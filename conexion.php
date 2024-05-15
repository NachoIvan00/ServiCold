<?php
header("Access-Control-Allow-Origin: *");
// Configuración de la base de datos
$user = 'id22139974_servicold';
$pass = 'Servicold1.';
$server = 'localhost';
$db = 'id22139974_servicold';

// Establece la conexión a la base de datos
$con = mysqli_connect($server, $user, $pass, $db);

// Verifica si la conexión fue exitosa
if (!$con) {
    die('Error de conexión a la base de datos: ' . mysqli_connect_error());
}

// Configura la codificación de caracteres para la conexión
mysqli_set_charset($con, 'utf8');
?>
