<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
include 'conexion.php';

$response = [];

if ($con) {
    $consulta = "SELECT id, nombre FROM sensores";
    $resultado = mysqli_query($con, $consulta);

    if ($resultado) {
        while ($fila = mysqli_fetch_assoc($resultado)) {
            $response[] = $fila;
        }
    } else {
        http_response_code(500);
        $response = ["error" => "Error al consultar la base de datos"];
    }
} else {
    http_response_code(500);
    $response = ["error" => "Error de conexión a la base de datos"];
}

echo json_encode($response);
?>
