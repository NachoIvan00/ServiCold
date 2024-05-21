<?php
// Configura las cabeceras de la respuesta
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: GET");
header("Cache-Control: no-cache, must-revalidate"); // No almacenar en caché y volver a validar
header("Pragma: no-cache"); // No almacenar en caché


// Incluye la conexión a la base de datos
include 'conexion.php';

// Inicializa la respuesta como un array vacío
$response = [];

if ($con) {
        // Consulta original sin filtro por fecha
        $consulta = "SELECT nivel_combustible, fecha_actual FROM `FL902` ORDER BY fecha_actual DESC LIMIT 1";

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
