<?php
// Configura las cabeceras de la respuesta
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: GET");

// Incluye la conexión a la base de datos
include 'conexion.php';

// Inicializa la respuesta como un array vacío
$response = [];

if ($con) {
    // Obtener el parámetro de fecha de la solicitud HTTP
    $selectedDate = isset($_GET['selected_date']) ? $_GET['selected_date'] : null;

    if ($selectedDate) {
        // Modificar la consulta SQL para filtrar por fecha
        $consulta = "SELECT nivel_combustible, fecha_actual FROM `FL902` WHERE DATE(fecha_actual) = '$selectedDate' ORDER BY fecha_actual DESC";
    } else {
        // Consulta original sin filtro por fecha
        $consulta = "SELECT nivel_combustible, fecha_actual FROM `FL902` ORDER BY fecha_actual DESC";
    }

    // Ejecuta la consulta
    $resultado = mysqli_query($con, $consulta);

    if ($resultado) {
        // Recorre los resultados de la consulta y almacena cada fila en el array de respuesta
        while ($fila = mysqli_fetch_assoc($resultado)) {
            $response[] = $fila;
        }
    } else {
        // Si hay un error en la consulta, devuelve un mensaje de error
        http_response_code(500); // Establece un código de respuesta HTTP 500 (Error interno del servidor)
        $response = ["error" => "Error al consultar la base de datos"];
    }
} else {
    // Si la conexión a la base de datos falla, devuelve un mensaje de error
    http_response_code(500); // Establece un código de respuesta HTTP 500 (Error interno del servidor)
    $response = ["error" => "Error de conexión a la base de datos"];
}

// Devuelve la respuesta como JSON
echo json_encode($response);
?>
