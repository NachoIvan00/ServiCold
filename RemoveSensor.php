<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
include 'conexion.php';

$response = [];

if ($con) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $usuario_id = $_POST['usuario_id'];
        $sensor_id = $_POST['sensor_id'];

        $consulta = "DELETE FROM permisos_sensores WHERE usuario_id = '$usuario_id' AND sensor_id = '$sensor_id' LIMIT 1";
        if (mysqli_query($con, $consulta)) {
            http_response_code(200);
            $response = ["message" => "Sensor eliminado correctamente"];
        } else {
            http_response_code(500);
            $response = ["error" => "Error al eliminar el sensor"];
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
