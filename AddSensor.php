<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
include 'conexion.php';

$response = [];

if ($con) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $usuario_id = $_POST['usuario_id'];
        $sensor_id = $_POST['sensor_id'];

        $consulta = "INSERT INTO permisos_sensores (usuario_id, sensor_id) VALUES ('$usuario_id', '$sensor_id')";
        if (mysqli_query($con, $consulta)) {
            http_response_code(201);
            $response = ["message" => "Sensor agregado correctamente"];
        } else {
            http_response_code(500);
            $response = ["error" => "Error al agregar el sensor"];
        }
    } else {
        http_response_code(405);
        $response = ["error" => "Método no permitido"];
    }
} else {
    http_response_code(500);
    $response = ["error" => "Error de conexión a la base de datos"];
}

echo json_encode($response);
?>
