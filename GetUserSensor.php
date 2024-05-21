<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
include 'conexion.php';

$response = [];

if ($con) {
    $consulta = "SELECT u.id as usuario_id, u.nombre as usuario, GROUP_CONCAT(s.nombre SEPARATOR ', ') as sensores 
                FROM usuarios u 
                LEFT JOIN permisos_sensores ps ON u.id = ps.usuario_id 
                LEFT JOIN sensores s ON ps.sensor_id = s.id 
                GROUP BY u.id";
    $resultado = mysqli_query($con, $consulta);
    
    if ($resultado) {
        $data = [];
        while ($fila = mysqli_fetch_assoc($resultado)) {
            $data[] = $fila;
        }
        $response = $data;
    } else {
        http_response_code(500);
        $response = ["error" => "Error al obtener datos de la base de datos"];
    }
} else {
    http_response_code(500);
    $response = ["error" => "Error de conexión a la base de datos"];
}

echo json_encode($response);
?>
