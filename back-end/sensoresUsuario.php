<?php
// Configura las cabeceras de la respuesta
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

// Incluye la conexión a la base de datos
require_once 'conexion.php';

// Inicia la sesión
session_start();

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario_id'])) {
    http_response_code(401);
    echo json_encode(["error" => "Acceso no autorizado"]);
    exit;
}

// Obtén el ID del usuario que ha iniciado sesión
$usuario_id = $_SESSION['usuario_id'];

// Consulta SQL para seleccionar los sensores a los que tiene acceso el usuario
$consulta = "SELECT s.id, s.nombre FROM sensores s
             INNER JOIN permisos_sensores ps ON s.id = ps.sensor_id
             WHERE ps.usuario_id = ?";
$stmt = $con->prepare($consulta);
$stmt->bind_param('i', $usuario_id);
$stmt->execute();
$result = $stmt->get_result();

// Verifica si se encontraron sensores
if ($result->num_rows === 0) {
    // Si el usuario no tiene acceso a ningún sensor
    http_response_code(404);
    echo json_encode(["error" => "No se encontraron sensores"]);
    exit;
}

// Almacena los sensores en un array
$sensores = [];
while ($row = $result->fetch_assoc()) {
    $sensores[] = $row;
}

// Devuelve la lista de sensores como JSON
echo json_encode($sensores);
?>
