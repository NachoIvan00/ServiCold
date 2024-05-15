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
    // Obtener parámetros de consulta para el filtro de temperatura
    $temp_min = isset($_GET['temp_min']) ? (float)$_GET['temp_min'] : null;
    $temp_max = isset($_GET['temp_max']) ? (float)$_GET['temp_max'] : null;

    // Construye la consulta SQL con filtro de temperatura si se proporciona el rango
    $consulta = "SELECT Temperatura, Humedad, fecha_actual FROM Tb_DHT11";
    
    // Añadir condiciones a la consulta si se proporcionan parámetros de filtro
    $condiciones = [];
    if ($temp_min !== null) {
        $condiciones[] = "Temperatura >= $temp_min";
    }
    if ($temp_max !== null) {
        $condiciones[] = "Temperatura <= $temp_max";
    }
    if (count($condiciones) > 0) {
        $consulta .= " WHERE " . implode(' AND ', $condiciones);
    }
    
    // Ordenar por fecha actual
    $consulta .= " ORDER BY fecha_actual DESC";

    // Ejecutar la consulta SQL
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
